CREATE DEFINER=`user`@`localhost` PROCEDURE `startTokenEvent`()
BEGIN
	DECLARE eventStatus VARCHAR(10);
	
    #select current status of event
    SELECT 
		STATUS
	INTO
		eventStatus
	FROM 
		information_schema.EVENTS
	WHERE 
		EVENT_SCHEMA = DATABASE()
		AND EVENT_NAME LIKE 'checkTokenExpire';  
	
    IF eventStatus LIKE 'DISABLED' THEN
		ALTER EVENT checkTokenExpire ENABLE;
    END IF;
END