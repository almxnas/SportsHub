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
**SportsHub** is a modern web‑based sports facility booking and management system developed using the Laravel MVC framework. The platform solves the common problem of manual booking and unorganised scheduling of sports facilities in universities or communities. It allows students and staff to conveniently browse available facilities (futsal courts, badminton courts, basketball courts, etc.), check real‑time availability, and make instant bookings.  

Administrators benefit from a dedicated panel to manage venues, schedules, and users – all with a clean, energetic sports‑themed responsive interface.

---

## Project Objectives
1. To develop a convenient online system for booking sports facilities.  
2. To provide real‑time availability checking and booking management.  
3. To implement different user roles (student / admin) with proper access control.  
4. To create an attractive, responsive, and easy‑to‑use interface.  
5. To apply Laravel best practices in developing a functional web application.

---

## Target Users
- **Students / Players** – browse facilities, check availability, book time slots, cancel bookings, and leave reviews.  
- **Administrators** – full control over the system: manage users, facilities, bookings, and reviews; add, edit or delete facilities.

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
- **Admin Dashboard** – overview of total users, facilities, bookings, and reviews.  
- **Facility Management** – add, edit, delete facilities (name, description, sport type, location, price, image URL).  
- **User Management** – view registered users (via database, no separate page in this version).  
- **Booking Management** – view all bookings (via database).  
- **Review Moderation** – view all reviews (via database).

---

## Technical Implementation
- **Backend Framework:** Laravel 12.x  
- **Frontend:** Blade Templates with Tailwind CSS (inline style overrides for guaranteed button visibility)  
- **Database:** MySQL (via XAMPP)  
- **Authentication:** Laravel Breeze  
- **Development Environment:** XAMPP + Git Bash / VS Code  

---

## Database Design

### Entity Relationship Diagram (ERD)
<img width="800" height="800" alt="image" src="https://github.com/user-attachments/assets/efa0558c-710d-478f-af63-7d7e9f8c0887" />

The ERD illustrates the database structure for SportsHub. The main entities are `users`, `facilities`, `bookings`, and `reviews`.  

**Relationships:**  
- A **user** can have many **bookings** and many **reviews** (one‑to‑many).  
- A **facility** can have many **bookings** and many **reviews** (one‑to‑many).  
- A **booking** belongs to one user and one facility; it may have one review (one‑to‑one).  
- A **review** belongs to one user, one facility, and one booking.  

This design ensures data integrity and supports all features: booking, cancellation, reviews, and facility management.

### Table Structures

#### `users`
| Column | Type | Description |
|--------|------|-------------|
| id | int | Primary key |
| name | varchar | User's name |
| email | varchar | Unique login credential |
| password | varchar | Hashed password |
| role | varchar | `student` or `admin` |
| timestamps | - | created_at, updated_at |

#### `facilities`
| Column | Type | Description |
|--------|------|-------------|
| id | int | Primary key |
| name | varchar | Facility name |
| description | text | Detailed description |
| sport_type | varchar | e.g., Futsal, Badminton |
| location | varchar | Campus or venue |
| price_per_hour | decimal | Cost per hour |
| image | varchar | URL to facility image |
| timestamps | - | created_at, updated_at |

#### `bookings`
| Column | Type | Description |
|--------|------|-------------|
| id | int | Primary key |
| user_id | foreign key | References users.id |
| facility_id | foreign key | References facilities.id |
| booking_date | date | Date of booking |
| start_time | time | Start time (e.g., 14:00:00) |
| end_time | time | End time |
| status | varchar | `confirmed` or `cancelled` |
| total_price | decimal | Calculated price |
| timestamps | - | created_at, updated_at |

#### `reviews`
| Column | Type | Description |
|--------|------|-------------|
| id | int | Primary key |
| user_id | foreign key | References users.id |
| facility_id | foreign key | References facilities.id |
| booking_id | foreign key | References bookings.id |
| rating | int | 1–5 stars |
| comment | text | Optional feedback |
| timestamps | - | created_at, updated_at |

---

