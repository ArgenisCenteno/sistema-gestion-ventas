<form action="{{ route('usuarios.store') }}" method="POST">
    @csrf

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label fw-bold">Nombre</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="email" class="form-label fw-bold">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    @if($cliente == false)
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label fw-bold">Contraseña</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="role" class="form-label fw-bold">Rol</label>
                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                    <option value="">Selecciona un rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="dni" class="form-label fw-bold">Cédula</label>
            <input type="text" class="form-control @error('dni') is-invalid @enderror" id="dni" name="dni" required>
            @error('dni')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="sector" class="form-label">Sector</label>
            <input type="text" class="form-control @error('sector') is-invalid @enderror" id="sector" name="sector">
            @error('sector')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="calle" class="form-label">Calle</label>
            <input type="text" class="form-control @error('calle') is-invalid @enderror" id="calle" name="calle">
            @error('calle')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label for="casa" class="form-label">Casa</label>
            <input type="text" class="form-control @error('casa') is-invalid @enderror" id="casa" name="casa">
            @error('casa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="status" class="form-label fw-bold">Estado</label>
            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                <option value="Activo" selected>Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="float-end">
        <button type="submit" class="btn btn-primary">Registrar</button>
    </div>
</form>
