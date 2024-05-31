---
layout: post
title:  "Learning Godot"
date:   2023-07-21 12:00:00
categories: learning godot tutorial
published: false
---

- [Godot Tutorials](#godot-tutorials)
  - [Setup godot to work in VSCode](#setup-godot-to-work-in-vscode)
  - [](#)
  - [Make a snake clone](#make-a-snake-clone)
    - [Signals](#signals)
    - [Creation / Destruction](#creation--destruction)

## Godot Tutorials

### Setup godot to work in VSCode

Install `godot-tools` in VSCode.

In godot go to editor tab -> settings. Network tab -> Language Server. Copy the port and paste it into the `godot-tools` settings port.

In godot editor settings tab -> text Editor -> External -> 
Turn on external editor and 

Find the executable path

```
/usr/share/codium/codium
```

for exec flags use the following

```
{project} --goto {file}:{line}:{col}
```


### 

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


### Make a snake clone

https://www.youtube.com/watch?v=c7HQwxs5y8w&t=183s

Downloaded art assets from here: https://devilsworkshop.itch.io/match-3-free-2d-sprites-game-art-and-ui/download/eyJpZCI6OTcxMjIsImV4cGlyZXMiOjE3MTAwNDIyNzJ9.gqzaLkls7wczbdStjdpruzKz%2bRI%3d

Made a gameplay scene.
Made a new scene with area2d as it's parent object. 

Toggle grid snapping 

To add wasd go into project setting, click on input map, then add wasd to ui_left, _right, _up, and _down.

Godot renders the stack bottom to top so the things on the bottom are put closest to the viewer.


#### Signals

OR how to let other classes know if an object has collided.

In a godot scene (i.e. a gdscript file) make a line called

```
signal collision_occurred
```

In that same file you'll need to add in when the signal should be emitted. As far as I know you'll need to use the editor and click on the node tab then click on signals to define the function that gets called when the event should occur.


#### Creation / Destruction


