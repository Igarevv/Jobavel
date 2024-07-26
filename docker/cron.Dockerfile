FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    cron \
    && docker-php-ext-install pdo pdo_pgsql pgsql

COPY crontab /etc/cron.d/cron

RUN chmod 0644 /etc/cron.d/cron

RUN touch /var/log/cron.log

CMD cron