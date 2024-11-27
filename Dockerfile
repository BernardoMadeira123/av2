FROM mysql:8.0

ENV MYSQL_DATABASE=laravel_db
ENV MYSQL_USER=laravel_user
ENV MYSQL_PASSWORD=laravel_password
ENV MYSQL_ROOT_PASSWORD=root_password

EXPOSE 3302
