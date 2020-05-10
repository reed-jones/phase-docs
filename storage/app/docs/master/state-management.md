# State Management

All of the state management component of Phase is exposed through the `Vuex` Facade. Since much of how Phase makes the connections between Vue & Laravel doesn't require much direct interaction, This is likely to be the most commonly used feature for day to day development.
```php
// Namespace
use Phased\State\Facades\Vuex;
```

### [#](#store-actions)Store Actions
The `Vuex` facade provides several methods for handling data. All of these methods are 'write-only'. This means you can send data to vuex, however there is no way to read data back. These methods can be called at any time, and when called, will stage the supplied data to be included in the response. When the front end gets ahold of this new data, it will automatically commit mutations, and add this new data to your vuex store.

To add data to your base vuex state, the `::state` method can be used. Any data added here will be available on the base `this.$store.state` object of your vuex store. This data must be either an `key => value` array which will store the data as it currently it or a function which will be lazily evaluated at the end of the request, For example, to add the currently authenticated user to state, you could do the following.
```php
Vuex::state([
    'user' => Auth::user()
]);
```
Which would then expose the the user to the front end. If this was done in the controller which loaded the view, then the information will be available on page load. Likewise if it was in response to an api call, then the new data would be automatically committed & available as soon as the api call was resolved.
```js
mounted() {
    console.log(this.$store.state.user)
}
```
Using state in this manner is great for some use cases, & smaller apps however as your application grows, [Vuex modules](https://vuex.vuejs.org/guide/modules.html) are a great way to organize your code. Phase supports this using the `::module` method. The first argument is the namespace of your module, and the second is a state array such as we saw in the previous example.
```php
Vuex::module('posts', [
    // this.$store.state.posts.all
    'all' => Post::paginate(),

    // this.$store.state.posts.author
    'author' => Auth::user(),

    // this.$store.state.posts.comments_enabled
    'comments_enabled' => true
]);
```
As you may have noticed, the above examples completed overwrite whatever is currently in your vuex state, with the new state. Often this is great, and what you need however in some cases a little more finesse may be called for. Lets say on the front end you have an array of 100 widgets, and you send a delete request to the backend to destroy one of the widgets. One approach would be to send the request, delete the widget, then update the store with the remaining widgets. This would look something like
```js
// widgetId is just one of our many widgets
axios.delete(`/widgets/${widgetId})
```

```php
public function destroy(Widget $widget)
{
    // Delete the widget
    $widget->delete();

    // Store all remaining widgets in vuex
    Vuex::module('widgets', [ 'all' => Widget::all() ]);

    // Update the front end
    return response()->vuex();
}
```
This works and is an extremely easy way to update the front end while maintaining data integrity with the backend, however that means you are sending back 99 widgets over the network that are already on the front end. In this case you may prefer to reach for a slightly more fine tuned solution. Using the `::commit` and `::dispatch` methods, allow you to call your own mutations and actions right from php. Redoing the above example using a custom mutation to filter out the deleted widget would be another solution to the above problem.
```js
// widgetId is just one of our many widgets
axios.delete(`/widgets/${widgetId})
```

```php
public function destroy(Widget $widget)
{
    // Delete the widget
    $widget->destroy();

    // Call our custom mutation, passing the widget ID
    Vuex::commit('widgets/removeWidget', $widget->id);

    //return to the front end
    return response()->vuex();
}
```

```js
// our vuex mutation in widgets.js
mutations: {
    removeWidget(state, widgetId) {
        state.all = state.all.filter(widget => widget.id !== widgetId);
    }
}
```
As with regular mutations, if multiple mutations are called, each will be called in order, and are synchronous.
```php
Vuex::module('numbers', ['count' => 0]);
Vuex::commit('numbers/increment', 1);
Vuex::commit('numbers/increment', 1);
Vuex::commit('numbers/increment', 1);
// in JS, this.$store.state.numbers.count === 3
```
Actions will also be called in order, however are asynchronous.
```php
// will trigger the front end to fetch the latest
// weather from an external third party api...
Vuex::dispatch('fetchWeather');
```

### [#](#collections--methods)Collections & Methods
Phase extends collections our of the box, adding a `->toVuex(....)` method for storing data to modules. This can be chained onto existing queries & returns its original collection, so it can continue to be chained if needed.
```php
Post::query()
    ->where('author_id', Auth::user()->id)
    ->get()
    ->toVuex('posts', 'myPosts');
// access at this.$store.state.posts.myPosts
```
Models don't provide an easy way too extend the default behavior, so if you want this functionality, it must be provided via the `Vuexable` trait.
```php
use Phased\State\Traits\Vuexable;

class User extends Authenticatable
{
    use Vuexable;

// Later...

Auth::user()->toVuex('user', 'active');
```

### [#](#module-loaders)Module Loaders
TODO:...

- Module Loaders are placed at `app/VuexLoaders/{{ModuleName}}ModuleLoader.php`.
- Can be generated with `php artisan make:loader {ModuleName}`
- Will be automatically registered if the above naming convention is used.

```php
// API...
Vuex::load($namespace, $keys);
Vuex::lazyLoad($namespace, $keys);
Vuex::register($mappings);
```

Example:
```js
// user.js User vuex module...
export default {
    state: {
        // All Users
        all: [],

        // current selected user
        active: null
    }
}
```

```php
<?php

namespace App\VuexLoaders;

use App\User;
use Phased\State\Support\VuexLoader;

class UsersModuleLoader extends VuexLoader
{
    public function all()
    {
        return User::all();
    }

    public function active($id)
    {
        return User::find($id);
    }

    public function authenticated()
    {
        return Auth::user();
    }
}
```

```php
// Usage from e.g. a controller
Vuex::load('users', [
    'all',
    'active' => 1
]);
```

If the following, for example, was placed int eh AppServiceProvider, it would attach the authenticated user along with every request. now since AppServiceProvider runs before the Auth middleware, if its run in immediate mode, then `Auth::user()` would always return null, however by using `lazy` it won't be run until the end of the request life-cycle, and `Auth::user()` will be available again.
```php
// Lazy evaluation
Vuex::lazyLoad('users', 'authenticated');
```

### [#](#helpers)Helpers
```php
Vuex::toArray(); // returns currently staged data as array
Vuex::toJson(); // returns currently staged data as json string
Vuex::dd(); // dd the current data
```
