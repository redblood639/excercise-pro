<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Crud;

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
        $cruds->crud1 = $request->crud1;
        $cruds->crud2 = $request->crud2;
        $cruds->save();

        return response()
            ->json(["message" => "crud record created"], 201);

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
            $cruds->crud1 = is_null($request->crud1) ? $cruds->crud1 : $request->crud1;
            $cruds->crud2 = is_null($request->crud2) ? $cruds->crud2 : $request->crud2;
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
}