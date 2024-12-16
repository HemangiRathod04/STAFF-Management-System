# STAFF-Management-System
This project is a Laravel-based application for managing staff. It includes features such as staff registration, login, an admin dashboard for managing staff, and API integrations using Laravel Passport.

# Laravel Project: Staff Management

## Introduction
This project is a Laravel-based application for managing staff. It includes features such as staff registration, login, an admin dashboard for managing staff, and API integrations using Laravel Passport.

---

## Requirements
- PHP >= 8.0
- Composer
- MySQL or any other database supported by Laravel

---

## Installation Steps
1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd <project-directory>
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Create Database**
   - Create a database (e.g., `staff_management`) and update your `.env` file with database credentials.

4. **Run Migrations**
   ```bash
   php artisan migrate
   ```

5. **Seed Database**
   ```bash
   php artisan db:seed --class=AdminSeeder
   ```

6. **Install Laravel Passport**
   ```bash
   composer require laravel/passport
   php artisan passport:install
   ```

7. **Serve the Application**
   ```bash
   php artisan serve
   ```
   Access the application at `http://127.0.0.1:8000`.

---

## Features
### Admin Features
- **Admin Login**
  - Email: `admin@gmail.com`
  - Password: `password`

- **Admin Dashboard**
  - Overview of staff activities.

- **Staff Management**
  - List all staff members.
  - Add new staff with validation.
  - Edit staff details.

- **Notification**
  - Send an email to staff upon registration.

### Staff Features
- **Registration and Login**
  - Staff can register and log in to their dashboard.

- **Dashboard**
  - Access personal details and updates.

- **Clock Out**
  - Staff can clock out, and this activity is listed on the admin side.

---

## API Integration
This project includes API functionality powered by Laravel Passport.
- **Login API**
- Other endpoints can be added as per project requirements.

---

## License
This project is licensed under the [MIT License](LICENSE).

---

## Contributions
Feel free to submit issues or pull requests. Contributions are welcome!

