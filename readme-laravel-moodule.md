#have login 2 levels (laravel-2fa)
- https://github.com/mateusjunges/laravel-2fa
----
- add plugin laravel-2fa
```shell
composer require mateusjunges/laravel-2fa
```
- add fields  two_factor_code  and two_factor_expires_at  to my table
- Replace AuthenticatesUsers trait on LoginController

##https://github.com/thecodework/two-factor-authentication
- https://www.youtube.com/watch?v=U6Nrl4vBSQ0

##https://mailtrap.io/blog/laravel-email-verification/
----

#validation with request && rule
----
- use data-validation = "" in form for input
- define OrderFormRequest.php
```php
namespace App\Http\Requests;

use App\Rules\AmtlicheBeglaubigungChronologischerAuszugRule;
use App\Rules\AmtlicheBeglaubigungGesellschaftsvertragRule;
use App\Rules\AmtlicheBeglaubigungHistorischerAuszugRule;
use App\Rules\AmtlicheBeglaubigungListeDerGesellschafterRule;
use App\Rules\AmtlicheBeglaubigungRule;
use App\Rules\ApostilleRule;
use App\Rules\EndbeglaubigungRule;
use App\Rules\NotariellRule;
use App\Rules\OrderCountryRule;
use App\Rules\UserCompanyRule;
use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class OrderFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_company' =>['',new UserCompanyRule],
            'company.*' => 'required|regex:/[^google]/',
            'documents' => [
                'required',
                new AmtlicheBeglaubigungRule,
                new ApostilleRule,
                new EndbeglaubigungRule,
                new AmtlicheBeglaubigungChronologischerAuszugRule,
                new AmtlicheBeglaubigungGesellschaftsvertragRule,
                new AmtlicheBeglaubigungHistorischerAuszugRule,
                new AmtlicheBeglaubigungListeDerGesellschafterRule
            ],
            'name' => 'required',
            'street_house_number' => 'required',
            'postal_code' => 'required',
            'city' => 'required',
            'user_country' => 'required|string',
            'order_country' => ['required', new OrderCountryRule],
            'tel' => 'required|numeric',
            'email' => 'required|email|confirmed',
            'email_confirmation' => 'required|email',
            'payment-method' => 'required',
            'agb' => 'required|in:1'
//           'g-recaptcha-response' => ['required', new Recaptcha()]
        ];
    }

    public function messages()
    {
        return [
            'company.errorCompanyGoogle' => 'Bitte ändern Sie den Firmennamen',
            'company.required' => 'Firma / Gesellschaft muss ausgefüllt sein',
            'documents.required' => 'Mindestens Aktueller Handelsregisterauszug muss gewählt werden',
            'name.required' => 'Vorname, Name muss ausgefüllt sein',
            'street_house_number.required' => 'Straße und Hausnr Name muss ausgefüllt sein',
            'postal_code.required' => 'PLZ muss ausgefüllt sein',
            'city.required' => 'Ort muss ausgefüllt sein',
            'user_country.required' => 'Land muss ausgefüllt sein',
            'tel.required' => 'Telefon muss ausgefüllt sein',
            'email.required' => 'E-Mail-Adresse muss ausgefüllt sein',
            'confirm_email.required' => 'E-Mail-Wiederholung muss ausgefüllt sein',
            'confirm_email.same' => 'E-Mail-Adresse und E-Mail-Wiederholung müssen identisch sein',
            'payment-method.required' => 'Zahlungsmethode muss ausgefüllt sein',
            'email.email' => "Bitte schreiben Sie das korrekte E-Mail-Adresse",
            "confirm_email.email" => "Bitte schreiben Sie das korrekte E-Mail-Wiederholung",
            "agb.in" => "Sie müssen die Bedingungen akzeptieren",
        ];
    }
}

```
- define UserCompanyRule.php
```php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UserCompanyRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->request = request()->all();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        if ($value == null){
            return true;
        }

        if ($value != null  && $value == 'google') {
            return false;
        }


        return true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Bitte ändern Sie den Firmennamen';
    }
}
```
----
#limited site on special IP
- https://stackoverflow.com/questions/36398081/only-allow-certain-ip-addresses-to-register-a-user-in-laravel-5-2
```shell
php artisan make:middleware IpMiddleware
```

