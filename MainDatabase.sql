#phpProject database is for

DROP DATABASE IF EXISTS phpProject;
CREATE DATABASE phpProject;

USE phpProject;

CREATE TABLE AccountType (
  AccountTypeID   INT AUTO_INCREMENT NOT NULL,
  AccountTypeText VARCHAR(25)        NOT NULL,
  PRIMARY KEY (AccountTypeID)
);

INSERT INTO AccountType (AccountTypeText)
VALUES ('Standard'),
  ('Banned'),
  ('Administrator'),
  ('Super Administrator');

CREATE TABLE AccountStatus (
  AccountStatusID   INT AUTO_INCREMENT,
  AccountStatusText VARCHAR(25) NOT NULL,
  PRIMARY KEY (AccountStatusID)
);

INSERT INTO AccountStatus (AccountStatusText)
VALUES ('Active'),
  ('Not Registered'),
  ('Suspended'),
  ('Banned'),
  ('Deleted');

CREATE TABLE AccountVisibility (
  AccountVisibilityID   INT AUTO_INCREMENT,
  AccountVisibilityText VARCHAR(25) NOT NULL,
  PRIMARY KEY (AccountVisibilityID)
);

INSERT INTO AccountVisibility (AccountVisibilityText)
VALUES ('Private'),
  ('Public');

/*Connecting items:
AccountType - AccountTypeText
AccountStatus - AccountStatusText
AccountVisibility - AccountVisibilityText
 */
CREATE TABLE Users (
  UserID              INT AUTO_INCREMENT NOT NULL,
  AccountTypeID       INT                NOT NULL,
  Username            VARCHAR(30) UNIQUE NOT NULL,
  Email               VARCHAR(256),
  PasswordHash        CHAR(64)           NOT NULL,
  PasswordSalt        CHAR(10)           NOT NULL,
  AccountStatusID     INT                NOT NULL,
  AccountVisibilityID INT                NOT NULL,
  DateCreated         DATE               NOT NULL,
  PRIMARY KEY (UserID),
  FOREIGN KEY (AccountTypeID) REFERENCES AccountType (AccountTypeID),
  FOREIGN KEY (AccountStatusID) REFERENCES AccountStatus (AccountStatusID),
  FOREIGN KEY (AccountVisibilityID) REFERENCES AccountVisibility (AccountVisibilityID)

);

#Generate the super user.
INSERT INTO Users (AccountTypeID, Username, Email, PasswordHash, PasswordSalt, AccountStatusID, AccountVisibilityID, DateCreated)
VALUES (4, 'SuperMan', 'SuperMan@phpProject.crack',
        '7947c5b676fb48dc824e0c9f751b27bc775c4343edc9bc4d0c7602c43c29990e',
        'j?(,9F7RbT', 1, 1, '2000-1-1');

CREATE TABLE LoginAction (
  LoginActionID INT AUTO_INCREMENT NOT NULL,
  ActionText    VARCHAR(180)       NOT NULL,
  PRIMARY KEY (LoginActionID)
);

CREATE TABLE UserAuthLog (
  LogID         INT AUTO_INCREMENT NOT NULL,
  UserID        INT                NOT NULL,
  LoginActionID INT                NOT NULL,
  DateTime      DATETIME           NOT NULL,
  PRIMARY KEY (LogID),
  FOREIGN KEY (UserID) REFERENCES Users (UserID),
  FOREIGN KEY (LoginActionID) REFERENCES LoginAction (LoginActionID)
);

INSERT INTO LoginAction (ActionText)
VALUES ('User Logged in successfully'),
  ('User Logged Out.'),
  ('User Session Ended'),
  ('Attempted Login: Bad Password');

CREATE TABLE UpdateAction (
  UpdateActionID INT AUTO_INCREMENT NOT NULL,
  ActionText     VARCHAR(180),
  PRIMARY KEY (UpdateActionID)
);

INSERT INTO UpdateAction (ActionText)
VALUES ('Changed Password'),
  ('Changed Username'),
  ('Changed Email'),
  ('Changed Username & Password'),
  ('Changed Username & Email'),
  ('Changed Password & Email'),
  ('Changed Username, Password & Email'),
  ('Deleted Account');

CREATE TABLE UserUpdateLog (
  UpdateID        INT AUTO_INCREMENT NOT NULL,
  UserBeingEdited INT                NOT NULL,
  UserEditing     INT,
  ActionID        INT                NOT NULL,
  TimeOfEdit      DATETIME,
  PRIMARY KEY (UpdateID),
  FOREIGN KEY (UserBeingEdited) REFERENCES Users (UserID),
  FOREIGN KEY (UserEditing) REFERENCES Users (UserID),
  FOREIGN KEY (ActionID) REFERENCES UpdateAction (UpdateActionID)
);

DROP FUNCTION IF EXISTS `Login_Check`;

DELIMITER $$
USE phpProject$$
CREATE DEFINER =`root`@`localhost` FUNCTION `Login_Check`(userN VARCHAR(30), passW VARCHAR(32))
  RETURNS VARCHAR(64)
  CHARSET latin1
  BEGIN
    DECLARE salt VARCHAR(64);
    SELECT PasswordSalt
    FROM Users
    WHERE Username = userN
    INTO @salt;
    IF EXISTS(SELECT Username
              FROM Users
              WHERE Username = userN)
    THEN
      IF EXISTS(SELECT UserID
                FROM Users
                WHERE Username = userN AND PasswordHash = SHA2(CONCAT(@salt, passW), 256))
      THEN
        RETURN "Username and password match";
      ELSE
        RETURN "Username and password do not match";
      END IF;
    ELSE
      RETURN "Username does not exist";
    END IF;
  END$$

