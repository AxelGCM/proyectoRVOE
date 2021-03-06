@extends('layouts.app')
@section('titulo')
    {{ $career->nombre }}
@endsection
@section('contenido')
  <div class="container mb-5 mt-4 pb-5">
    <div class="flex justify-end items-center mb-4">
      @if (Auth::user()->tipoUsuario != 'direccion')
          <form method="POST" action="{{ route('careers.destroy', $career->id) }}" class="flex justify-content-end">
            @csrf
            @method('DELETE')
            <button class="bg-red-600 hover:bg-red-800 p-2 text-white" type="submit">
              Eliminar
            </button>
          </form>
      @endif
    </div>
    <form method="POST" action="{{ route('careers.update', $career->id) }}">
      @csrf
      @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div class="col-md-6">
                <div class="form-floating mb-2">
                    <label for="careerName" class="mb-2 block uppercase text-gray-500 font-bold">Nombre de la Carrera</label>
                    <input name="nombre" type="text" class="w-full border p-3" id="careerName" placeholder="Nombre de la Carrera"
                    value="{{ $career->nombre }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <label for="careerArea" class="mb-2 block uppercase text-gray-500 font-bold">Area de la Carrera</label>
                    <select id="careerArea" class="w-full border p-3" name="area_id" required>
                        <option selected disabled>-- Seleccione el Area --</option>
                        @foreach ($areas as $area)
                            <option @if ($area->id == $career->area_id) selected @endif value="{{ $area->id }}">
                                {{ $area->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <label for="careerModality" class="mb-2 block uppercase text-gray-500 font-bold">Modalidad de la Carrera</label>
                    <select id="careerModality" class="w-full border p-3" name="modalidad" required>
                        <option selected disabled>-- Seleccione la Modalidad --</option>
                        <option value="Presencial" @if ($career->modalidad == 'Presencial') selected @endif>Presencial</option>
                        <option value="Distancia" @if ($career->modalidad == 'Distancia') selected @endif>Distancia</option>
                        <option value="Hibrida" @if ($career->modalidad == 'Hibrida') selected @endif>Hibrida</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <label for="careerDuration" class="mb-2 block uppercase text-gray-500 font-bold">Duraci??n de la Carrera</label>
                    <input type="number" class="w-full border p-3" name="duracion" value="{{ $career->duracion }}" id="careerDuration" placeholder="Duraci??n de la Carrera">
                </div>
            </div>
        </div>
      
      @if (Auth::user()->tipoUsuario != 'direccion')
        <div class="flex justify-center items-center">
          <button class="bg-[#13322B] hover:bg-[#0C231E] text-white py-2 px-10" type="submit">
            Actualizar
          </button>
        </div>
      @endif
    </form>

    <section class="mt-4">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl">Solicitudes</h2>
        @if (Auth::user()->tipoUsuario !== 'direccion')
          <button type="button" data-modal-toggle="new-request" type="submit"
            class="bg-[#13322B] hover:bg-[#0C231E] text-white py-2 px-4">
            Nueva Solicitud
          </button>
        @endif
      </div>

      
        @if (count($requisitions) != 0)
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                            <table class="min-w-full">
                                <thead class="border-b bg-[#13322B]">
                                <tr>
                                    <th class="text-sm font-bold text-white px-6 py-4 text-left">Meta</th>
                                    <th class="text-sm font-bold text-white px-6 py-4 text-left">Creaci??n</th>
                                    <th class="text-sm font-bold text-white px-6 py-4 text-left">Ultima Actualizaci??n</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requisitions as $requisition)
                                    <tr class="border-b" data-href="{{ route('requisitions.show', $requisition->id) }}">
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $requisition->meta }}</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $requisition->created_at }}</td>
                                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ $requisition->updated_at }}</td>
                                    </tr>
                                    </a>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <p class="text-gray-600 text-xl text-center font-bold mt-10">Todavia no hay solicitudes</p>
        @endif


      <div id="new-request" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="new-request">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>
                <div class="py-6 px-6 lg:px-8">
                    <h3 class="text-center mb-4 text-xl font-medium text-gray-900 dark:text-white">Nueva Solicitud</h3>
                    <form class="mb-2" method="POST" action="{{ route('requisitions.store') }}">
                        @csrf
                        <input type="hidden" value="{{ $career->id }}" name="career_id">
                        <div class="form-floating mb-3">
                            <label for="careerModality" class="mb-2 block uppercase text-gray-500 font-bold">Meta de la Requisici??n</label>
                          <select id="requisitionGoal" class="w-full border p-3 " name="meta" required>
                            <option selected disabled>-- Seleccione la Meta --</option>
                            <option value="solicitud">Solicitud</option>
                            <option value="domicilio">Domicilio</option>
                            <option value="planEstudios">Plan de Estudios</option>
                          </select>
                        </div>
                        <input type="hidden" name="career_id" value="{{ $career->id }}">
                        <div class="d-grid mt-4">
                          <button class="bg-[#13322B] hover:bg-[#0C231E] text-white uppercase w-full p-2" type="submit">Agregar</button>
                        </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
    </section>
  </div>
@endsection
@section('script')
  <script>
    $(document).ready(function($) {
      $(".table-row").click(function() {
        window.document.location = $(this).data("href");
      })
    })
  </script>
@endsection