## Laravel Components Implementation

### Routes (`routes/web.php`)
Key route groups:

```php
// Public facility browsing
Route::get('/facilities', [FacilityController::class, 'index'])->name('facilities.index');
Route::get('/facilities/{facility}', [FacilityController::class, 'show'])->name('facilities.show');

// Authenticated (student) routes
Route::middleware(['auth'])->group(function () {
    Route::post('/facilities/{facility}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('my-bookings');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/review', [ReviewController::class, 'store'])->name('reviews.store');
});

// Admin routes (protected by auth + admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('facilities', AdminFacilityController::class);
});
```

### Controllers
- **`FacilityController`** – `index()` lists facilities with search/filter; `show()` displays a single facility with its booking form.  
- **`BookingController`** – `store()` validates, checks availability (prevents overlaps), calculates total price, saves booking; `myBookings()` lists user’s bookings; `cancel()` updates status.  
- **`ReviewController`** – `store()` saves a review after booking.  
- **`Admin/DashboardController`** – `index()` returns statistics for the admin dashboard.  
- **`Admin/FacilityController`** – full CRUD (index, create, store, edit, update, destroy) for facility management.

### Models and Relationships

**User model** – includes `role` attribute and relationships:
```php
public function bookings() { return $this->hasMany(Booking::class); }
public function reviews() { return $this->hasMany(Review::class); }
```

**Facility model** – fillable fields and relationships:
```php
protected $fillable = ['name','description','sport_type','location','price_per_hour','image'];
public function bookings() { return $this->hasMany(Booking::class); }
public function reviews() { return $this->hasMany(Review::class); }
public function avgRating() { return $this->reviews()->avg('rating') ?? 0; }
```

**Booking model** – belongs to user and facility; has one review:
```php
protected $fillable = ['user_id','facility_id','booking_date','start_time','end_time','status','total_price'];
```

**Review model** – belongs to user, facility, and booking.

### Middleware – `AdminMiddleware`
```php
if (Auth::check() && Auth::user()->role === 'admin') {
    return $next($request);
}
abort(403);
```
Registered in `bootstrap/app.php` with alias `'admin'`.

### Views (Blade Templates)
All views are located in `resources/views/`:
- `facilities/index.blade.php` – facility grid with search/filter and **View & Book** buttons.  
- `facilities/show.blade.php` – facility details and booking form.  
- `bookings/my-bookings.blade.php` – user’s bookings with cancel and review forms.  
- `admin/dashboard.blade.php` – statistics and **Manage Facilities** button.  
- `admin/facilities/index.blade.php` – list of facilities with edit/delete and **+ Add Facility** button.  
- `admin/facilities/create.blade.php` – form to add a new facility.  
- `admin/facilities/edit.blade.php` – form to edit existing facility.  
- `layouts/app.blade.php` – main layout with navigation and session messages.  
- `layouts/navigation.blade.php` – dynamic navigation (shows Admin Panel only for role=admin).

> **Note:** To guarantee button visibility across all browsers, inline CSS (`style="..."`) was used on critical buttons (e.g., “View & Book”, “Confirm Booking”, “Add Review”, “Manage Facilities”, “+ Add Facility”, “Edit”, “Delete”, “Save”). This overrides any conflicting Tailwind classes.

---

## User Authentication System
- **Registration & Login** – provided by Laravel Breeze (email + password).  
- **Role Assignment** – after registration, the default role is `student`. An admin account is created via seeder or tinker.  
- **Access Control** – the `AdminMiddleware` protects admin routes; navigation menu conditionally shows the admin link only if `Auth::user()->role === 'admin'`.

### Demo Credentials
- **Student** – register a new account (use your personal email), or log in with the account you created during testing.  
- **Admin** – login with:  
  Email: `admin@sportshub.com`  
  Password: `password`  

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
   This creates the tables and inserts sample facilities, an admin user, and a student user.

7. **Start the development server**:
   ```bash
   php artisan serve
   ```
   The application will be available at `http://127.0.0.1:8000`.

---

