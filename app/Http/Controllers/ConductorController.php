<?php

namespace App\Http\Controllers;

use App\Models\Conductor;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use PSpell\Config;
use Symfony\Component\HttpFoundation\Response;

class ConductorController extends Controller
{
    protected $user;
    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if ($token != '')
            //get the user and store it in a variable
            $this->user = JWTAuth::parseToken()->authenticate();
    }

    //Display a listing of the conductor
    public function index()
    {
        //List all conductors
        return Conductor::get();
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
            'numero_licencia',
            'fecha_vencimiento_licencia',
            'salario',
            'empresa_afiliada_id',
            'user_id'
        );
        $validator = Validator::make($data, [
            'numero_identificacion' => 'required|string|max:10|unique:conductores',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'numero_licencia' => 'required|string|max:20',
            'fecha_vencimiento_licencia' => 'required|date',
            'salario' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'empresa_afiliada_id' => 'required|integer',
            'user_id' => 'required|integer'
        ]);

        //If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Create the conductor in the DB
        $conductor = Conductor::create([
            'numero_identificacion' => $request->numero_identificacion,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'numero_licencia' => $request->numero_licencia,
            'fecha_vencimiento_licencia' => $request->fecha_vencimiento_licencia,
            'salario' => $request->salario,
            'empresa_afiliada_id' => $request->empresa_afiliada_id,
            'user_id' => $request->user_id
        ]);

        //Response if all is well
        return response()->json([
            'mensaje' => 'El conductor se creo con exito',
            'datos' => $conductor
        ], Response::HTTP_OK);
    }

    //Display the specified resource
    public function show($id)
    {
        //Search for employee
        $conductor = Conductor::find($id);
        //If conductor does not exist we return error not found
        if (!$conductor) {
            return response()->json([
                'mensaje' => 'El conductor no existe.'
            ], 404);
        }
        //Return the conductor if it exists
        return $conductor;
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
            'numero_licencia',
            'fecha_vencimiento_licencia',
            'salario',
            'empresa_afiliada_id',
            'user_id'
        );
        $validator = Validator::make($data, [
            'numero_identificacion' => 'string|max:10|unique:conductores',
            'nombre' => 'string|max:100',
            'apellido' => 'string|max:100',
            'direccion' => 'string|max:255',
            'telefono' => 'string|max:20',
            'numero_licencia' => 'string|max:20',
            'fecha_vencimiento_licencia' => 'date',
            'salario' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'empresa_afiliada_id' => 'integer',
            'user_id' => 'integer'
        ]);

        //If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Search for conductor
        $conductor = Conductor::findOrfail($id);

        //Updating the conductor
        $conductor->update([
            'numero_identificacion' => $request->numero_identificacion,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'numero_licencia' => $request->numero_licencia,
            'fecha_vencimiento_licencia' => $request->fecha_vencimiento_licencia,
            'salario' => $request->salario,
            'empresa_afiliada_id' => $request->empresa_afiliada_id,
            'user_id' => $request->user_id
        ]);

        //Response if all is well
        return response()->json([
            'mensaje' => 'Conductor actualizado con exito',
            'datos' => $conductor
        ], Response::HTTP_OK);
    }

    //Remove the specified resource from storage
    public function destroy($id)
    {
        //Search for conductor
        $conductor = Conductor::findOrfail($id);

        //Delete employee
        $conductor->delete();

        //Response if all is well
        return response()->json([
            'mensaje' => 'Conductor eliminado con exito'
        ], Response::HTTP_OK);
    }
}
