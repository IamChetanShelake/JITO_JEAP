-- Reset Admin Panel Tables
-- Run this SQL script in your MySQL database

USE jitojeap_adminpanel_db;

-- Drop existing tables if they exist
DROP TABLE IF EXISTS chapters;
DROP TABLE IF EXISTS zones;

-- Now the migrations can create fresh tables with the correct structure
