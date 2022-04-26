<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\Format;
use App\Models\Element;
use App\Models\Plan;
use App\Models\Institution;
use App\Models\Career;
use App\Models\Municipality;
use Illuminate\Support\Facades\Auth;


class RequisitionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $requisitions = Requisition::all();
    $careers = Career::all();
    $institutions = Institution::all();

    return view('pages.dashboard');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $institutions = Institution::all();
    $careers = Career::all();

    return response()->json([
      'institutions' => $institutions,
      'careers' => $careers
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $requisition = new Requisition();
    $requisition->meta = $request->meta;
    $requisition->career_id = $request->career_id;
    $data = $requisition->save();

    $formatsName = ['Plan de estudios', 'Mapa curricular', 'Programas de estudios', 'Estructura e instalaciones', 'Plataforma tecnológica'];
    foreach ($formatsName as $formatName) {
      $format = new Format();
      $format->formato = $formatName;
      $format->requisition_id = $requisition->id;
      $format->save();
    }

    return redirect(route('requisition.show',$requisition->id));
  }


  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($requisition)
  {
    if(Auth::user() != null){
      $data = Requisition::find($requisition);
      $career = Career::find($data->career_id);
      $institution = Institution::find($career->institution_id);
      $elements = Element::searchrequisitionid($data->id)->get();
      $plans = Plan::searchrequisitionid($data->id)->get();


      if (isset($data)) {
        return response()->json([
          'requisition' => $data,
          'career' => $career,
          'institution' => $institution
        ]);
      } else {
        return response()->json([
          'error' => 'Data not found'
        ]);
      }
    }    
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
  public function update(Request $request, $requisition)
  {
    $data = Requisition::find($requisition);
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
  public function destroy($requisition)
  {
    $data = Requisition::find($requisition);
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

  //Funcion para vista de busqueda de RVOE ---PENDIENTE
  public function searchRequisition()
  {
    $institutions = Institution::all();
    $municipalities = Municipality::all();
    $areas = Area::all();

    return view('pages.consult', compact('institutions', 'municipalities', 'areas'));
  }

  //Funcion para buscar RVOE ---PENDIENTE
  public function showRVOE(Request $request)
  {
    if(!is_null($request->rvoe)){
      $requisition = Requisition::rvoe($request->rvoe)->first();
      if (!$requisition) {
        return response()->json([
          'status' => "No se encontró la requisición"
        ]);
      } else {
        return response()->json([
          'requisition' => $requisition
          
        ]);
      }
    }
  }
  
}
