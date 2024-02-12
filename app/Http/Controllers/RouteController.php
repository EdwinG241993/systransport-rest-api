<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class RouteController extends Controller
{
    protected $user;
    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if ($token != '')
            //get the user and store it in a variable
            $this->user = JWTAuth::parseToken()->authenticate();
    }

    //Display a listing of the routes
    public function index()
    {
        //List all routes
        return Route::get();
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        //Validate data
        $data = $request->only(
            'codigo',
            'origen',
            'destino',
            'distancia',
            'frecuencia'
        );
        $validator = Validator::make($data, [
            'codigo' => 'required|string|unique:rutas',
            'origen' => 'required|string|max:255',
            'destino' => 'required|string|max:255',
            'distancia' => 'required|integer',
            'frecuencia' => 'required|date_format:H:i:s'
        ]);

        //If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Create the route in the DB
        $route = Route::create([
            'codigo' => $request->codigo,
            'origen' => $request->origen,
            'destino' => $request->destino,
            'distancia' => $request->distancia,
            'frecuencia' => $request->frecuencia
        ]);

        //Response if all is well
        return response()->json([
            'mensaje' => 'La ruta se creo con exito',
            'datos' => $route
        ], Response::HTTP_OK);
    }

    //Display the specified resource
    public function show($id)
    {
        //Search for car
        $route = Route::find($id);
        //If route does not exist we return error not found
        if (!$route) {
            return response()->json([
                'mensaje' => 'La ruta no existe.'
            ], 404);
        }
        //Return the route if it exists
        return $route;
    }

    //Update the specified resource in storage
    public function update(Request $request, $id)
    {
        //Validate data
        //Validate data
        $data = $request->only(
            'origen',
            'destino',
            'distancia',
            'frecuencia'
        );
        $validator = Validator::make($data, [
            'origen' => 'string|max:255',
            'destino' => 'string|max:255',
            'distancia' => 'integer',
            'frecuencia' => 'date_format:H:i:s'
        ]);

        //If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Search for route
        $route = Route::findOrfail($id);

        //Updating the car
        $route->update([
            'origen' => $request->origen,
            'destino' => $request->destino,
            'distancia' => $request->distancia,
            'frecuencia' => $request->frecuencia
        ]);

        //Response if all is well
        return response()->json([
            'mensaje' => 'Ruta actualizada con exito',
            'datos' => $route
        ], Response::HTTP_OK);
    }

    //Remove the specified resource from storage
    public function destroy($id)
    {
        //Search for route
        $route = Route::findOrfail($id);

        //Delete route
        $route->delete();

        //Response if all is well
        return response()->json([
            'mensaje' => 'Ruta eliminada con exito'
        ], Response::HTTP_OK);
    }
}
