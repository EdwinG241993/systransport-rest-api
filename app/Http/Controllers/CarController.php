<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class CarController extends Controller
{
    protected $user;
    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if ($token != '')
            //get the user and store it in a variable
            $this->user = JWTAuth::parseToken()->authenticate();
    }

    //Display a listing of the car
    public function index()
    {
        //List all car
        return Car::get();
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        //Validate data
        $data = $request->only(
            'numero_interno',
            'placa',
            'capacidad',
            'marca',
            'modelo',
            'estado',
            'empresa_afiliada_id',
            'conductor_id'
        );
        $validator = Validator::make($data, [
            'numero_interno' => 'required|string|max:20|unique:vehiculos',
            'placa' => 'required|string|max:20',
            'capacidad' => 'required|integer',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'estado' => 'required|numeric',
            'empresa_afiliada_id' => 'required|integer',
            'conductor_id' => 'required|integer'
        ]);

        //If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Create the car in the DB
        $car = Car::create([
            'numero_interno' => $request->numero_interno,
            'placa' => $request->placa,
            'capacidad' => $request->capacidad,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'estado' => $request->estado,
            'empresa_afiliada_id' => $request->empresa_afiliada_id,
            'conductor_id' => $request->conductor_id
        ]);

        //Response if all is well
        return response()->json([
            'mensaje' => 'El vehiculo se creo con exito',
            'datos' => $car
        ], Response::HTTP_OK);
    }

    //Display the specified resource
    public function show($id)
    {
        //Search for car
        $car = Car::find($id);
        //If car does not exist we return error not found
        if (!$car) {
            return response()->json([
                'mensaje' => 'El vehiculo no existe.'
            ], 404);
        }
        //Return the car if it exists
        return $car;
    }

    //Update the specified resource in storage
    public function update(Request $request, $id)
    {
        //Validate data
        $data = $request->only(
            'numero_interno',
            'placa',
            'capacidad',
            'marca',
            'modelo',
            'estado',
            'empresa_afiliada_id',
            'conductor_id'
        );
        $validator = Validator::make($data, [
            'numero_interno' => 'string|max:20|unique:vehiculos',
            'placa' => 'string|max:20',
            'capacidad' => 'integer',
            'marca' => 'string|max:50',
            'modelo' => 'string|max:50',
            'estado' => 'numeric',
            'empresa_afiliada_id' => 'integer',
            'conductor_id' => 'integer'
        ]);

        //If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Search for car
        $car = Car::findOrfail($id);

        //Updating the car
        $car->update([
            'numero_interno' => $request->numero_interno,
            'placa' => $request->placa,
            'capacidad' => $request->capacidad,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'estado' => $request->estado,
            'empresa_afiliada_id' => $request->empresa_afiliada_id,
            'conductor_id' => $request->conductor_id
        ]);

        //Response if all is well
        return response()->json([
            'mensaje' => 'Vehiculo actualizado con exito',
            'datos' => $car
        ], Response::HTTP_OK);
    }

    //Remove the specified resource from storage
    public function destroy($id)
    {
        //Search for car
        $car = Car::findOrfail($id);

        //Delete car
        $car->delete();

        //Response if all is well
        return response()->json([
            'mensaje' => 'Vehiculo eliminado con exito'
        ], Response::HTTP_OK);
    }
}
