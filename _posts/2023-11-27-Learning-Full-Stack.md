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

### Database debugging

This section is covered later but adding all of my debugging notes together.
If not getting any data from the database check you can still access it

```bash
node mongo.js insert_password_here
```

If using `.env` you can add the following to automatically grab the URL and passwords from the file.
```javascript
require('dotenv').config()

const PORT = process.env.PORT
const MONGODB_URI = process.env.MONGODB_URI
```
Also try to visit the website directly to see if it's reachable:
https://test-express-db.fly.dev/api/note


# Databases

We need to store the data somehow and create backups etc. 

## MongoDB

We'll use MongoDB Atlas for our server.
Steps 
1. add username and password for admin.  
1. Add allow network access from all IPs.  0.0.0.0/0
1. Click database tab and connect. Copy the server address


```javascript
mongodb+srv://admin:<password>@db.12zqhl8.mongodb.net/?retryWrites=true&w=majority
```

We'll use the `mongoose` library

```
cd backend

npm install mongoose
```

Make a test application `mongo.js`


```javascript
const mongoose = require('mongoose')

if (process.argv.length<3) {
  console.log('give password as argument')
  process.exit(1)
}

const password = process.argv[2]

const url =
  `mongodb+srv://admin:${password}@db.12zqhl8.mongodb.net/?retryWrites=true&w=majority`

mongoose.set('strictQuery',false)
mongoose.connect(url)

const noteSchema = new mongoose.Schema({
  content: String,
  important: Boolean,
})

const Note = mongoose.model('Note', noteSchema)

const note = new Note({
  content: 'HTML is Easy',
  important: true,
})

note.save().then(result => {
  console.log('note saved!')
  mongoose.connection.close()
})
```

Run it with 

```
node mongo.js insert_password_here
```

On the website click on the databases tab and then click on browse collections to view what we've added.

```javascript
// edit the const url

// from
const url =
  `mongodb+srv://admin:${password}@db.12zqhl8.mongodb.net/?retryWrites=true&w=majority`

// to
const url =
  `mongodb+srv://admin:${password}@db.12zqhl8.mongodb.net/noteApp?retryWrites=true&w=majority`
```

## Adding mongoose to the backend

Add the base of the previous part to the top of `index.js`

```javascript
const mongoose = require('mongoose')

// DO NOT SAVE YOUR PASSWORD TO GITHUB!!
const url =
  `mongodb+srv://admin:${password}@db.12zqhl8.mongodb.net/noteApp?retryWrites=true&w=majority`

mongoose.set('strictQuery',false)
mongoose.connect(url)

const noteSchema = new mongoose.Schema({
  content: String,
  important: Boolean,
})

const Note = mongoose.model('Note', noteSchema)
```

Update the getter

```javascript
app.get('/api/notes', (request, response) => {
  Note.find({}).then(notes => {
    response.json(notes)
  })
})
```

Run it

`node index.js password`

Make a few changes.  Make the id parameter valid such as from `_id` to `id` and don't return the version i.e. `_v` field.

```javascript
noteSchema.set('toJSON', {
  transform: (document, returnedObject) => {
    returnedObject.id = returnedObject._id.toString()
    delete returnedObject._id
    delete returnedObject.__v
  }
})
```

Move the code out of the file to it's own folder and file. `models/notes.js`

```javascript
const mongoose = require('mongoose')

mongoose.set('strictQuery', false)


const url = process.env.MONGODB_URI


console.log('connecting to', url)

mongoose.connect(url)

  .then(result => {
    console.log('connected to MongoDB')
  })
  .catch((error) => {
    console.log('error connecting to MongoDB:', error.message)
  })

const noteSchema = new mongoose.Schema({
  content: String,
  important: Boolean,
})

noteSchema.set('toJSON', {
  transform: (document, returnedObject) => {
    returnedObject.id = returnedObject._id.toString()
    delete returnedObject._id
    delete returnedObject.__v
  }
})


module.exports = mongoose.model('Note', noteSchema)
```

Run it via commandline like so

```bash
MONGODB_URI=address_here npm run dev
```

Alternatively lets just use an environment file to define all of the hard coded values.

```bash
npm install dotenv
```

Create `.env` file.  (Replace <password> with the actual password.)

```
MONGODB_URI=mongodb+srv://admin:<password>@db.12zqhl8.mongodb.net/noteApp?retryWrites=true&w=majority
PORT=3001
```

Add `.env` to both `.gitignore` and to `.dockerignore` (if it isn't already there).

Now we can update index.js and don't need the OR around the PORT variable.

```javascript
require('dotenv').config()
const express = require('express')
const app = express()
const Note = require('./models/note')

