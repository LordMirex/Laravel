# replit.md

## Overview

This is a Laravel 12 PHP web application built with the Laravel framework. Laravel provides an elegant MVC architecture with features including routing, dependency injection, Eloquent ORM, database migrations, background job processing, and real-time event broadcasting. The project uses Vite for frontend asset compilation with Tailwind CSS for styling.

## User Preferences

Preferred communication style: Simple, everyday language.

## System Architecture

### Backend Framework
- **Laravel 12**: Full-featured PHP web framework handling routing, controllers, models, and views
- **PHP 8.2+**: Minimum required PHP version
- **Artisan CLI**: Laravel's command-line interface for running tasks, migrations, and development server

### Frontend Build System
- **Vite**: Modern frontend build tool configured via `vite.config.js`
- **Laravel Vite Plugin**: Integrates Vite with Laravel for asset compilation
- **Tailwind CSS**: Utility-first CSS framework with custom theme configuration in `tailwind.config.ts`

### Development Workflow
- **Entry Point**: `php artisan serve` runs the development server on port 5000
- **Build Command**: Caches configuration, routes, and views for production
- **Composer Scripts**: 
  - `composer setup`: Installs dependencies, generates app key, runs migrations, builds frontend
  - `composer dev`: Runs server, queue worker, log viewer, and Vite dev server concurrently
  - `composer test`: Clears config cache and runs PHPUnit tests

### Project Structure
- `app/`: Application code (controllers, models, services)
- `resources/`: Frontend assets (CSS, JS, Blade templates)
- `database/`: Migrations, factories, and seeders
- `public/`: Publicly accessible files
- `vendor/`: Composer dependencies
- `tests/`: PHPUnit test files

### Key Configuration Files
- `composer.json`: PHP dependencies and autoloading
- `package.json`: Node.js scripts for development
- `vite.config.js`: Frontend asset bundling configuration
- `tailwind.config.ts`: Tailwind CSS theme customization

## External Dependencies

### PHP Packages (via Composer)
- **laravel/framework**: Core Laravel framework
- **laravel/tinker**: REPL for Laravel
- **guzzlehttp/guzzle**: HTTP client for API requests
- **nesbot/carbon**: DateTime handling (via Laravel)
- **monolog/monolog**: Logging (via Laravel)

### Development PHP Packages
- **fakerphp/faker**: Fake data generation for testing
- **laravel/pail**: Real-time log viewer
- **laravel/pint**: Code formatter
- **laravel/sail**: Docker development environment
- **phpunit/phpunit**: Testing framework
- **mockery/mockery**: Mocking library for tests

### Frontend Dependencies (via npm)
- **Radix UI components**: Various React UI primitives (accordion, dialog, dropdown, etc.)
- **@tanstack/react-query**: Data fetching and caching
- **Tailwind CSS**: Utility CSS framework
- **class-variance-authority**: CSS class management
- **date-fns**: Date utility library
- **drizzle-orm**: TypeScript ORM (may be used for additional backend logic)

### Database
- Laravel supports multiple database backends (MySQL, PostgreSQL, SQLite, SQL Server)
- Uses Eloquent ORM for database interactions
- Migrations handle schema management

### Additional Integrations (referenced in build script)
- **OpenAI / Google Generative AI**: AI service integrations
- **Stripe**: Payment processing
- **Passport**: Authentication
- **Nodemailer**: Email sending
- **WebSocket (ws)**: Real-time communication