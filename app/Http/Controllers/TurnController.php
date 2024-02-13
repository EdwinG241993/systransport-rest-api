<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Turn;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class TurnController extends Controller
{
    protected $user;
    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if ($token != '')
            //get the user and store it in a variable
            $this->user = JWTAuth::parseToken()->authenticate();
    }

    //Display a listing of the turn
    public function index()
    {
        //List all turn
        return Turn::get();
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        //Validate data
        $data = $request->only(
            'conductor_id',
            'fecha',
            'hora_inicio',
            'hora_fin'
        );
        $validator = Validator::make($data, [
            'conductor_id' => 'required|integer|unique:turnos',
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i:s',
            'hora_fin' => 'required|date_format:H:i:s'
        ]);

        //If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Create the turn in the DB
        $turn = Turn::create([
            'conductor_id' => $request->conductor_id,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin
        ]);

        //Response if all is well
        return response()->json([
            'mensaje' => 'El turno se creo con exito',
            'datos' => $turn
        ], Response::HTTP_OK);
    }

    //Display the specified resource
    public function show($id)
    {
        //Search for turn
        $turn = Turn::find($id);
        //If turn does not exist we return error not found
        if (!$turn) {
            return response()->json([
                'mensaje' => 'El turno no existe.'
            ], 404);
        }
        //Return the ticket if it exists
        return $turn;
    }

    //Update the specified resource in storage
    public function update(Request $request, $id)
    {
        //Validate data
        $data = $request->only(
            'fecha',
            'hora_inicio',
            'hora_fin'
        );
        $validator = Validator::make($data, [
            'fecha' => 'date',
            'hora_inicio' => 'date_format:H:i:s',
            'hora_fin' => 'date_format:H:i:s'
        ]);

        //If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Search for turn
        $turn = Turn::findOrfail($id);

        //Updating the turn
        $turn->update([
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin
        ]);

        //Response if all is well
        return response()->json([
            'mensaje' => 'Turno actualizado con exito',
            'datos' => $turn
        ], Response::HTTP_OK);
    }

    //Remove the specified resource from storage
    public function destroy($id)
    {
        //Search for turn
        $turn = Turn::findOrfail($id);

        //Delete turn
        $turn->delete();

        //Response if all is well
        return response()->json([
            'mensaje' => 'Turno eliminado con exito'
        ], Response::HTTP_OK);
    }
}
