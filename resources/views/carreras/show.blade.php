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
                    <button class="bg-red-600 hover:bg-red-800 px-10 py-2 text-white rounded-xl" type="submit">
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
                        <label for="careerName" class="mb-2 block uppercase text-gray-500 font-bold">Nombre de la
                            Carrera</label>
                        <input name="name" type="text" class="w-full border-gray-200 rounded-xl p-3" id="careerName"
                            placeholder="Nombre de la Carrera" value="{{ $career->name }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <label for="careerArea" class="mb-2 block uppercase text-gray-500 font-bold">Area de la
                            Carrera</label>
                        <select id="careerArea" class="w-full border-gray-200 rounded-xl p-3" name="area_id">
                            <option selected disabled>-- Seleccione el Area --</option>
                            @foreach ($areas as $area)
                                <option @if ($area->id == $career->area_id) selected @endif value="{{ $area->id }}">
                                    {{ $area->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <label for="careerModality" class="mb-2 block uppercase text-gray-500 font-bold">Modalidad de la
                            Carrera</label>
                        <select id="careerModality" class="w-full border-gray-200 rounded-xl p-3" name="modality">
                            <option selected disabled>-- Seleccione la Modalidad --</option>
                            <option value="Escolarizado" @if ($career->modality == 'Escolarizado') selected @endif>Escolarizado
                            </option>
                            <option value="Semiescolarizado" @if ($career->modality == 'Semiescolarizado') selected @endif>
                                Semiescolarizado</option>
                            <option value="No escolarizado" @if ($career->modality == 'No escolarizado') selected @endif>No
                                escolarizado</option>
                            <option value="Dual" @if ($career->modality == 'Dual') selected @endif>Dual</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <label for="careerPeriod" class="mb-2 block uppercase text-gray-500 font-bold">Tipo de
                            periodo</label>
                        <select id="careerPeriod" class="w-full border-gray-200 rounded-xl p-3" name="typeOfPeriod"
                            required>
                            <option selected disabled>-- Seleccione la tipo de periodo --</option>
                            <option value="Semestral" @if ($career->typeOfPeriod == 'Semestral') selected @endif>Semestral</option>
                            <option value="Cuatrimestral" @if ($career->typeOfPeriod == 'Cuatrimestral') selected @endif>Cuatrimestral
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <label for="careerDuration" class="mb-2 block uppercase text-gray-500 font-bold">Duración de la
                            Carrera</label>
                        <input type="text" class="w-full border-gray-200 rounded-xl p-3" name="duration"
                            value="{{ $career->numOfPeriods }}" id="careerDuration" placeholder="Duración de la Carrera">
                    </div>
                </div>
            </div>

            @if (Auth::user()->tipoUsuario != 'direccion')
                <div class="flex justify-center items-center mt-10">
                    <button class="bg-green-900 hover:bg-green-700 rounded-xl text-white py-2 px-10" type="submit">
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
                        class="bg-green-900 hover:bg-green-700 text-white rounded-xl py-2 px-4">
                        Nueva Solicitud
                    </button>
                @endif
            </div>


            @if (count($requisitions) != 0)
                <div class="flex flex-col">
                    @foreach ($requisitions as $requisition)
                        <a href="{{ route('requisitions.show', $requisition->id) }}" class="hover:bg-gray-200">
                            <div class="md:flex md:justify-between p-2">
                                <p class="font-bold"> 
                                    Meta:
                                    <span class="font-light">{{ $requisition->procedure }}</span>
                                </p>
                                <p class="font-bold">
                                    Fecha de creacion:
                                    <span class="font-light">{{ $requisition->created_at }}</span>
                                </p>
                                <p class="font-bold">
                                   Ultima fecha de actualizacion: <span class="font-light">{{ $requisition->updated_at }}</span>
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 text-xl text-center font-bold mt-10">Todavia no hay solicitudes</p>
            @endif
            <div id="new-request" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button"
                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                            data-modal-toggle="new-request">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div class="py-6 px-6 lg:px-8">
                            <h3 class="text-center mb-4 text-xl font-medium text-gray-900 dark:text-white">Nueva Solicitud
                            </h3>
                            <form class="mb-2" method="POST" action="{{ route('requisitions.store') }}">
                                @csrf
                                <input type="hidden" value="{{ $career->id }}" name="career_id">
                                <div class="form-floating mb-3">
                                    <label for="careerModality" class="mb-2 block uppercase text-gray-500 font-bold">Meta de
                                        la Requisición</label>
                                    <select id="requisitionGoal" class="w-full border p-3 " name="procedure" required>
                                        <option selected disabled>-- Seleccione la Meta --</option>
                                        <option value="solicitud">Solicitud</option>
                                        <option value="domicilio">Domicilio</option>
                                        <option value="planEstudios">Plan de Estudios</option>
                                    </select>
                                </div>
                                <input type="hidden" name="career_id" value="{{ $career->id }}">
                                <div class="d-grid mt-4">
                                    <button class="bg-green-900 hover:bg-green-700 text-white uppercase w-full p-2"
                                        type="submit">Agregar</button>
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
