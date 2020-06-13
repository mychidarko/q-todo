# Router to Components

This is where routers are kept. And each route has it's dedicated component to render.

## How it works

`./routes.js` is the meeting point for all the routes inside these directories;

`./auth` `./home` `./errors` and `./timeline`.

And `./index.js` keeps `./routes.js`

## Usage

```javascript
//inside ./routes.js

import foo from './foo/routes'

export default [..., ...foo]
```
