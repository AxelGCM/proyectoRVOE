@extends('layouts.app')
@section('titulo')
  @if ($noEvaluation == 1)
    Revisión de existencia de formatos
  @elseif ($noEvaluation == 2)
    Revisión del contenido de los formatos 1
  @else
    Revisión del contenido de los formatos 2
  @endif
@endsection
@section('contenido')
  <form class="mb-2 flex flex-col justify-center items-center" method="POST" action="{{ url('/update/formats') }}">
    @csrf
    <input type="hidden" name="requisition_id" value="{{ $requisition->id }}">
    <input type="hidden" name="noEvaluation" value="{{ $noEvaluation }}">
    <div class="@if ($noEvaluation != 1) grid grid-cols-2 @endif gap-4">
      @foreach (range(1, 5) as $i)
        @foreach ($formats as $format)
          @if ($format->formato == $i)
            <div class="@if ($i == 5) col-span-2 @endif">
              <div class="mb-4  flex justify-start items-center gap-4">
                <input name="anexo{{ $i }}" value="{{ $format->valido }}"
                  class="reviewCheckbox form-check-input" type="checkbox" id="check-review-{{ $format->id }}"
                  @if ($format->valido) checked @endif>
                <label class="form-check-label" for="check-review2-{{ $format->id }}">
                  {{ $formatNames[$i - 1] }}
                </label>
              </div>
              @if ($noEvaluation != 1)
                <div>
                  <textarea name="anexo{{ $i }}j" class="w-full resize-none" id="just-review-{{ $format->id }}"
                    placeholder="Justificación">{{ $format->justificacion }}</textarea>
                </div>
              @endif
            </div>
          @endif
        @endforeach
      @endforeach
    </div>
    <div class="flex justify-center items-center mt-4">
      <button class="text-white bg-[#13322B] hover:bg-[#0C231E] px-10 py-3" type="submit">Guardar</button>
    </div>
  </form>
@endsection
@section('script')
  <script>
    const checkboxes = document.querySelectorAll('.reviewCheckbox')

    window.onload = function() {
      $('input[type=checkbox]').prop('checked', false);

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
        console.log(justificacion);
      })
    }
  </script>
@endsection
