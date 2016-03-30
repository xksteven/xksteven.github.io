---
layout: post
title:  "Intro to Web Development"
date:   2016-03-30 23:00:31
categories: webdev update d3
---

Hello I'm Steven.  At the time of writing this I'm a second year PhD student and the TA for information visualization.  This tutorial should hopefully get someone who knows a bit of programming to being able to use and modify visualizations in D3. D3 is a nice tool for making visualizations and displaying them in the browser, and even though it can do more than that in this series we shall focus on the visualization aspects of it.  So let's get started.  

###Sections:  
[Getting Started](#getting-started)  
[Next Steps](#next-steps-with-css)  
[Just Javascript](#just-javascript)  
[D3](#d3-doing-debugging-done)  
[Debugging](#debugging)  
[Extra Resources](#extra-resources)

##Getting Started

In this section we will build a simple website which will be needed to test out the code later.  First thing's first we need to pick an editor to write and work with.  Notepad is okay, vim is good (best for working over a server), and my personal preference is [sublime](https://www.sublimetext.com/3).  In sublime you can download packages to make building a website easier like emmet and even a package for assisting in code completion for D3.js.  

This first example is to get you to see something a bit more complicated than necessary and then we will strip away the unnecessary details 

{% highlight HTML %}
<!DOCTYPE html>
<html lang="en">
<head>
	<title>My First Awesome Webpage</title>
</head>
<body>
	
</body>
</html>
{% endhighlight %}

If you downloaded emmet in sublime you can quickly type all of this by typing "html:5" (without quotes) and pressing Ctrl + e (command on apple). 

A quick intro HTML is short for hypertext markup language, fancy terms but basically meaning it isn't a programming language which means it can't do much on its own. You can think about html as specifying the content of a web page by enclosing the content like words, paragraphs, images etc. in the page by some descriptor in the these <>. The things enclosed in <> are called **tags** for example head, body, title are all tags. The objects enclosed between <> and </> are called **elements** for example "My First Awesome Webpage" is an element.  This format serves to let the browser know how the elements should be processed to be displayed on the browser.

So html is read in blocks.  <>  this is an opening bracket. </> this is a closing bracket and they usually come in pairs.

	<!DOCTYPE html>

This part here specifies that we are writing a webpage specifically in html format.  This part is essential and must always be there for a webapge to be properly displayed so always include it.

	<html lang="en">

This tag does two things: first it starts the html document by specifying the "html" in the brackets. Secondly in the same tag it tells the browser what language all (or the majority) of our text on the webpage will be in with "lang="en"". In this case en is short for english.  Here you can see an example of how multiple things can specified in one tag.  

	<head>
		...
	</head>

This part opens something on webpages called the head as designated by <head> and then closes it like so </head>.  The head short for heading basically gives an overview of the webpage for your web browser.  In the example above it sets the title of the webpage to be "My First Awesome Webpage".

Here we have where the majority of the content in a webpage will go.  You can think of the <body> like the body of essay where it contains all of the actual content and majority of what's actually on the page goes in here.

Finally there's the closing </html>.  This tells the browser that it is the end of the document because it closes the opening DOCTYPE html.  

Well that was a bit tedious now lets get rid of what we don't need and keep the bare minimum.  Open your favorite editor and let's make a website. Copy the code below and paste it into a file called "index.html" (without quotes).


{% highlight HTML %}
<!DOCTYPE html>
<body>
	<p>Hello World</p>
</body>
</html>
{% endhighlight %}

Now that we have this how can we actually view and test our code?  

There are many ways to do this and I'll go with the one I've found to be the easiest.  Install python or python3 if you don't already have it installed.  Use this [Install Python](https://wiki.python.org/moin/BeginnersGuide/Download) for help in installing python.  I personally recommend installing python3 instead of python 2 as python2.7 is legacy and will be deprecated and not maintained anymore in the near future.


Next open up a terminal (or some place where you can execute python code).    Next run this command

	python -m http.server

Some notes:  
if you installed or have installed python2.7 replace "http.server" with "SimpleHTTPServer".  
you might need to replace "python" with with "python3"  
Make sure the index.html is saved in the same directory that your terminal directory is currently in (typically your home or user directory).  If index.html is saved somewhere else move it to your home directory or whatever directory you are in, in your current terminal session.  

Finally open up your browser and type in this link into your web browser

http://localhost:8000/

You should be able to see Hello World in your web browser


##Next Steps With CSS

Since the purpose of this tutorial is to quickly get someone up and running with a website that can run D3 we shall only talk briefly about CSS here. CSS stands for Cascading Style Sheets.  This is what specifies the styles, positionings, colors, etc. of the elements in a web site.

Why do we need CSS if we are going to be working with D3 primarily? Well the truth is we don't need a dedicated CSS page but a lot of what D3 uses to change the colors of it's graphs and figures relies on CSS in the background. So a lot of the notation you'll encounter is exactly the same (or very similar) as CSS for that reason we will cover CSS.

####Style it up

We will make a basic css file and work through its notation as well as expand a bit on our previous html example.


{% highlight CSS %}
p {color:blue}
 
{% endhighlight %}


For more on CSS notation see this or go to extra resources at the end of the page  
[CSS notation](https://learnxinyminutes.com/docs/css/)


##Just Javascript

In this section I will go over some of the basics of javascript language itself and how it interacts with html and CSS.

For a slightly more in depth look at javascript you can look at [javascript][javascriptquick].  



##D3: Doing Debugging Done



##Debugging




To do:

mention but for the most part ignore CSS

talk about JS
learnxinyminutes.com/docs/javascript

D3




##Extra Resources

W3schools and mozilla developers network (MDN) are good resources for much of the above material.  
[HTML](http://www.w3schools.com/html/default.asp)  
[HTML dev guide](https://developer.mozilla.org/en-US/docs/Web/Guide/HTML)  
[CSS Reference](https://developer.mozilla.org/en-US/docs/Web/CSS/Reference)  
[Javascript Quick Reference][javascriptquick]  
[Javascript In Depth](https://developer.mozilla.org/en-US/docs/Web/JavaScript)  



[javascriptquick]: https://learnxinyminutes.com/docs/javascript/