DELIMITER ;

DROP FUNCTION IF EXISTS `Create_User`;

DELIMITER $$
USE phpProject$$
CREATE DEFINER =`root`@`localhost` FUNCTION `Create_User`(userN VARCHAR(30), passW VARCHAR(32), salt CHAR(10))
  RETURNS VARCHAR(64)
  CHARSET latin1
  BEGIN
    IF (EXISTS(SELECT Username FROM users WHERE Username = userN) > 0) THEN
      RETURN "Username Taken";
    ELSE
      Call Add_User(1, userN, "", passW, salt, 1);
      RETURN "User Added";
    END IF;
  END$$

DELIMITER ;


DROP PROCEDURE IF EXISTS `Add_User`;

DELIMITER $$
USE phpProject$$
CREATE DEFINER =`root`@`localhost` PROCEDURE `Add_User`(IN accType INT, IN userN VARCHAR(30), IN email VARCHAR(256),
                                                        IN passW   VARCHAR(256), IN salt CHAR(10), IN accVis INT)
  BEGIN
    DECLARE nPassW VARCHAR(99);
    IF (ISNULL(accVis))
    THEN
      SET @accVis := 1;
    END IF;

    SET nPassW = CONCAT(salt, passW);
    INSERT INTO Users (AccountTypeID, Username, Email, PasswordHash, PasswordSalt, AccountStatusID, DateCreated, AccountVisibilityID)
    VALUES (accType, userN, email, SHA2(nPassW, 256), salt, 1, CURDATE(), accVis);
  END$$

DELIMITER ;


DROP PROCEDURE IF EXISTS `Change_Profile`;

DELIMITER $$
USE phpProject$$
CREATE DEFINER =`root`@`localhost` PROCEDURE `Change_Profile`(IN emailChng INT, IN userN VARCHAR(30),
                                                              IN email     VARCHAR(256), IN passW VARCHAR(256),
                                                              IN accVis    INT)
  BEGIN
    DECLARE
    salt CHAR(10);

    IF (userN)
    THEN
      IF (email, passW)
      THEN
        UPDATE Users
        SET Email = email, PasswordHash = SHA2(CONCAT(@salt, passW), 256)
        WHERE Username = userN;
      ELSEIF (emailChng)
        THEN
          UPDATE Users
          SET Email = email
          WHERE Username = userN;
      ELSEIF (passW)
        THEN
          UPDATE Users
          SET PasswordHash = SHA2(CONCAT(@salt, passW), 256)
          WHERE Username = userN;
      ELSEIF (accVis)
        THEN
          UPDATE Users
          SET AccountVisibilityID = accVis
          WHERE Username = userN;
      END IF;
    END IF;
  END;
$$

DELIMITER ;


DROP PROCEDURE IF EXISTS `Admin_Profile_Change`;

DELIMITER $$
USE phpProject$$
CREATE DEFINER =`root`@`localhost` PROCEDURE `Admin_Profile_Change`(emailChng INT, accType INT, userN VARCHAR(30),
                                                                    email     VARCHAR(256), passW VARCHAR(256),
                                                                    salt      CHAR(10), userNChng INT, accVis INT)
  BEGIN
    DECLARE accSalt CHAR(10);
    DECLARE id INT;

    IF (userN)
    THEN
      SELECT
        PasswordSalt,
        id
      FROM Users
      WHERE Username = userN
      INTO @accSalt, @id;

      IF (accType)
      THEN
        UPDATE Users
        SET AccountTypeID = accType
        WHERE UserID = @id AND PasswordHash = SHA2(CONCAT(@accSalt, passW), 256);
      END IF;
      IF (emailChng)
      THEN
        UPDATE Users
        SET Email = email
        WHERE UserID = @id AND PasswordHash = SHA2(CONCAT(@accSalt, passW), 256);
      END IF;
      IF (salt)
      THEN
        UPDATE Users
        SET PasswordSalt = salt
        WHERE UserID = @id AND PasswordHash = SHA2(CONCAT(@accSalt, passW), 256);
      END IF;
      IF (salt)
      THEN
        UPDATE Users
        SET PasswordSalt = salt
        WHERE UserID = @id AND PasswordHash = SHA2(CONCAT(@accSalt, passW), 256);
        SELECT PasswordSalt
        FROM Users
        WHERE Username = userN
        INTO @accSalt;
      END IF;
      IF (passW)
      THEN
        UPDATE Users
        SET PasswordHash = SHA2(CONCAT(@salt, passW), 256)
        WHERE UserID = @id AND PasswordHash = SHA2(CONCAT(@accSalt, passW), 256);
      END IF;
      IF (userNChng)
      THEN
        UPDATE Users
        SET Username = userN
        WHERE UserID = @id AND PasswordHash = SHA2(CONCAT(@accSalt, passW), 256);
      ELSEIF (accVis)
        THEN
          UPDATE Users
          SET AccountVisibilityID = accVis
          WHERE Username = userN;
      END IF;
    END IF;
  END$$

DELIMITER ;