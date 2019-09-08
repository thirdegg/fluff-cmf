#!/bin/bash

function update() {
    #docker exec -it fluff_cmf composer install
    echo "no composer"
}

function shell() {
    docker exec -it fluff_cmf bash
}


function build() {
    docker-compose build
}

function clear() {
    docker-compose rm fluff_db fluff_cmf
}

function up() {
    build
    docker-compose up -d
    sleep 3
    update
}

function down() {
    docker-compose down
}

$1