#!/bin/bash

# docker build -t internship .
# docker stop intern && docker rm intern
docker build -t internship . && docker stop intern && docker rm intern && ./run.sh
# docker run -i -d -p 10080:80 -p 15432:5432 -v /home/xen/projects/internship/backend:/home/project --name intern internship
