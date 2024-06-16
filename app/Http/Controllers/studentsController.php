<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class studentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students=Students::all();
        if($students->isEmpty()){

            $data=[
                'message'=>'No se encontraron estudiantes.',
                'status'=>'200'
            ];

            return response()->json($data,200);
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //primero validamos, y exiguimos que los datos seleccionado son obligatorios
        $validator=Validator::make($request->all(),[
            'name'=>'required|max:50',
            'email'=>'required|email|unique ',
            'phone'=>'required|digits:8',
            'languaje'=>'required|in:English,Espanish'
        ]);

        //mensaje de error en caso tal envie el formulario vacio sin datos
        if($validator->fails()){
            $data=[
                'message'=>'Error en la validacion de los datos.',
                'errors'=>$validator->errors(),
                'status'=>400
            ];
            return response()->json($data,400);
        }


        //aqui recogemos los datos para poder enviarlos a la base de datos
        $student=Students::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'languaje'=> $request->languaje
        ]);

        //mensaje en caso tal este mal los datos
        if(!$student){
            $data=[
                'message'=>'Error mal registro',
                'status'=>'500'
            ];
            return response()->json($data,500);
        }

        //resolver el porque no se guarda en la DB
        //guardamos los datos 
        $data=[
            'students'=>$student,
            'status'=> 201
        ];
        return response()->json($data, 201);
    
;    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $student=Students::find($id);
        if(!$student){
            $data=[
                'message'=>'Estudiante no encontrado',
                'status'=>404
            ];
            return response()->json($data,404);
        }

        $data=[
            'students'=> $student,
            'status'=> 200
        ];
        return response()->json($data,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $student=Students::find($id);

        if(!$student){
            $data=[
                'message'=>'Estudiante no encontrado',
                'status'=>404
            ];
            return response()->json($data,404);
        }

        //primero validamos, y exiguimos que los datos seleccionado son obligatorios
        $validator=Validator::make($request->all(),[
            'name'=>'required|max:50',
            'email'=>'required|email|unique ',
            'phone'=>'required|digits:8',
            'languaje'=>'required|in:English,Espanish'
        ]);

        //mensaje de error en caso tal envie el formulario vacio sin datos
        if($validator->fails()){
            $data=[
                'message'=>'Error en la validacion de los datos.',
                'errors'=>$validator->errors(),
                'status'=>400
            ];
            return response()->json($data,400);
        }

        $student->name=$request->name;
        $student->email=$request->email;
        $student->phone=$request->phone;
        $student->languaje=$request->languaje;

        $student->save();

        $data=[
            'message'=>'Estudiante actualizado con exito',
            'status'=>200
        ];
        return response()->json($data,200);
    }


    
    public function update_patch(Request $request, $id){

        $student=Students::find($id);

        if(!$student){
            $data=[
                'message'=>'Estudiante no encontrado',
                'status'=>404
            ];
            return response()->json($data,404);
        }

        //primero validamos, y exiguimos que los datos seleccionado son obligatorios
        $validator=Validator::make($request->all(),[
            'name'=>'max:50',
            'email'=>'email|unique ',
            'phone'=>'digits:8',
            'languaje'=>'in:English,Espanish'
        ]);

        //mensaje de error en caso tal envie el formulario vacio sin datos
        if($validator->fails()){
            $data=[
                'message'=>'Error en la validacion de los datos.',
                'errors'=>$validator->errors(),
                'status'=>400
            ];
            return response()->json($data,400);
        }

        if($request->has('name')){
            $student->name=$request->name;
        }
        if($request->has('email')){
            $student->email=$request->email;
        }
        if($request->has('phone')){
            $student->phone=$request->phone;
        }
        if($request->has('languaje')){
            $student->languaje=$request->languaje;
        }

        $student->save();

        $data=[
            'message'=>'Estudiante actualizado con exito',
            'status'=>200
        ];
        return response()->json($data,200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Students::find($id);

        if(!$student){
            $data=[
                'message'=>'Estudiante no encontrado',
                'status'=>404
            ];
            return response()->json($data,404);
        }

        $student->delete();

        $data=[
            'message'=>'Estudiante eliminado',
            'status'=>200
        ];
        return response()->json($data,200);
    }
}
