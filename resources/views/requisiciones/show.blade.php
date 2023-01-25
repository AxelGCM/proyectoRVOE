@extends('layouts.app')
@section('titulo')
    Información de la Solicitud
@endsection
@section('contenido')
    <form class="flex justify-end gap-2">
        <select name="" class="border-gray-200 rounded-xl">
            <option selected disabled>-- seleccione una opción --</option>
            <option value="activar">Activar</option>
            <option value="rechazar">Rechazar</option>
            <option value="eliminar">Eliminar</option>
        </select>

        <input class="bg-green-900 text-white p-2 hover:bg-green-700 hover:cursor-pointer rounded-xl" type="submit"
            value="Confirmar">
    </form>
    <div class="flex justify-center items-center  mb-4 py-4">
        <img src="{{ $institution->logo }}" alt="Logotipo Institución">
    </div>
    <div class="md:grid md:grid-cols-2 md:gap-4">
        <div class="border border-gray-200 rounded-md shadow-lg">
            <div class="border-b border-gray-200">
                <h2 class="text-gray-600 md:col-span-2 text-center p-3 text-xl font-bold uppercase">Información de la
                    Institución
                </h2>
            </div>
            <p class="p-2 text-lg font-bold">Nombre: <span class="font-normal">{{ $institution->name }}</span></p>
            <p class="p-2 text-lg font-bold">Titular: <span class="font-normal">{{ $institution->owner }}</span></p>
            <p class="p-2 text-lg font-bold">Representante legal o Asociación Civil: <span
                    class="font-normal">{{ $institution->legalRep }}</span></p>
            <p class="p-2 text-lg font-bold">Correo Institucional: <span
                    class="font-normal">{{ $institution->email }}</span>
            </p>
            <p class="p-2 text-lg font-bold">Dirección: <span class="font-normal">{{ $institution->address }}</span></p>
        </div>
        <div class="border border-gray-200 mt-4 md:mt-0 rounded-md shadow-lg">
            <div class="border-b border-gray-200">
                <h2 class="text-gray-600 text-center p-3 text-xl font-bold uppercase">Información de la Carrera</h2>
            </div>
            <p class="p-2 text-lg font-bold">Nombre: <span class="font-normal">{{ $career->name }}</span></p>
            <p class="p-2 text-lg font-bold">Modalidad: <span class="font-normal">{{ $career->modality }}</span></p>
            <p class="p-2 text-lg font-bold">Duración: <span class="font-normal">{{ $career->numOfPeriods }} @if ($career->typeOfPeriod == 'Semestral')
                        Semestres
                    @elseif($career->tipoPeriodo == 'Cuatrimestral')
                        Cuatrimestres
                    @endif
                </span></p>
            <p class="p-2 text-lg font-bold">Área: <span class="font-normal">{{ $area->name }}</span></p>
        </div>
    </div>

    <div class="md:flex md:justify-between md:items-center gap-4 mt-4 mb-4">
        @if ($data->rvoe)
            <div class="md:flex gap-4">
                <p class="font-bold">Rvoe o Acuerdo: <span class="font-normal">{{ $data->rvoe }}</span></p>
                <p class="font-bold">Estado: <span class="font-normal">{{ $data->status }}</span></p>
            </div>
        @endif
        <div>
            @if ($data->dueDate)
                <div>
                    <p class="font-bold">Fecha de Vencimiento: <span class="font-normal">{{ $data->dueDate }}</span></p>
                </div>
            @endif

            @if ($data->latencyDate)
                <div>
                    <p class="font-bold">Fecha de Latencia: <span class="font-normal">{{ $data->latencyDate }}</span>
                    </p>
                </div>
            @endif
        </div>
    </div>


    @if (Auth::user()->typeOfUser == 'administrador')
        @if ($data->status == 'activo' || $data->status == 'latencia' || $data->status == 'revocado')
            <form action="{{ route('requisitions.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="btn-group">
                    <select class="form-select" name="estado">
                        <option selected disabled>Selecciona un estado</option>
                        @switch($data->status)
                            @case('activo')
                                <option value="latencia">Latencia</option>
                                <option value="revocado">Revocado</option>
                            @break

                            @case('latencia')
                            @case('revocado')
                                <option value="activo">Activo</option>
                            @break
                        @endswitch
                    </select>
                    <button class="bg-green-900 hover:bg-green-700 py-2 px-3 text-white" type="submit">
                        Actualizar
                    </button>
                </div>
            </form>
        @endif
    @endif

    <div class="my-10">
        <h2 class="text-center mb-5 uppercase text-2xl">Evaluación de la Solicitud</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-6 gap-4">
            <a href="{{ route('evaluate.formats', ['requisition_id' => $data->id, 'no_evaluation' => 1]) }}" type="button"
                id="evaFormatos"
                class="rounded-md p-3 text-white formatos bg-green-900 hover:bg-green-700 @if ($data->evaNum == 1) bg-blue-500 hover:bg-blue-800 @endif flex flex-col justify-center items-center @if (Auth()->user()->typeOfUser == 'direccion') disabled @endif">
                <p class="uppercase">Formatos</p>
                <p>Revisión <span class="font-bold">1</span></p>
                <p>Planeación</p>
            </a>
            <a href="{{ route('evaluate.formats', ['requisition_id' => $data->id, 'no_evaluation' => 2]) }}"
                class="rounded-md p-3 text-white formatos bg-green-900 hover:bg-green-700 @if ($data->evaNum == 2) bg-blue-500 hover:bg-blue-800 @endif flex flex-col justify-center items-center @if ($data->evaNum < 2 || Auth()->user()->typeOfUser == 'direccion') disabled @endif">
                <p class="uppercase">Formatos</p>
                <p>Revisión <span class="font-bold">2</span></p>
                <p>Planeación</p>
            </a>
            <a href="{{ route('evaluate.formats', ['requisition_id' => $data->id, 'no_evaluation' => 3]) }}"
                class="rounded-md p-3 text-white formatos bg-green-900 hover:bg-green-700 @if ($data->evaNum == 3) bg-blue-500 hover:bg-blue-800 @endif flex flex-col justify-center items-center @if (Auth()->user()->typeOfUser == 'planeacion' || $data->evaNum < 3) disabled @endif">
                <p class="uppercase">Formatos</p>
                <p>Revisión <span class="font-bold">3</span></p>
                <p>Dirección</p>
            </a>
            <a href="{{ url('/evaluate/factibilidadYPertinencia', $data->id) }}"
                class="rounded-md p-3 text-white bg-green-900 hover:bg-green-700 flex flex-col justify-center items-center">
                <p class="uppercase text-center">Factibilidad y Pertinencia</p>
                <p>Evaluación <span class="font-bold">4</span></p>
                <p>Dirección</p>
            </a>
            <a href="{{ url('/evaluate/elements', $data->id) }}"
                class="rounded-md p-3 text-white bg-green-900 hover:bg-green-700 @if ($data->evaNum == 4) bg-blue-500 hover:bg-blue-800 @endif flex flex-col justify-center items-center @if ($data->evaNum < 4 || Auth()->user()->typeOfUser == 'planeacion') disabled @endif">
                <p class="uppercase">Instalaciones</p>
                <p>Evaluación <span class="font-bold">2</span></p>
                <p>Dirección</p>
            </a>
            <a href="{{ url('/evaluate/plans', $data->id) }}"
                class="rounded-md p-3 text-white bg-green-900 hover:bg-green-700 @if ($data->evaNum == 5) bg-blue-500 hover:bg-blue-800 @endif flex flex-col justify-center items-center">
                <p class="uppercase">Planes</p>
                <p>Evaluación <span class="font-bold">3</span></p>
                <p>Dirección</p>
            </a>
            <a download="OTAReq-{{ $data->id }}" href="{{ url('/download/status', $data->id) }}"
                class="rounded-md p-3 text-white bg-green-900 hover:bg-green-700 @if ($data->evaNum == 6) bg-blue-500 hover:bg-blue-800 @endif flex flex-col justify-center items-center @if ($data->evaNum < 6 || Auth()->user()->typeOfUser == 'planeacion') disabled @endif">
                <p>Descargar</p>
                <p class="uppercase">ESTADO</p>
            </a>
            @if ($data->ota == 'true')
                <a download="OTAReq-{{ $data->id }}" href="{{ url('/download', $data->id) }}"
                    class="rounded-md p-3 text-white bg-green-900 hover:bg-green-700 @if ($data->evaNum == 6) bg-blue-500 hover:bg-blue-800 @endif flex flex-col justify-center items-center @if ($data->evaNum < 6 || Auth()->user()->typeOfUser == 'planeacion') disabled @endif">
                    <p>Descargar</p>
                    <p class="uppercase">ota</p>
                </a>
            @endif

        </div>


        <div class="@if ($data->formatoInstalaciones) flex justify-between items-center gap-4 @endif mt-5">

            @if ($data->formatoInstalaciones)
                <button id="open-img" class="bg-green-900 hover:bg-green-700 text-white rounded-lg p-2">Evidencia
                    Evaluación de Instalaciones</button>
            @endif


            @if (Auth::user()->tipoUsuario != 'planeacion')
                <form action="{{ route('solicitud', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex gap-4 justify-end items-center">
                        <div class="flex gap-2 items-center">
                            <label for="opcion1">Si</label>
                            <input type="radio" name="evaluacion" id="opcion1" value="1">
                        </div>

                        <div class="flex items-center gap-2">
                            <label for="opcion2">No</label>
                            <input type="radio" name="evaluacion" id="opcion2" value="0">
                        </div>
                        <button class="text-white bg-green-900 hover:bg-green-700 p-2 rounded-lg" type="submit">Pasar al
                            administrador</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <div class="pb-4 w-4/6 mx-auto text-center">
        @foreach ($formats as $format)
            @if ($format->valido == false && $format->justificacion)
                <p class="bg-red-400 p-4 text-red-900 mb-4">Evaluación de Formatos -
                    {{ $format->justificacion }} ({{ $formatNames[$format->formato - 1] }})</p>
            @endif
        @endforeach
        @if ($data->noEvaluacion > 4)
            @foreach ($elements as $element)
                @if (
                    $element->existente == false &&
                        (($element->elemento > 0 && $element->elemento < 7) ||
                            ($element->elemento > 7 && $element->elemento < 12) ||
                            $element->elemento == 13 ||
                            $element->elemento == 16 ||
                            ($element->elemento > 28 && $element->elemento < 31) ||
                            $element->elemento == 40 ||
                            ($element->elemento > 41 && $element->elemento < 48) ||
                            $element->elemento > 50))
                    <p class="bg-red-400 p-4 text-red-900 mb-4">Evaluación de las Instalaciones.-
                        {{ $element->observacion }} (Elemento {{ $element->elemento }})</p>
                @elseif ($element->existente == false)
                    <p class="bg-orange-400 p-4 text-orange-900 mb-4">Evaluación de las Instalaciones.-
                        {{ $element->observacion }} (Elemento {{ $element->elemento }})</p>
                @endif
            @endforeach
        @endif

        @if ($data->noEvaluacion > 5)
            @foreach ($plans as $plan)
                @if ($plan->ponderacion < 60)
                    <p class="bg-red-400 p-4 text-red-900 mb-4">Evaluación de los Planes.-{{ $plan->comentario }} (Plan
                        {{ $plan->plan }})</p>
                @endif
            @endforeach
        @endif
    </div>



    @if ($data->formatoInstalaciones)
        <div id="buildings-img" class="hidden p-5 fixed top-0 bottom-0 left-0 right-0 bg-black/80 h-screen">
            <button id="close-img"
                class="absolute rounded-lg bg-gray-200 hover:bg-gray-400 px-4 py-2 text-gray-400 hover:text-gray-800 transition-all text-5xl font-bold top-10 right-10">X</button>
            <div class="flex flex-col justify-center items-center h-screen">
                <img src="{{ $data->formatoInstalaciones }}" alt="Formato de instalaciones">
            </div>
        </div>
    @endif
