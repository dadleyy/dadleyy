function Migrate {
  php artisan migrate:rollback
  php artisan migrate
  php artisan migrate --package="dadleyy/lvpress"
  php artisan db:seed
}


Migrate
