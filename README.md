# job-board-api

README: Laravel Job Board API

1. Project Overview

The Laravel Job Board API provides an efficient way to fetch and filter job listings using advanced filtering, EAV attributes, and cursor-based pagination.

2. Setup Instructions
Prerequisites

PHP 8.1+
Laravel 10+
MySQL / PostgreSQL
Composer


Installation

git clone https://github.com/Hashir-tech/job-board-api.git

cd job-board-api

composer install

cp .env.example .env

php artisan key:generate

Database Setup

Update .env file with your database credentials:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=job_board
DB_USERNAME=root
DB_PASSWORD=

Run migrations and seed data

php artisan migrate --seed

Running the API

php artisan serve

The API will be available at: http://127.0.0.1:8000/api/jobs
