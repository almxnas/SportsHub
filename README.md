# SportsHub – Sports Facility Booking System

## Group Information
**Group Name:** Ayam Gepuk Supremacy  
**Section:** 2  
**Instructor:** Madam Nor Azura binti Kamarulzaman  

**Group Members:**  
- Sadia Ahmad (2413422)  
- Fathima Hiba (2411914)  
- Al Meerah Anas (2416772)  

---

## Project Overview
**SportsHub** is a web‑based sports facility booking and management system built with Laravel. It allows students to browse facilities, check real‑time availability, make bookings, cancel bookings, and leave reviews.  
Administrators have a dedicated panel to manage facilities (add, edit, delete) and view system statistics.

---

## Project Objectives
1. To develop a convenient online system for booking sports facilities.  
2. To provide real‑time availability checking and booking management.  
3. To implement different user roles (student / admin) with proper access control.  
4. To create an attractive, responsive, and easy‑to‑use interface.  
5. To apply Laravel best practices in developing a functional web application.

---

## Target Users
- **Students** – browse facilities, book time slots, cancel bookings, leave reviews.  
- **Administrators** – manage facilities (add, edit, delete), view dashboard statistics.

---

## Features and Functionalities

### Student Features
- **User Authentication** – register, login, logout (Laravel Breeze).  
- **Browse Facilities** – view all facilities with images, sport type, location, price, and average rating.  
- **Search & Filter** – filter by sport type (Futsal, Badminton, Basketball) and location.  
- **Real‑time Availability** – system prevents double‑booking by checking overlapping time slots.  
- **Make a Booking** – select date, start time, end time → instant confirmation.  
- **My Bookings** – view upcoming and past bookings, cancel confirmed bookings.  
- **Reviews & Ratings** – after using a facility, students can give a star rating and write a comment.

### Admin Features
- **Admin Dashboard** – shows total users, facilities, bookings, and reviews.  
- **Facility Management** – full CRUD (add, edit, delete facilities) via a dedicated panel.

---

## Technical Implementation
- **Backend Framework:** Laravel 12.x  
- **Frontend:** Blade Templates with Tailwind CSS (inline style overrides for guaranteed button visibility)  
- **Database:** MySQL  
- **Authentication:** Laravel Breeze  
- **Development Environment:** XAMPP + Git Bash / VS Code  

---

## Database Design

### Entity Relationship Diagram (ERD)
<img width="722" height="742" alt="Screenshot 2026-06-14 210024" src="https://github.com/user-attachments/assets/ec75c362-4d77-47a9-9cf2-6773536d7fa3" />


The ERD shows the following relationships:  
- `users` → `bookings` (one‑to‑many)  
- `users` → `reviews` (one‑to‑many)  
- `facilities` → `bookings` (one‑to‑many)  
- `facilities` → `reviews` (one‑to‑many)  
- `bookings` → `reviews` (one‑to‑one)

### Main Tables

#### `users`
Stores student and admin accounts with a `role` column (`student` or `admin`).

#### `facilities`
Stores facility details: name, description, sport type, location, price per hour, image URL.

#### `bookings`
Stores bookings: which user, which facility, date, start time, end time, status, total price.

#### `reviews`
Stores reviews: rating (1‑5), comment, linked to a user, facility, and booking.

---

## Laravel Components Implementation

### Routes (`routes/web.php`)
Key routes:

```php
// Public facility browsing
Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
Route::get('/facilities/{facility}', [FacilityController::class, 'show'])->name('facilities.show');

// Student routes (authenticated)
Route::middleware(['auth'])->group(function () {
    Route::post('/facilities/{facility}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my-bookings');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/review', [ReviewController::class, 'store'])->name('reviews.store');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('facilities', AdminFacilityController::class);
});
```

### Controllers
- **`FacilityController`** – lists facilities with search/filter, shows a single facility with booking form.  
- **`BookingController`** – handles booking creation (with availability check), listing user bookings, and cancellation.  
- **`ReviewController`** – saves reviews after a booking.  
- **`Admin/DashboardController`** – returns statistics for the admin dashboard.  
- **`Admin/FacilityController`** – full CRUD for facilities (create, read, update, delete).

### Models and Relationships

**User model** – has many bookings and reviews.  
**Facility model** – has many bookings, many reviews, and an `avgRating()` method.  
**Booking model** – belongs to a user and a facility; has one review.  
**Review model** – belongs to a user, facility, and booking.

### Middleware – `AdminMiddleware`
Checks if the logged‑in user has `role = admin`. Protects all admin routes.

