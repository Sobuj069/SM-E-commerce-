# SM E-Commerce Platform

A modern, responsive, and full-featured E-Commerce web application built with **Laravel 12**, **Tailwind CSS**, and **Vite**.

## Features

- **Storefront & Catalog**:
  - Hero banner with high-impact promotions and quick category shortcuts.
  - Featured and trending product displays with live pricing and discount badges.
  - Advanced catalog filtering by category, search keywords, and price range.
  - Dynamic sorting (Newest, Price: Low to High, Price: High to Low, Rating, Popularity).
- **Product Details**:
  - High-resolution product image showcase with stock indicators and SKU.
  - Customer ratings and verified review counts.
  - Quantity picker and instant Add to Cart.
  - Technical details and related product recommendations.
- **Shopping Cart**:
  - Session-based shopping cart with real-time subtotal and free shipping thresholds.
  - Quantity increment/decrement and item removal.
- **Checkout & Orders**:
  - Streamlined one-page checkout with billing & shipping address validation.
  - Multiple payment method options (Cash on Delivery, Mobile Wallets like bKash/Nagad, Cards).
  - Order placement with database transactions and automated order number generation (`ORD-XXXXXXXX`).
  - Detailed order confirmation and invoice receipt page.

## Tech Stack

- **Backend**: Laravel 12 (PHP 8.3+)
- **Database**: MySQL 8.x
- **Frontend**: Blade Templates, Tailwind CSS v4, Vite 8
- **Icons & Fonts**: FontAwesome 6, Plus Jakarta Sans

## Getting Started

### 1. Requirements
- PHP >= 8.3
- Composer >= 2.x
- Node.js >= 18.x & npm
- MySQL / MariaDB

### 2. Installation
```bash
# Clone the repository
git clone https://github.com/Sobuj069/SM-E-commerce-.git
cd SM-E-commerce-

# Install PHP dependencies
composer install

# Install NPM dependencies and compile assets
npm install
npm run build

# Configure Environment
cp .env.example .env
php artisan key:generate

# Run Database Migrations and Seed Sample Catalog
php artisan migrate --seed
```

### 3. Running the Application
```bash
php artisan serve
```
Open your browser and visit: `http://127.0.0.1:8000` (or `http://localhost:8080`)


## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