```php
namespace App\Http\Middleware;

use Closure;

class IpMiddleware
{

    public function handle($request, Closure $next)
    {
        if ($request->ip() != "192.168.0.155") {
        // here instead of checking a single ip address we can do collection of ips
        //address in constant file and check with in_array function
            return redirect('home');
        }

        return $next($request);
    }

}
```
-------


#limited site on IP of special country
- https://github.com/stevebauman/location
- https://www.itsolutionstuff.com/post/how-to-get-location-information-from-ip-address-in-laravel-example.html#:~:text=We%20can%20get%20information%20from,%2C%20metro%20Code%2C%20metro%20Code.

----

#create google authentication in laravel
- create image code look like barcode
- https://www.roxo.ir/add-googles-two-factor-authentication-to-laravel
----

#link documents
- https://quickadminpanel.com/

-----
#unit Test
- TDD : Test Driven Development
- 
```shell
vendor/bin/phpunit tests/Unit/Projectors/MatchProjectorTest.php
#other way
phpunit tests/Unit/Projectors/MatchProjectorTest.php
```
-----
------
#how use 2 databases

- Add these lines to .env

  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3307
  DB_DATABASE=test
  DB_USERNAME=root
  DB_PASSWORD=

  DB_CONNECTION=mysql_second
  DB_HOST_SECOND= 127.0.0.1
  DB_PORT_SECOND=3306
  DB_DATABASE_SECOND=e-handle
  DB_USERNAME_SECOND=root
  DB_PASSWORD_SECOND=123456

- Add to database.php
```php
  'mysql_second' => [
  'driver' => 'mysql',
  'url' => env('DATABASE_URL'),
  'host' => env('DB_HOST_SECOND', '127.0.0.1'),
  'port' => env('DB_PORT_SECOND', '3307'),
  'database' => env('DB_DATABASE_SECOND', 'forge'),
  'username' => env('DB_USERNAME_SECOND', 'forge'),
  'password' => env('DB_PASSWORD_SECOND', ''),
  'unix_socket' => env('DB_SOCKET_SECOND', ''),
  'charset' => 'utf8mb4',
  'collation' => 'utf8mb4_unicode_ci',
  'prefix' => '',
  'prefix_indexes' => true,
  'strict' => true,
  'engine' => null,
  'options' => extension_loaded('pdo_mysql') ? array_filter([
  PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
  ]) : [],
  ],
```
- how call database for query
```php
$userhandle = DB::connection('mysql_second')->table('users')->get()->where('id','<',7);
#create table
Schema::connection('mysql_second')->create('table_name', function($table){
   // entire code here
});
#model
class Gender extends Model
{
    protected $connection = 'mysql2'; // This line will get records from mysql2 database data whenever we use this model
    protected $fillable = [
        ...
    ];
}
#migration
class CreateGendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('genders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('genders');
    }
}
```
-----

