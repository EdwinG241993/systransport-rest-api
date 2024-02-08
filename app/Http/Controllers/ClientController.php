<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    protected $user;
    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if ($token != '')
            //get the user and store it in a variable
            $this->user = JWTAuth::parseToken()->authenticate();
    }

    //Display a listing of the clients
    public function index()
    {
        //List all clients
        return Client::get();
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        //Validate data
        $data = $request->only(
            'numero_identificacion',
            'nombre',
            'apellido',
            'direccion',
            'telefono',
            'fecha_nacimiento',
            'user_id'
        );
        $validator = Validator::make($data, [
            'numero_identificacion' => 'required|string|max:10|unique:clientes',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'fecha_nacimiento' => 'required|date',
            'user_id' => 'required|integer'
        ]);

        //If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Create the client in the DB
        $client = Client::create([
            'numero_identificacion' => $request->numero_identificacion,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'user_id' => $request->user_id
        ]);

        //Response if all is well
        return response()->json([
            'mensaje' => 'El cliente se creo con exito',
            'datos' => $client
        ], Response::HTTP_OK);
    }

    //Display the specified resource
    public function show($id)
    {
        //Search for employee
        $client = Client::find($id);
        //If employee does not exist we return error not found
        if (!$client) {
            return response()->json([
                'mensaje' => 'El cliente no existe.'
            ], 404);
        }
        //Return the employee if it exists
        return $client;
    }

    //Update the specified resource in storage
    public function update(Request $request, $id)
    {
        //Validate data
        $data = $request->only(
            'numero_identificacion',
            'nombre',
            'apellido',
            'direccion',
            'telefono',
            'fecha_nacimiento',
            'user_id'
        );
        $validator = Validator::make($data, [
            'numero_identificacion' => 'string|max:10|unique:funcionario',
            'nombre' => 'string|max:100',
            'apellido' => 'string|max:100',
            'direccion' => 'string|max:255',
            'telefono' => 'string|max:20',
            'fecha_nacimiento' => 'date',
            'user_id' => 'integer'
        ]);

        //If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Search for client
        $client = Client::findOrfail($id);

        //Updating the client
        $client->update([
            'numero_identificacion' => $request->numero_identificacion,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'user_id' => $request->user_id
        ]);

        //Response if all is well
        return response()->json([
            'mensaje' => 'Cleinte actualizado con exito',
            'datos' => $client
        ], Response::HTTP_OK);
    }

    //Remove the specified resource from storage
    public function destroy($id)
    {
        //Search for client
        $client = Client::findOrfail($id);

        //Delete client
        $client->delete();

        //Response if all is well
        return response()->json([
            'mensaje' => 'Cliente eliminado con exito'
        ], Response::HTTP_OK);
    }
}
