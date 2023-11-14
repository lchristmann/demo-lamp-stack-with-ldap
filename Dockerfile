FROM php:8.2-apache

# Install the mysqli, pdo and pdo_mysql extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install the ldap extension
RUN apt-get -y update && apt-get install -y libldap2-dev
RUN docker-php-ext-install ldap
RUN docker-php-ext-enable ldap