#if Dockerized your project
- add below lines to docker-compose.yml 
```shell
 #MySQL Service
  db:
    image: mysql:5.7.29
    container_name: db
    restart: unless-stopped
    tty: true
    ports:
      - "3306:3306"
    environment:
      MYSQL_DATABASE: aas
      MYSQL_USER: aas_admin
      MYSQL_PASSWORD: secret
      MYSQL_ROOT_PASSWORD: secret
      SERVICE_TAGS: dev
      SERVICE_NAME: mysql
    volumes:
      - dbdata:/var/lib/mysql/
      - ./mysql/my.cnf:/etc/mysql/my.cnf
    networks:
      - app-network

  access_db:
    image: mysql:5.7.29
    container_name: access_db
    restart: unless-stopped
    tty: true
    ports:
      - "3307:3306"
    environment:
      MYSQL_DATABASE: access_aas
      MYSQL_USER: aas_admin
      MYSQL_PASSWORD: secret
      MYSQL_ROOT_PASSWORD: secret
      SERVICE_TAGS: dev
      SERVICE_NAME: mysql
    volumes:
      - accessdbdata:/var/lib/mysql/
      - ./mysql/my.cnf:/etc/mysql/accessmy.cnf
    networks:
      - app-network


```
- add this line to .env
  - ACCESS_DB_PORT=3307 => ACCESS_DB_PORT=3306

-----
#special command in laravel
```php
#get class object
$className = get_class($faq->products()->getRelated());
#find parent class
class ClassA {}
class ClassB extends ClassA {}

$a = new ClassB();
if ($a instanceof ClassA) {
    echo '$a is an instanceof ClassA<br />';
}
if ($a instanceof ClassB) {
    echo '$a is an instanceof ClassB<br />';
}

```
-----
#phpmyadmin with docker
- server : mysql
----

#repository
- It is design pattern
- It's an abstraction
- how write this:
  - write queries in repository where is it in "App\Models\Repositories" or write interface and inheritance from it.
```php
## interface
namespace App\Repositories;
 
interface PostRepositoryInterface{
	
	public function getAll();
 
	public function getPost($id);
 
	// more
}


## class
namespace App\Repositories;
 
use App\Post;
 
class PostRepository implements PostRepositoryInterface
{
	public function getAll(){
		return Post::all();
	}
 
	public function getPost($id){
		return Post::findOrFail($id);
	}
 
	// more 
 
}
# controller
namespace App\Http\Controllers;
 
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepositoryInterface;
 
class PostController extends Controller
{
	private $repository;
 
	public function __construct(PostRepositoryInterface $repository)
	{
	   $this->repository = $repository;
	}
 
	public function index(){
		$data = $this->repository->getAll();
		return view('posts.index')->with('data', $data);
	}
 
	public function show($id){
		$data = $this->repository->getPost($id);
		return view('posts.show')->with('data', $data);
	}
}

#AppService Provider
namespace App\Providers;
 
use Illuminate\Support\ServiceProvider;
 
class AppServiceProvider extends ServiceProvider
{
    
    public function register()
    {
        $this->app->bind(
            'App\Repositories\PostRepositoryInterface',
            'App\Repositories\PostRepository'
        );
    }
 
   
    public function boot()
    {
        //
    }
}
```
- In controller , you must build "PostsRepository $posts"
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PostsRepository;

