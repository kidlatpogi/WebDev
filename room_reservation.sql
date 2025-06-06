CREATE DATABASE room_reservation;
USE room_reservation;

-- for LOGIN and SIGNUP of the users
CREATE TABLE USERS(
    user_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL
);

-- usders details connected to USERS table
CREATE TABLE USER_DETAILS(
    userDetails_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    fname VARCHAR(30) NOT NULL DEFAULT ' ',
    lname VARCHAR(30) NOT NULL DEFAULT ' ',
    image BLOB NULL,
    user_id INT UNIQUE,
    CONSTRAINT user_id_fk FOREIGN KEY(user_id) REFERENCES USERS(user_id)
);

-- for rooms floor and type
CREATE TABLE ROOMS(
    room_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    floor ENUM('4th','5th') NOT NULL,
    room_type ENUM('Lecture', 'Laboratory') NOT NULL
);

-- rooms descriptions
CREATE TABLE ROOM_DETAILS (
    room_detail_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    room_id INT NOT NULL,
    description VARCHAR(255) NOT NULL,
    CONSTRAINT fk_room_details FOREIGN KEY(room_id) REFERENCES ROOMS(room_id)
);

-- reservation status
CREATE TABLE RESERVATION_STATUS(
    status_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    status ENUM('Ongoing', 'Completed', 'Canceled') NOT NULL
);

-- for users reservations, connected to USERS_DETAILES, ROOMS, RESERVATION_STATUS
CREATE TABLE RESERVATION(
    reservation_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    reservation_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    userDetails_id INT,
    room_id INT,
    status_id INT,
    CONSTRAINT fk_userDetails FOREIGN KEY(userDetails_id) REFERENCES USER_DETAILS(userDetails_id),
    CONSTRAINT fk_room FOREIGN KEY(room_id) REFERENCES ROOMS(room_id),
    CONSTRAINT fk_status FOREIGN KEY(status_id) REFERENCES RESERVATION_STATUS(status_id)
);

-- connected to ROOMS table
CREATE TABLE ROOM_SCHEDULE (
    schedule_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
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
