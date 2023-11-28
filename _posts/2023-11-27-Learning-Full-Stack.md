---
layout: post
title:  "Learning Full Stack"
date:   2023-07-16 12:00:00
categories: learning full stack full-stack
published: false
---

# Learning full stack notes

Following this course [fullstackopen.com](https://fullstackopen.com/en/)

# Frontend

React mostly.

## Install node and npm

```bash
sudo apt-get update
sudo apt-get install -y ca-certificates curl gnupg
sudo mkdir -p /etc/apt/keyrings
curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | sudo gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg

NODE_MAJOR=20
echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | sudo tee /etc/apt/sources.list.d/nodesource.list

sudo apt-get update
sudo apt-get install nodejs -y
```

[Source](https://github.com/nodesource/distributions)

## Course instructions

### Set up the template

```bash
npm create vite@latest part1 --template react
cd part1
npm install

# I chose the react version and typescript + swc

npm run dev
```

### Editing the template

Go to `src/` folder. Delete the assets folder, App.css, and index.css.

main.jsx
```javascript
import ReactDOM from 'react-dom/client'
import App from './App.tsx'

ReactDOM.createRoot(document.getElementById('root')!).render(
    <App />
)
```

App.jsx
```javascript
function App() {
  return (
    <div>
      <p>Hello world</p>
    </div>
  )
}

export default App
```

## For testing a server

```
npm install json-server --save-dev
```


make a json file.  call it `db.json` then run `npx json-server --port 3001 --watch db.json`

## For making calls to the server

```
npm install axios
```

```json
 "scripts": {
    "dev": "vite",
    "build": "tsc && vite build",
    "lint": "eslint . --ext ts,tsx --report-unused-disable-directives --max-warnings 0",
    "preview": "vite preview",
Add this ==>    "server": "json-server -p3001 --watch db.json"
  },
```

Simple example

```javascript
import axios from 'axios'

const promise = axios.get('http://localhost:3001/notes')
console.log(promise)
```

Don't put axios fetch command before the react in the main.tsx. Do this instead inside of the App.tsx.

```javascript
import { useState, useEffect } from 'react'
import axios from 'axios'

const App = () => {
  const [notes, setNotes] = useState([])
  const [newNote, setNewNote] = useState('')
  const [showAll, setShowAll] = useState(true)

  useEffect(() => {
    console.log('effect')
    axios
      .get('http://localhost:3001/notes')
      .then(response => {
        console.log('promise fulfilled')
        setNotes(response.data)
      })
  }, [])
  console.log('render', notes.length, 'notes')
}
```

So by default, the effect is always run after the component has been rendered. In our case, however, we only want to execute the effect along with the first render.

The second parameter of useEffect is used to specify how often the effect is run. If the second parameter is an empty array [], then the effect is only run along with the first render of the component.

Make sure to try promise chaining
https://javascript.info/promise-chaining


## How to edit arrays and objects

use .map or reduce
Examples
```javascript
const note = notes.find(n => n.id === id)
const changedNote = { ...note, important: !note.important }

const changed_notes = notes.map((note) => {
  if (note.id === changedNote.id) {
    return changedNote;
  }
  return note;
});
```

```javascript
export default { 
  getAll: getAll, 
  create: create, 
  update: update 
}

===

export default { getAll, create, update }
```

## CSS in react

Quick example to highlight

```javascript
const Footer = () => {
  const footerStyle = {
    color: 'green',
    fontStyle: 'italic',
    fontSize: 16
  }
  return (
    <div style={footerStyle}>
      <br />
      <em>Note app, Department of Computer Science, University of Helsinki 2023</em>
    </div>
  )
}

const App = () => {
  // ...

  return (
    <div>
      <h1>Notes</h1>

      <Notification message={errorMessage} />

      // ...  

      <Footer />
    </div>
  )
}
```

## Typescript

```javascript
// How to fix the {name} error in props
interface Props {
  name: string;
  age: number;
  onClick: () => void;
}

const MyComponent: React.FC<Props> = ({ name, age, onClick }) {
  return (<div> </div>)
}


// events
event: React.SyntheticEvent
// or even better if you use event.target.value
event: React.ChangeEvent<HTMLInputElement>

// Updating this lines
const [notes, setNotes] = useState([]);

interface Note {
  id: number,
  content: string
}

const [notes, setNotes] = useState<Note[]>([]);

// Also instead of interface you can use type
type Props = {
  name: string;
  age: number;
  onClick: () => void;
}
// This prevents multiple redefinitions
// interface having multiple will just combine them adding the new stuff
```


# Backend

Nodes.js and Express

## Running simple js file

npm init

vim package.json

```json
"scripts": {
    "start": "node index.js",
    ...
}
```

create index.js 

```javascript
console.log("hello world")
```

run it with `node index.js` or `npm start`

## simple node web server

```
const http = require('http')

const app = http.createServer((request, response) => {
  response.writeHead(200, { 'Content-Type': 'text/plain' })
  response.end('Hello World')
})

const PORT = 3001
app.listen(PORT)
console.log(`Server running on port ${PORT}`)
```

Returning json

```javascript
let notes = [
  {
    id: 1,
    content: "HTML is easy",
    important: true
  },
  ...
]
const app = http.createServer((request, response) => {
  response.writeHead(200, { 'Content-Type': 'application/json' })
  response.end(JSON.stringify(notes))
})
```

## Express

Lets use a more feature rich JS backend server model Express. 
Lets install it `npm install express`

For easier developing as well we recommend using nodemon which will restart the server based on file changes. `npm install --save-dev nodemon`
Add `"dev": "nodemon index.js",` to package.json under scripts. Start it with `npm run dev`

Simple express example

```javascript
const express = require('express')
const app = express()

let notes = [
  ...
]

app.get('/', (request, response) => {
  response.send('<h1>Hello World!</h1>')
})

app.get('/api/notes', (request, response) => {
  response.json(notes)
})

const PORT = 3001
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`)
})copy
```

### Making it restful adding an API

Getting a resource.
Here id is a parameter, however it has a bug.

```javascript
app.get('/api/notes/:id', (request, response) => {
  const id = request.params.id
  const note = notes.find(note => {
    console.log(note.id, typeof note.id, id, typeof id, note.id === id)
    return note.id === id
  })
  response.json(note)
})
```

How to send back an error when a note isn't found and see [link](https://stackoverflow.com/questions/14154337/how-to-send-a-custom-http-status-message-in-node-express/36507614#36507614) for how to send a more informative status message.

```javascript
app.get('/api/notes/:id', (request, response) => {
  const id = Number(request.params.id)
  const note = notes.find(note => note.id === id)
  
  if (note) {
    response.json(note)
  } else {
    response.status(404).end()
  }
})
```

How to delete a resource

```javascript
app.delete('/api/notes/:id', (request, response) => {
  const id = Number(request.params.id)
  notes = notes.filter(note => note.id !== id)

  response.status(204).end()
})
```

### Receiving data (with Express)

```javascript
const express = require('express')
const app = express()

