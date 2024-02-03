<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\AffiliatedCompany;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AffiliatedCompanyController extends Controller
{
    protected $user;
    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if ($token != '')
            //get the user and store it in a variable
            $this->user = JWTAuth::parseToken()->authenticate();
    }

    //Display a listing of the resource.
    public function index()
    {
        //List all affiliated companies
        return AffiliatedCompany::get();
    }

    //Store a newly created resource in storage.
    public function store(Request $request)
    {
        //Validate data
        $data = $request->only(
            'codigo',
            'nombre',
            'nit',
            'direccion',
            'telefono',
            'fecha_afiliacion',
            'estado'
        );
        $validator = Validator::make($data, [
            'codigo' => 'required|string|max:70|unique:empresa_afiliada',
            'nombre' => 'required|string|max:100',
            'nit' => 'required|string|max:10',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'fecha_afiliacion' => 'required|date',
            'estado' => 'required|numeric'
        ]);

        //If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Create the affiliated company in the DB
        $affiliatedCompany = AffiliatedCompany::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'nit' => $request->nit,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'fecha_afiliacion' => $request->fecha_afiliacion,
            'estado' => $request->estado
        ]);

        //Response if all is well
        return response()->json([
            'mensaje' => 'La empresa afiliada se creo con exito',
            'datos' => $affiliatedCompany
        ], Response::HTTP_OK);
    }

    //Display the specified resource
    public function show($id)
    {
        //Search for affiliated company
        $affiliatedCompany = AffiliatedCompany::find($id);
        //If affiliated company does not exist we return error not found
        if (!$affiliatedCompany) {
            return response()->json([
                'mensaje' => 'La empresa afiliada no existe.'
            ], 404);
        }
        //Return the affiliated company if it exists
        return $affiliatedCompany;
    }

    //Update the specified resource in storage
    public function update(Request $request, $id)
    {
        //Validate data
        $data = $request->only(
            'codigo',
            'nombre',
            'nit',
            'direccion',
            'telefono',
            'fecha_afiliacion',
            'estado'
        );
        $validator = Validator::make($data, [
            'codigo' => 'string|max:70|unique:empresa_afiliada',
            'nombre' => 'string|max:100',
            'nit' => 'string|max:10',
            'direccion' => 'string|max:255',
            'telefono' => 'string|max:20',
            'fecha_afiliacion' => 'date',
            'estado' => 'numeric'
        ]);

        //If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Search for affiliated company
        $affiliatedCompany = AffiliatedCompany::findOrfail($id);

        //Updating the affiliated company
        $affiliatedCompany->update([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'nit' => $request->nit,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'fecha_afiliacion' => $request->fecha_afiliacion,
            'estado' => $request->estado
        ]);

        //Response if all is well
        return response()->json([
            'mensaje' => 'Empresa afiliada actualizada con exito',
            'datos' => $affiliatedCompany
        ], Response::HTTP_OK);
    }

    //Remove the specified resource from storage
    public function destroy($id)
    {
        //Search for affiliated company
        $affiliatedCompany = AffiliatedCompany::findOrfail($id);

        //Delete affiliated company
        $affiliatedCompany->delete();

        //Response if all is well
        return response()->json([
            'mensaje' => 'Empresa afiliada eliminada con exito'
        ], Response::HTTP_OK);
    }
}
