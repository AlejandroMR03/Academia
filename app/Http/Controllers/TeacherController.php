<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeTeacherRequest;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tutor = Teacher::all();//Traemos toda la info de la tabla courses a traves del modelo y el método all()
        return view('teachers.index', compact('tutor'));//Se adjunta grade a la vista para poderlo usar, usando compact
        // return $grade;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeTeacherRequest $request)
    {
        //  se implementa Validacion
            // $dataValidate = $request->validate([
            //     'nombre' => 'required|max:10',
            //     'avatar' => 'required|image'
            // ]);
        //Se devuelve la petición hecha al servidor
        // return $request->all();
        $tutor = new Teacher();//Crear una instancia de la clase Curso
        $tutor->name = $request->input('name');
        $tutor->description = $request->input('description');
        $tutor->duration = $request->input('duration');
        if($request->hasFile('imagen')){
            $tutor->imagen = $request->file('imagen')->store('public/teachers');
        }
        $tutor->save();//Comando para registrar la info en la bd
        return 'El curso se ha guardado exitosamente';
        // return $grade->description;
        // return $grade;
        // return $request->input('name');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tutor = Teacher::find($id);
        return view('teachers.show', compact('tutor'));
        // return 'El id de este curso es: ' . $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tutor = Teacher::find($id);
        // return 'El id de este curso es: ' . $id;
        // return 'La iformación que ud quiere actualizar, se vería en formato array...' . $grade;
        return view('courses.edit', compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tutor = Teacher::find($id);
        // return $grade;
        $tutor->fill($request->except('imagen'));
        if($request->hasFile('imagen')){
            $tutor->imagen = $request->file('imagen')->store('public/courses');
        }
        $tutor->save();
        // return $request;
        return 'La información del curso se ha actualizado exitosamente';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tutor = Teacher::find($id);

        $urlImagenBD = $tutor->imagen;
        // return $urlImagenBD;
        // $rutaCompleta = public_path().$urlImagenBD;
        // return $rutaCompleta;
        $nombreImagen = str_replace('public/', '\storage\\', $urlImagenBD );
        $rutaCompleta = public_path().$nombreImagen;
        // return $rutaCompleta;
        unlink($rutaCompleta);
        $tutor ->delete();
        return 'registro
        eliminado correctamente';

    }
}