class PostsController extends Controller
{
    public function index(PostsRepository $posts)
    {
        $userPosts = $posts->getByUserId(\Auth::id());
        // ...
    }
```
- you can write all operation CRUD (create,read,update,delete) in repository
-----
#marshaler
- You can use the DynamoDB Marshaler to convert this JSON document into the format required by DynamoDB.
- Marshalling SQS jobs in Laravel
  - https://culttt.com/2015/11/09/marshalling-sqs-jobs-in-laravel
  - https://www.npmjs.com/package/dynamodb-marshaler
- 
```php
$this->marshaler = new Marshaler();
$item = $this->marshaler->marshalJson($this->serializer->serialize($model, 'json'));
```
-----
#Service providers (https://laravel.com/docs/9.x/providers)
- have 2 methods:
  - register : only used for binding and case of service container
  - boot : after registering and loading executes. Then don't bind from other service providers
- define provider in bootstrap/app.php
- Service providers are the central place of all Laravel application bootstrapping. Your own application, as well as all of Laravel's core services, are bootstrapped via service providers.
- Most service providers contain a register and a boot method. 
- You should never attempt to register any event listeners, routes, or any other piece of functionality within the register method.
```php
class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        ServerProvider::class => DigitalOceanServerProvider::class,
    ];
}
```

-----
#projector
- Projectors are now a huge part of the events industry, and it's easy to see why! Projecting images, logos, graphics and information onto surfaces not only looks impressive, but also brightens event spaces and can complement your event theme.
----
#Utilities 
- Utilities (water, electricity and gas) are essential services that play a vital role in economic and social development. Quality utilities are a prerequisite for effective poverty eradication.
----
#login with google
- https://virgool.io/laravel-community/%D9%84%D8%A7%DA%AF%DB%8C%D9%86-%D8%A8%D8%A7-%DA%AF%D9%88%DA%AF%D9%84-%D8%AF%D8%B1-%D9%84%D8%A7%D8%B1%D8%A7%D9%88%D9%84-gizrm55hjjnl
-----
#Service Controller
- if I have some classes for payments, likes Paypall , Mellat, Zarinpall , ... ,for cleaning and comfortable changes in big project , we need to use  AppServiceProvider.php and bind (or singleton) for switching classes.
- for Dependency injection
- for registering in service container, we use from AppServiceProvider.php and bind (or singleton) for switching classes.
- singleton : build only one instance from class
- bind : with every call , it builds one new instance from class
- instance : use from previous instance
- resolve : for using from binding class , you use from resolve
-----
#Dependency injection (DI)
```php
class Car
{
    public function make()
    {
        $wheel = new Wheel;
        // ...
    }
}
```
- Dependency injection of car to wheel from out
```php
class Car
{
    private $wheel;

    public function __construct(Wheel $wheel)
    {
        $this->Wheel = $wheel;
    }

    public function make()
    {
        $this->wheel->create(4);
    }
}


$car = new Car(new EconomicWheel);
$car->make();
```
-----
#solid
1- Single Responsibility Principle : Any class has one responsibility
2- Open/Closed Principle : Entities for development are open and for changing are close
3- Liskov Substitution Principle : To substitute child instead of father, my program is still correct
4- Interface Segregation Principle : Separate irrelevant interfaces
5- Dependency Inversion Principle : High classes (such as reporting for register) must not depend on low classes (such as work with database) and both of them use from abstraction

-----
#Middleware
- It uses for filtering HTTP request
- It has one class as name as handle
----
#cast (https://ditty.ir/posts/laravel-eloquent-casts/JmB25)
- convert variable to favor format by laravel
    array
    boolean
    collection
    date
    datetime
    decimal:<digits>
    double
    encrypted
    encrypted:array
    encrypted:collection
    encrypted:object
    float
    integer
    object
    real
    string
    timestamp
- used way:
```php
namespace App\Models;
class User extends Model
{
    protected $casts = [
        'favorites' => 'array',
        'email_verified_at' => 'datetime',
    ];
}
#build favour cast (https://ditty.ir/posts/laravel-eloquent-casts/JmB25)
php artisan make:cast Serialize
namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Serialize implements CastsAttributes
{
    public function __construct($algorithm)
    {
        $this->algorithm = $algorithm;
    }
    public function get($model, $key, $value, $attributes)
    {
        return $value;
    }

    public function set($model, $key, $value, $attributes)
    {
        return $value;
    }
}
#used favour cast 
class User extends Model
{
    protected $casts = [
        // ...
        'details' => Serialize::class
        'password1' => Serialize::class . ':sha1'
    ];
}
```
-----
#Signed URL (https://ditty.ir/posts/laravel-signed-urls/5V04X)
- created safe URL
- for example : Route::get('unsubscribe/{user_id}', '...')->name('unsubscribe');
```php
use Illuminate\Support\Facades\URL;

