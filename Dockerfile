FROM docker.io/php:7.4.33-cli-alpine

# Instala dependncias para o Composer
RUN apk add --no-cache $PHPIZE_DEPS bash git unzip zip subversion less procps 

RUN pecl install xdebug-3.1.6 \
    && docker-php-ext-enable xdebug

COPY .docker/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Instala o Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

WORKDIR /app

# Copia arquivos do Composer
COPY composer.* ./

RUN composer config --global secure-http false
RUN composer install --no-dev -vvv    

# Configura locale (opcional)
RUN sed -i '/pt_BR.UTF-8/s/^# //g' /etc/locale.gen || true \
    && locale-gen pt_BR.UTF-8 || true \
    && update-locale LANG=pt_BR.UTF-8 || true

ENV LANG=pt_BR.UTF-8 \
    LC_ALL=pt_BR.UTF-8

# Cria diretório de trabalho
WORKDIR /app

# Comando padrão: abre um shell bash (o compose também define isso).
CMD ["bash"]