@endsection

@section('script')
    <script>
        const checkBtnRadios = document.querySelectorAll('.btn-check')
        const checkBoxes1 = document.querySelectorAll('.review2Checkbox')
        const imgContainer = document.querySelector("#buildings-img");
        const closeImg = document.querySelector("#close-img");
        const openImg = document.querySelector("#open-img");

        cargarEventListener()

        function cargarEventListener() {
            checkBtnRadios.forEach(radio => {
                radio.addEventListener('click', review1)
            });

            checkBoxes1.forEach(checkBox => {
                checkBox.addEventListener('click', review2)
            })


            if (openImg) {
                openImg.addEventListener('click', () => imgContainer.classList.remove("hidden"));
            }

            if (closeImg) {
                closeImg.addEventListener('click', () => imgContainer.classList.add("hidden"));
            }
        }

        function review1(e) {
            const radioBtn = e.target
            if (radioBtn.classList.contains('btn-No')) {
                radioBtn.value = !this.checked
            } else {
                radioBtn.value = this.checked
            }
        }

        function review2(e) {
            const checkBox = e.target
            const id = checkBox.id.split('-')[2]
            const justInput = document.getElementById(`just-review2-${id}`)
            checkBox.value = checkBox.checked
            if (checkBox.value == 'true') {
                justInput.required = false
            } else {
                justInput.required = true
            }
        }
    </script>
@endsection
