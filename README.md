# Hansraj Singh Rawat — Portfolio

Data-driven PHP portfolio site.

## Structure

- `index.php` — entry point, orchestrates includes
- `contact-handler.php` — POST endpoint for the contact form (JSON)
- `includes/` — config, functions, layout partials
- `sections/` — page sections, all data-driven from `config.php`
- `assets/` — CSS, JS, images

## Requirements

- PHP 8.0+ (uses `declare(strict_types=1)`, typed functions)
- A web server (Apache/XAMPP/Nginx). `mail()` must be enabled to send email.

## Local dev

```bash
cd portfolio
php -S localhost:8000