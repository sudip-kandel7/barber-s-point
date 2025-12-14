--  Users table 
CREATE TABLE users (
    uid INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(8) NOT NULL,
    firstN TEXT NOT NULL,
    lastN TEXT,
    email VARCHAR(200) NOT NULL UNIQUE,
    phone VARCHAR(10),
    passwrd TEXT NOT NULL
);
-- Shops table 
CREATE TABLE shop (
    sid INT PRIMARY KEY AUTO_INCREMENT,
    sname varchar(20) NOT NULL,
    saddress VARCHAR(20) NOT NULL,
    photo TEXT NOT NULL,
    uid INT,
    status TEXT,
    UNIQUE (sname, saddress),
    FOREIGN KEY(uid) REFERENCES users(uid)
);
-- queue table 
CREATE TABLE queue (
    sid INT PRIMARY KEY,
    current_queue INT NOT NULL DEFAULT 0,
    total_wait_time TIMEf NOT NULL DEFAULT '00:00:00',
    FOREIGN KEY(sid) REFERENCES shop(sid)
);
-- reviews table
CREATE TABLE review (
    rid INT PRIMARY KEY AUTO_INCREMENT,
    uid INT,
    sid INT,
    review TEXT,
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(uid) REFERENCES users(uid),
    FOREIGN KEY(sid) REFERENCES shop(sid),
    UNIQUE (uid, sid)
);


-- services table
-- CREATE TABLE services(
--     services_id int AUTO_INCREMENT PRIMARY KEY,
--     services_name text,
--     price int,
--     duration int,
--     sid int,
--     FOREIGN KEY (sid) REFERENCES shop(sid)
-- );

CREATE TABLE services(
    services_id int AUTO_INCREMENT PRIMARY KEY,
    services_name text,
);
CREATE TABLE shop_services(
    sid INT,
    services_id INT,
    price INT,
    duration INT,
    PRIMARY KEY (sid, services_id),
    FOREIGN KEY (sid) REFERENCES shop(sid),
    FOREIGN KEY (services_id) REFERENCES services(services_id)
);