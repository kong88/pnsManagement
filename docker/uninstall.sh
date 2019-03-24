#!/bin/bash

docker-compose down

sudo umount data/ospos/app/application/
sudo umount data/ospos/app/public/
sudo umount data/ospos/app/vendor/
sudo umount data/database/db/
