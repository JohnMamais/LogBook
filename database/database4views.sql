CREATE VIEW teacherUserInfo AS
SELECT id, username, CONCAT(fname, ' ', lname) AS fullName, email, signupDate, tokenUsed AS token
FROM user
WHERE isAdmin = 0;

CREATE VIEW adminUserInfo AS
SELECT id, username, CONCAT(fname, ' ', lname) AS fullName, email, signupDate, tokenUsed as token
FROM user
WHERE isAdmin = 1;

CREATE VIEW fullUserView AS
SELECT id, username, CONCAT(fname, ' ', lname) AS fullName, email, signupDate
FROM user
WHERE isActive=1;
