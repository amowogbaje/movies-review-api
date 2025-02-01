
# Movie Review Api

## Overview

This project is a Laravel 10-based movie review api. It includes features for creating movie records, reviewing movie and viewing movie ratings. The project uses various tools and libraries, including Swagger for API documentation and a postman docs link too.

## Requirements

- PHP 8.1 or higher
- Composer
- Laravel 10.x
- MySQL or another supported database
- [Swagger](http://127.0.0.1:8000/api/docs) (for API documentation)
- [Postman](http://127.0.0.1:8000/api/docs) (for API documentation)

## Setup

### 1. Clone the Repository

```bash
git clone https://github.com/amowogbaje/movies-review-api 
cd movies-review-api
```

### 2. Install Dependencies

Run the following commands to install PHP and JavaScript dependencies:

```bash
composer install
```

### 3. Environment Configuration

Copy the example environment file and configure your environment settings:

```bash
cp .env.example .env
```

Edit the `.env` file to configure your database and other environment variables. For example:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key

Generate a new application key:

```bash
php artisan key:generate
```

### 5. Run Migrations and Seed the Database

Run migrations and seed the database with sample data:

```bash
php artisan migrate --seed
```

### 6. Serve the Application

Start the Laravel development server:

```bash
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`.

### 7. API Documentation

API documentation is available at:

[Swagger Documentation](http://127.0.0.1:8000/api/docs)

### 8. Running Tests

To run the tests for the application, use the following command:

```bash
php artisan test
```

Alternatively, you can run PHPUnit directly:

```bash
./vendor/bin/phpunit
```


## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contact

For any inquiries, please contact [amowogbajegideon@gmail.com](mailto:amowogbajegideon@gmail.com).

