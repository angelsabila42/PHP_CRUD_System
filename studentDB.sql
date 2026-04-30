-- Student Management System Database Setup
-- Import this file in phpMyAdmin to set up the database

CREATE DATABASE IF NOT EXISTS studentDB
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE studentDB;

CREATE TABLE IF NOT EXISTS students (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(100)  NOT NULL,
    email         VARCHAR(100)  NOT NULL UNIQUE,
    course        VARCHAR(100)  NOT NULL,
    phone_contact VARCHAR(15)   NOT NULL,
    reg_number    VARCHAR(30)   NOT NULL UNIQUE,
    created_at    TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
);
