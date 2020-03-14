# State Management

```php
// Namespace
use Phased\State\Facades\Vuex;
```

### [#](#store-actions)Store Actions
```php
Vuex::store($closure);
Vuex::state($state);
Vuex::module($namespace, $state);
Vuex::commit($mutation, $arguments);
Vuex::dispatch($mutation, $arguments);
```

### [#](#module-loaders)Module Loaders
```php
Vuex::load($namespace, $keys);
Vuex::lazyLoad($namespace, $keys);
Vuex::register($mappings);
```

### [#](#helpers)Helpers
```php
Vuex::toArray();
Vuex::toJson();
Vuex::dd();

use Phased\State\Traits\Vuexable; // trait
$collection->toVuex($namespace, $key); // Collections
$model->toVuex($namespace, $key); // Models

response()->vuex(); // api responses
```
