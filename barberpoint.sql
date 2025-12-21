-- database 
create DATABASE barber_point;
--  Users table 
CREATE TABLE users (
    uid INT PRIMARY KEY AUTO_INCREMENT,
    type ENUM('customer', 'shop', 'admin') NOT NULL DEFAULT 'customer',
    name VARCHAR(50) NOT NULL,
    address VARCHAR(255),
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(15),
    passwrd VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_type (type)
);
-- Shops table 
CREATE TABLE shop (
    sid INT PRIMARY KEY AUTO_INCREMENT,
    sname VARCHAR(100) NOT NULL,
    saddress VARCHAR(50) NOT NULL,
    photo TEXT NOT NULL,
    uid INT NOT NULL,
    total_barbers INT NOT NULL DEFAULT 1,
    available_barbers INT NOT NULL DEFAULT total_barbers,
    status ENUM('pending', 'open', 'closed', 'suspended') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    approved_at DATETIME NULL,
    approved_by INT NULL,
    UNIQUE (sname, saddress),
    FOREIGN KEY(uid) REFERENCES users(uid) ON DELETE CASCADE,
    FOREIGN KEY(approved_by) REFERENCES users(uid) ON DELETE CASCADE,
    INDEX idx_status (status),
    INDEX idx_location (saddress)
);
-- reviews table
CREATE TABLE review (
    rid INT PRIMARY KEY AUTO_INCREMENT,
    uid INT NOT NULL,
    sid INT NOT NULL,
    review TEXT NOT NULL,
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(uid) REFERENCES users(uid) ON DELETE CASCADE,
    FOREIGN KEY(sid) REFERENCES shop(sid) ON DELETE CASCADE,
    UNIQUE (uid, sid),
    INDEX idx_shop_reviews (sid),
    INDEX idx_users_reviews (uid)
);
-- services table
CREATE TABLE services (
    services_id INT PRIMARY KEY AUTO_INCREMENT,
    services_name VARCHAR(100) NOT NULL UNIQUE
);
-- shop services 
CREATE TABLE shop_services (
    sid INT NOT NULL,
    services_id INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    duration INT NOT NULL,
    PRIMARY KEY (sid, services_id),
    FOREIGN KEY (sid) REFERENCES shop(sid) ON DELETE CASCADE,
    FOREIGN KEY (services_id) REFERENCES services(services_id) ON DELETE CASCADE
);
-- favorite shops of a user 
CREATE TABLE favorites (
    uid INT NOT NULL,
    sid INT NOT NULL,
    PRIMARY KEY(uid, sid),
    FOREIGN KEY (uid) REFERENCES users(uid) ON DELETE CASCADE,
    FOREIGN KEY (sid) REFERENCES shop(sid) ON DELETE CASCADE,
    INDEX idx_user (uid)
);
-- queue table 
CREATE TABLE queue (
    qid INT PRIMARY KEY AUTO_INCREMENT,
    uid INT NOT NULL,
    sid INT NOT NULL,
    queue_number INT NOT NULL,
    status ENUM(
        'waiting',
        'in_service',
        'completed',
        'cancelled'
    ) DEFAULT 'waiting',
    total_duration INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    joined_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    service_started_at DATETIME NULL,
    completed_at DATETIME NULL,
    UNIQUE (uid, sid, status) FOREIGN KEY (uid) REFERENCES users(uid) ON DELETE CASCADE,
    FOREIGN KEY (sid) REFERENCES shop(sid) ON DELETE CASCADE,
    INDEX idx_shop_status (sid, status),
    INDEX idx_user (uid)
);
-- Queue services
CREATE TABLE queue_services (
    qid INT NOT NULL,
    services_id INT NOT NULL,
    PRIMARY KEY (qid, services_id),
    FOREIGN KEY (qid) REFERENCES queue(qid) ON DELETE CASCADE,
    FOREIGN KEY (services_id) REFERENCES services(services_id) ON DELETE CASCADE
);