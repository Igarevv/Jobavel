***In development***

## Jobavel-application

** app name is not registered, and just using locally

This application is my first study application wrote on [Laravel](https://laravel.com) framework.

This is CRUD application

### ***Functionalities done for this moment:***

- Separate registration for employers and employees
- Email verification handled by queues and [Mailtrup](https://mailtrap.io)
- Roles and Permissions policies using [Spatie Permissions](https://spatie.be/docs/laravel-permission/v6/introduction)
  library
- CRUD functionality for vacancy with trash using soft deletes
- Upload employer logo via [AWS S3](https://aws.amazon.com/s3/) storage and also via local storage
- Simple frontend
- Filtering
- Caching with [Redis](https://redis.io/)
- Employee response to a vacancy (with CV created by app and own file)

## Configuration:

.env file with variables:

- **Database (PostgreSQL)**
    - DB_CONNECTION
    - DB_HOST
    - DB_PORT
    - DB_DATABASE
    - DB_USERNAME
    - DB_PASSWORD
- **Cache**
    - CACHE_DRIVER=redis
    - REDIS_HOST
    - REDIS_PASSWORD
    - REDIS_PORT
- **Mail**
    - Use variables that provides Mailtrap
- **AWS**
    - AWS_ACCESS_KEY_ID
    - AWS_SECRET_ACCESS_KEY
    - AWS_DEFAULT_REGION
    - AWS_BUCKET
    - URL settings optional
    - FILE_STORAGE_PROVIDER=file or s3 (default is file)

#### Tips:

To switch from local storage to S3 or vice versa, define in .env FILE_STORAGE_PROVIDER.

## Installation:

Project use Docker

Start docker

````
docker-compose up --build -d
````

Then, run composer

````
docker-compose exec php composer install --prefer-dist --no-dev -o
````

Generate application key

````
docker-compose exec php php artisan key:generate
````

Then, build frontend assets

````
docker-compose exec php sh -c "npm install && npm run build|dev"
````

Run migration

````
docker-compose exec php php artisan migrate:fresh --seed
````

Create symbolic link for local storage use command:

````
docker-compose exec php php artisan storage:link
````

You can also get test user data for login:

````
docker exec -it php php artisan test:give-user
````
And test super-admin for admin panel:

````
docker exec -it php php artisan admin:super
````
Cache routes, views, configs

````
docker-compose exec php php artisan route:cache
````

````
docker-compose exec php php artisan config:cache
````

````
docker-compose exec php php artisan view:cache
````

## Additional
CSP Policies applied only when debug mode is off or app is in production,
so run npm run dev only in debug or local.

If you want to run application on different devices, make some changes:
- in .env - APP_URL http://<your-machine-ip-address>:8080
- in vite.config.js - hmr -> host: '<your-machine-ip-address'
- rebuild
