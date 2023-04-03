---
layout: post
title:  "Simple Web Dev Network Setup"
date:   2016-04-28 12:00:00
categories: webdev d3 networking network networks setup LAN DNS
---

## Setting up your local network

### Want to set up a local server to host my D3 app

First and foremost set up port forwarding from your router to your machine. Honestly though this should probably happen later to last as you're now forwarding any traffic that requests port 80 to your computer.

I'll install and set up nginx on Ubuntu.

```bash
sudo apt install nginx

systemctl status nginx
```

Edit the file in /etc/nginx/sites-available/default

```bash
server {
        root /var/www/blah;
}
```

Note Nginx need to have +x access on all directories leading to the site's root directory.

```bash
sudo systemctl restart nginx
```

Go to local host first [localhost](http://localhost).  Then find your local ip:

```bash
hostname -i
```

Go to it on the browser such as [http://192.168.0.167](http://192.168.0.167).

After that works then find your external IP address

```bash
curl -4 icanhazip.com
```

192.168.0.55 60:d2:48:e9:c1:47

### Router configuration

Different routers have different setups but forward port 80 to your machines IP address.  You may need to google or lookup a youtube video for help setting up how to port forward to your local machine.

#### Useful tools for debugging

If things go wrong the following tools are helpful for trying to get information as to where the problem lies exactly.

* ping
* ifconfig
* nmap
* traceroute

#### Problems that can come up

firewall

```bash
sudo ufw status
```

Look at the access logs

```bash
less /var/log/nginx/access.log
less /var/log/nginx/error.log
```

Reread the note above:
Note Nginx need to have +x access on all directories leading to the site's root directory.

```bash
# if your root was /home/user/workspace/web
sudo chmod +rx /home{,/user{,/workspace{,/web}}}
```

## Free DNS

Get your local website exposed to the outside world for free.  Please note that there are security risks by exposing your own machine to the internet.  My own machine will constantly get pings to check which ports are exposed and who knows what else they try to do to hack it.

### Duck DNS

[Duck dns](https://www.duckdns.org) is a free DNS (Domain Name Service) so even if your dynamic IP changes then you can still login or visit your machine with a public name.  Very easy to set up for many different machines after you sign in or login just click the install tab.
