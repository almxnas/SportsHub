# SportsHub – Sports Facility Booking System

## Group: Ayam Gepuk Supremacy
- Sadia Ahmad (2413422)
- Fathima Hiba (2411914)
- Al Meerah Anas (2416772)

## Course
BIIT 2305 Web Application Development (Section 2)

## Features
- User authentication (Student / Admin)
- Browse facilities with search/filter by sport type & location
- Real-time availability checking
- Book, cancel, and review facilities
- Admin dashboard to manage facilities

## Technologies
- Laravel 12, MySQL, Blade, Tailwind CSS, Laravel Breeze

## Installation
```bash
composer install
cp .env.example .env
# set DB_DATABASE=sports_hub, DB_USERNAME=root, DB_PASSWORD=
php artisan key:generate
php artisan migrate --seed
npm install && npm run build
php artisan serve
