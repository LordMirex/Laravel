# replit.md

## Overview

This is a Laravel 12 PHP web application that has been migrated from a Node.js/Express backend with a React frontend. The project includes configuration for both the Laravel backend and a client-side React application using Vite, Tailwind CSS, and shadcn/ui components. The application uses PostgreSQL as its database with Drizzle ORM for schema management.

## User Preferences

Preferred communication style: Simple, everyday language.

## System Architecture

### Backend Architecture
- **Framework**: Laravel 12 (PHP 8.2+) - Full-featured MVC framework
- **Entry Point**: Standard Laravel structure with `php artisan serve` for development
- **API Routes**: Laravel routing system handles HTTP requests
- **Database ORM**: Dual approach - Laravel's Eloquent ORM for PHP and Drizzle ORM for TypeScript schema definitions
- **Queue Processing**: Laravel's built-in queue system with `php artisan queue:listen`

### Frontend Architecture
- **Framework**: React with TypeScript (located in `client/` directory)
- **Build Tool**: Vite with Laravel Vite Plugin for asset bundling
- **Routing**: Wouter for client-side routing
- **State Management**: TanStack React Query for server state
- **UI Components**: shadcn/ui component library with Radix UI primitives
- **Styling**: Tailwind CSS with custom theme configuration and CSS variables for theming

### Database Schema
- **ORM**: Drizzle ORM with PostgreSQL dialect
- **Schema Location**: `shared/schema.ts`
- **Migrations**: Stored in `migrations/` directory
- **Tables**: Currently includes a `users` table with id, username, and password fields

### Build System
- **PHP Dependencies**: Composer for package management
- **Node Dependencies**: npm for frontend packages
- **Development**: Concurrent processes for server, queue, logs, and Vite dev server
- **Production Build**: `composer setup` script handles full installation and build

## External Dependencies

### Database
- **PostgreSQL**: Primary database, connection via `DATABASE_URL` environment variable
- **Drizzle Kit**: Database migration and schema push tooling

### PHP Packages (via Composer)
- Laravel Framework 12.x
- Laravel Tinker (REPL)
- Laravel Pail (log tailing)
- Laravel Pint (code styling)
- Laravel Sail (Docker development)
- PHPUnit for testing
- Faker for test data generation

### Frontend Packages (via npm)
- React 18+ with React DOM
- TanStack React Query for data fetching
- Radix UI component primitives (dialog, dropdown, tabs, toast, etc.)
- Tailwind CSS with PostCSS and Autoprefixer
- Zod for schema validation
- React Hook Form with Zod resolver
- date-fns for date manipulation
- class-variance-authority and clsx for styling utilities

### Development Tools
- Vite with React plugin
- TypeScript for type checking
- ESBuild for server bundling (in build script)
- Concurrently for running multiple dev processes