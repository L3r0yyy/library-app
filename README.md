# Library Management System

A modern, web-based Library Management application built with Laravel, Tailwind CSS, and Alpine.js.

## Features

- **User Authentication:** Secure login and registration system.
- **Book Management:** 
  - Admin users can Add, Edit, and Delete books.
  - Track book availability, ISBN, Author, and Categories.
- **Borrowing System:**
  - Standard users can browse and borrow available books.
  - Return borrowed books.
  - Automatic due date tracking (14-day checkout period).
  - Highlighting of overdue books.
- **Dashboard:**
  - **Admin Dashboard:** View system statistics (Total Users, Books, Active Loans, Overdue Loans) and manage user roles (promote users to Admins).
  - **User Dashboard:** View total library stats and track personal active loans, including overdue statuses.
- **Role-Based Access Control (RBAC):** Distinct permissions for `admin` and `user` roles to secure application features.
- **Clean UI:** Responsive, modern design using Tailwind CSS.

## Tech Stack

*   **Framework:** Laravel 11.x
*   **Frontend:** Blade Templates, Tailwind CSS
*   **Database:** MariaDB (via Laravel Sail)
*   **Environment:** Docker (Laravel Sail)

## Prerequisites

*   Docker Desktop installed and running.
*   Composer installed locally (or via Docker).

## Getting Started

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd library-app
   ```

2. **Install Composer Dependencies:**
   If you have composer installed locally:
   ```bash
   composer install
   ```

3. **Set up Environment File:**
   ```bash
   cp .env.example .env
   ```

4. **Start Laravel Sail (Docker):**
   ```bash
   ./vendor/bin/sail up -d
   ```

5. **Generate Application Key:**
   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

6. **Run Migrations and Seeders:**
   This step will create the database tables and populate the system with dummy books, categories, a test Admin account, and a test User account.
   ```bash
   ./vendor/bin/sail artisan migrate --seed
   ```

## Test Accounts

The seeder provides two default accounts to test the Role-Based Access Control:

*   **Admin:** `admin@example.com` / `password`
*   **User:**  `user@example.com` / `password`

## Usage

*   Navigate to `localhost` in your browser.
*   Log in as an Admin to access the Admin Panel, manage user roles, and add/edit/delete books.
*   Log in as a standard User to browse the catalog, view your active loans, and borrow/return books.
