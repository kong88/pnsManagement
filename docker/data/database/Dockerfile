FROM alpine
MAINTAINER jekkos

ADD db/database.sql /docker-entrypoint-initdb.d/database.sql
VOLUME /docker-entrypoint-initdb.d
