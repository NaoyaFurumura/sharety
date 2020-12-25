FROM mysql:8.0

ENV MYSQL_DATABASE=laravel_local \
  MYSQL_USER=dbuser \
  MYSQL_PASSWORD=dbpass \
  MYSQL_ROOT_PASSWORD=dbpass \
  TZ=Asia/Tokyo

COPY ./my.cnf /etc/mysql/conf.d/my.cnf
RUN chmod 644 /etc/mysql/conf.d/my.cnf