$url = URL::signedRoute('unsubscribe', ['user_id' => 429]);
//http://example.com/unsubscribe/429?signature=897fa0b2832a1ebf57726ae80576f9b900dba98dbc7cc670a85d0d83a0297dcf
```
- validation signed address
```php
#add middleware route in Kennel.php
 protected $routeMiddleware = [
    // ...
    'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
];
#route
Route::get('unsubscribe/{user_id}', '...')->name('unsubscribe')->middleware('signed');
#temp Signed URL
$url = URL::signedRoute(
    'unsubscribe', ['user_id' => 429], now()->addMinutes(30)
);
#OR
$url = URL::temporarySignedRoute(
    'unsubscribe', now()->addMinutes(30), ['user' => 429]
);
```
-----
#View Composer (https://ditty.ir/posts/laravel-view-composer/nZqG5)
- first define provider
```shell
php artisan make:provider ViewServiceProvider
```
- second in boot function write
```php
namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
   public function boot()
    {
        View::composer('shared.header', function($view) {
            $categories = Category::all();

            $view->with([
                'categories' => $categories,
            ]);
        });
    }
}

# in header.blade.php
<ul>
  @foreach($categories as $category)
    <li>{{ $category->title }}</li>
  @endforeach
</ul>
# in master.blade.php

<!doctype html>
<html>
<body>
    <div id="app">
        @include('shared.header')
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>

```
----
#Query Scope (https://ditty.ir/posts/laravel-eloquent-scopes/nxLDn)
------
#Cache (https://ditty.ir/posts/laravel-cache-101/JA0VX)
```php
use Illuminate\Support\Facades\Cache;
Cache::get('posts'); // If it doesn't exit in cache, it returns null 
Cache::get('key', 'default'); //
Cache::get('posts', function() {
    return Post::where('status', 'published')->get();
});
//check exits in cache
if (Cache::has('key')) {
    //
}
//increment (decrement) amount of number are saved in cache
Cache::increment('post_visits');
Cache::increment('post_visits', 5);
Cache::decrement('coupons_used', 5);
//Read cache. if it doesn't exit in cache, it saves this amount
$users = Cache::remember('users', 300, function () {
    return User::all();
});
//Save forever
$users = Cache::rememberForever('users', function () {
    return User::all();
});
//Read and Clean
$books = Cache::pull('books');
// Save in Cache
Cache::put('key', 'value', $seconds);
Cache::forever('key', 'value');
Cache::put('key', 'value', now()->addMinutes(10));
//Save if it doesn't exit
Cache::add('key', 'value', $seconds);
//Delete item
Cache::forget('key');

Cache::put('key', 'value', 0);
Cache::put('key', 'value', -5);
//Delete all cache
Cache::flush();
//Cookie
$cookies = $request->cookie();
$request->cookie('name');
//get file
$image = $request->file('image');
// or
$image = $request->image;
if ($request->hasFile('image')) {
    //
}
if ($request->file('image')->isValid()) {
    //
}
//get info of header
$request->header();
$request->hasHeader('user-agent');
$request->hasHeader('user-agent');
$request->bearerToken();
$request->allFiles()
```
-----
#Check exist or doesn't exist
```php
if ($request->has(['duck', 'bear'])) {  }
if ($request->hasAny(['mobile', 'email'])) {  }
$request->missing('dive'); // doesn't exist
$request->filled('jump'); // check exits and fills
$request->anyFilled(['jump', 'run', 'eat']); // true
```
#check old data in form - html
```html
<input type="text" name="username" value="{{ old('username') }}">
```
```php
# Save old data
$request->flash();
#or
$request->flashOnly(['username', 'email']);
$request->flashExcept('password');
```
-----
#used when 
- Used for condition routes
```php
Post::select('id', 'title')
    ->when($request->filled('status'), function($query) {
        return $query->where('status', request()->status);
    })
    ->when($request->filled('limit'), function($query) {
        return $query->limit(request()->limit);
    })

    /* ... */

    ->get();
