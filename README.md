# Laravel E-commerce Module

A modern e-commerce module built with Laravel, Vue.js, and Inertia.js.

## Features

- Product catalog with categories
- Shopping cart functionality
- User authentication and authorization
- Order management system
- Admin dashboard
- Email notifications
- Responsive design

## Requirements

- PHP >= 8.1
- Composer
- Node.js >= 16
- NPM
- MySQL >= 5.7
- OpenServer (for Windows) or similar local development environment

## Installation

1. Clone the repository:
```bash
git clone https://github.com/your-repository/laravel-star-tz.git
cd laravel-star-tz
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install JavaScript dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Configure your environment variables in `.env`:
```env
APP_NAME="Laravel Star"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://laravel-star-tz

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_star
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

6. Generate application key:
```bash
php artisan key:generate
```

7. Run database migrations:
```bash
php artisan migrate
```

8. Seed the database with test data:
```bash
php artisan db:seed
```

9. Build frontend assets:
```bash
npm run build
```

10. Start the development server:
```bash
php artisan serve
```

11. In a separate terminal, start Vite:
```bash
npm run dev
```

## Accessing the Application

- Main site: http://laravel-star-tz/
- Admin panel: http://laravel-star-tz/admin/dashboard
- Default admin credentials:
  - Email: admin@admin.com
  - Password: admin@admin.com

## Development

- Frontend development:
  ```bash
  npm run dev
  ```
  This will start Vite development server with hot module replacement.

- Backend development:
  ```bash
  php artisan serve
  ```

## Project Structure

```
laravel-star-tz/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   └── ...
│   │   └── Middleware/
│   ├── Models/
│   ├── Notifications/
│   ├── Repositories/
│   └── Services/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── js/
│   │   ├── Pages/
│   │   ├── Stores/
│   │   └── ...
│   └── views/
└── routes/
    └── web.php
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License.
