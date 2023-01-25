@extends('layouts.app')
@section('titulo')
  @if ($noEvaluation == 1)
    Revisión de existencia de formatos 1
  @elseif ($noEvaluation == 2)
    Revisión del contenido de los formatos 2
  @else
    Revisión del contenido de los formatos 3
  @endif
@endsection
@section('contenido')
<div class="my-20">
  <form method="POST" action="{{ url('/update/formats') }}">
    @csrf
    <div @if ($noEvaluation == 1) class="flex flex-col justify-center items-center" @endif>
        <input type="hidden" name="requisition_id" value="{{ $requisition->id }}">
        <input type="hidden" name="noEvaluation" value="{{ $noEvaluation }}">
        <div class="@if ($noEvaluation != 1) grid grid-cols-2 @endif gap-4">
        @foreach (range(1, 5) as $i)
            @foreach ($formats as $format)
                @if ($format->format == $i)
                    <div class="@if ($i == 5) col-span-2 @endif">
                    <div class="mb-4  flex justify-start items-center gap-4">
                        <input name="anexo{{ $i }}" value="{{$format->valid}}"
                        class="reviewCheckbox form-check-input" type="checkbox" id="check-review-{{ $format->id }}">
                        <label class="form-check-label" for="check-review2-{{ $format->id }}">
                        {{ $formatNames[$i - 1] }} 
                        @if ($format->valid == false && $format->justificacion) 
                        <span class="text-red-600">({{ $format->justificacion }})</span>
                        @elseif ($format->valid == true)
                            <span class="text-green-400">&#10003;</span>
                        @endif
                        </label>
                    </div>
                    @if ($noEvaluation != 1)
                        <div>
                        <textarea name="anexo{{ $i }}j" class="w-full resize-none" id="just-review-{{ $format->id }}"
                            placeholder="Justificación"></textarea>
                        </div>
                    @endif
                    </div>
                @endif
            @endforeach
        @endforeach
        </div>
        <div class="flex justify-center items-center mt-4">
        <button class="text-white bg-green-900 hover:bg-green-700 px-10 py-3" type="submit">Guardar</button>
        </div>
    </div>
  </form>
</div>
@endsection
@section('script')
  <script>
    const checkboxes = document.querySelectorAll('.reviewCheckbox')

    window.onload = function() {
    //   $('input[type=checkbox]').prop('checked', false);

      setRequired()
    }

    checkboxes.forEach(element => {
      element.addEventListener('change', e => {
        e.target.value = e.target.checked
        setRequired()
      })
    });


    function setRequired() {
      checkboxes.forEach(element => {
        const id = element.id.split('-')[2]
        const justificacion = document.querySelector(`#just-review-${id}`)
        if (justificacion !== null) {
          if (element.value == 'true') {
            justificacion.required = false
          } else {
            justificacion.required = true
          }
        }
      })
    }
  </script>
@endsection
