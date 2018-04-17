let $router = $app.make<RouterInterface>("$router");
import RouterInterface from "varie/lib/routing/RouterInterface";

/*
|--------------------------------------------------------------------------
| Your default routes for your application
|--------------------------------------------------------------------------
|
*/

$router.route("/", "dashboard/index").setName('dashboard');
$router.route('/my-profile', 'user/profile');

$router.route("*", "errors/404");