...

const PORT = process.env.PORT
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`)
})
```

For fly.io make a new secret and pass in the full url (along with the real password).

```
fly secrets set MONGODB_URI='mongodb+srv://admin:<password>@db.12zqhl8.mongodb.net/noteApp?retryWrites=true&w=majority'
```

Lets finish updating the rest of the routes. Update the post method.

```javascript
app.post('/api/notes', (request, response) => {
  const body = request.body

  if (body.content === undefined) {
    return response.status(400).json({ error: 'content missing' })
  }

  const note = new Note({
    content: body.content,
    important: body.important || false,
  })

  note.save().then(savedNote => {
    response.json(savedNote)
  })
})
```

Update getting a note by id.

```javascript
app.get('/api/notes/:id', (request, response) => {
  Note.findById(request.params.id).then(note => {
    response.json(note)
  })
})
```

After changing the backend it's a good thing to verify it before continuing.  Test with either VSCode Rest tests, the browser or postman.


Adding some more functionality that we'll need.  Deletion

```javascript
app.delete('/api/notes/:id', (request, response, next) => {
  Note.findByIdAndDelete(request.params.id)
    .then(result => {
      response.status(204).end()
    })
    .catch(error => next(error))
})
```

Update the contents like toggling importance

```javascript
app.put('/api/notes/:id', (request, response, next) => {
  const body = request.body

  const note = {
    content: body.content,
    important: body.important,
  }

  Note.findByIdAndUpdate(request.params.id, note, { new: true })
    .then(updatedNote => {
      response.json(updatedNote)
    })
    .catch(error => next(error))
})
```

