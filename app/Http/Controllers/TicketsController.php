<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TicketsController extends Controller
{
    protected $user;
    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if ($token != '')
            //get the user and store it in a variable
            $this->user = JWTAuth::parseToken()->authenticate();
    }

    //Display a listing of the ticket
    public function index()
    {
        //List all ticket
        return Ticket::get();
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        //Validate data
        $data = $request->only(
            'cliente_id',
            'ruta_id',
            'vehiculo_id',
            'fecha',
            'hora_inicio',
            'hora_fin',
            'tarifa',
            'numero_asiento'
        );
        $validator = Validator::make($data, [
            'cliente_id' => 'required|integer|unique:tiquetes',
            'ruta_id' => 'required|integer|unique:tiquetes',
            'vehiculo_id' => 'required|integer|unique:tiquetes',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i:s',
            'hora_fin' => 'required|date_format:H:i:s',
            'tarifa' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'numero_asiento' => 'required|integer'
        ]);

        //If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Create the ticket in the DB
        $ticket = Ticket::create([
            'cliente_id' => $request->cliente_id,
            'ruta_id' => $request->ruta_id,
            'vehiculo_id' => $request->vehiculo_id,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'tarifa' => $request->tarifa,
            'numero_asiento' => $request->numero_asiento
        ]);

        //Response if all is well
        return response()->json([
            'mensaje' => 'El ticket se creo con exito',
            'datos' => $ticket
        ], Response::HTTP_OK);
    }

    //Display the specified resource
    public function show($id)
    {
        //Search for car
        $ticket = Ticket::find($id);
        //If ticket does not exist we return error not found
        if (!$ticket) {
            return response()->json([
                'mensaje' => 'El ticket no existe.'
            ], 404);
        }
        //Return the ticket if it exists
        return $ticket;
    }

    //Update the specified resource in storage
    public function update(Request $request, $id)
    {
        //Validate data
        $data = $request->only(
            'fecha',
            'hora_inicio',
            'hora_fin',
            'tarifa',
            'numero_asiento'
        );
        $validator = Validator::make($data, [
            'fecha' => 'date',
            'hora_inicio' => 'date_format:H:i:s',
            'hora_fin' => 'date_format:H:i:s',
            'tarifa' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'numero_asiento' => 'integer'
        ]);

        //If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Search for car
        $ticket = Ticket::findOrfail($id);

        //Updating the car
        $ticket->update([
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'tarifa' => $request->tarifa,
            'numero_asiento' => $request->numero_asiento
        ]);

        //Response if all is well
        return response()->json([
            'mensaje' => 'Ticket actualizado con exito',
            'datos' => $ticket
        ], Response::HTTP_OK);
    }

    //Remove the specified resource from storage
    public function destroy($id)
    {
        //Search for ticket
        $ticket = Ticket::findOrfail($id);

        //Delete ticket
        $ticket->delete();

        //Response if all is well
        return response()->json([
            'mensaje' => 'Ticket eliminado con exito'
        ], Response::HTTP_OK);
    }
}
