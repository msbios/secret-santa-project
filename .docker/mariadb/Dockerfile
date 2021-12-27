FROM mariadb:latest as scratch

CMD ["mysqld"]
EXPOSE 3306

# DEV env (local)
FROM scratch as dev

FROM scratch as test

# PROD env (kubernetes)
FROM scratch as prod
