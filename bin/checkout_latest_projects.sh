#!/bin/bash

PROJECTS=(
  api
)

for p in "${PROJECTS[@]}"; do
    if [ -d "projects/$p" ]; then
        echo "Pulling latest projects updates for $p..."
        (cd "projects/$p" && git pull)
    else
        echo "Cloning $p..."
        git clone --single-branch --branch main "https://github.com/laravelcm/$p" "projects/$p"
    fi;
done
