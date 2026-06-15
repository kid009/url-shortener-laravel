# URL Shortener with Laravel

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <strong>A fast and simple URL Shortener built with Laravel</strong><br>
  Supports user authentication, role-based access, and link management.
</p>

---

## Table of Contents

- [Overview](#overview)
- [Tech Stack](#tech-stack)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Running the Project](#running-the-project)
- [Testing](#testing)
- [Project Structure](#project-structure)
- [User Roles](#user-roles)
- [License](#license)

---

## Overview

This project is a web-based URL shortener built with [Laravel](https://laravel.com). It includes user registration and authentication, allowing users to create short links, search their history, and manage their own URLs. Administrators can view and search all links created by any user.

---

## Tech Stack

- [Laravel 13.x](https://laravel.com/docs) — PHP Web Framework
- [PHP 8.3](https://www.php.net/)
- [Livewire 4.x](https://livewire.laravel.com/) — Interactive UI components without heavy JavaScript
- [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze) — Lightweight authentication scaffolding
- [Tailwind CSS 4.x](https://tailwindcss.com/) — Utility-first CSS framework
- [Flowbite](https://flowbite.com/) — UI components built on Tailwind CSS
- [Alpine.js](https://alpinejs.dev/) — Lightweight JavaScript framework
- [Vite](https://vitejs.dev/) — Frontend build tool
- [MySQL](https://www.mysql.com/) — Primary database

---

## Features

- 🔐 User registration and authentication via Laravel Breeze
- 🔗 Create short links from long URLs with auto-generated 5-character short codes
- 📋 List links with original URL, short URL, creation date, and creator
- 🔍 Search links by:
  - Original URL
  - Creation date
  - Creator (admin only)
- 📄 Pagination support
- 🔔 Toast notifications for user feedback
- 👤 Role-based access: regular users see only their own links, admins see all links

---

## Requirements

- PHP >= 8.3
- Composer
- Node.js and npm
- MySQL or MariaDB
- Required PHP extensions: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`

---

## Installation

### 1. Clone the project and install dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 2. Set up the environment file

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Configure the database

Update the `.env` file with your database credentials. For example:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=short_url
DB_USERNAME=root
DB_PASSWORD=
```

Then run the migrations:

```bash
php artisan migrate
```

Alternatively, you can run the full setup with one command:

```bash
composer run setup
```

---

## Database Setup

The application uses MySQL as the default database. Make sure you have created the database specified in your `.env` file before running migrations.

Key migrations:

- `0001_01_01_000000_create_users_table.php` — Users, password resets, and sessions
- `2026_06_14_042522_create_urls_table.php` — Shortened URLs

---

## Running the Project

### Development Mode

```bash
composer run dev
```

This command starts:
- Laravel Development Server
- Queue Worker (`php artisan queue:listen`)
- Vite Dev Server

Then open your browser at [http://localhost:8000](http://localhost:8000)

### Production Build

```bash
npm run build
```

---

## Testing

Run the test suite with:

```bash
composer run test
```

Or directly with Artisan:

```bash
php artisan test
```

---

## Project Structure

```
url-shortener-laravel/
├── app/
│   ├── Actions/
│   │   └── CreateLinkAction.php      # Business logic for creating links
│   ├── DTOs/
│   │   └── LinkDTO.php               # Data transfer object for links
│   ├── Http/Controllers/
│   │   ├── LinkController.php        # Handles link pages
│   │   └── ManageLinkController.php  # Handles link management pages
│   ├── Livewire/Link/
│   │   └── LinkComponent.php         # Livewire component for creating and searching links
│   └── Models/
│       ├── Url.php                   # URL model
│       └── User.php                  # User model
├── database/migrations/
│   └── 2026_06_14_042522_create_urls_table.php
├── resources/views/
│   ├── links/index.blade.php
│   └── livewire/link/link-component.blade.php
├── routes/
│   └── web.php
└── README.md
```

---

## User Roles

| Role  | Capabilities |
|-------|-------------|
| Guest | Can view the landing page, but must log in to create links |
| User  | Can create, search, and view their own links |
| Admin | Can create, search, and view all users' links, including search by creator |

The default user role in the `users` table is `guest`. You can change a user's role to `admin` directly in the database.

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
