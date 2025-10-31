# Hotel Booking Task - Afif Rayhan

A Laravel based hotel booking system with smart date validation, availability checking, and automatic price adjustments.
The system automatically prevents overlapping bookings and disables fully booked dates in the calendar.
---

## Installation Guide

### Requirements
- PHP 8.2 or higher 
- Composer
- Node.js and NPM
- (Optional) XAMPP or any local PHP server  
- SQLite (used by default in this project)

---

### Setup Steps
1. Clone the repository:

git clone https://github.com/afifrayhan/hotel-booking-task-afif-rayhan.git

cd hotel-booking-task-afif-rayhan

2. Install dependencies:

composer install

npm install

npm run build

3. Environment Setup:

cp .env.example .env

php artisan key:generate

4. Database Setup in .env:
COMMENT/REMOVE THE MYSQL (I did the project with MySQL first and changed it to SQLite later)

DB_CONNECTION=sqlite

DB_DATABASE=database/database.sqlite

#Make a database.sqlite file inside database if missing

5. Run the migrations:

php artisan migrate --seed

6. Run the application:

php artisan serve

Open in your browser: http://localhost:8000

5. Default Pages:

/ → Home / Booking Page

/check-availability → Room Availability Checker

/bookings → Booking Confirmation
