---
layout: post
title: "Learning Docker Part 3"
date:  2025-05-01 12:00:00
categories: Docker docker
---

## Docker Part 3

In this section we cover images, what they are, how to find them and modify or build them.

### Images

The application binaries and dependencies, and metadata to run the image.

Every commit done to an image creates another image. Docker uses caching to reuse old images if they have the same hash. Copy on write refers to the process by which base layers are read only and any new container that has changes will copy the diff to the new container.

Image layers, union file system. history and inspect commands and copy on write.

```bash
docker history nginx:latest

docker history mysql

docker image inspect nginx # old way is `docker inspect`
```

### Tagging

Images do not have names. Besides image id (which is a hash), we refer to the images by `<user>/<repo>:<tag>`.
Default tag is latest if not specified.
Versions of images can have tags and have multiple tags.

```bash
docker image tag # docker tag (old way)

docker image tag nginx <username>/nginx
docker image push # access denied need to login first
docker login
```

### Building a Docker file

#### Building nginx container from scratch

We will be using the files and folders from the git repo [docker-mastery](https://github.com/BretFisher/udemy-docker-mastery).

```bash
docker build -f some-dockerfile # Usually named Dockerfile
```

Example docker file to highlight the relevant parts. FROM, ENV, RUN EXPOSE, and CMD.

```docker
FROM debian:bullseye-slim
# all images must have a FROM
# usually from a minimal Linux distribution like debian or (even better) alpine
# if you truly want to start with an empty container, use FROM scratch

LABEL maintainer="NGINX Docker Maintainers <docker-maint@nginx.com>"

# optional environment variable that's used in later lines and set as envvar when container is running
ENV PKG_RELEASE     1~bullseye

RUN set -x \
    && apt-get update \
    && apt-get install --no-install-recommends --no-install-suggests -y gnupg1 ca-certificates \
# forward request and error logs to docker log collector
# Docker reads all things from standard in and out and there's lot of helper things that work with it.
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log 

EXPOSE 80
# expose these ports on the docker virtual network
# you still need to use -p or -P to open/forward these ports on host

STOPSIGNAL SIGQUIT

CMD ["nginx", "-g", "daemon off;"]
# required: run this command when container is launched
# only one CMD allowed, so if there are multiple, last one wins
```

```bash
cd directory-with-Dockerfile
docker image build -t customnginx .  # the dot means build it here
```

#### Building nginx container

The above highlights the complicated way to build nginx from scratch on a debian machine.  We typically don't need to do this.  Instead we'll typically use something like the following file.

```docker
FROM nginx:latest

# change the working directory to root of nginx webhost
# using WORKDIR is preferred to using `RUN cd /some/path`
# If the WORKDIR doesn’t exist, it will be created even if it’s not used in any subsequent Dockerfile instruction.
WORKDIR /usr/share/nginx/html

COPY index.html index.html

# No need to specify EXPOSE 80 or CMD because they are automatically done from 
```

```bash
# Reminder how to build a regular nginx
# docker container run [OPTIONS] IMAGE [COMMAND] [ARG...]
# [OPTIONS = -p 80:80 --rm] IMAGE = nginx # No commands or other args

docker container run -p 80:80 --rm nginx

docker image build -t nginx-with-html .

docker container run -p 80:80 --rm nginx-with-html
```

If you want to see what's happening while building add the following flag to build `--progress=plain`. Like so:

```bash
docker image build --progress=plain -t nginx-with-html .
```

Check the outputs

```bash
docker image ls

# what we're tagging followed by tag name
docker image tag nginx-with-html:latest xksteven/nginx-with-html:latest

# should see the new image 
docker image ls

docker image push # publish it to dockerhub 
```

#### Homework Build your own Image

Make a dockerfile.  (HINT `Dockerfile`'s are named with only the D being capital otherwise you'll need to specify a -f to the file name.)
Build it.
Test it.
Push it.
rm it.
Run it.

assignment is in [dockerfile-assingment-1/](https://github.com/BretFisher/udemy-docker-mastery/tree/main/dockerfile-assignment-1).

```bash
docker image build --progress=plain -t my-node .

docker container run -p 8080:80 --rm my-node
```
