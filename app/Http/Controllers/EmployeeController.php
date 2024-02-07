<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    protected $user;
    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if ($token != '')
            //get the user and store it in a variable
            $this->user = JWTAuth::parseToken()->authenticate();
    }

    //Display a listing of the employee
    public function index()
    {
        //List all employees
        return Employee::get();
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
            'cargo',
            'fecha_ingreso',
            'salario',
            'user_id',
            'empresa_afiliada_id'
        );
        $validator = Validator::make($data, [
            'numero_identificacion' => 'required|string|max:10|unique:funcionario',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:255',
            'cargo' => 'required|string|max:100',
            'fecha_ingreso' => 'required|date',
            'salario' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'user_id' => 'required|integer',
            'empresa_afiliada_id' => 'required|integer'
        ]);

        //If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Create the affiliated employee in the DB
        $employee = Employee::create([
            'numero_identificacion' => $request->numero_identificacion,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'cargo' => $request->cargo,
            'fecha_ingreso' => $request->fecha_ingreso,
            'salario' => $request->salario,
            'user_id' => $request->user_id,
            'empresa_afiliada_id' => $request->empresa_afiliada_id
        ]);

        //Response if all is well
        return response()->json([
            'mensaje' => 'El funcionario se creo con exito',
            'datos' => $employee
        ], Response::HTTP_OK);
    }

    //Display the specified resource
    public function show($id)
    {
        //Search for employee
        $employee = Employee::find($id);
        //If employee does not exist we return error not found
        if (!$employee) {
            return response()->json([
                'mensaje' => 'El funcionario no existe.'
            ], 404);
        }
        //Return the employee if it exists
        return $employee;
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
            'cargo',
            'fecha_ingreso',
            'salario',
            'user_id',
            'empresa_afiliada_id'
        );
        $validator = Validator::make($data, [
            'numero_identificacion' => 'string|max:10|unique:funcionario',
            'nombre' => 'string|max:100',
            'apellido' => 'string|max:100',
            'direccion' => 'string|max:255',
            'telefono' => 'string|max:255',
            'cargo' => 'string|max:100',
            'fecha_ingreso' => 'date',
            'salario' => 'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'user_id' => 'integer',
            'empresa_afiliada_id' => 'integer'
        ]);

        //If validation fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Search for employee
        $employee = Employee::findOrfail($id);

        //Updating the employee
        $employee->update([
            'numero_identificacion' => $request->numero_identificacion,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'cargo' => $request->cargo,
            'fecha_ingreso' => $request->fecha_ingreso,
            'salario' => $request->salario,
            'user_id' => $request->user_id,
            'empresa_afiliada_id' => $request->empresa_afiliada_id
        ]);

        //Response if all is well
        return response()->json([
            'mensaje' => 'Funcionario actualizada con exito',
            'datos' => $employee
        ], Response::HTTP_OK);
    }

    //Remove the specified resource from storage
    public function destroy($id)
    {
        //Search for employee
        $employee = Employee::findOrfail($id);

        //Delete employee
        $employee->delete();

        //Response if all is well
        return response()->json([
            'mensaje' => 'Funcionario eliminado con exito'
        ], Response::HTTP_OK);
    }
}
