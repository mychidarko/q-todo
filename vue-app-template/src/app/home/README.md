# Directory Structure

Every directory has it's `components`, `routes`, `store` to manage how that particular component works.

## How it works

### Inside `components` Folder

---

`Home.vue` is the Vue component itself and `index.js` is kind of acting as a bootstrap for the component.

### Inside `routes` Folder

---

`index.js` is where the route for this component is registered.

### Inside `store` Folder

---

This folder contains the store activities such as `actions`, `getters`, `mutations`, and `states`.

`index.js` is the central point for those store activities.
