# Utilisation de l'image PHP officielle
FROM php:8.2-apache

# Mise à jour des paquets et installation des outils nécessaires
RUN apt-get update && apt-get install -y \
    iputils-ping \
    netcat-openbsd \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Activation des extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Configuration du répertoire de travail
WORKDIR /var/www/html

# Copie du contenu du projet dans le conteneur
COPY . /var/www/html

# Donne les droits nécessaires
RUN chown -R www-data:www-data /var/www/html

# Exposition du port 80 pour Apache
EXPOSE 80
