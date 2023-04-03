---
layout: post
title: "Learning React"
date:  2022-06-10 12:00:00
categories: React react
---

## Learning Web Tools

One of the hardest part of learning web tools is figuring out what are the core components you need for your project.  This is typically categorized as a "front-end" and "back-end" or "full-stack."  Front end is someone who creates what the user will interact with, and the backend usually deals with handling all the data and networking.  This is a very rough approximation of the differences between the two.  Finally when someone says they are a full-stack developer usually it means they're just bad at both front and back ends (that'll be me soon).

The answer to why are there so many components/libraries/frameworks when developing for the internet comes down to the infamous ["old thing sucks, lets build new one."](https://xkcd.com/927/) So the core components are react and nodejs.  Feel free to use dino as an alternative to node.

## What is React

React is a front-end framework.  Front-end being the parts of the interface that users interact with either being on the website or on a phone.  

Other competitors (and my quick summary):

* Svelte (Cool new kid on the block. I'd suggest this as the primary alternative.)
* Vue JS (Less popular than React but definitely up there.  Would be my third choice.)
* Flutter (Develop by Google. Uses Dart language so don't recommend.)
* Angular JS (Also developed by Google. I think they prefer you use Flutter though.)
* Mithril (no longer in active development afaik.)

### Why I decided on React

Ultimately I needed to pick something to learn.  I went with react because it transfers nicely to react-native which I can then use a similar platform to make mobile applications.  

There probably are "better" alternatives but learning something is better than being stuck with [option paralysis](https://en.wikipedia.org/wiki/Option_Paralysis).  

## How I learned React

Granted I am no React professional and YMMV, but I'll just share what I used to learn react.  Honestly I recommend doing he [codeacademy react 101](https://www.codecademy.com/learn/react-101).  There are a lot of tutorials online, but they integrate with redux and other components that are not necessary and will confuse more than enlighten.  Even if you don't start with that same tutorial I'd highly suggest focusing on only React when trying to learn React.  Avoid the tutorials that teach react + X or redux etc.  The only other tutorial I'd recommend is currently incomplete but is the [beta official tutorial](https://beta.reactjs.org/learn).

## React tutorial

### JSX

So react also has it's own language that it uses in conjunction with javascript called [JSX](https://reactjs.org/docs/introducing-jsx.html).  The purpose of this is to allow you to render or create HTML elements via code.  See the following line as an example of what JSX looks like.

```javascript
const element = <h1>Hello, world!</h1>;
```

The main idea here is that JSX allows the developer to directly manipulate UI elements with Javascript.  For small projects it doesn't make too much sense and the old Model View Controller paradigm should be fine but in modern applications this idea is constantly broken.  Need to re-render previously rendered things the controller needs to update the model and possibly the view and perhaps even remember the state of things.  

#### One root to rule them all

One thing to note about JSX is you need to keep elements under one root.  Here's an example of what I mean:

```javascript
// This is invalid JSX and will cause weird errors.
// const variable = (
//   <p>Hello</p>  
//   <p>World</p>
// );

const variable = (
<div>
  <p>Hello</p> 
  <p>World</p>
</div>
);
```

#### Self-Closing Tags

In JSX Self Closing Tags must always end with the />.

```javascript
// This is invalid.
//<br>

// This is valid.
<br />
```

#### className vs class

If you want to insert css into the JSX variables the best way to go about doing it is with unique class names.  The important thing to note here is that "class" is a reserved word in Javascript so we have to use a different keyword.  Here's an example showing how the 'className' keyword will be treated the same the HTML 'class'.

```javascript
<img className="avatar" src="img_girl.jpg" />
```

```css
.avatar {
  border-radius: 50%;
}
```

#### Inserting Javascript into JSX elements

```javascript
const string_version = <h1>2 + 3 = 5</h1>;  // Renders as "2 + 3 = 5"

const math_version = <h1>{2 + 3} = 5</h1>;  // Renders as "5 = 5"
```

#### Calling functions from within JSX

```javascript
// You will always import this first one.
import React from 'react';
// You will import this one in the file that does the rendering.
import ReactDOM from 'react-dom';

// Example of calling a function called "makeDoggy"
function makeDoggy(e) {
  // The <img \> will become a picture of a doggy if its a cat.
  if (e.target.getAttribute("alt") == "kitty")
  {
    e.target.setAttribute('src', 'https://content.codecademy.com/courses/React/react_photo-puppy.jpeg');
    e.target.setAttribute('alt', 'doggy');
  } else
  {
    e.target.setAttribute('src', "https://content.codecademy.com/courses/React/react_photo-kitty.jpg" );
    e.target.setAttribute('alt', 'kitty');
  } 
}

const kitty = (
<img 
    onClick={makeDoggy}
    src="https://content.codecademy.com/courses/React/react_photo-kitty.jpg" 
    alt="kitty" />
);

// This tells React to render the img in the document "body."
ReactDOM.render(kitty, document.getElementById("body"));
```

#### If Statements

In React you can't put if statements within the curly braces.  Instead you will see a lot of short circuiting with "&&" (and) operators and extensive use of the ternary operator.

```javascript
// Putting an if in curly braces is not allowed. {if}

let string_to_be_rendered;
if (true) {
    string_to_be_rendered = <p>Render me.</p>
}
```

Example of ternary operator:

```javascript
const img = <img src={Math.random() > 0.5 ? "http://cat_url" : "http://doggy_url"} />;
```

## React

Quite a bit of react was me just needing to refresh myself on what is now considered good practice and style for Javascript.  The rest was indeed learning about React.  Without further ado here are some React notes.

### Component Classes

These are deprecated or not used very much beyond React 13+ because they were more wordy and harder to debug and test.  Difficulty to test makes them harder to maintain.  I'll still cover them briefly as you might see them elsewhere (or you might even need to code with them).

**Very important note** components in React *need* to be capitalized.  They follow the camel case and enforce it in the language.  If you switch a class to lowercase you'll encounter rendering issues or other weird bugs.  It's not fun to debug.

```javascript
import React from 'react';
import ReactDOM from 'react-dom';

class MySecondComponentClass extends React.Component {
  render() {
    return <h2>Hear me roar!</h2>;
  }
}

class MyComponentClass extends React.Component {
  render() {
    // We need to insert <div> because there has to be one root.
    return (
        <div>
            <h1>Hello world</h1>
            <MySecondComponentClass />
        </div>;
    )
  }
}

ReactDOM.render(<MyComponentClass />, document.getElementById("body"))
```

The output will look something like

```html
<h1>Hello world</h1>
<h2>Hear me roar!</h2>
```

### Functional Components

This is the main way to create components now.  

```javascript
// A component class
export class MyComponentClass extends React.Component {
  render() {
    return <h1>Hello world</h1>;
  }
}

// The same component class, written as a stateless functional component:
export const MyComponentClass = () => {
  return <h1>Hello world</h1>;
}
```

Note the arrow function "=>" is for anonymous functions.  See [arrow functions](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Arrow_functions) for more details.

### Props vs State

This is a very big thing in React so it would be good to spend a bit of time to capture the differences and provide some examples of when to use one or the other.  I'll also state my understanding of the two.

Props are arguments (or properties) you want to pass from one component to another.  A caveat to this is that props have to be stateless.  If you try to carry any state information it will complain and throw errors.

You manage the state with the `useState` function.  The function returns both a variable that you want to persist and a function to update said variable.

```javascript
// prop example.  Handy tip to remember:
// props come from above
function Welcome(props) {
  return <h1>Hello {props.name}</h1>;
}

// state setting example with a button
class Button extends React.Component {
  constructor() {
    super();
    this.state = {
      count: 0,
    };
  }

  updateCount() {
    this.setState((prevState, props) => {
      return { count: prevState.count + 1 }
    });
  }

  render() {
    return (<button
              onClick={() => this.updateCount()}
            >
              Clicked {this.state.count} times
            </button>);
  }
}
```

Summary: `props` get passed to the component (similar to function parameters) whereas state is managed within the component (similar to variables declared within a function). See [react docs](https://reactjs.org/docs/faq-state.html#what-is-the-difference-between-state-and-props) for more details.

#### State more in depth

Something I found extremely confusing when starting out is how "random" variables can appear and be used without warning.  A common example of this is using the "previous state."

```javascript
export default function Login() {
  const [formState, setFormState] = useState({});
 
  const handleChange = ({ target }) => {
    const { name, value } = target;
    // Where does "prev" come from????
    // prev is an implicit variable that is auto-populated with the 
    // previous state from "setFormState" function.
    setFormState((prev) => ({
      ...prev,
      [name]: value
    }));
  };
 
  return (
    <form>
      <input
        value={formState.firstName}
        onChange={handleChange}
        name="firstName"
        type="text"
      />
    </form>
  );
}
```

### Summary

Honestly I did not find the language/library that bad to learn.  It only took me a few days to get comfortable with the JSX language and the rest of week I spent learning React.  Granted I'm still not a React pro and don't feel completely comfortable doing a solo project.  I do feel comfortable reading and editing code though.  

Eventually I'll want to go through learning full stack: [fullstackopen.com](fullstackopen.com).
