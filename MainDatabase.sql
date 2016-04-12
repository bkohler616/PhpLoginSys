#phpProject database is for

DROP DATABASE IF EXISTS phpProject;
CREATE DATABASE phpProject;

USE phpProject;

CREATE TABLE Users (
  UserID          INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  AccountTypeID   INT                NOT NULL,
  Username        VARCHAR(30)        NOT NULL,
  Email           VARCHAR(256),
  PasswordHash    CHAR(64)           NOT NULL,
  PasswordSalt    CHAR(10)           NOT NULL,
  AccountStatusID INT                NOT NULL,
  DateCreated     DATE
);

CREATE TABLE AccountType (
  AccountTypeID   INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  AccountTypeText VARCHAR(25)        NOT NULL
);

INSERT INTO AccountType (AccountTypeText)
VALUES ('Standard'),
  ('Administrator'),
  ('Super Administrator');

CREATE TABLE AccountStatus (
  AccountStatusID   INT AUTO_INCREMENT PRIMARY KEY,
  AccountStatusText VARCHAR(25) NOT NULL
);

INSERT INTO AccountStatus (AccountStatusText)
VALUES ('Active'),
  ('Not Registered'),
  ('Suspended'),
  ('Banned'),
  ('Deleted');

#Generate the super user.
INSERT INTO Users (AccountTypeID, Username, Email, PasswordHash, PasswordSalt, AccountStatusID, DateCreated)
VALUES (3, 'SuperMan', 'SuperMan@phpProject.crack',
        '794d4b0fb26f63ed17db55b61dc269b36709a6326a5edd0b1d836da50b0ad9d6',
        'FGHruFkles', 1, '2000-1-1');

CREATE TABLE UserAuthLog (
  LogID         INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  UserID        INT                NOT NULL,
  LoginActionID INT                NOT NULL,
  DateTime      DATETIME           NOT NULL
);

CREATE TABLE LoginAction (
  LoginActionID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  ActionText    VARCHAR(180)       NOT NULL
);

INSERT INTO LoginAction (ActionText)
VALUES ('User Logged in successfully'),
  ('User Logged Out.'),
  ('User Session Ended'),
  ('Attempted Login: Bad Password');

CREATE TABLE UpdateAction (
  UpdateActionID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  ActionText     VARCHAR(180)
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
  UpdateID        INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  UserBeingEdited INT                NOT NULL,
  UserEditing     INT,
  ActionID        INT                NOT NULL,
  TimeOfEdit      DATETIME
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