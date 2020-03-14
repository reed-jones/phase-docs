# Routing

### [#](#pages) Pages
Routing of your application starts in your `routes/web.php`. It's from here that your Vue Router configuration is generated. To mark a route as a Phase route, the `Route::phase` method is used.
```php
Route::phase('/', 'HomeController@HomePage');
```
Diving deeper into into this example, there are several things at play. As could be expected, this route will respond to all `GET` requests to `/`.  It will route all those requests to your `HomeController`, specifically the `HomePage` method. Now as long as that method returns Phases view function `Phase::view();`, Laravel is all setup for SPA routing.
```php
use Phased\Routing\Facades\Phase;

// HomeController.php
public function HomePage()
{
    return Phase::view();
}
```
Phase follows some conventions in order to get all the routing to stay predictable. All pages will be put in a `pages` directory, and named as `location/method` so continuing our above example, a file would be generated at `pages/HomeController/HomePage.vue` and would be seen by navigating to `/`

> If `npm run watch` or `npm run hot` is running while adding routes to `web.php`, your .vue files will be generated if they don't already exist. but don't worry! If they do exists, they will not be modified, and if you remove a route, the file will not be deleted.

### [#](#api-routes)API Routes
...

### [#](#middleware)Middleware
Any middleware applied to the route server side, will be used and a front end middleware will be added to your route config. You may find this useful for specific behavior on certain routes in conjunction with vue routers [Global Before Guards](https://router.vuejs.org/guide/advanced/navigation-guards.html#global-before-guards)
