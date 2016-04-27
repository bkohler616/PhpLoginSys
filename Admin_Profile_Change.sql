USE `phptest`;
DROP procedure IF EXISTS `Admin_Profile_Change`;

DELIMITER $$
USE `phptest`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Admin_Profile_Change`(emailChng INT, accType INT, userN VARCHAR(30), email VARCHAR(256), passW VARCHAR(256), salt CHAR(10), userNChng INT)
BEGIN
	DECLARE accSalt CHAR(10);
    DECLARE id INT;

    IF(userN) THEN
		SELECT PasswordSalt, id FROM Users WHERE Username = userN INTO @accSalt, @id;

		IF(accType)THEN
			UPDATE Users
            SET AccountTypeID = accType
            WHERE UserID = @id AND PasswordHash = SHA2(CONCAT(@accSalt, passW), 256);
        END IF;
        IF(emailChng)THEN
			UPDATE Users
            SET Email = email
            WHERE UserID = @id AND PasswordHash = SHA2(CONCAT(@accSalt, passW), 256);
        END IF;
        IF(salt)THEN
			UPDATE Users
            SET PasswordSalt = salt
            WHERE UserID = @id AND PasswordHash = SHA2(CONCAT(@accSalt, passW), 256);
        END IF;
        IF(salt)THEN
			UPDATE Users
            SET PasswordSalt = salt
            WHERE UserID = @id AND PasswordHash = SHA2(CONCAT(@accSalt, passW), 256);
			SELECT PasswordSalt FROM Users WHERE Username = userN INTO @accSalt;
        END IF;
        IF(passW)THEN
			UPDATE Users
            SET PasswordHash = SHA2(CONCAT(@salt, passW), 256)
            WHERE UserID = @id AND PasswordHash = SHA2(CONCAT(@accSalt, passW), 256);
        END IF;
        IF(userNChng)THEN
			UPDATE Users
            SET Username = userN
            WHERE UserID = @id AND PasswordHash = SHA2(CONCAT(@accSalt, passW), 256);
        END IF;
    END IF;
END$$

DELIMITER ;
