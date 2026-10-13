FROM php:8.2-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends python3 python3-venv ca-certificates \
    && docker-php-ext-install pdo_mysql fileinfo \
    && a2enmod headers deflate \
    && python3 -m venv /opt/venv \
    && /opt/venv/bin/pip install --no-cache-dir joblib numpy pandas scikit-learn==1.6.0 \
    && rm -rf /var/lib/apt/lists/*

ENV PATH="/opt/venv/bin:${PATH}"
ENV PYTHON_PATH="/opt/venv/bin/python"

COPY . /var/www/html/

RUN sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf \
    && mkdir -p /var/www/html/uploads \
    && touch /var/www/html/error.log \
    && chown -R www-data:www-data /var/www/html/uploads /var/www/html/error.log

CMD ["sh", "-c", "export PORT=${PORT:-10000}; sed -i \"s/\\${PORT}/${PORT}/g\" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf; exec apache2-foreground"]