### Views (Blade Templates)
Key views:
- `facilities/index.blade.php` – facility grid with search/filter.  
- `facilities/show.blade.php` – facility details and booking form.  
- `bookings/my-bookings.blade.php` – user’s bookings with cancel and review forms.  
- `admin/dashboard.blade.php` – statistics and **Manage Facilities** button.  
- `admin/facilities/index.blade.php` – list of facilities with edit/delete and **+ Add Facility**.  
- `admin/facilities/create.blade.php` – form to add a new facility.  
- `admin/facilities/edit.blade.php` – form to edit a facility.  

> **Button visibility fix:** Inline CSS (`style="..."`) was used on all critical buttons because Tailwind classes were overridden in some browsers.

---

## User Authentication System
- **Registration & Login** – Laravel Breeze (email + password).  
- **Role Assignment** – new users default to `student`. Admin account is created via seeder or tinker.  
- **Access Control** – admin routes are protected by `AdminMiddleware`.

### Demo Credentials
- **Student** – register a new account (any email/password).  
- **Admin** – login with:  
  Email: `admin@sportshub.com`  
  Password: `password`  
*(Create the admin account via `php artisan tinker` if not already seeded.)*

---

## Installation and Setup Instructions

### Prerequisites
- PHP >= 8.1  
- Composer  
- Node.js & NPM  
- MySQL (via XAMPP)  
- Git

### Step‑by‑Step Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/almxnas/SportsHub.git
   cd SportsHub
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Install NPM dependencies and build assets**:
   ```bash
   npm install
   npm run build
   ```

4. **Environment configuration**:
   ```bash
   cp .env.example .env
   ```
   Edit `.env` and set your database credentials:
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sports_hub
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

6. **Run database migrations and seeders**:
   ```bash
   php artisan migrate --seed
   ```
   This creates tables and inserts sample facilities.

7. **Start the development server**:
   ```bash
   php artisan serve
   ```
   The application will be available at `http://127.0.0.1:8000`.

---

## Testing and Quality Assurance

### Functionality Testing 
- [x] User registration, login, logout.  
- [x] Student can browse facilities, filter by sport type/location.  
- [x] Facility detail page shows correct info and booking form.  
- [x] Booking – availability check prevents double‑booking; total price calculated.  
- [x] My Bookings – displays bookings with cancel option.  
- [x] Cancel booking – status updates to “cancelled”.  
- [x] Add review – rating and comment saved, shown on facility page.  
- [x] Admin login – sees Admin Panel link.  
- [x] Admin Dashboard – shows total users, facilities, bookings, reviews.  
- [x] Manage Facilities – add, edit, delete facilities.  
- [x] All buttons visible and functional (inline CSS fix).


## Challenges Faced and Solutions

| Challenge | Solution |
|-----------|----------|
| White / invisible buttons (Tailwind CSS overrides) | Used inline `style` attributes for critical buttons. |
| Missing migration columns (`user_id` in bookings, `comment` in reviews) | Added columns manually via `php artisan tinker`. |
| 419 Page Expired (CSRF) | Ensured `@csrf` in forms; temporarily added booking route to `VerifyCsrfToken::$except` for demo. |
| Admin dashboard view not found | Moved `dashboard.blade.php` from `admin/facilities/` to `admin/`. |
| Negative total price | Fixed calculation using `abs()` and correct `diffInMinutes()/60`. |
| SQLite vs MySQL confusion | Switched from SQLite to MySQL and updated `.env`. |

---

## Future Enhancements
- **Image upload** – allow admins to upload images instead of using URLs.  
- **Time slot picker** – visual grid for easier selection.  
- **Email notifications** – send booking confirmations.  
- **Pagination** – for facilities list when many facilities exist.

---

## Learning Outcomes

### Technical Skills Gained
- Laravel MVC, Eloquent, Blade, Artisan.  
- Database migrations, seeding, relationships.  
- Role‑based authentication with custom middleware.  
- Real‑time availability logic (complex query to prevent overlaps).  
- Git & GitHub collaboration.

### Soft Skills Developed
- Team collaboration (VS Code Live Share, WhatsApp).  
- Debugging and problem solving.  
- Time management under deadline pressure.  
- Documentation and presentation preparation.

---

## References
- [Laravel Documentation](https://laravel.com/docs)  
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)  
- [MDN Web Docs](https://developer.mozilla.org)  
- [Stack Overflow](https://stackoverflow.com)  
- dbdiagram.io – ERD design.

---

## GitHub Repository
[https://github.com/almxnas/SportsHub](https://github.com/almxnas/SportsHub)

---

## Conclusion
SportsHub is a functional sports facility booking system. Students can browse, filter, book, cancel, and review facilities. Administrators can manage facilities and view system statistics. All core objectives were met. Despite challenges with CSS visibility and database migrations, the final application is stable and ready for presentation.

**Project Completion Date:** 14 June 2026  
**Course:** BIIT 2305 Web Application Development (Section 2)
