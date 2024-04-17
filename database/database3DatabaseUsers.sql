USE log_book;

DROP USER IF EXISTS 'login'@'localhost';
DROP USER IF EXISTS 'bookAdmin'@'localhost';
DROP USER IF EXISTS 'teacher'@'localhost';
DROP USER IF EXISTS 'superadmin'@'localhost';

CREATE USER 'login'@'localhost' IDENTIFIED BY 'Log_Book_2024_IEK_AIGALEO@login';

GRANT SELECT ON log_book.user TO 'login'@'localhost';
GRANT INSERT ON log_book.serverlog TO 'login'@'localhost';

CREATE USER 'bookAdmin'@'localhost' IDENTIFIED BY 'Log_Book_2024_IEK_AIGALEO@adminuser';

GRANT INSERT ON log_book.serverlog TO 'bookAdmin'@'localhost';
GRANT SELECT ON log_book.user TO 'bookAdmin'@'localhost';
GRANT SELECT, INSERT, UPDATE ON log_book.activesubjects TO 'bookAdmin'@'localhost';
GRANT SELECT ON log_book.bookentry TO 'bookAdmin'@'localhost';
GRANT SELECT,INSERT,UPDATE ON log_book.class TO 'bookAdmin'@'localhost';
GRANT SELECT,INSERT,UPDATE ON log_book.edperiod TO 'bookAdmin'@'localhost';
GRANT SELECT ON log_book.specialty TO 'bookAdmin'@'localhost';
GRANT SELECT ON log_book.subject TO 'bookAdmin'@'localhost';
GRANT INSERT, UPDATE, SELECT ON log_book.user TO 'bookAdmin'@'localhost';
GRANT SELECT ON log_book.bookEntry TO 'bookAdmin'@'localhost';

CREATE USER 'teacher'@'localhost' IDENTIFIED BY 'Log_Book_2024_IEK_AIGALEO@teacheruser';

GRANT INSERT ON log_book.serverlog TO 'teacher'@'localhost';
GRANT SELECT ON log_book.activesubjects  TO 'teacher'@'localhost';
GRANT INSERT ON log_book.bookentry TO 'teacher'@'localhost';
GRANT SELECT ON log_book.class TO 'teacher'@'localhost';
GRANT SELECT ON log_book.edperiod TO 'teacher'@'localhost';
GRANT SELECT ON log_book.specialty TO 'teacher'@'localhost';
GRANT SELECT ON log_book.subject TO 'teacher'@'localhost';
GRANT SELECT, UPDATE ON log_book.user TO 'teacher'@'localhost';

CREATE USER 'superadmin'@'localhost' IDENTIFIED BY 'Log_Book_2024_IEK_AIGALEO@$uperAdm_1n';

GRANT ALL PRIVILEGES ON log_book.* TO 'superadmin'@'localhost';

FLUSH PRIVILEGES;