app.use(express.json())

//...

app.post('/api/notes', (request, response) => {
  const note = request.body
  console.log(note)
  response.json(note)
})

// Add a new note
app.post('/api/notes', (request, response) => {
  // We find the max id in case notes have been deleted.
  const maxId = notes.length > 0
    ? Math.max(...notes.map(n => n.id)) 
    : 0

  const note = request.body
  note.id = maxId + 1

  notes = notes.concat(note)

  response.json(note)
})copy
```

### Express middleware

[Middleware docs](https://expressjs.com/en/guide/using-middleware.html)
This example shows a middleware function with no mount path. The function is executed every time the app receives a request.

```javascript
const express = require('express')
const app = express()

app.use((req, res, next) => {
  console.log('Time:', Date.now())
  next()
})
```

This example shows a middleware function mounted on the /user/:id path. The function is executed for any type of HTTP request on the /user/:id path.

```javascript
app.use('/user/:id', (req, res, next) => {
  console.log('Request Type:', req.method)
  next()
})
```

### Testing with Postman

curl is a valid option too.

Download [postman](https://www.postman.com/downloads/)
Currently command is 
`curl -o- "https://dl-cli.pstmn.io/install/linux64.sh" | sh`

Alternatively feel free to use VScode [REST client](https://marketplace.visualstudio.com/items?itemName=humao.rest-client)


## Learning same origin policy and CORS

Example error `Redirect has been blocked by CORS policy: No 'Access-Control-Allow-Origin' header is present on the requested resource. Origin 'http://localhost:8080' is therefore not allowed access.`


The issue lies with a thing called same origin policy. A URL's origin is defined by the combination of protocol (AKA scheme), hostname, and port.

http://example.com:80/index.html
  
protocol: http
host: example.com
port: 80

```bash
npm install cors

# in the backend code Express
const cors = require('cors')

app.use(cors())
```

## Deploying to the Internet

Going to try with [Fly.io](https://fly.io) because it also offers CI/CD.
Can also use other platforms like Render, cyclic, replit, codeSandBox.

[install fly.io](https://fly.io/docs/hands-on/install-flyctl/) (linux)

```bash
curl -L https://fly.io/install.sh | sh

fly launch
```

### Deploy the backend

```
cd part3_backend
```

index.js

```javascript
const PORT = process.env.PORT || 3001
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`)
})
```

possibly add the following to fly.toml

```yaml
[env]
  PORT = "3000" # add this
```

```bash
fly deploy

fly open

# use this
fly logs

# fly sometimes automatically deploys 
fly scale show  
fly scale count 1

flyctl ping -o personal
# 35 bytes from fdaa:3:8d69::3 (gateway), seq=0 time=39.4ms
```

### Deploy the frontend

```bash
cd part1_react

npm run build 
```

By making the baseUrl relative it breaks the fetching for local development.  Add the following to `vite.config.js`

```js
// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],
  server: {
    proxy: {
      '/api': {
        target: 'http://localhost:3001',
        changeOrigin: true,
      },
    }
  },
})
```

Add the following to `package.json` of the backend repository.

```json
{
  "scripts": {
    // ...
    "build:ui": "rm -rf dist && cd ../notes-frontend/ && npm run build && cp -r dist ../notes-backend",
    "deploy": "fly deploy",
    "deploy:full": "npm run build:ui && npm run deploy",    
    "logs:prod": "fly logs"
  }
}
```

Now you can launch both with 

```bash
npm deploy:full
```

## Debugging

Keep the developer console open and make sure to use `console.log()` it is your best friend.

### VS Code

In VS Code you can debug from the top `Run` to `Start Debugging`.  Might need to click `Add Configuration` and add in `npm start.` 

### Chrome dev tools

```bash
node --inspect index.js
# OR
nodemon --inspect index.js
```



## Databases

We need to store the data somehow and create backups etc. 

### MongoDB

We'll use MongoDB Atlas for our server.
Steps 
1. add username and password for admin.  
1. Add allow network access from all IPs.  0.0.0.0/0
1. Click database tab and connect. Copy the server address


We'll use the `mongoose` library

