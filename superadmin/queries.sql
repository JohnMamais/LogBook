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

#selects in order of superadmin
select * from user;
select * from edPeriod;
select * from class;
select COUNT(*) from activesubjects;


#empty database in order
delete from activesubjects where specialtyID>=0;
delete from bookentry where entryid>=0;
delete from class where id >=0;
delete from edperiod where id>=0;