## Testing and Quality Assurance

### Functionality Testing
The following features have been tested and confirmed working:

- [x] User registration, login, logout.  
- [x] Student can browse all facilities, filter by sport type/location.  
- [x] Facility detail page shows correct info and booking form.  
- [x] Booking – availability check prevents double‑booking; total price calculated correctly.  
- [x] My Bookings – displays confirmed and cancelled bookings.  
- [x] Cancel booking – status updates to “cancelled”.  
- [x] Add review – rating and comment are saved and displayed on facility page.  
- [x] Admin login (role=admin) – sees Admin Panel link.  
- [x] Admin Dashboard – shows total users, facilities, bookings, reviews.  
- [x] Manage Facilities – list, add, edit, delete facilities.  
- [x] Search/filter works on facilities index.  
- [x] All buttons are visible and functional (inline styles guarantee visibility).

### Browser Compatibility
- Google Chrome (Latest) – fully compatible.  
- Mozilla Firefox (Latest) – fully compatible.  
- Microsoft Edge (Latest) – fully compatible.

---

## Challenges Faced and Solutions

| Challenge | Solution |
|-----------|----------|
| White / invisible buttons (Tailwind CSS overrides) | Used inline `style` attributes for critical buttons. |
| Missing migration columns (`user_id` in bookings, `comment` in reviews) | Added columns manually via `php artisan tinker` with `ALTER TABLE`. |
| 419 Page Expired (CSRF) | Ensured `@csrf` in forms; temporarily added booking route to `VerifyCsrfToken::$except` for demo. |
| Admin dashboard view not found | Moved `dashboard.blade.php` from `admin/facilities/` to `admin/`. |
| Negative total price | Fixed calculation using `abs()` and correct `diffInMinutes()/60`. |
| SQLite vs MySQL confusion | Switched from SQLite to MySQL and updated `.env`. |

---

## Future Enhancements
- **Image upload** – allow admins to upload facility images instead of URLs.  
- **Time slot picker** – visual grid for selecting time slots.  
- **Email notifications** – booking confirmation and reminders.  
- **Admin user management** – page to manage all registered users.  
- **Pagination** – for large facilities list.  
- **Advanced search** – filter by price range, date availability.

---

## Learning Outcomes

### Technical Skills Gained
- Laravel Framework – MVC, Eloquent, Blade, Artisan.  
- Database Design – migrations, relationships, seeding.  
- Authentication & Authorization – role‑based middleware and blade conditionals.  
- Frontend Development – Tailwind CSS and inline overrides.  
- Real‑time availability logic – complex query to prevent overlaps.  
- Version Control – Git and GitHub collaboration.

### Soft Skills Developed
- Team Collaboration – task distribution via WhatsApp and VS Code Live Share.  
- Problem Solving – debugging migrations, CSRF, and visibility issues.  
- Time Management – delivering a complete app under tight deadline.  
- Documentation – professional README with clear structure.

---

## References
- [Laravel Documentation](https://laravel.com/docs)  
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)  
- [MDN Web Docs](https://developer.mozilla.org)  
- [Stack Overflow](https://stackoverflow.com)  
- dbdiagram.io – ERD design.  
- Unsplash – placeholder sports images.

---

## Demo Video
()

## GitHub Repository
[https://github.com/almxnas/SportsHub](https://github.com/almxnas/SportsHub)

---

## Conclusion
SportsHub successfully demonstrates a complete Laravel‑based sports facility booking system. All planned objectives were met: convenient online booking, real‑time availability checks, role‑based access (student / admin), an attractive responsive interface, and adherence to Laravel best practices.

Students can browse, filter, book, cancel, and review facilities. Administrators have full CRUD control over facilities and an overview dashboard. Despite challenges with button visibility and database migrations, the final application is fully functional and ready for presentation.

The project provided invaluable hands‑on experience in full‑stack web development, team collaboration, and problem solving – directly applicable to real‑world software development.

**Project Completion Date:** 14 June 2026  
**Course:** BIIT 2305 Web Application Development (Section 2)
