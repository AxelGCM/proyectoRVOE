@extends('layouts.app')
@section('header')
  
  
@endsection
@section('main-content')
  <div class="container-sm py-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h1 class="text-uppercase">Instituciones</h1>
      @if (Auth::user()->tipoUsuario != 'direccion')
        <button type="button" data-bs-target="#institutionsModal" data-bs-toggle="modal"
          class="boton boton-green py-2 rounded">Nueva
          Institución</button>
      @endif
    </div>
    @foreach ($institutions as $institution)
      <a class="text-decoration-none text-dark institution" href="{{ route('institutions.show', $institution) }}">
        <div class="p-3">
          <div class="d-flex justify-content-around align-items-center gap-5">
            <img src="{{ asset('img/institutions/' . $institution->logotipo) }}" class="img-fluid rounded-start"
              alt="Logo de la Institución">
            <div class="">
              <h3 class="text-center card-title">{{ $institution->nombre }}<h3>
                  <p class="fs-5 text-center">Director(a): {{ $institution->director }}</p>
            </div>
          </div>
        </div>
        <div class="institution__overlay rounded"></div>
      </a>
    @endforeach
    <nav class="mt-4">
      <ul class="pagination justify-content-center text-dark m-0">
        <li class="page-item">
          <a class="page-link text-dark" href="#">Previous</a>
        </li>
        <li class="page-item">
          <a class="page-link text-dark" href="#">1</a>
        </li>
        <li class="page-item">
          <a class="page-link text-dark" href="#">2</a>
        </li>
        <li class="page-item">
          <a class="page-link text-dark" href="#">3</a>
        </li>
        <li class="page-item">
          <a class="page-link text-dark" href="#">Next</a>
        </li>
      </ul>
    </nav>
  </div>
  <div class="modal fade" id="institutionsModal" tabindex="-1" aria-labelledby="institutionsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h5 class="modal-title text-uppercase w-100" id="institutionsModalLabel">Nueva Institución</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="mb-2" method="POST" action="{{ route('institutions.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="form-floating mb-3">
              <input type="text" class="form-control" id="institutionName" name="nombre"
                placeholder="Nombre de la Institución">
              <label for="institutionName">Nombre de la Institución</label>
            </div>
            <div class="form-floating mb-3">
              <input type="text" class="form-control" name="director" id="directorName"
                placeholder="Nombre del Director">
              <label for="directorName">Nombre del Director</label>
            </div>
            <div class="form-floating mb-3">
              <select name="municipalitie_id" class="form-select" id="municipality"
                aria-label="Floating label select example">
                <option selected disabled>Selecciona un municipio</option>
                @foreach ($municipalities as $municipality)
                  <option value="{{ $municipality->id }}">{{ $municipality->nombre }}</option>
                @endforeach
              </select>
              <label for="municipality">Municipio</label>
            </div>
            <div class="form-floating mb-3">
              <textarea name="direccion" class="form-control resize-none" id="address" placeholder="Dirección"></textarea>
              <label for="address">Dirección</label>
            </div>
            <div class="input-group form-group mb-3">
              <input type="file" class="form-control" id="institutionLogo" name="logotipo">
            </div>
            <div class="d-grid mt-4">
              <button class="boton boton-green py-2 rounded text-uppercase" type="submit">Agregar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
@endsection
@section('footer')
  
@endsection
