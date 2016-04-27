USE `phptest`;
DROP procedure IF EXISTS `Change_Profile`;

DELIMITER $$
USE `phptest`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Change_Profile`(IN emailChng INT, IN userN VARCHAR(30), IN email VARCHAR(256), IN passW VARCHAR(256))
BEGIN
	DECLARE
		salt CHAR(10);

	IF(userN) THEN
		IF(email, passW) THEN
			UPDATE Users
			SET Email = email, PasswordHash = SHA2(CONCAT(@salt, passW), 256)
            WHERE Username = userN;
		ELSEIF(emailChng) THEN
			UPDATE Users
			SET Email = email
            WHERE Username = userN;
		ELSEIF(passW) THEN
			UPDATE Users
			SET PasswordHash = SHA2(CONCAT(@salt, passW), 256)
            WHERE Username = userN;
		END IF;
    END IF;
END;$$

DELIMITER ;

