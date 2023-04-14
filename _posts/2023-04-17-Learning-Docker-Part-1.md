---
layout: post
title: "Learning Docker Part 1"
date:  2023-04-17 12:00:00
categories: Docker docker
---

## Docker

Main resource I used to learn Docker is [Udemy Docker Mastery](https://www.udemy.com/course/docker-mastery).
At the end of this series I want to write up a quick getting started with docker because there's a lot of content it seems to go through to start using docker.  

### Summary

This post covers docker installation, running/starting a container, viewing the (stdout/error) logs, and inspecting the container.

### Installing Docker on Desktop (Ubuntu)

[Ubuntu Docker setup](https://docs.docker.com/engine/install/ubuntu/#set-up-the-repository)

```bash
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

sudo apt-get update
sudo apt-get install docker-ce docker-ce-cli containerd.io docker-compose-plugin

# verify that it works
sudo service docker start
sudo docker run hello-world
```

[Install Docker on Ubuntu](https://docs.docker.com/desktop/install/ubuntu/)

```bash
# Download it from the above link.

sudo apt-get update
mv docker-desktop-<version>-<arch>.deb /tmp/
sudo apt-get install /tmp/docker-desktop-<version>-<arch>.deb
```

It wasn't starting because it requires KVM.
[Install KVM on Ubuntu](https://www.linuxtechi.com/how-to-install-kvm-on-ubuntu-22-04/)

Make sure (SVM) or KVM is enabled in the BIOS.  Otherwise you'll see the message Docker is stopped in Docker Desktop.

#### Optional Installing on a Linux Server

I prefer to use Docker's automated script to add their repository and install all dependencies: curl -sSL https://get.docker.com/ | sh  but you can also install in a more manual method by following specific instructions that Docker provides for your Linux distribution.

#### Installing Docker Credentials

[Install Docker credentials](https://github.com/docker/docker-credential-helpers/issues/102#issuecomment-388974092)

```bash
sudo apt-get install pass
wget https://github.com/docker/docker-credential-helpers/releases/download/v0.6.4/docker-credential-pass-v0.6.4-amd64.tar.gz

tar -xf docker-credential-pass-v0.6.4-amd64.tar.gz
chmod +x docker-credential-pass
sudo mv docker-credential-pass /usr/local/bin/

sudo apt install gnupg2
gpg2 --gen-key

pass init "YOUR NAME GOES HERE"

docker login
```

### Running Docker

Make sure to start up the docker daemon or the docker desktop.

```bash
docker version
docker info

docker --help
```

Let's run a container.

```bash
#old way is to just remove the container subcommand.
docker container run --publish 80:80 nginx

docker container run --publish 80:80 --detach nginx # this will run it in the background.

# If container doesn't automatically stop 
docker stop <containerid/name>

docker container run --publish 80:80 --detach --name webhost nginx  # note that putting arguments after the container name sends the commands as arguments to the container causing errors.
```

What did docker (container) run do?

- Downloaded the image nginx from Docker Hub.
- Started a new container from that iamge.
- Opened post 80 on the host IP
- Routes that traffic to the container IP, port 80.
- Note the first arg is the host port so it can be 8080 and the second arg is the container port.

#### View all of the containers

```bash
docker container ls # docker ps
docker container ls -a
```

#### View the logs

```bash
docker container logs webhost

# OR docker logs webhost

docker container top webhost
```

Remove the old containers

```bash
docker container rm a01

docker container rm -f webhost ast a01 we3
```

### What *are* containers?

They're just a process. They have limits on resources they can access and exit when process stops.

It's a restricted process.

### HW 1 Manage multiple containers

Start a nginx on port 80:80, mysql port 8080:80, and httpd server on port 3306:3306

for mysql pass --env or -e with MYSQL_RANDOM_ROOT_PASSWORD=true

View the logs to view the container password.
docker container logs `<container>`

```bash
docker container run --detach -p 80:80 --name nginx nginx
docker container run --detach --env MYSQL_RANDOM_ROOT_PASSWORD=true -p 3306:3306 --name mysql mysql
docker container run --detach -p 8080:80 --name httpd httpd

docker container logs mysql
# docker logs mysql1 2>&1 | grep GENERATED

docker container stop nginx httpd mysql
docker container rm nginx httpd mysql
```

### Some tools to inspect containers

`docker info, inspect, stats`

### Getting inside a container to mess with its internals

```bash
docker container run -it
docker container exec -it
```

To reattach to a stopped container use start and -a

```bash
docker container run -it --name ubuntu ubuntu  # the default command is bash so it'll drop you into bash
apt install curl
# type exit to leave
docker container start -ai ubuntu
```

Use exec to attach to an already running container.

```bash
docker container exec -it mysql bash  # alternatively use mariadb
```

Get to know Alpine

```bash
docker container run -it alpine sh
apk # the apt or pacman equivalent for alpine
```
