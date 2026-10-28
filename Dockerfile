FROM php:8.2-fpm-alpine

# Instalar dependências do sistema e extensões PHP necessárias
RUN apk add --no-cache \
    icu-dev \
    libzip-dev \
    oniguruma-dev \
    bash \
    curl \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    mysqli \
    mbstring \
    intl \
    zip \
    bcmath \
    opcache

# Copiar configurações de performance do PHP e PHP-FPM
COPY docker/php/local.ini /usr/local/etc/php/conf.d/99-local.ini
COPY docker/php/fpm-performance.conf /usr/local/etc/php-fpm.d/zz-fpm-performance.conf
COPY docker/scripts/start-app.sh /usr/local/bin/start-app.sh

RUN sed -i 's/\r$//' /usr/local/bin/start-app.sh \
    && chmod +x /usr/local/bin/start-app.sh \
    && mkdir -p /tmp/sessions \
    && chmod -R 777 /tmp/sessions

WORKDIR /var/www/html

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000

CMD ["/usr/local/bin/start-app.sh"]
