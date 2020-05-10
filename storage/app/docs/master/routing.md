# Routing

### [#](#pages) Pages
As with most Laravel apps, the routing of your application starts in your `routes/web.php`. It's from here that your Vue Router configuration is generated. To mark a route as a Phase route, the `Route::phase` method is used.
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
Phase follows some conventions in order to get all the routing to stay predictable. All Vue page components will be put in the `resources/js/pages` directory, and named as after the `controller/method` so continuing our above example, our home page would be found in `resources/js/pages/HomeController/HomePage.vue` and would be seen by navigating to `/`. If the route is added to `routes/web.php`, but the appropriate page component has not yet been created, Phase will generate a basic template page component for you at the correct location.

> If `npm run watch` or `npm run hot` is running while adding routes to `web.php`, your .vue files will be generated if they don't already exist. but don't worry! If they do exists, they will not be modified, and if you remove a route, the file will not be deleted.

Dynamic routes can be used as usual, simply pass create the Phase route as if it where any other GET request, and the parameters will be passed into the controller as usual

```php
Route::phase('/posts/{post}', 'BlogController@SinglePostPage');
```

### [#](#api-routes)API Routes
Api routes, are just regular laravel routes with the slight difference in the return value. For integration with the state management portion of Phase, api routes should `return response()->vuex()`. For more information on this, refer the the state management section.
