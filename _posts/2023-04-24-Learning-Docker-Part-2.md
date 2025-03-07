---
layout: post
title: "Learning Docker Part 2"
date:  2023-04-24 12:00:00
categories: Docker docker
---

## Docker Part 2

In this section we cover the basics of docker networking.

### Docker Networking

Ports -p or --publish follows the HOST:Container format.

```bash
docker container run -p 80:80 --name webhost -d nginx
docker container port webhost

# Ignore the slashes below otherwise jekyll complains about replacement.
# In -> {} .NetworkSettings.IPAddress 
docker container inspect --format "{\{ \.NetworkSettings.IPAddress }}" webhost
```

```bash
docker network ls
docker network inspect
docker network create --driver
# example drivers include bridge, host and none. default = bridge
docker network connect
docker network disconnect
```

docker0 or bridge is the default docker virtual network which is NAT'ed behind host IP.

--network host skips the docker network and attaches the network directly to the hosts network.  For performance but skips on docker security.

```bash
docker network create my_app_net
docker container run -d --name new_nginx --network my_app_net nginx

docker network inspect my_app_net
# Dynamically create a NIC in a container on an existing virtual network
docker network connect new_nginx webhost

# This should now show it appearing on two networks the bridge and my_app_net
docker container inspect webhost
```

### Domain Name System (DNS)

IPs are not a good system to use with Docker/Kubernetes as the containers are likely to be taken down and brought back up.  As such it is an antipattern to expect the same IPs to be used for the same containers.

Docker uses the container names as the host names as default but you can also set aliases.  

HW  
start bash in centos:7 and ubuntu:14.04 interactively and check the version of curl.

Answer

```bash
# --rm automatically removes the container upon exit.
docker container run --rm -it ubuntu:14.04 bash
apt-get install curl

curl --version
#curl 7.35.0

docker container run --rm -it centos:7 bash
#yum update curl
curl --version
#curl 7.29.0
```

HW 2  
Create a new virtual network (default bridge driver)
Create two containers from `elasticsearch:2` image
Research use `-network-alias search` when creating them to them additional DNS name to respond to
Run `alpine nslookup search` with `--net` to see the two containers list for the same DNS name
Run `ubuntu curl -s search:9200` with `--net` multiple times until you see both "name" fields show

Answer

My attempt.

```bash
docker container run --detach --network-alias search elasticsearch:2
docker container run --detach --network-alias search elasticsearch:2
docker run --net=bridge alpine nslookup search
docker run --net=bridge centos curl -s search:9200
```

Correct answer.

```bash
docker network create my_net
docker container run --detach --net my_net --network-alias search elasticsearch:2
docker container run --detach --net my_net --network-alias search elasticsearch:2
docker run --rm --net=my_net alpine nslookup search
docker run --rm --net=my_net centos curl -s search:9200
```

Why it is necessary to create your own virtual network instead of using bridge explained [here](https://stackoverflow.com/a/72335743/6416660).  Answer copied here as well: By default, a container inherits the DNS settings of the host, as defined in the /etc/resolv.conf configuration file. Containers that use the default bridge network get a copy of this file, whereas containers that use a custom network use Docker’s embedded DNS server.
