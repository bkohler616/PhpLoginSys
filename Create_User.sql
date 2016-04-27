USE `phptest`;
DROP procedure IF EXISTS `Create_User`;

DELIMITER $$
USE `phptest`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Create_User`(IN accType INT, IN userN VARCHAR(30), IN email VARCHAR(256), IN passW VARCHAR(256), IN salt CHAR(10))
BEGIN
	declare nPassW varchar(99);
	SET nPassW = CONCAT(salt, passW);
	INSERT INTO Users (AccountTypeID, Username, Email, PasswordHash, PasswordSalt, AccountStatusID, DateCreated)
		VALUES(accType, userN, email, SHA2(nPassW,256), salt, 1, CURDATE());
END;$$

DELIMITER ;

