# Laravel Test CRUD
Create and Consume Endpoints

## Run The Project
You can download this as a zip file, then extract.

Run `cmd` and set the directory to the project.

Run `composer install`. 

change `.env.example` to `.env` and make necessary changes to your database

`php artisan serve`

## Setup
For Windows 10, download XAMPP, then download `composer`.

## Step 1

create a folder at `C:\xampp\htdocs\`, my folder name is `laravel-crud`

change directory 

`cd C:\xampp\htdocs\laravel-crud`

create the project 

`composer create-project laravel/laravel laravel-crud`

## Step 2
I'm using the database named `laravel_test`,
later this will be used to create one table, 

```
APP_NAME=first_laravel
APP_ENV=local
APP_KEY=base64:Vo0OoJYrIF8H5W+8TCZ8LfLYJkh3UBNP3cKP7H3fngc=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_test
DB_USERNAME=root
DB_PASSWORD=
```

then

`php artisan make:model Crud -m`

then `Crud.php`

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crud extends Model
{
    protected $table = 'cruds';

    protected $fillable = ['username', 'password'];
}
```

then `create_cruds_table.php`

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->name();
            $table->password();
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
        Schema::dropIfExists('users');
    }
};
```
then

`php artisan migrate`

## Step 3

`php artisan make:controller ApiController`

then

```
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Crud;
use App\Models\User;

use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function getAllCRUDS()
    {
        $cruds = Crud::get()->toJson(JSON_PRETTY_PRINT);
        return response($cruds, 200);
        //endpoint GET http://127.0.0.1:8000/api/cruds';
        
    }

    public function createCRUD(Request $request)
    {

        $cruds = new Crud;
        $cruds->username = $request->username;
        $cruds->password = $request->password;
        $cruds->save();

        return response()
            ->json(["message" => "user created"], 201);

        //endpoint POST http://127.0.0.1:8000/api/cruds/create
        
    }

    public function getCRUD($id)
    {
        if (Crud::where('id', $id)->exists())
        {
            $cruds = Crud::where('id', $id)->get()
                ->toJson(JSON_PRETTY_PRINT);
            return response($cruds, 200);
            //endpoint GET http://127.0.0.1:8000/api/cruds/[id]';
            
        }
        else
        {
            return response()->json(["message" => "record not found"], 404);
        }
    }

    public function updateCRUD(Request $request, $id)
    {
        if (Crud::where('id', $id)->exists())
        {
            $cruds = Crud::find($id);
            $cruds->username = is_null($request->username) ? $cruds->username : $request->username;
            $cruds->password = is_null($request->password) ? $cruds->password : $request->password;
            $cruds->save();

            return response()
                ->json(["message" => "records updated successfully"], 200);
        }
        else
        {
            return response()
                ->json(["message" => "record not found"], 404);

        }
        //endpoint PUT http://127.0.0.1:8000/api/cruds/[id]
        
    }

    public function deleteCRUD($id)
    {
        if (Crud::where('id', $id)->exists())
        {
            $cruds = Crud::find($id);
            $cruds->delete();

            return response()
                ->json(["message" => "records deleted"], 202);
        }
        else
        {
            return response()
                ->json(["message" => "record not found"], 404);
        }
        //endpoint DELETE http://127.0.0.1:8000/api/cruds/id
        
    }

    public function authenticate(Request $request)
    {

        $userExists = DB::table('cruds')->where('username', '=', $request->input('username'))
            ->exists();

        $password = DB::table('cruds')->where('password', '=', $request->input('password'))
            ->exists();

        //echo $request->input('username');
        //if($request->input('username') == "admin") {
        //echo "admin";
        

        //}
        if ($request->input('username') == "admin" && $request->input('password') == "@admin")
        {

            return response()
                ->json(["message" => "success"], 200);

        }
        else
        {

            if ($userExists)
            {

                if ($password)
                {
                    //echo "Success";
                    return response()->json(["message" => "success"], 201);
                }
                else
                {
                    return response()
                        ->json(["message" => "not found"], 404);
                    //echo "wrong username or password";
                    
                }
            }
            else
            {
                //echo "wrong username or password";
                return response()
                    ->json(["message" => "not found"], 404);
            }

        }
    }

}
```

## Step 4
routing :

```
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('cruds', 'App\Http\Controllers\ApiController@getAllCRUDS');
Route::get('cruds/{id}', 'App\Http\Controllers\ApiController@getCRUD');
Route::post('cruds/create', 'App\Http\Controllers\ApiController@createCRUD');
Route::put('cruds/{id}', 'App\Http\Controllers\ApiController@updateCRUD');
Route::delete('cruds/{id}','App\Http\Controllers\ApiController@deleteCRUD');
```

## Endpoints
`GET http://127.0.0.1:8000/api/cruds`

`GET http://127.0.0.1:8000/api/cruds/[id]`

`POST http://127.0.0.1:8000/api/cruds/create`

`PUT http://127.0.0.1:8000/api/cruds/[id]`

`DELETE http://127.0.0.1:8000/api/cruds/id`

`POST http://127.0.0.1:8000/api/authenticate`
