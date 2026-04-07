# /Dockerfile
FROM php:8.4-fpm

# Arguments for user and group
ARG USER=laravel
ARG UID=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libicu-dev \
    libjpeg-dev \
    libfreetype6-dev \
    sudo

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions for Laravel and MySQL
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js and NPM for Vite/Livewire/Flux
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Create system user to run Composer and Artisan Commands
RUN if ! getent passwd $USER; then \
        useradd -G sudo -u $UID -d /home/$USER -m $USER; \
    fi && \
    mkdir -p /home/$USER/.composer && \
    chown -R $USER:$USER /home/$USER && \
    echo "$USER ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers

# Set working directory
WORKDIR /var/www

# Expose port 9000 and start php-fpm server
EXPOSE 9000

USER $USER

CMD ["php-fpm"]
