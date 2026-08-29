# Office Task Tracker (Laravel)

A clean, modern, and production-ready **Office Task Tracker** web application built with **Laravel** and **Tailwind CSS**.

---

## 📌 Project Overview
Office Task Tracker helps teams organize, track, and manage everyday office tasks efficiently. It provides:
- **Dynamic Dashboard**: Real-time task statistics (Total, Pending, In Progress, Completed, High Priority, and Completion Percentage Rate).
- **Task Management**: Full CRUD capabilities (Create, Read, Update, Delete) with server-side validation.
- **Dedicated Task List View**: Sortable, filterable, and searchable full table view with assignee avatars and overdue indicators.
- **Due Soon Alerts**: Highlights tasks due within the next 3 days.
- **Recent Tasks**: Quick-access preview of the 5 latest tasks with relative time badges.
- **CSV Export**: Securely feature-flagged CSV export of tasks.
- **Interactive UI**: Dark/Light mode toggle, and a Mobile/Desktop responsive device preview switch.

---

## 🚀 Installation & Setup Guide

### 1. Clone the Repository
```bash
git clone https://github.com/ramim452996/New-folder.git
cd New-folder
```

### 2. Install Dependencies
```bash
composer install
npm install && npm run build
```

### 3. Environment Configuration
Create your `.env` file by copying from `.env.example`:
```bash
cp .env.example .env
```
Generate the application key:
```bash
php artisan key:generate
```

### 4. Configure Database
In your `.env` file, configure your database connection:

**For MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=office_task_tracker
DB_USERNAME=root
DB_PASSWORD=your_password
```

**For SQLite (Default local development):**
```env
DB_CONNECTION=sqlite
```

### 5. Run Database Migrations
Run the migrations to create the database schema:
```bash
php artisan migrate
```

### 6. Start the Application
Run the local development server (or use Laravel Herd):
```bash
php artisan serve
```
Visit `http://localhost:8000` or `http://office-task-manager.test` in your browser.

---

## ⚙️ Custom Environment Variables (.env)

The application supports dynamic configuration via environment variables:

| Variable | Default Value | Description |
|---|---|---|
| `OFFICE_APP_NAME` | `"ASTGD Task Tracker"` | Controls application title in navbar & browser tab |
| `COMPANY_NAME` | `"ASTGD"` | Displayed in dashboard header and footer copyright |
| `COMPANY_EMAIL` | `"info@astgd.com"` | Displayed in footer mailto link |
| `TASKS_PER_PAGE` | `10` | Number of tasks per page for dashboard pagination |
| `ENABLE_TASK_EXPORT` | `true` | Feature flag to toggle CSV Export button & route access |

---

## 🔍 Architecture & Interview Concepts (Review Reference)

### 1. Why `.env` is used?
The `.env` file isolates environment-specific configurations (such as database credentials, API keys, app mode, and feature toggles) from the source code. This allows the application to run smoothly across different environments (Local, Staging, Production) without modifying any codebase files.

### 2. Difference between `.env` and `.env.example`
- **`.env`**: Contains the actual, active environment values and sensitive secrets (passwords, app keys). Kept strictly local and private.
- **`.env.example`**: A sanitized template committed to version control that demonstrates all required variable keys with safe placeholders.

### 3. Why `.env` is never committed to GitHub?
To prevent security breaches, credential leaks, and data exposure. It is strictly excluded via `.gitignore`.

### 4. Application Flow & Structure
```
HTTP Request ➡️ routes/web.php ➡️ TaskController ➡️ Task Model ➡️ Database (MySQL/SQLite) ➡️ Blade View
```
- **Migration** (`database/migrations/...`): Defines table schema (`tasks` table with title, description, assigned_to, priority, status, due_date).
- **Model** (`app/Models/Task.php`): Handles data layer, `$fillable` protection, and date casting.
- **Controller** (`app/Http/Controllers/TaskController.php`): Handles business logic, query filtering, pagination, and request validation.
- **Routes** (`routes/web.php`): Maps HTTP endpoints to controller actions.
- **Validation**: Enforces strict custom error messages before storing/updating tasks.

### 5. Dynamic Pagination & Feature Flagging
- Changing `TASKS_PER_PAGE` in `.env` automatically alters the pagination limit via `config('office.tasks_per_page')`.
- Toggling `ENABLE_TASK_EXPORT=false` hides the CSV export button in the Blade UI and returns a `403 Forbidden` response if the export route is accessed directly.

---

## 🧪 Testing
Run the test suite to verify application integrity:
```bash
php artisan test
```

---

## 📄 License
Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
