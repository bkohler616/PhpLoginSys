USE `phptest`;
DROP function IF EXISTS `Login_Check`;

DELIMITER $$
USE `phptest`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `Login_Check`(userN VARCHAR(30), passW VARCHAR(32)) RETURNS varchar(64) CHARSET latin1
BEGIN
DECLARE salt VARCHAR(64);
	SELECT PasswordSalt FROM Users WHERE Username = userN INTO @salt;
    IF EXISTS(SELECT Username FROM Users WHERE Username = userN) THEN
		IF EXISTS(SELECT UserID FROM Users WHERE Username = userN AND PasswordHash = SHA2(CONCAT(@salt, passW), 256)) THEN
			RETURN "Username and password match";
		ELSE
			RETURN "Username and password do not match";
		END IF;
	ELSE
        RETURN "Username does not exist";
	END IF;
END$$

DELIMITER ;

