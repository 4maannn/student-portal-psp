

CREATE DATABASE IF NOT EXISTS psp_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE psp_portal;

DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS students;

CREATE TABLE students (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100)   NOT NULL,
    ic         VARCHAR(20)    NOT NULL UNIQUE,
    program    VARCHAR(100)   NOT NULL,
    marks      DECIMAL(5,2)   NOT NULL DEFAULT 0.00,
    profile_picture VARCHAR(255) NULL DEFAULT NULL,   -- renamed upload filename (Mini Project 2)
    created_at TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;


CREATE TABLE users (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT            NOT NULL UNIQUE,
    password   VARCHAR(255)   NOT NULL,          -- bcrypt hash via password_hash()
    created_at TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_student
        FOREIGN KEY (student_id) REFERENCES students(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;


INSERT INTO students (id, name, ic, program, marks) VALUES
(1, 'Ahmad Danial bin Zulkifli', '900101015566', 'Diploma in Computer Science', 78.50),
(2, 'Nur Aisyah binti Rahman', '910305087788', 'Diploma in Information Technology', 65.00),
(3, 'Tan Wei Jian', '890722109912', 'Diploma in Information Technology', 42.75),
(4, 'Siti Nurhaliza binti Kassim', '920815145523', 'Diploma in Computer Science', 88.00);

INSERT INTO users (student_id, password) VALUES
(1, '$2y$10$cD7gQYnBsnyA1hyr/aq.8uhuP8WwAvNOCqQ/Xv1mg7co08EtAYwF.'),
(2, '$2y$10$cD7gQYnBsnyA1hyr/aq.8uhuP8WwAvNOCqQ/Xv1mg7co08EtAYwF.'),
(3, '$2y$10$cD7gQYnBsnyA1hyr/aq.8uhuP8WwAvNOCqQ/Xv1mg7co08EtAYwF.'),
(4, '$2y$10$cD7gQYnBsnyA1hyr/aq.8uhuP8WwAvNOCqQ/Xv1mg7co08EtAYwF.');
