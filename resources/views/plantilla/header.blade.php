@if(isset($asignatura) && isset($asignatura['nombre']))
    {{-- Header para vista de asignatura específica --}}
    <div class="top-bar-new">
        <div class="header-left">
            <button class="back-btn" onclick="goBack()" title="Volver">
                <i class="fas fa-arrow-left"></i>
            </button>
        </div>
        
        <div class="header-center">
            <h1 class="subject-header-title">
                {{ $asignatura['nombre'] }}
            </h1>
        </div>
        
        <div class="header-right">
            <div class="user-info">
                <div class="user-avatar">
                    <img src="{{ asset('images/avatars/' . (Auth::user()->avatar_kid ?? 'default.png')) }}" alt="Avatar" class="avatar-img">
                </div>
                <div class="user-name">{{ Auth::user()->nombre_usuario }}</div>
            </div>
            <button class="logout-btn" onclick="logout()" title="Cerrar sesión">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </div>
    </div>
@else
    {{-- Header para vista principal de asignaturas --}}
    <div class="top-bar-new">
        <div class="header-left"></div>

        <div class="header-center">
            <img src="{{ asset('images/logo.png') }}" alt="PEDKIDS" class="header-logo">
        </div>

        <div class="header-right">
            <div class="user-info">
                <div class="user-avatar">
                    <img src="{{ asset('images/avatars/' . (Auth::user()->avatar_kid ?? 'default.png')) }}" alt="Avatar" class="avatar-img">
                </div>
                <div class="user-name">{{ Auth::user()->nombre_usuario }}</div>
            </div>
            <button class="logout-btn" onclick="logout()" title="Cerrar sesión">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </div>
    </div>
@endif