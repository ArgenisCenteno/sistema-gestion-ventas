<td>
    @if($apertura->estatus == 'Finalizado')
        <a href="{{ route('aperturas.edit', $apertura) }}" class="btn btn-info">
            <span >Detalles</span>
        </a>
    @else
        <a href="{{ route('aperturas.edit', $apertura) }}" class="btn btn-warning">
            <span >Cerrar</span>
        </a>
    @endif
    @if(Auth::user()->hasRole('superAdmin'))


        <form action="{{ route('aperturas.destroy', $apertura) }}" method="POST" class="btn-delete" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <span>Eliminar</span>
            </button>
        </form>
    @endif
</td>