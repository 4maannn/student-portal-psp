# PSP Student Portal — Mini Project 2
**DFP40443 Full Stack Web Development**

## Requirements
- XAMPP / WAMP / MAMP (PHP 7.4+ and MySQL/MariaDB)
- A web browser

## Setup Instructions
1. Copy the `psp_student_portal` folder into your web server's document root
   (e.g. `C:\xampp\htdocs\psp_student_portal`).
2. Start Apache and MySQL from your XAMPP Control Panel.
3. Open **phpMyAdmin** (`http://localhost/phpmyadmin`), create a new database,
   then import `database.sql` (it also creates the database for you if you
   run the whole file directly via the **Import** tab or the `mysql` CLI:
   `mysql -u root -p < database.sql`).
4. If your MySQL username/password differ from the default XAMPP setup
   (`root` / empty password), edit `config/database.php` accordingly.
5. Visit `http://localhost/psp_student_portal/login.php` in your browser.

## Demo Login
| IC Number      | Password      |
|-----------------|---------------|
| 900101015566    | Student@123   |
| 910305087788    | Student@123   |

## Database Design
Two related tables:
- **`students`** — academic/profile data: `name`, `ic` (unique), `program`, `marks`.
- **`users`** — login credentials only: `student_id` (FK → `students.id`, unique) and `password` (bcrypt hash).

Relationship: **one-to-one**, `users.student_id` → `students.id`, with `ON DELETE CASCADE` —
deleting a student automatically removes their login account too.

## Folder Structure (MVC)
```
psp_student_portal/
├── config/database.php          # PDO database connection (Singleton)
├── models/StudentModel.php      # CRUD queries on "students" (Model)
├── models/UserModel.php         # Login/password queries on "users" (Model)
├── views/                       # All HTML/Bootstrap templates (View)
│   ├── layout/                  # shared header & footer
│   ├── auth/                    # login page
│   ├── profile/                 # profile + change password pages
│   └── students/                # grade management CRUD pages
├── includes/
│   ├── functions.php            # reusable helpers (sanitize, redirect, validators)
│   └── session_check.php        # auth guard, included on every protected page
├── public/
│   ├── css/style.css
│   └── js/validation.js         # client-side validation + delete confirmation
├── index.php                    # dashboard (Controller)
├── login.php                    # AuthController
├── logout.php
├── profile.php                  # ProfileController (Part 1.1)
├── change_password.php          # PasswordController (Part 1.2)
├── students_list.php            # StudentController::index  (READ)
├── students_create.php          # StudentController::create (CREATE)
├── students_edit.php            # StudentController::update (UPDATE)
├── students_delete.php          # StudentController::delete (DELETE)
└── database.sql                 # schema + seed data
```

## Features Implemented
- **MVC architecture** with modular `include`/`require` for shared components.
- **Session management**: profile data is fetched strictly from `$_SESSION['student_id']`,
  never from user-supplied IDs, so a student cannot view another student's record.
- **Database Relationship**: `users` (1) —— (1) `students` via `student_id` FK; login joins
  the two tables, and creating/deleting a student provisions/removes the matching account.
- **Password Exchange Module**: verifies the old password with `password_verify()`
  before allowing a change, and stores the new password with `password_hash()` — both
  operating on the `users` table via `$_SESSION['user_id']`.
- **Full CRUD** on the `students` table using PDO **prepared statements** throughout
  (protects against SQL Injection).
- **Client-side + server-side validation** on all forms (required fields, IC format,
  marks range 0–100, password match/length).
- **Delete confirmation** prompt via JavaScript before permanent deletion.
- **Responsive UI** built with Bootstrap 5 (via CDN).


---

## Mini Project 2 additions

### Profile picture upload
- Controller: `upload_picture.php` | Helpers: `includes/functions.php` | Model: `StudentModel::updateProfilePicture()`
- Stored in `uploads/profile/`, filename saved in `students.profile_picture`
- Validation: .jpg/.jpeg/.png only, max 2MB, real MIME check, renamed with `uniqid()`
- `uploads/profile/.htaccess` blocks script execution

### Database upgrade
Existing database: run `migration_mini_project_2.sql`. Fresh install: import `database.sql`.

### Configuration
Copy `config/db_credentials.example.php` to `config/db_credentials.php` and enter your MySQL details
(local XAMPP or live hosting). This file is git-ignored.

### Deployment (InfinityFree)
1. Create the hosting account and a MySQL database.
2. Import `database.sql` (or the migration) with phpMyAdmin.
3. Upload all files to `htdocs/` and create `config/db_credentials.php` on the server.
4. Make sure `uploads/profile/` is writable (755).
