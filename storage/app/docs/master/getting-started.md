# Getting Started

## [#](#installation)Installation

Phase is modular by design, so each component can be installed individually, depending on the use case and requirements of the project. However for most projects, the easiest way to get started is to install the main `phase` meta packages, which includes everything you need to hit the ground running. These packages are split into two main components. The backend (server-side) is installed using composer, and the front end (client-side) is installed via npm.

```bash
npm install @phased/phase
composer require @phased/phase
```

In addition, you will need to install Vue, Vuex (for state management), Vue Router (for SPA routing), and axios (for API requests) incase you have not done that yet

```bash
npm install axios vue vuex vue-router
```

`Vuex` is the official state management library provided by Vue. More information on this can be found here: [Vuex Documentation](https://vuex.vuejs.org/) . and `Vue Router` is the official router for building Single Page Apps (SPA) using Vue. [Vue Router Documentation](https://router.vuejs.org/) . Some knowledge of these tools will likely help when trying to understanding what Phase is doing, however is not at all a pre-requisite for building fast, easy to use SPA's.

### [#](#client-side-configuration)Client Side Configuration

Once the npm packages have been installed, some configuration is required. This is split into four main steps, however depending on the stage of your project, the first three may already be complete, since they aren't really unique to Phase.

#### [#](#axios)Axios

The first and easiest step is to ensure that [Axios](https://github.com/axios/axios) is available globally by attaching it (or an instance of it) to the window. This comes standard with Laravel apps, so unless you deleted it, its very possible its still in bootstrap.js
```js
window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
```

> If you are planning on taking advantage of Server Side Rendering provided by Phase, it should be pointed out that to write Universal Javascript, you cannot rely on `window` being present. With this in mind, one possible solution would be to re-write the above code by a using a check for the existence of the 'window' object

```js
if  (typeof window !== 'undefined') {
    window.axios = require('axios')
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
}
```

#### [#](#vuex)Vuex

Phase integrates deeply with Vuex for a much easier state management solution. [Detailed Installation of Vuex](https://vuex.vuejs.org/) can be followed from the official documentation. In short, you will need to create a 'store' that will be used as the single source of truth for your application. Below is an example setup shown as a 'diff' to demonstrate the changes to the install process required to make Phase work
```diff
import Vue from 'vue'
import Vuex, { Store } from 'vuex'
+ import { hydrate } from '@phased/state'
Vue.use(Vuex)

- const store = new Store({
+ const store = new Store(hydrate({
    state: {
        count: 0
    },
    mutations: {
        increment (state) {
            state.count++
        }
    }
- })
+ }))
```
The `hydrate` helper serves several purposes, but primarily its job is to accept updates from the backend and commit mutations automatically in order to keep your vuex state in sync.

#### [#](#laravel-mix)Laravel Mix

Phase uses a laravel-mix plugin in order to generate the routes definitions for your SPA. Although configurable, below is an example of the simplest possible setup. Notice that `app.js` is not specified. At this time, it is required to have `js/app.js` as the entry for your app, so its not needed to be configured. Out of the box `/sass/app.scss` is the main stylesheet entry, however This can be configured in `config/phase.php` if you so choose.

```js
// webpack.mix.js
const mix = require("laravel-mix")
require("@phased/phase")
mix.phase()
```

#### [#](#vue-router)Vue Router

Phase takes advantage of [Vue Router](https://router.vuejs.org/) to achieve SPA navigation. Phase provides a pre-configured routes file generated from your `routes/web.php`. These routes are generated as part of the build process, so make sure you have either [Laravel Mix](#laravel-mix) configured, or have configured the webpack plugin directly.
```js
import Vue from 'vue'
import VueRouter from 'vue-router'
import PhaseRoutes from '@phased/phase/routes'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: PhaseRoutes
})
```

### [#](#app-setup) App Setup
Assuming you have followed along with [Vuex](#vuex) & [Vue Router](#vue-router) setup, you now have a `store` a `router` objects. Phase requires the base app to be written in `resources/js/app.js` and export the app instead of mounting it directly as you may be used to. This deviation allows Phase to handle enabling or disabling SSR. In your vue config you must also supply a render function pointing to the entry `.vue` file.
```js
// app.js
import App from './App.vue'
// store, and router previously declared
export default new Vue({
    store,
    router
    render: h => h(App)
})
```
`App.vue` can be anything you like, however for the vue-router to work, you need to include a `<RouterView />` component. This is where each 'page' is rendered.
```html
<template>
    <div>
        <!--
            This is outside of the RouterView and
            therefore is persistent between page changes
        -->
        <StaticNavbar />

        <!-- This is where each page will be rendered -->
        <RouterView />
    </div>
</template>
```

### [#](#server-side-configuration)Server Side Configuration

After installing both `phased/phase` with composer and configuring the client side, Phase is ready to roll. For more customization options, a 'phased' config is exposed and can be published.
```bash
php artisan vendor:publish \
    --provider="Phased\Routing\PhasedRoutingServiceProvider" \
    --tag="config"
```
If you are planning on taking advantage of Server Side Rendering of your SPA, you will need to add the path to Node.js
```bash
NODE_PATH='/path/to/node'
```
