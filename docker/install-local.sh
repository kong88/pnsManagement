#!/bin/bash

if [ ! -d "data/ospos/app/application" ]; then
  mkdir data/ospos/app/application
  sudo mount --bind ../application/ data/ospos/app/application/
fi
if [ ! -d "data/ospos/app/public" ]; then
  mkdir data/ospos/app/public
  sudo mount --bind ../public/ data/ospos/app/public/
fi
if [ ! -d "data/ospos/app/vendor" ]; then
  mkdir data/ospos/app/vendor
  sudo mount --bind ../vendor/ data/ospos/app/vendor/
fi

cp ../*.csv data/ospos/app/

if [ ! -d "data/database/db" ]; then
  mkdir data/database/db
  sudo mount --bind ../database/ data/database/db/
fi

docker-compose build

/bin/bash ./init-selfcert.sh
