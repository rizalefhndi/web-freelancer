# Kan - Freelancer Marketplace

Kan is a web application built with Laravel that serves as a marketplace for freelancers and clients to connect. Clients can post projects, and freelancers can offer their services.

## Features

- User authentication and registration
- Service and order management
- Team and member management
- Profile management for freelancers
- A landing page to attract users
- A dashboard for managing services, orders, and profiles

## Installation

Follow these steps to set up the project locally:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/kan.git
   cd kan
   ```

2. **Install Composer dependencies:**
   ```bash
   composer install
   ```

3. **Install NPM dependencies:**
   ```bash
   npm install
   ```

4. **Create your environment file:**
   ```bash
   cp .env.example .env
   ```

5. **Generate an application key:**
   ```bash
   php artisan key:generate
   ```

6. **Configure your database:**
   Open the `.env` file and set your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kan
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. **Run database migrations and seeders:**
   ```bash
   php artisan migrate --seed
   ```

8. **Build assets:**
   ```bash
   npm run dev
   ```

9. **Run the development server:**
   ```bash
   php artisan serve
   ```
   The application will be available at `http://localhost:8000`.

## Running Tests

To run the test suite, use the following command:

```bash
php artisan test
```

## Contributing

Thank you for considering contributing to the Kan project! Please feel free to create a pull request.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
