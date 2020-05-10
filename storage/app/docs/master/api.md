## Routing
```php
Route::phase($url, $action); // create new phase route
```

## Vuex Facade
```php
use Phased\State\Facades\Vuex;

// State
Vuex::state($state); // set vuex root state
Vuex::module($namespace, $state); // set vuex module state
Vuex::commit($mutation, $arguments); // commit vuex mutation
Vuex::dispatch($mutation, $arguments); // dispatch vuex action

// Module Loaders
Vuex::load($namespace, $keys); // immediate mode load module loader
Vuex::lazyLoad($namespace, $keys); // lazy load module loader
Vuex::register($mappings); // register module loader

// Helpers
Vuex::toArray();
Vuex::toJson();
Vuex::dd();
```

## toVuex Helpers
```php
use Phased\State\Traits\Vuexable; // model trait
$collection->toVuex($namespace, $key); // Collections
$model->toVuex($namespace, $key); // Models
```

## Responses
```php
use Phased\Routing\Facades\Phase;
Phase::view(); // view/api responses
response()->vuex(); // api responses
```

## JS Imports
```js
// State Hydration
import { hydrate } from '@phased/state'

// Phase Routes
import PhaseRoutes from '@phased/phase/routes'

// Laravel Mix
require("@phased/phase")
mix.phase()
```
