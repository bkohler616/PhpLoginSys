USE `phptest`;
DROP procedure IF EXISTS `Create_User`;

DELIMITER $$
USE `phptest`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Create_User`(IN accType INT, IN userN VARCHAR(30), IN email VARCHAR(256), IN passW VARCHAR(256), IN salt CHAR(10), IN accVis INT)
BEGIN
	declare nPassW varchar(99);
    IF(accVis = NULL) THEN
		SET @accVis := 1;
    END IF;

	SET nPassW = CONCAT(salt, passW);
	INSERT INTO Users (AccountTypeID, Username, Email, PasswordHash, PasswordSalt, AccountStatusID, DateCreated, AccountVisibilityID)
		VALUES(accType, userN, email, SHA2(nPassW,256), salt, 1, CURDATE(), accVis);
END$$

DELIMITER ;