FROM php:8.3.10
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update && apt-get install -y libpq-dev 
RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get install -y nodejs \
    && docker-php-ext-install exif
RUN apt-get install -y npm
RUN npm i -g yarn


RUN php -m | grep mbstring
WORKDIR /app
COPY .env.example .env.example
COPY . /app
RUN cp .env.example .env
RUN composer install

RUN sed -i 's/DB_CONNECTION=mysql/DB_CONNECTION=sqlite/' .env
RUN sed -i 's|APP_URL=http://localhost|APP_URL=https://website-hrd-production.up.railway.app/|' .env

# Run Vite build
RUN yarn && yarn run build

# Generate application key
RUN php artisan key:generate --force

# Run migrations to create necessary tables
RUN php artisan migrate --force

RUN php artisan db:seed --force

RUN php artisan storage:link

# Generate cache Laravel
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000
