DROP DATABASE IF EXISTS hostelmanagementsystem_city_university;
CREATE DATABASE IF NOT EXISTS hostelmanagementsystem_city_university;
USE hostelmanagementsystem_city_university;

-- User table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    mail VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'student', 'provost', 'hallsuper', 'accounts') NOT NULL,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    verified BOOLEAN NOT NULL DEFAULT FALSE
);
-- Create a new table for detailed user information
CREATE TABLE user_info (
    usr INT AUTO_INCREMENT PRIMARY KEY,
    profile_pic_path VARCHAR(255),
    phone_number VARCHAR(20),
    address TEXT,
    date_of_birth datetime(6) NOT NULL,
    gender ENUM('Male', 'Female', 'Other'),
    nationality VARCHAR(50),
    emergency_contact_name VARCHAR(255),
    emergency_contact_phone VARCHAR(20),
    blood_type VARCHAR(5),
    medical_conditions TEXT,
    hobbies TEXT,
    about_me TEXT

);
-- Applications table
CREATE TABLE applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    path_to_file VARCHAR(255) NOT NULL,
    application_type ENUM('leave', 'room_allocation', 'complaint', 'cancel') NOT NULL,
    status ENUM('pending', 'approved', 'canceled') NOT NULL,
    applied_by INT NOT NULL,
    approved_by INT NOT NULL,
    date datetime(6) NOT NULL,
    description TEXT
);

-- Payment table
CREATE TABLE payment (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    user INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'paid', 'due') NOT NULL,
    description TEXT,
    date datetime(6) NOT NULL,
    transaction_id VARCHAR(255),
    others TEXT
);


-- Notice table
CREATE TABLE notice (
    notice_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    visibility ENUM('public', 'admin', 'student', 'provost', 'hallsuper', 'accounts') NOT NULL,
    date datetime(6) NOT NULL,
    updated_by INT
);

-- Room table
CREATE TABLE room (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    floor INT NOT NULL,
    room_no INT NOT NULL,
    no_of_seats INT NOT NULL,
    status VARCHAR(255)
);

-- Seats table
CREATE TABLE seats (
    seat_id INT AUTO_INCREMENT PRIMARY KEY,
    room_no INT,
    status VARCHAR(255),
    occupied_by INT DEFAULT NULL,
    date datetime(6) NOT NULL
);

-- Seat Allocation table
CREATE TABLE seat_allocation (
    seat_allocation_id INT AUTO_INCREMENT PRIMARY KEY,
    seat_no INT,
    student INT,
    allocated_by INT,
    date datetime(6) NOT NULL,
    rent DECIMAL(10, 2),
    lease_start_date datetime(6) NOT NULL,
    lease_end_date datetime(6) NOT NULL,
    status ENUM('booked', 'expired', 'pending')
);

-- Inventory table
CREATE TABLE inventory (
    inventory_id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    status ENUM('available', 'out-of-stock') NOT NULL,
    description TEXT,
    last_updated_by INT,
    last_updated_date datetime(6) NOT NULL
);

-- Visitor Management: Visitors table
CREATE TABLE visitors (
    visitor_id INT AUTO_INCREMENT PRIMARY KEY,
    visiting_student_id INT,
    visitor_name VARCHAR(255) NOT NULL,
    visitor_contact_info VARCHAR(255),
    visit_purpose TEXT DEFAULT NULL,
    visit_date datetime(6) NOT NULL,
    check_in_time TIME,
    check_out_time TIME,
    checked_out BOOLEAN
);

-- Feedback table
CREATE TABLE feedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    usr INT,
    feedback_text TEXT,
    rating INT,
    date datetime(6) NOT NULL
);

-- Requests table
CREATE TABLE requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    usr INT,
    request_description TEXT,
    status ENUM('pending', 'in-progress', 'resolved'),
    resolved_by INT,
    date datetime(6) NOT NULL
);

-- Altering user_info table
ALTER TABLE user_info
ADD CONSTRAINT fk_user_info_usr
FOREIGN KEY (usr) REFERENCES users(id);

-- Altering applications table
ALTER TABLE applications
ADD CONSTRAINT fk_applications_applied_by
FOREIGN KEY (applied_by) REFERENCES users(id),
ADD CONSTRAINT fk_applications_approved_by
FOREIGN KEY (approved_by) REFERENCES users(id);

-- Altering payment table
ALTER TABLE payment
ADD CONSTRAINT fk_payment_user
FOREIGN KEY (user) REFERENCES users(id);


-- Altering notice table
ALTER TABLE notice
ADD CONSTRAINT fk_notice_updated_by
FOREIGN KEY (updated_by) REFERENCES users(id);

-- Altering seats table
ALTER TABLE seats
ADD CONSTRAINT fk_seats_room
FOREIGN KEY (room_no) REFERENCES room(room_id),
ADD CONSTRAINT fk_seats_occupied_by
FOREIGN KEY (occupied_by) REFERENCES users(id);

-- Altering seat_allocation table
ALTER TABLE seat_allocation
ADD CONSTRAINT fk_seat_allocation_seats
FOREIGN KEY (seat_no) REFERENCES seats(seat_id),
ADD CONSTRAINT fk_seat_allocation_student
FOREIGN KEY (student) REFERENCES users(id),
ADD CONSTRAINT fk_seat_allocation_allocated_by
FOREIGN KEY (allocated_by) REFERENCES users(id);

-- Altering inventory table
ALTER TABLE inventory
ADD CONSTRAINT fk_inventory_last_updated_by
FOREIGN KEY (last_updated_by) REFERENCES users(id);

-- Altering visitors table
ALTER TABLE visitors
ADD CONSTRAINT fk_visitors_visiting_student
FOREIGN KEY (visiting_student_id) REFERENCES users(id);

-- Altering feedback table
ALTER TABLE feedback
ADD CONSTRAINT fk_feedback_user
FOREIGN KEY (usr) REFERENCES users(id);

-- Altering requests table
ALTER TABLE requests
ADD CONSTRAINT fk_requests_user
FOREIGN KEY (usr) REFERENCES users(id),
ADD CONSTRAINT fk_requests_resolved_by
FOREIGN KEY (resolved_by) REFERENCES users(id);