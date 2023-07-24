#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
source "${DIR}/doc.sh"
source "${DIR}/common.sh"

checkDockerCompose() {
  if ! [ -f ${DIR}/../docker-compose.yml ]; then
    log "docker-compose.yml not exist."
    exit
  fi
}

checkEnv() {
  if ! [ -f ${DIR}/../.env ]; then
    log "File .env not exist" "error"
    exit
  fi
}

init() {
  checkDockerCompose
  checkEnv
  docker-compose build
  docker-compose up -d
  composer install
  migrationApple
  apFixtures
  printf "\e[0m\n"
  log "Project initialization completed!" "wait"
  printf "\e[0m\n"
}

up() {
  down
  docker-compose up -d
}

down() {
  checkDockerCompose
  docker-compose down
}

build() {
  checkDockerCompose
  docker-compose build --network=host
}

makeEntity() {
  console make:entity ${@:1}
  log "DONE!" "info"
}

migrationCreate() {
  console make:migration
  log "DONE!" "info"
}

migrationApple() {
  console doctrine:migrations:migrate
  log "DONE!" "info"
}

php() {
  docker-compose exec php ${@:1}
  log "DONE!" "info"
}

exec() {
  docker exec -it dev_srt_app ${@:1}
  log "DONE!" "info"
}

case "$1" in
  "init")
    init;;
  "build")
    build;;
  "up")
    up;;
  "down")
    down;;
  "mc")
    migrationCreate;;
  "ma")
    migrationApple;;
  "fxt")
    apFixtures;;
  "ent"*)
    makeEntity ${@:2};;
  "composer"*)
    composer ${@:2};;
  "cli"*)
    console ${@:2};;
  "php"*)
    php ${$:2};;
  "exec"*)
    exec ${$:2};;
  *)
    doc;;
esac