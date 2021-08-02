#!/bin/bash

# docker build -t internship .
# docker stop intern && docker rm intern
docker build -t internship . && docker stop intern && docker rm intern && ./run.sh
# docker run -i -d -p 10080:80 -p 15432:5432 -v /home/xen/projects/internship/backend:/home/project --name intern internship


# run

DIR=$(realpath $(dirname "$0")/..)
docker run -i -d -p 10080:80 -p 15432:5432 -v $DIR:/home/project --name intern internship


docker run -i -d -v /your-path/:/home/project --name myproject internship


docker exec -it myproject bash


