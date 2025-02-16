# Blog Post Management API


This project is a Blog Post Management API built using Laravel, providing robust CRUD functionality for managing blog posts. It integrates with Elasticsearch for efficient searching and indexing, ensuring fast retrieval of relevant content.
## Requirements

- Docker
- Docker Compose

## Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/amir-ys/e-task.git
   cd e-task
   ```

2. **Install dependencies:**
   ```sh
   docker run --rm \
       -u "$(id -u):$(id -g)" \
       -v "$(pwd):/var/www/html" \
       -w /var/www/html \
       laravelsail/php81-composer:latest \
       composer install --ignore-platform-reqs
   ```
4. **Copy the environment file:**
   ```sh
   cp .env.example .env
   ```
   
3. **Start Laravel Sail:**
   ```sh
   ./vendor/bin/sail up -d
   ```

6. **Run migrations:**
   ```sh
   ./vendor/bin/sail artisan migrate
   ```

7. **Seed the database (if necessary):**
   ```sh
   ./vendor/bin/sail artisan db:seed
   ```

The application will be accessible at `http://localhost`.

## Useful Commands

- Run queue worker for index posts in none-sync mode queue:
  ```sh
  ./vendor/bin/sail artisan queue:work
  ```
- reindex all post model records in Elasticsearch:
  ```sh
  ./vendor/bin/sail artisan elastic:reindex-searchable-model "App\Models\Post"
  ```

## License

This project is open-source and available under the [MIT license](LICENSE).

