<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Consultar toda la infomracion de 5 registros
        $datos['empleados']=Empleado::paginate(5);
        //vista principal
        return view('empleado.index',$datos );

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //acceder a la vista
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //obtener toda la informacion enviada/recolectar
        //$datosEmpleado = request()->all();
        //Reolecta infor excepto el token
        $datosEmpleado = request()->except('_token');
        //agarra el modelo e inserta toda la informacion
        Empleado::insert($datosEmpleado);
        //si el form captura algo  modificarlo y agregarlo
        if($request->hasFile('Foto')){
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads', 'public');
        }
        //responder y mostrar en formato json la informacion enviada del form
        //return response()->json($datosEmpleado);
        return redirect('empleado')->with('mensaje','Empleado agregado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $empleado=Empleado::findOrFail($id);

        return view('empleado.edit', compact('empleado') );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $datosEmpleado = request()->except(['_token','_method']);

        if($request->hasFile('Foto')){
            $empleado=Empleado::findOrFail($id);

            Storage::delete('public/'.$empleado->Foto);

            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads', 'public');
        }
        //respond


        Empleado::where('id','=',$id)->update($datosEmpleado);

        $empleado=Empleado::findOrFail($id);
        return view('empleado.edit', compact('empleado') );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        
        $empleado=Empleado::findOrFail($id);
        if(Storage::delete('public/'.$empleado->Foto)){

            Empleado::destroy($id);
        }

        return redirect('empleado')->with('mensaje','Empleado Borrado');



    }
}
