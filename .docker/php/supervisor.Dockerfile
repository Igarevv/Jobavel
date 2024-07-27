FROM php:8.2-fpm-alpine

RUN apk update && apk add --no-cache supervisor \
    libpq-dev \
    postgresql-dev \
        && docker-php-ext-install pdo pdo_pgsql pgsql

RUN mkdir -p "/var/log/jobavel"
RUN mkdir -p "/etc/supervisor/logs"

ADD ./crontab /etc/cron.d/laravel-cron
RUN chmod 0644 /etc/cron.d/laravel-cron \
    && crontab /etc/cron.d/laravel-cron

COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/bin/sh", "-c", "/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf"]