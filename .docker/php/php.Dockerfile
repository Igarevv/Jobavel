FROM php:8.2-fpm

ARG UID
ARG GID
ENV UID=${UID}
ENV GID=${GID}

RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    zlib1g-dev \
    libicu-dev \
    g++ \
    curl \
    zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN mkdir -p /var/www/jobavel

WORKDIR /var/www/jobavel

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN docker-php-ext-install pdo pdo_pgsql pgsql

RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-install opcache

RUN addgroup --system --gid ${GID} laravel
RUN adduser --system --uid ${UID} --ingroup laravel --shell /bin/sh --no-create-home laravel

RUN sed -i "s/user = www-data/user = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN echo "php_admin_flag[log_errors] = on" >> /usr/local/etc/php-fpm.d/www.conf

RUN mkdir -p /usr/src/php/ext/redis \
    && curl -L https://github.com/phpredis/phpredis/archive/5.3.4.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 \
    && echo 'redis' >> /usr/src/php-available-exts \
    && docker-php-ext-install redis

RUN chown -R ${UID}:${GID} /var/www/jobavel

USER laravel

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
