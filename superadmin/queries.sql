#Left join excluding inner join
#selects edPeriodIDs that don't have classes assigned to them
SELECT edPeriod.id
FROM edPeriod
LEFT JOIN class ON edperiod.id = class.edPeriodID
WHERE class.edPeriodID IS NULL;

#selects classes without subjects assigned to them
SELECT class.id
FROM class
LEFT JOIN activeSubjects ON class.id = activesubjects.classID
WHERE activesubjects.classID IS NULL;

select * from activesubjects
join class on class.specialtyID=activesubjects.specialtyID 
AND semester = 'b';

select numofclasses, specialtyid, edperiodid, semester 
from class where specialtyid=2
order by specialtyid;

#selects in order of superadmin
select * from user;
select * from edPeriod;
select * from class;
select COUNT(*) from activesubjects;
select * from serverlog;
select * from registrationTokens;

#empty database in order
delete from user where id>=0;
delete from bookentry where entryid>=0;
delete from activesubjects where specialtyID>=0;
delete from class where id >=0;
delete from edperiod where id>=0;

ALTER EVENT checkTokenExpire ENABLE;

CALL startTokenEvent();

SELECT STATUS
FROM information_schema.EVENTS
WHERE EVENT_SCHEMA = DATABASE()  -- Replace with your database name
		AND EVENT_NAME = 'checkTokenExpire';  -- Replace with the event name

SELECT  token AS token, endDate AS expire
  FROM registrationTokens
  WHERE id=(SELECT MAX(id) FROM registrationTokens WHERE isActive=1);