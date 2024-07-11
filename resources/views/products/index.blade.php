@extends('layouts.template')

@section('title', 'Productos')
    
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="form-wrapper">
                <h2>Agregar Productos</h2>
                <form action="{{ route('producto.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Precio</label>
                        <input type="number" name="price" class="form-control" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="table-wrapper">
                <h2>Lista de Productos</h2>
                @if($producto->isEmpty())
                    <p>No se encontraron registros de productos.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>--</th>
                                <th>--</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($producto as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td><a href="{{ route('producto.edit', $item->id) }}" class="btn btn-success btn-custom">Editar</a></td>
                                    <td>
                                        <form action="{{ route('producto.delete', $item->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-custom" onclick="return confirm('¿Estás seguro de eliminar este registro?');">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
    

