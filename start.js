const express = require('express')
const bodyParser = require('body-parser')
const session = require('express-session')
const companion = require('@uppy/companion')

const app = express()

// Companion requires body-parser and express-session middleware.
// You can add it like this if you use those throughout your app.
//
// If you are using something else in your app, you can add these
// middlewares in the same subpath as Companion instead.
app.use(bodyParser.json())
app.use(session({secret: 'some secrety secret'}))
// const options = {
//     providerOptions: {
//         drive: {
//             key: "239715823811-mu1lmcapj69a8cqjsppfbd939gp2nvg4.apps.googleusercontent.com",
//             secret: "Xtu_-ruPXPqjjL7ROrp1ByNS",
//         },
//     },
//     server: {
//         host: 'formacamp.localhost',
//         protocol: 'http',
//         // This MUST match the path you specify in `app.use()` below:
//         path: '/companion',
//     },
//     filePath: '/path/to/folder/',
// }
//
// app.use('/companion', companion.app(options))