```
-----
#Collection
- It is the class that it get easier and more comfortable for using arrays
```php
//check repetitive arrays
$collection = collect(['james', 'lisa', 'ryan', 'james', 'brad', 'lisa']);
$collection->duplicates(); // [3 => 'james', 5 => 'lisa']
//method each
$collection->each(function ($item, $key) {
    print_r($item);
});
//debug
$collection->dump();  //or $collection->dd(); 
$collection->has('author'); 
$collection->implode('title', ', ');
//
$collection = collect([1, 2, 3]);
$collection->push(4);
$collection->all(); // [1, 2, 3, 4]

$collection->prepend(4);
$collection->all(); // [4, 1, 2, 3]
//get Item of array
$collection = collect([
    'title' => 'Harry Potter',
    'author' => 'J.K. Rowling',
    'price' => 25
]);
$collection->pull('author'); // 'J.K. Rowling'
//Shuffle Array
$shuffled = $collection->shuffle();
//Filter Array
$collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
$even_numbers = $collection->filter(function ($value, $key) {
    return $value % 2 == 0;
});
$even_numbers->all(); // [2, 4, 6, 8, 10]
//
$max = collect([1, 2, 3])->max();
$sliced = $collection->slice(2);
```
----
#How add soft delete (https://ditty.ir/posts/laravel-interview-questions-part-2/XO4jJ)
- first create trait SoftDelete
- second use it in Model //use SoftDeletes;
- add column deleted_at from type, timestamp //fill if we delete its row
- write $table->softDeletes(); in function up() 

--------
#Amazon Cognito
What Is Amazon Cognito?
The two main components of Amazon Cognito are user pools and identity pools. User pools are user directories that provide sign-up and sign-in options for your app users. Identity pools enable you to grant your users access to other AWS services. You can use identity pools and user pools separately or together.

**Identity pools support anonymous guest users**

Identity pools define two types of identities: authenticated and unauthenticated. Every identity in your identity pool is either authenticated or unauthenticated. Authenticated identities belong to users who are authenticated by a public login provider (Amazon Cognito user pools, Login with Amazon, Sign in with Apple, Facebook, Google, SAML, or any OpenID Connect Providers) or a developer provider (your own backend authentication process). Unauthenticated identities typically belong to guest users.

**To learn more about Cognito , take a look at the following resources:**
- https://docs.aws.amazon.com/cognito/latest/developerguide/what-is-amazon-cognito.html
- https://aws.amazon.com/premiumsupport/knowledge-center/cognito-user-pools-identity-pools/
-------------
#swagger (https://swagger.io/docs/open-source-tools/swagger-codegen/)
- used for creating and documentation of API
- which is used for design and documentation to testing and preparing the product for use by users (Deployment)
#Postman 
- It is an application used for API testing
- It is an HTTP client that tests HTTP requests, utilizing a graphical user interface, through which we obtain different types of responses that need to be subsequently validated
#What is swagger vs Postman?
- The swagger is generally helpful for the API's and the postman is helpful to quickly test the HTTP request.
- Design management of the swagger is better than the postman.
-----
#DynamoDB Marshaler
- It is a new class that the Marshaler object has methods for marshaling JSON documents and PHP arrays to the DynamoDB item format and unmarshaling them back.
-----
#new function in laravel 9
- str()->
- to_route('name) //redirect to name of route
-----
alt+j // select all of similar codes
-----
php artisan route:list
//2 click shift key for search function

---------------------
#postman

1- login
2- add workplaces
3- create new
4- http request must open
5- in browser in Network and Fetch/XHR : header can write information

---------------------
#add error page for laravel
```shell
php artisan vendor:publish --tag=laravel-errors
```
- define folder errors in views/errors/404.blade.php , ...
- add css , js
-------------
#How add fontawesome
```shell
npm install -D @fortawesome/fontawesome-free
or
npm i --save @fortawesome/fontawesome-free
```
- add fontawsome.css
- add fonts in public and in css
