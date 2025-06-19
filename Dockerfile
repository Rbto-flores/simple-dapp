# Stage 1: Build stage
FROM php:8.2-fpm-alpine AS build

# Instalar dependencias para build
RUN apk add --no-cache --virtual .build-deps \
    git unzip curl libzip-dev libpng-dev libpq-dev build-base nodejs npm

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install pdo_mysql pdo_pgsql zip gd

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Copiar archivos composer.json y package.json para aprovechar cache
COPY composer.json composer.lock ./
COPY package.json package-lock.json ./

# Copiar todo el código fuente
COPY . .


# Instalar dependencias PHP y Node
RUN composer install --no-dev --optimize-autoloader
RUN npm install


# Construir assets front-end (ej: Laravel Mix, Vite)
RUN npm run build

# Limpiar dependencias de build para bajar tamaño
RUN apk del .build-deps

# Stage 2: Runtime stage
FROM php:8.2-fpm-alpine

# Instalar solo librerías necesarias para runtime
RUN apk add --no-cache libpq libpng libzip

# Copiar composer del build stage (para comandos en runtime)
COPY --from=build /usr/local/bin/composer /usr/local/bin/composer

# Copiar extensiones y configuración PHP compiladas
COPY --from=build /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=build /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# Copiar código y assets ya compilados
COPY --from=build /var/www/html /var/www/html

WORKDIR /var/www/html

# Crear directorios para cache y storage y dar permisos
RUN mkdir -p storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copiar entrypoint para tareas runtime
RUN wget -qO /usr/local/bin/wait-for https://raw.githubusercontent.com/eficode/wait-for/v2.2.3/wait-for && \
    chmod +x /usr/local/bin/wait-for

COPY docker/production/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm", "-F"]
