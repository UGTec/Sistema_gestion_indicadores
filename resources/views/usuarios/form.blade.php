@props(['usuario' => null, 'perfiles', 'departamentos', 'estados'])

<x-adminlte-input name="usuario" label="Usuario" placeholder="usuario" disabled value="{{ old('usuario', $usuario->usuario ?? '') }}">
    <x-slot name="prependSlot">
        <div class="input-group-text">
            <i class="fas fa-user"></i>
        </div>
    </x-slot>
</x-adminlte-input>
<x-adminlte-input name="nombre" label="Nombre" placeholder="nombre" value="{{ old('nombre', $usuario->nombre ?? '') }}">
    <x-slot name="prependSlot">
        <div class="input-group-text">
            <i class="fas fa-user"></i>
        </div>
    </x-slot>
</x-adminlte-input>
<x-adminlte-input name="primer_apellido" label="Primer apellido" placeholder="primer apellido" value="{{ old('primer_apellido', $usuario->primer_apellido ?? '') }}">
    <x-slot name="prependSlot">
        <div class="input-group-text">
            <i class="fas fa-user"></i>
        </div>
    </x-slot>
</x-adminlte-input>
<x-adminlte-input name="segundo_apellido" label="Segundo apellido" placeholder="segundo apellido" value="{{ old('segundo_apellido', $usuario->segundo_apellido ?? '') }}">
    <x-slot name="prependSlot">
        <div class="input-group-text">
            <i class="fas fa-user"></i>
        </div>
    </x-slot>
</x-adminlte-input>
<x-adminlte-input type="email" name="correo_electronico" label="correo electronico" placeholder="correo_electronico" value="{{ old('correo_electronico', $usuario->correo_electronico ?? '') }}">
    <x-slot name="prependSlot">
        <div class="input-group-text">
            <i class="fas fa-envelope"></i>
        </div>
    </x-slot>
</x-adminlte-input>
<x-adminlte-select2 name="cod_perfil" label="Perfil">
    <x-slot name="prependSlot">
        <div class="input-group-text">
            <i class="fas fa-profile"></i>
        </div>
    </x-slot>
    <option value="">Seleccione un perfil</option>
    {{-- @foreach($perfiles as $perfil)
    <option value="{{ $perfil->cod_perfil }}" {{ old('cod_perfil', $usuario->cod_perfil ?? '') == $perfil->cod_perfil ? 'selected' : '' }}>
        {{ $perfil->perfil }}
    </option>
    @endforeach --}}
</x-adminlte-select2>
<x-adminlte-select2 name="cod_departamento" label="Departamento">
    <x-slot name="prependSlot">
        <div class="input-group-text">
            <i class="fas fa-building"></i>
        </div>
    </x-slot>
    <option value="">Seleccione un departamento</option>
    @foreach($departamentos as $departamento)
    <option value="{{ $departamento->cod_departamento }}" {{ old('cod_departamento', $usuario->cod_departamento ?? '') == $departamento->cod_departamento ? 'selected' : '' }}>
        {{ $departamento->departamento }}
    </option>
    @endforeach
</x-adminlte-select2>
<x-adminlte-select2 name="cod_estado_usuario" label="Estado">
    <x-slot name="prependSlot">
        <div class="input-group-text">
            <i class="fas fa-check"></i>
        </div>
    </x-slot>
    @foreach($estados as $estado)
    <option value="{{ $estado->cod_estado_usuario }}" {{ old('cod_estado_usuario', $usuario->cod_estado_usuario ?? '') == $estado->cod_estado_usuario ? 'selected' : '' }}>
        {{ $estado->estado_usuario }}
    </option>
    @endforeach
</x-adminlte-select2>
<hr>
<x-adminlte-input type="email" name="password" label="contraseña" placeholder="contraseña" value="">
    <x-slot name="prependSlot">
        <div class="input-group-text">
            <i class="fas fa-key"></i>
        </div>
    </x-slot>
</x-adminlte-input>
<x-adminlte-input type="email" name="password" label="repetir contraseña" placeholder="contraseña" value="">
    <x-slot name="prependSlot">
        <div class="input-group-text">
            <i class="fas fa-key"></i>
        </div>
    </x-slot>
</x-adminlte-input>
<hr>
