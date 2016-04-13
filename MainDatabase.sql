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

CREATE TABLE Users (
  UserID          INT AUTO_INCREMENT NOT NULL,
  AccountTypeID   INT                NOT NULL,
  Username        VARCHAR(30)        NOT NULL,
  Email           VARCHAR(256),
  PasswordHash    CHAR(64)           NOT NULL,
  PasswordSalt    CHAR(10)           NOT NULL,
  AccountStatusID INT                NOT NULL,
  DateCreated     DATE               NOT NULL,
  PRIMARY KEY (UserID),
  FOREIGN KEY (AccountTypeID) REFERENCES AccountType (AccountTypeID),
  FOREIGN KEY (AccountStatusID) REFERENCES AccountStatus (AccountStatusID)
);

#Generate the super user.
INSERT INTO Users (AccountTypeID, Username, Email, PasswordHash, PasswordSalt, AccountStatusID, DateCreated)
VALUES (3, 'SuperMan', 'SuperMan@phpProject.crack',
        '794d4b0fb26f63ed17db55b61dc269b36709a6326a5edd0b1d836da50b0ad9d6',
        'FGHruFkles', 4, '2000-1-1');

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

CREATE TABLE LoginStatusMessages (
  MessageID   INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  MessageText VARCHAR(180)       NOT NULL
);

INSERT INTO LoginStatusMessages (MessageText)
VALUES ('Unknown Error'),
  ('Password Fail'),
  ('Account Does Not Exist'),
  ('Invalid Username'),
  ('Invalid Email'),
  ('Invalid Password'),
  ('Session Expired');