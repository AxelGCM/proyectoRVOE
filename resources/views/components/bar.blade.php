<div class="bar container-fluid d-flex justify-content-between align-items-center px-2 py-3">
    <a href="{{ url('/')}}">
        <img src="{{ asset('img/Logo_gob_mx.svg') }}" alt="">
    </a>
    @guest
        <button type="button" data-bs-target="#loginModal" class="text-light" data-bs-toggle="modal" style="background-color:transparent">Iniciar Sesion</button>
    @endguest
</div>
