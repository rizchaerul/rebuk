FROM php:7.4-alpine AS build-env
WORKDIR /app

# Copy everything and build
COPY . ./
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install

FROM php:7.4-alpine
WORKDIR /app
COPY --from=build-env /app .

CMD php artisan serve --host=0.0.0.0 --port=$PORT
