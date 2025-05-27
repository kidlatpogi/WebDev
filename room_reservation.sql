CREATE DATABASE room_reservation;
USE room_reservation;

CREATE TABLE USERS(
	user_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT
    , email VARCHAR(50) NOT NULL
    , password VARCHAR(50) NOT NULL
);

CREATE TABLE USER_DETAILS(
	userDetails_id INT PRIMARY KEY NOT NULL
    , fname VARCHAR(30) NOT NULL DEFAULT ' '
    , lname VARCHAR(30) NOT NULL DEFAULT ' '
    , user_id INT UNIQUE
    , CONSTRAINT user_id_fk FOREIGN KEY(user_id) REFERENCES USERS(user_id)
);

CREATE TABLE ROOMS(
	room_id INT PRIMARY KEY NOT NULL
    , floor ENUM('4th','5th')
    , room_type ENUM('Lecture', 'Laboratory')
);

CREATE TABLE RESERVATION(
	reservation_id INT PRIMARY KEY NOT NULL
    , reservation_date DATE NOT NULL
    , start_time TIME NOT NULL
    , end_time TIME NOT NULL
    , userDetails_id INT
    , room_id INT
    , CONSTRAINT userDetails_id_FK FOREIGN KEY(userDetails_id) REFERENCES USER_DETAILS(userDetails_id)
    , CONSTRAINT room_id_fk FOREIGN KEY(room_id) REFERENCES ROOMS(room_id)
);

CREATE TABLE ROOM_SCHEDULE (
    schedule_id INT PRIMARY KEY AUTO_INCREMENT,
    room_id INT NOT NULL,
    day_of_week ENUM('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    subject_code VARCHAR(20),
    section VARCHAR(20),
    instructor VARCHAR(50),
    is_occupied BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT fk_room_schedule FOREIGN KEY(room_id) REFERENCES ROOMS(room_id)
);

CREATE VIEW reservation_view AS
SELECT 
    u.user_id,
    ud.lname,
    ud.fname,
    r.room_id,
    r.reservation_date AS date,
    r.start_time,
    r.end_time
FROM RESERVATION r
JOIN USER_DETAILS ud ON r.userDetails_id = ud.userDetails_id
JOIN USERS u ON ud.user_id = u.user_id;

SELECT * FROM reservation_view;

INSERT INTO ROOM_SCHEDULE(room_id, day_of_week, start_time, end_time, subject_code, section, instructor, is_occupied)
	VALUES (401, 'Monday', '07:00:00', '09:40:00', 'ABC231', 'ABCOM16X', 'R. BUELO', TRUE);



