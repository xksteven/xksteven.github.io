---
layout: post
title:  "Learning Godot"
date:   2023-07-21 12:00:00
categories: learning godot tutorial
published: false
---

- [Godot Tutorials](#godot-tutorials)

## Godot Tutorials

Following this tutorial: https://www.youtube.com/watch?v=xQIaRSXh4ic


Create 2d node. This will be the "world".  
Give it a child node.  "characterbody2d" you can search and type stuff after right clicking and then clicking add node.
Give the character a sprite. (another child node)
Every game gives you the godot icon feel free to use that as a placeholder texture for your sprite.

Make sure to click "group selected nodes" on the parent of nodes.  It's next to the lock icon.  This prevents the sprite from being detached from the body.

Add a collision shape 2d.  Select the shape that best fits.

Click on the parent node and you can add a script with the scroll or right click and then click "attach script"

Click play button to start the game and it'll let you select which world it's supposed to play in.

you can search help docs or ctrl click 

On the sprite you can click modulate and then drag to all black to make it a black wall.

Ctrl D to duplicate

For collision shape 2d click on in the wrench and screwdriver icon in the inspector.  Then click on make resources unique.  Otherwise all of the 2d rectangles will be linked.
Click on the shape and then click on make unique.
