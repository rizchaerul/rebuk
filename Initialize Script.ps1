New-Item -Path './database/database.sqlite'
New-Item -Path './storage/app/public/bookImg' -ItemType Directory
composer install
php artisan migrate:fresh
php artisan db:seed
php artisan storage:link
php artisan serve
