#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
export $(grep -v '#' "$DIR/../.env" | xargs)

log() {
    RED='\e[31m'
    GREEN='\e[32m'
    YELLOW='\e[33m'
    BLUE='\e[34m'

    case $2 in
        wait)
            printf "${BLUE}${1}\e[0m\n"
        ;;
        progress)
            printf "${GREEN}${1}\e[0m\n"
        ;;
        info)
            printf "${YELLOW}${1}\e[0m\n"
        ;;
        error)
            printf "${RED}${1}\e[0m\n"
        ;;
        *)
            printf "${1}"
        ;;
    esac
}

console() {
  docker exec -it "${CONTAINER_PREFIX}_${CONTAINER_NAME}_app" ./bin/console ${@:1}
}

composer() {
  docker exec -it "${CONTAINER_PREFIX}_${CONTAINER_NAME}_app" composer ${@:1}
  log "DONE!" "info"
}

apFixtures() {
  console "--env=dev doctrine:fixtures:load"
}
