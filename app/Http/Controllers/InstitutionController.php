<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\Career;
use Illuminate\Queue\RedisQueue;

class InstitutionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $institutions = Institution::all();
    return view('instituciones.index', compact('institutions'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('instituciones.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $institution = new Institution();
    $imagen = $request->logotipo;
    if (!is_null($imagen)) {
      $ruta_destino = public_path('img/institutions/');
      $nombre_de_archivo = time() . '.' . $imagen->getClientOriginalExtension();
      $imagen->move($ruta_destino, $nombre_de_archivo);
      $institution->logotipo = $nombre_de_archivo;
    }
    $institution->nombre = $request->nombre;
    $institution->director = $request->director;
    $institution->save();
    return redirect('institutions');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($institution)
  {
    $institution = Institution::find($institution);
    $careers = Career::all();
    return view('instituciones.show', compact('institution', 'careers'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $institution)
  {
    $data = Institution::find($institution);
    $data->update($request->all());
    if (!$data) {
      return response()->json([
        'status' => 400,
        'error' => "something went wrong"
      ]);
    } else {
      return response()->json([
        'status' => 200,
        'message' => 'Data successfully updated'
      ]);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($institution)
  {
    $data = Institution::find($institution);
    $data->delete();
    if (!$data) {
      return response()->json([
        'status' => 400,
        'error' => "something went wrong"
      ]);
    } else {
      return response()->json([
        'status' => 200,
        'message' => 'Data successfully destroyed'
      ]);
    }
  }
}
