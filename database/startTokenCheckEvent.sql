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
		EVENT_SCHEMA = DATABASE()  -- Replace with your database name
		AND EVENT_NAME = 'checkTokenExpire';  
        # Replace with the event name
	
    IF eventStatus LIKE 'DISABLED' THEN
		ALTER EVENT checkTokenExpire ENABLE;
    END IF;
END