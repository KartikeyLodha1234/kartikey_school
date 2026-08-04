CREATE DATABASE IF NOT EXISTS kartikeyschool;
USE kartikeyschool;

DROP TABLE IF EXISTS `transport_assign`;
DROP TABLE IF EXISTS `transport_fee`;
DROP TABLE IF EXISTS `student_fees`;
DROP TABLE IF EXISTS `fees`;
DROP TABLE IF EXISTS `students`;
DROP TABLE IF EXISTS `subjects`;
DROP TABLE IF EXISTS `sections`;
DROP TABLE IF EXISTS `classes`;
DROP TABLE IF EXISTS `routes`;
DROP TABLE IF EXISTS `vehicles`;
DROP TABLE IF EXISTS `drivers`;
DROP TABLE IF EXISTS `staff`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','teacher','accountant','driver') NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `staff` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `designation` VARCHAR(100) DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `email` VARCHAR(100) DEFAULT NULL,
  `status` ENUM('Active','Inactive','On Leave') DEFAULT 'Active'
);

CREATE TABLE `classes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `class_name` VARCHAR(50) NOT NULL,
  `section_count` INT DEFAULT 0
);

CREATE TABLE `sections` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `class_id` INT NOT NULL,
  `section_name` VARCHAR(20) NOT NULL,
  `room_no` VARCHAR(20) DEFAULT NULL,
  FOREIGN KEY (`class_id`) REFERENCES `classes`(`id`) ON DELETE CASCADE
);

CREATE TABLE `subjects` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `subject_name` VARCHAR(100) NOT NULL,
  `class_id` INT DEFAULT NULL,
  `status` ENUM('Active','Inactive') DEFAULT 'Active',
  FOREIGN KEY (`class_id`) REFERENCES `classes`(`id`) ON DELETE SET NULL
);

CREATE TABLE `students` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `admission_no` VARCHAR(50) UNIQUE NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `class_id` INT DEFAULT NULL,
  `section_id` INT DEFAULT NULL,
  `gender` ENUM('Male','Female','Other') DEFAULT 'Male',
  `dob` DATE DEFAULT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `status` ENUM('Active','Inactive') DEFAULT 'Active',
  FOREIGN KEY (`class_id`) REFERENCES `classes`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`section_id`) REFERENCES `sections`(`id`) ON DELETE SET NULL
);

CREATE TABLE `fees` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `fee_name` VARCHAR(100) NOT NULL,
  `fee_type` VARCHAR(50) DEFAULT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `status` ENUM('Active','Inactive') DEFAULT 'Active'
);

CREATE TABLE `student_fees` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT NOT NULL,
  `fee_id` INT NOT NULL,
  `amount_paid` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `due_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `payment_status` ENUM('Paid','Pending','Partial') DEFAULT 'Pending',
  `paid_on` DATE DEFAULT NULL,
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`fee_id`) REFERENCES `fees`(`id`) ON DELETE CASCADE
);

CREATE TABLE `routes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `route_name` VARCHAR(100) NOT NULL,
  `distance_km` DECIMAL(5,2) DEFAULT 0.00,
  `status` ENUM('Active','Inactive') DEFAULT 'Active'
);

CREATE TABLE `vehicles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `vehicle_no` VARCHAR(50) UNIQUE NOT NULL,
  `vehicle_type` VARCHAR(50) DEFAULT NULL,
  `driver_name` VARCHAR(100) DEFAULT NULL,
  `status` ENUM('Active','Inactive') DEFAULT 'Active'
);

CREATE TABLE `drivers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `license_no` VARCHAR(50) UNIQUE NOT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `status` ENUM('Active','Inactive','On Leave') DEFAULT 'Active'
);

CREATE TABLE `transport_fee` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `fee_id` VARCHAR(50) UNIQUE NOT NULL,
  `route_id` INT NOT NULL,
  `distance_km` DECIMAL(5,2) DEFAULT 0.00,
  `fee_amount` DECIMAL(10,2) NOT NULL,
  `status` ENUM('Active','Inactive') DEFAULT 'Active',
  FOREIGN KEY (`route_id`) REFERENCES `routes`(`id`) ON DELETE CASCADE
);

CREATE TABLE `transport_assign` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT NOT NULL,
  `route_id` INT NOT NULL,
  `vehicle_id` INT DEFAULT NULL,
  `pickup_point` VARCHAR(100) DEFAULT NULL,
  `pickup_time` TIME DEFAULT NULL,
  `drop_time` TIME DEFAULT NULL,
  `transport_fee` DECIMAL(10,2) DEFAULT 0.00,
  `status` ENUM('Active','Inactive','Hold') DEFAULT 'Active',
  `remarks` TEXT DEFAULT NULL,
  FOREIGN KEY (`student_id`) REFERENCES `students`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`route_id`) REFERENCES `routes`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles`(`id`) ON DELETE SET NULL
);

INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES
('Admin User', 'admin@school.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.', 'admin');

INSERT INTO `classes` (`class_name`, `section_count`) VALUES
('Grade 1', 2),
('Grade 2', 2),
('Grade 3', 2),
('Grade 4', 2),
('Grade 5', 2),
('Grade 6', 2),
('Grade 7', 2),
('Grade 8', 2),
('Grade 9', 2),
('Grade 10', 2),
('Grade 11', 2),
('Grade 12', 2);

INSERT INTO `sections` (`class_id`, `section_name`, `room_no`) VALUES
(1, 'A', '101'),
(1, 'B', '102'),
(2, 'A', '201'),
(2, 'B', '202');

INSERT INTO `subjects` (`subject_name`, `class_id`, `status`) VALUES
('Mathematics', 1, 'Active'),
('English', 1, 'Active'),
('Science', 2, 'Active'),
('Computer', 2, 'Active');

INSERT INTO `students` (`admission_no`, `name`, `class_id`, `section_id`, `gender`, `dob`, `phone`, `address`, `status`) VALUES
('ADM-001', 'Aarav Sharma', 10, 1, 'Male', '2010-05-12', '9876543210', 'City Center', 'Active'),
('ADM-002', 'Priya Patel', 8, 2, 'Female', '2012-04-18', '9876543211', 'North Side', 'Active');

INSERT INTO `fees` (`fee_name`, `fee_type`, `amount`, `status`) VALUES
('Tuition Fee', 'Academic', 1200.00, 'Active'),
('Transport Fee', 'Transport', 1500.00, 'Active'),
('Exam Fee', 'Academic', 500.00, 'Active');

INSERT INTO `student_fees` (`student_id`, `fee_id`, `amount_paid`, `due_amount`, `payment_status`, `paid_on`) VALUES
(1, 1, 1200.00, 0.00, 'Paid', '2026-08-01'),
(1, 2, 1000.00, 500.00, 'Partial', '2026-08-01'),
(2, 1, 900.00, 300.00, 'Partial', '2026-08-02');

INSERT INTO `routes` (`route_name`, `distance_km`, `status`) VALUES
('Route 1 - City Center', 12.00, 'Active'),
('Route 2 - North Side', 18.00, 'Active'),
('Route 3 - South Side', 22.00, 'Active');

INSERT INTO `vehicles` (`vehicle_no`, `vehicle_type`, `driver_name`, `status`) VALUES
('MH-12-AB-1234', 'Bus', 'Ramesh Kumar', 'Active'),
('MH-12-CD-5678', 'Van', 'Suresh Patel', 'Active');

INSERT INTO `drivers` (`name`, `license_no`, `phone`, `status`) VALUES
('Ramesh Kumar', 'DL-123456', '9898000001', 'Active'),
('Suresh Patel', 'DL-654321', '9898000002', 'Active');

INSERT INTO `transport_fee` (`fee_id`, `route_id`, `distance_km`, `fee_amount`, `status`) VALUES
('TF-001', 1, 12.00, 1200.00, 'Active'),
('TF-002', 2, 18.00, 1500.00, 'Active'),
('TF-003', 3, 22.00, 1800.00, 'Active');

INSERT INTO `transport_assign` (`student_id`, `route_id`, `vehicle_id`, `pickup_point`, `pickup_time`, `drop_time`, `transport_fee`, `status`, `remarks`) VALUES
(1, 1, 1, 'Main Gate', '07:00:00', '14:30:00', 1200.00, 'Active', 'Morning pickup'),
(2, 2, 2, 'Bus Stop', '06:45:00', '14:45:00', 1500.00, 'Active', 'North side route');