There is one important detail regarding the use of the findByIdAndUpdate method. By default, the updatedNote parameter of the event handler receives the original document [without the modifications](https://mongoosejs.com/docs/api/model.html#Model.findByIdAndUpdate()). We added the optional { new: true } parameter, which will cause our event handler to be called with the new modified document instead of the original.


## Error Handling

### Basic Error Handling

If we visit an id that doesn't exist such as http://localhost:3001/api/notes/5c41c90e84d891c15dfa3431 then we get null.  Let's make that prettier.

```javascript
app.get('/api/notes/:id', (request, response) => {
  Note.findById(request.params.id)
    .then(note => {
      if (note) {
        response.json(note)
      } else {
        response.status(404).end()
      }
    })
    .catch(error => {
      console.log(error)
      response.status(500).end()
    })
})

// Alternatively
    .catch(error => {
      console.log(error)
      response.status(400).send({ error: 'malformatted id' })
    })
```

Look at the terminal, console for these errors appearing.

### Error Handling Middleware

```javascript
app.get('/api/notes/:id', (request, response, next) => {
  Note.findById(request.params.id)
    .then(note => {
      if (note) {
        response.json(note)
      } else {
        response.status(404).end()
      }
    })
    .catch(error => next(error))
})
```

```javascript
const errorHandler = (error, request, response, next) => {
  console.error(error.message)

  if (error.name === 'CastError') {
    return response.status(400).send({ error: 'malformatted id' })
  } 

  next(error)
}

// this has to be the last loaded middleware.
app.use(errorHandler)
```

## Validation and Linting

### Validation

Besides not posting in case the body is empty

```javascript
app.post('/api/notes', (request, response) => {
  const body = request.body
  if (body.content === undefined) {
    return response.status(400).json({ error: 'content missing' })
  }
```

We can also add a content schema to mongoose

```
const noteSchema = new mongoose.Schema({

  content: {
    type: String,
    minLength: 5,
    required: true
  },
  important: Boolean
})
```

Add a catch error `.catch(error => next(error))` to `app.post` and a new error condition to the error handler

```javascript
app.put('/api/notes/:id', (request, response, next) => {

  const { content, important } = request.body

  Note.findByIdAndUpdate(
    request.params.id, 

    { content, important },
    { new: true, runValidators: true, context: 'query' }
  ) 
    .then(updatedNote => {
      response.json(updatedNote)
    })
    .catch(error => next(error))
})
```

Deploy to prod backend

```bash
fly secrets set MONGODB_URI='mongodb+srv://admin:<password>@db.12zqhl8.mongodb.net/noteApp?retryWrites=true&w=majority'
```

### Linting

Install ESLint

```bash
# backend repo
npm install eslint --save-dev

npx eslint --init
```


```
You can also run this command directly using 'npm init @eslint/config'.
✔ How would you like to use ESLint? · style
✔ What type of modules does your project use? · commonjs
✔ Which framework does your project use? · vue
✔ Does your project use TypeScript? · No / Yes
✔ Where does your code run? · browser
✔ How would you like to define a style for your project? · prompt
✔ What format do you want your config file to be in? · JavaScript
✔ What style of indentation do you use? · 4
✔ What quotes do you use for strings? · double
✔ What line endings do you use? · unix
✔ Do you require semicolons? · No
The config that you've selected requires the following dependencies:

@typescript-eslint/eslint-plugin@latest eslint-plugin-vue@latest @typescript-eslint/parser@latest
✔ Would you like to install them now? · No / Yes
✔ Which package manager do you want to use? · npm
```

Install ESLint in VSCode

in `eslintrc.js` add the following rules

```javascript
  'eqeqeq': 'error',
  "@typescript-eslint/no-var-requires": "off",
```

TODO: Need to double check which packages can be imported as requires or not.

Add the file `.eslintignore` to ignore a bunch of the node_modules and dist.

```
dist
node_modules
```

## Project structure

```
├── index.js
├── app.js
├── dist
│   └── ...
├── controllers
│   └── notes.js
├── models
│   └── note.js
├── package-lock.json
├── package.json
├── utils
│   ├── config.js
│   ├── logger.js
│   └── middleware.js  
```

`utils/logger.js` helpful for whenever you want to change how you log stuff.

```javascript
const info = (...params) => {
  console.log(...params)
}

const error = (...params) => {
  console.error(...params)
}

module.exports = {
  info, error
}
```

The handling of environment variables is extracted into a separate `utils/config.js` file:

```javascript
require('dotenv').config()

const PORT = process.env.PORT
const MONGODB_URI = process.env.MONGODB_URI

module.exports = {
  MONGODB_URI,
  PORT
}
```

The other parts of the application can access the environment variables by importing the configuration module:

```javascript
const config = require('./utils/config')

logger.info(`Server running on port ${config.PORT}`)
```

`app.js`

```javascript
const config = require('./utils/config')
const express = require('express')
const app = express()
const cors = require('cors')
const notesRouter = require('./controllers/notes')
const middleware = require('./utils/middleware')
const logger = require('./utils/logger')
const mongoose = require('mongoose')

mongoose.set('strictQuery', false)

logger.info('connecting to', config.MONGODB_URI)

mongoose.connect(config.MONGODB_URI)
  .then(() => {
    logger.info('connected to MongoDB')
  })
  .catch((error) => {
    logger.error('error connecting to MongoDB:', error.message)
  })

app.use(cors())
app.use(express.static('dist'))
app.use(express.json())
app.use(middleware.requestLogger)

app.use('/api/notes', notesRouter)

app.use(middleware.unknownEndpoint)
app.use(middleware.errorHandler)

module.exports = app
```

Shortened the following 
```javascript
const express = require('express')
const app = express()
// to 
const notesRouter = require('express').Router()
```

The router is in fact a middleware, that can be used for defining "related routes" in a single place, which is typically placed in its own module.

`controllers/notes.js`

```javascript
const notesRouter = require('express').Router()
const Note = require('../models/note')

notesRouter.get('/', (request, response) => {
  Note.find({}).then(notes => {
    response.json(notes)
  })
})

notesRouter.get('/:id', (request, response, next) => {
  Note.findById(request.params.id)
    .then(note => {
      if (note) {
        response.json(note)
      } else {
        response.status(404).end()
      }
    })
    .catch(error => next(error))
})

notesRouter.post('/', (request, response, next) => {
  const body = request.body

  const note = new Note({
    content: body.content,
    important: body.important || false,
  })

  note.save()
    .then(savedNote => {
      response.json(savedNote)
    })
    .catch(error => next(error))
})

notesRouter.delete('/:id', (request, response, next) => {
  Note.findByIdAndDelete(request.params.id)
    .then(() => {
      response.status(204).end()
    })
    .catch(error => next(error))
})

notesRouter.put('/:id', (request, response, next) => {
  const body = request.body

  const note = {
    content: body.content,
    important: body.important,
  }

  Note.findByIdAndUpdate(request.params.id, note, { new: true })
    .then(updatedNote => {
      response.json(updatedNote)
    })
    .catch(error => next(error))
})

module.exports = notesRouter
```

`index.js`

```javascript
const app = require('./app') // the actual Express application
const config = require('./utils/config')
const logger = require('./utils/logger')

app.listen(config.PORT, () => {
  logger.info(`Server running on port ${config.PORT}`)
})
```

`utils/middleware.js`

```javascript
const logger = require('./logger')

const requestLogger = (request, response, next) => {
  logger.info('Method:', request.method)
  logger.info('Path:  ', request.path)
  logger.info('Body:  ', request.body)
  logger.info('---')
  next()
}

const unknownEndpoint = (request, response) => {
  response.status(404).send({ error: 'unknown endpoint' })
}

const errorHandler = (error, request, response, next) => {
  logger.error(error.message)

  if (error.name === 'CastError') {
    return response.status(400).send({ error: 'malformatted id' })
  } else if (error.name === 'ValidationError') {
    return response.status(400).json({ error: error.message })
  }

  next(error)
}

module.exports = {
  requestLogger,
  unknownEndpoint,
  errorHandler
}
```

## Testing

### Unit testing Basics

This is mostly for automated tests.  We will use [jest](https://jestjs.io)

```bash
npm install --save-dev jest
```

to the scripts in package.json add `"test": "jest --verbose"`. We also need to add to package.json to let jest know which environment we're using.

```javascript
 "jest": {
   "testEnvironment": "node"
 }
```

Add a file called `utils/for_testing.js`

```javascript
const reverse = (string) => {
  return string
    .split('')
    .reverse()
    .join('')
}

const average = (array) => {
  const reducer = (sum, item) => {
    return sum + item
  }

  return array.reduce(reducer, 0) / array.length
}

module.exports = {
  reverse,
  average,
}
```

Add a simple test file in folder `tests/reverse.test.js`

```javascript
const reverse = (string) => {
    return string
      .split('')
      .reverse()
      .join('')
}
  
const average = (array) => {
const reducer = (sum, item) => {
    return sum + item
}

return array.reduce(reducer, 0) / array.length
}

module.exports = {
    reverse,
    average,
}
```

The linter will complain about `test` being undefined so lets fix that by modifying the `.eslintrc.js` file Add the `'jest' : true`

```javascript
module.exports = {
  'env': {
    'commonjs': true,
    'es2021': true,
    'node': true,
    'jest': true,
  },
```

describe blocks are necessary when we want to run some shared setup or teardown operations for a group of tests.

Test with 

```
npm run test
```

### Integration Testing

Add `NODE_ENV` to package.json scripts

```javascript
"scripts": {
    "start": "NODE_ENV=production node index.js",
    "dev": "NODE_ENV=development nodemon index.js",
    "build:ui": "rm -rf build && cd ../frontend/ && npm run build && cp -r build ../backend",
    "deploy": "fly deploy",
    "deploy:full": "npm run build:ui && npm run deploy",
    "logs:prod": "fly logs",
    "lint": "eslint .",
    "test": "NODE_ENV=test jest --verbose --runInBand"
}, //...
```

If you need to run on windows install `cross-env` globally and add it before all of the `NODE_ENV` variables such as `"start": "cross-env NODE_ENV=production ...`.

TODO return to https://fullstackopen.com/en/part4/testing_the_backend later
Currently suggests to test the database with a test DB also on atlas.


## Asynchronous async/await

Code for context.

In file `backend/models/note.js`
```
const mongoose = require("mongoose")
const noteSchema = new mongoose.Schema({
    content: {
        type: String,
    },
    important: Boolean,
})
module.exports = mongoose.model("Note", noteSchema)
```

In `backend/controllers/notes.js`
```
const Note = require('../models/note')
...
Note.find({}).then(notes => {
  console.log('operation returned the following notes', notes)
})
```

The Note.find() method returns a promise and we can access the result of the operation by registering a callback function with the `then` method. 



