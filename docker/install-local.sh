#!/bin/bash

if [ ! -d "data/ospos/app/application" ]; then
  echo "### Create app/application folder ..."
  mkdir data/ospos/app/application
fi
if [ ! -d "data/ospos/app/public" ]; then
  echo "### Create app/public folder ..."
  mkdir data/ospos/app/public
fi
if [ ! -d "data/ospos/app/vendor" ]; then
  echo "### Create app/vendor folder ..."
  mkdir data/ospos/app/vendor
fi
if [ ! -e "data/ospos/app/application/index.html" ]; then
  echo "### Mount app/application folder ..."
  sudo mount --bind ../application/ data/ospos/app/application/
fi
if [ ! -e "data/ospos/app/public/index.php" ]; then
  echo "### Mount app/public folder ..."
  sudo mount --bind ../public/ data/ospos/app/public/
fi
if [ ! -e "data/ospos/app/vendor/autoload.php" ]; then
  echo "### Mount app/vendor folder ..."
  sudo mount --bind ../vendor/ data/ospos/app/vendor/
fi

cp ../*.csv data/ospos/app/

if [ ! -d "data/database/db" ]; then
  echo "### Create database/db folder ..."
  mkdir data/database/db
fi
if [ ! -e "data/database/db/database.sql" ]; then
  echo "### Mount database/db folder ..."
  sudo mount --bind ../database/ data/database/db/
fi

docker-compose build

/bin/bash ./init-selfcert.sh
