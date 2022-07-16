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