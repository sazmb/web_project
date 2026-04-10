# GeoLocalProject

A Laravel 12 web application for managing matches, players, locations, and treasure interactions with multilingual support.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Local Development](#local-development)
- [Database](#database)
- [Run the App](#run-the-app)
- [Project Structure](#project-structure)
- [Publishing to GitHub](#publishing-to-github)
- [License](#license)

## Features

- Laravel 12 application with PHP 8.2 support
- User authentication and role-based access control
- Player profile and location management
- Match creation, joining, and management
- Admin dashboard for players, matches, and treasures
- Multilingual support via language routes
- Frontend built with Vite, Tailwind CSS, and Alpine.js

## Requirements

- PHP 8.2
- Composer
- Node.js and npm
- SQLite, MySQL, or other supported database

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/<your-username>/GeoLocalProject.git
   cd GeoLocalProject
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Install Node dependencies:

   ```bash
   npm install
   ```

4. Copy the environment file:

   ```bash
   copy .env.example .env
   ```

5. Generate an application key:

   ```bash
   php artisan key:generate
   ```

6. Configure your database settings inside `.env`.

   Example for SQLite:

   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=database/database.sqlite
   ```

   Example for MySQL:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=geolocal
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. Create the SQLite file if using SQLite:

   ```bash
   php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
   ```

## Database

Run migrations and optional seeders:

```bash
php artisan migrate
php artisan db:seed
```

If you want a fresh database with seed data:

```bash
php artisan migrate:fresh --seed
```

## Local Development

Compile frontend assets and start the Laravel server:

```bash
npm run dev
php artisan serve
```

Open your browser at:

```text
http://127.0.0.1:8000
```

## Run the App

After starting the server, the main routes include:

- `/` - Home page
- `/dashboard` - Dashboard view
- `/lang/{lang}` - Switch application language

Admin-only routes:

- `/matches`
- `/treasures`
- `/players`

Authenticated user routes:

- `/match`
- `/myMatches`
- `/findMatches`

## Project Structure

- `app/` - PHP application code and controllers
- `routes/` - Application routes
- `resources/` - Blade views, CSS, and JavaScript
- `database/` - Migrations, factories, seeders
- `public/` - Public web assets
- `tests/` - Automated tests

## Publishing to GitHub

1. Initialize git if needed:

   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   ```

2. Add your GitHub repository as the remote:

   ```bash
   git remote add origin https://github.com/<your-username>/GeoLocalProject.git
   ```

3. Push the repository:

   ```bash
   git push -u origin main
   ```
