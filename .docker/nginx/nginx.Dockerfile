FROM nginx:latest

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN addgroup --system --gid ${GID} laravel
RUN adduser --system --uid ${UID} --ingroup laravel --shell /bin/sh --no-create-home laravel
RUN sed -i "s/user  nginx/user laravel/g" /etc/nginx/nginx.conf

RUN rm /etc/nginx/conf.d/default.conf

COPY jobavel.conf /etc/nginx/conf.d/

RUN mkdir -p /var/www/jobavel

WORKDIR /var/www/jobavel



