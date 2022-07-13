# Laravel Test CRUD
Create and Consume Endpoints

## Setup
For Windows 10, download XAMPP, then download `composer`.

## Step 1

create a folder at `C:\xampp\htdocs\`, my folder name is `laravel-crud`

change directory 

`cd C:\xampp\htdocs\laravel-crud`

create the project 

`composer create-project laravel/laravel laravel-crud`

## Step 2
I'm using the database named `laravel_test`,
later this will be used to create one table, 

```
APP_NAME=first_laravel
APP_ENV=local
APP_KEY=base64:Vo0OoJYrIF8H5W+8TCZ8LfLYJkh3UBNP3cKP7H3fngc=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_test
DB_USERNAME=root
DB_PASSWORD=
```

then

`php artisan migrate`

## Step 3

`php artisan make:controller ApiController`




