DROP DATABASE IF EXISTS Log_Book;
CREATE DATABASE Log_Book;
USE Log_Book;

CREATE TABLE user(
  id INT AUTO_INCREMENT,
  username VARCHAR(20) NOT NULL,
  password VARCHAR(255) NOT NULL,
  fname VARCHAR(20) NOT NULL,
  lname VARCHAR(20) NOT NULL,
  email VARCHAR(20), #user's email
  isAdmin INT DEFAULT 0,
  isActive INT DEFAULT 1, #enabled/disabled users
  tokenUsed INT, #token used for singup
  PRIMARY KEY (id),
  CHECK (isAdmin IN(0,1,2))
);

CREATE TABLE edPeriod(
  id INT AUTO_INCREMENT,
  year INT NOT NULL,
  season VARCHAR(2) NOT NULL,
  PRIMARY KEY (id),
  CHECK (SEASON IN ('A', 'B'))
);

CREATE TABLE specialty(
  specialtyID INT AUTO_INCREMENT,
  name VARCHAR(128) NOT NULL,
  PRIMARY KEY (specialtyID)
);

CREATE TABLE subject(
  subjectID INT AUTO_INCREMENT,
  specialtyID INT NOT NULL,
  name VARCHAR(128) NOT NULL,
  semester VARCHAR(2) NOT NULL,
  PRIMARY KEY (subjectID),
  FOREIGN KEY (specialtyID) REFERENCES specialty(specialtyID),
  CHECK (semester IN('A','B','C','D'))
);

CREATE TABLE class(
  id INT AUTO_INCREMENT,
  numOfClasses INT NOT NULL,
  specialtyID INT NOT NULL,
  edPeriodID INT NOT NULL,
  semester CHAR NOT NULL,
  PRIMARY KEY (id,  specialtyID, edPeriodID, semester),
  FOREIGN KEY (specialtyID) REFERENCES specialty(specialtyID),
  FOREIGN KEY (edPeriodID) REFERENCES edPeriod(id)
);

CREATE TABLE activeSubjects(
  subjectID INT NOT NULL,
  specialtyID INT NOT NULL,
  classID INT NOT NULL,
  FOREIGN KEY (subjectID) REFERENCES subject(subjectID),
  FOREIGN KEY (specialtyID) REFERENCES specialty(specialtyID),
  FOREIGN KEY (classID) REFERENCES class(id)
);

CREATE TABLE bookEntry(
  entryID INT AUTO_INCREMENT,
  date DATE NOT NULL,
  description VARCHAR(256) NOT NULL,
  periods VARCHAR(10) NOT NULL,
  username INT NOT NULL,
  subjectID INT NOT NULL,
  specialtyID INT NOT NULL,
  class	INT NOT NULL,
  year INT NOT NULL,
  season VARCHAR(10) NOT NULL,
  semester CHAR NOT NULL,
  PRIMARY KEY (entryID),
  FOREIGN KEY (username) REFERENCES User(id),
  FOREIGN KEY (subjectID) REFERENCES Subject(subjectID),
  FOREIGN KEY (specialtyID) REFERENCES class(specialtyID)
);

CREATE TABLE registrationTokens(
	id INT AUTO_INCREMENT,
    startDate DATE NOT NULL, #date of creation or enabling for the token
    endDate DATE NOT NULL, #expiration date for the token
    token VARCHAR(20) NOT NULL,
    maxUses INT NOT NULL, #max users to sign up with this token
    used INT DEFAULT 0, #count of uses for specific token
    isActive INT DEFAULT 1, 
    PRIMARY KEY(ID)
);

CREATE TABLE pages(
	id INT AUTO_INCREMENT,
    pageName VARCHAR(50),
    alias VARCHAR(15),
    PRIMARY KEY(id)
);
CREATE TABLE serverLog(
  id INT AUTO_INCREMENT,
  pageID INT, #page from which the log was made
  logDesc VARCHAR(255) NOT NULL,
  ip VARCHAR(46), #ip of user if applicable
  uid INT, #user ID
  logTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY(id),
  FOREIGN KEY (pageID) REFERENCES pages(id)
);

CREATE TABLE passwordRecovery(
	id INT AUTO_INCREMENT,
	uid INT NOT NULL,
    token VARCHAR(30) NOT NULL,
    isActive INT DEFAULT 1,
    requestTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
    expiresAt TIMESTAMP,
    FOREIGN KEY (uid) REFERENCES user(id),
    PRIMARY KEY (id)
);