#Event to automatically disable tokens if they are past their expire date or user limit has been reached
DELIMITER //

CREATE EVENT checkTokenExpire
ON SCHEDULE EVERY 1 HOUR
DO
BEGIN
    DECLARE tokenID INT;
    DECLARE tokenDate DATE;
    DECLARE done INT DEFAULT 0;  -- Variable to indicate end of cursor

    -- Cursor to select tokens that might need updating
    DECLARE token_cursor CURSOR FOR
    SELECT id, endDate FROM registrationTokens WHERE isActive = 1;

    -- Handler for cursor ending
    DECLARE CONTINUE HANDLER FOR NOT FOUND
    BEGIN
		
		SET done = 1;
	END;
    -- Open the cursor
    OPEN token_cursor;

    -- Loop through the results
    token_loop: LOOP
        -- Fetch data into variables
        FETCH token_cursor INTO tokenID, tokenDate;

        -- Exit the loop if there are no more rows
        IF done THEN
            LEAVE token_loop;
        END IF;

        -- Check if the token has expired
        IF tokenDate < NOW() THEN
            -- Update the token to be inactive
            UPDATE registrationTokens SET isActive = 0 WHERE id = tokenID;
        END IF;

    END LOOP;

    -- Close the cursor
    CLOSE token_cursor;

END;
//

DELIMITER ;

#update count of usages for the used token
DELIMITER //

CREATE TRIGGER updateTokenUses
AFTER INSERT ON user
FOR EACH ROW
BEGIN
    DECLARE tokenIsActive INT;
    DECLARE maxUsers INT;
    DECLARE currentUsers INT;
    
	SELECT isActive, maxUses, used
		INTO tokenIsActive , maxUsers , currentUsers 
		FROM registrationTokens
		WHERE registrationTokens.id = NEW.tokenUsed;
    
    #check if the token provided is active and procced to change the said tokens count
	IF tokenIsActive=1 AND maxUsers>currentUsers THEN
		UPDATE registrationTokens 
			SET used=used+1 
            WHERE id=NEW.tokenUsed;
	END IF; 
    
    #check if the token can still be used after the insertion
    IF currentUsers>=maxUsers THEN 
		UPDATE registrationTokens 
			SET isActive=0 
			WHERE id=NEW.tokenUsed;
	END IF;
    IF currentUsers>maxUsers THEN
		INSERT INTO serverLog(pageID, logDesc, uid) VALUES
        (4,"CRITICAL: User registered out of token Active Bounds!!", NEW.id);
	END IF;
END; //

DELIMITER ;

#Trigger to add expiration date to the created password recovery token
DELIMITER //

CREATE TRIGGER recoveryTokenExpiration
BEFORE INSERT ON passwordRecovery
FOR EACH ROW
BEGIN
    SET NEW.expiresAt = DATE_ADD(NOW(), INTERVAL 1 HOUR);
END; //

DELIMITER ;

#Event to disable expired recoveryTokens
DELIMITER //

CREATE EVENT checkRecoveryTokenExpire
ON SCHEDULE EVERY 30 MINUTE
DO
BEGIN
	
    -- Update tokens that have expired by setting them to inactive
    UPDATE passwordRecovery 
    SET isActive = 0
    WHERE isActive = 1 
      AND expiresAt < NOW();

END;
//

DELIMITER ;