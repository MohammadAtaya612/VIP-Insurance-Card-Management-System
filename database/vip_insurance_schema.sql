-- VIP Insurance Database Schema
-- Run: mysql -u root -p vip_insurance < database/vip_insurance_schema.sql

CREATE DATABASE IF NOT EXISTS vip_insurance
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE vip_insurance;

-- Note: Use `php artisan migrate --seed` for full setup with Laravel.
-- This file is a reference schema only.
