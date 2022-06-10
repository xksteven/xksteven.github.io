---
layout: post
title:  "Setting up a Flask Server"
date:   2022-05-28 12:00:00
categories: Flask flask
---

## Why Flask

I have used several different back-end frameworks before and I have found flask to be almost the absolute simplest to use and setup to do debugging.  

## How to install

```python
pip3 install flask
```

## The hello\_world

```python
from flask import Flask

app = Flask(__name__)

@app.route('/')
def hello_world():
    return 'Hello World!'
```

## How to run it

```
export FLASK_APP=hello.py

flask run
# alternative way to start it
python3 -m flask run
```
