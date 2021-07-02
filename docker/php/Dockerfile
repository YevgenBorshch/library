FROM php:7.4-fpm
ENV TZ 'Europe/Kiev'

# Install system dependencies
RUN apt-get update && apt-get install -y libmcrypt-dev \
    libonig-dev zip unzip libmagickwand-dev git iputils-ping --no-install-recommends
RUN docker-php-ext-install mbstring \
    && docker-php-ext-enable mbstring \
    && docker-php-ext-configure gd \
        --with-freetype=/usr/include/ \
        --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable gd \
    && rm -rf /tmp/*
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer