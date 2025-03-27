# Scraper API (Laravel 12)

A PHP-based API for scraping data, built with Laravel 12. This project converts a previous Node.js scraper into a Laravel application, storing results in a MySQL database and serving them via RESTful endpoints.

## Prerequisites

- **PHP**: 8.2+
- **Composer**: PHP dependency manager
- **MySQL**: 8.0+ (or compatible)
- **macOS**: Instructions tested on macOS (Intel chip); adaptable to other OS
- **Git**: For version control

## Quick Start

### 1. Clone the Repository
```bash
git clone https://github.com/your-username/scraper-api.git
cd scraper-api
```

### 2. Install Dependencies
Install PHP dependencies via Composer:
```bash
composer install
```

### 3. Configure Environment
Copy the example `.env` file and set your database credentials:
```bash
cp .env.example .env
```
Edit `.env` with your MySQL details:
```
APP_NAME=ScraperAPI
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=scraper_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

Generate an application key:
```bash
php artisan key:generate
```

### 4. Set Up the Database
Create the `scraper_db` database in MySQL:
```bash
mysql -u root -p
CREATE DATABASE scraper_db;
EXIT;
```

Run migrations to create tables (e.g., `scraped_items`):
```bash
php artisan migrate
```

### 5. Start the Development Server
Launch Laravel’s built-in server:
```bash
php artisan serve
```
The API will be available at `http://localhost:8000`.

### 6. Test the API
- **List all scraped items**:
  ```bash
  curl http://localhost:8000/api/items
  ```
- **Run the scraper**:
  ```bash
  curl http://localhost:8000/api/scrape
  ```

## Project Structure
- **`app/Http/Controllers/ScraperController.php`**: Handles API endpoints (`index` for listing, `scrape` for scraping).
- **`app/Models/ScrapedItem.php`**: Eloquent model for the `scraped_items` table.
- **`routes/api.php`**: Defines API routes (`/api/scrape`, `/api/items`).
- **`database/migrations/`**: Migration files (e.g., `create_scraped_items_table`).

## Endpoints
- **`GET /api/items`**: Retrieve all scraped items as JSON.
- **`GET /api/scrape`**: Trigger the scraper and return the newly scraped item as JSON.

## Notes
- **Scraping Logic**: Uses `guzzlehttp/guzzle` for HTTP requests. Customize `ScraperController::scrape()` for your target site.
- **Database**: `scraped_items` table includes `id`, `title`, `url`, and additional fields (customize as needed).
- **Future Tables**: Additional tables can be added via `php artisan make:migration`.

## Troubleshooting
- **404 Errors**: Ensure routes are in `routes/api.php` and use the `api/` prefix.
- **DB Issues**: Verify MySQL is running (`brew services start mysql`) and `.env` credentials match.
- **Logs**: Check `storage/logs/laravel.log` for errors.

## Contributing
Feel free to fork, submit PRs, or report issues!
```
