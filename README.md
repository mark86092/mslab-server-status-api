Install
=============

1. install the dependecy package

  ```
  composer install
  ```

2. copy .env.example to .env, and modify corresponding setting

3. run the migration of database

  ```
  php artisan migrate
  php artisan db:seed
  ```
4. point your webroot to public folder
