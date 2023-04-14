# Laravel RESTful API - Training

## Run Locally

Clone the project

```bash
  git clone https://github.com/jaysontolentino/laravel-api.git
```

Go to the project directory

```bash
  cd laravel-api
```

Install dependencies

```bash
  composer install
```

Copy .env.example and update the the variables based on your local setup

```bash
  cp .env.example .env
```

Database Migration and Seeder

```bash
  php artisan migrate:fresh --seed
```

Start the server

```bash
  php artisan serve
```
