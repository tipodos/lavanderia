@extends('layouts.template')

@section('content')
<div class="container mt-5">
    <div class="form-wrapper">
        <h2>Detalle de la Orden</h2>
        <p><strong>Nombre:</strong> {{ $detalle->name }}</p>
        <p><strong>Celular:</strong> {{ $detalle->celular }}</p>
        <p><strong>DNI:</strong> {{ $detalle->dni }}</p>
        <p><strong>Estado:</strong> {{ $detalle->status_text }}</p>
        <p><strong>Total:</strong> {{ $detalle->total }}</p>

        <h3>Productos</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->product->name }}</td>
                        <td>{{ $producto->quantity }}</td>
                        <td>{{ $producto->price }}</td>
                        <td>{{ $producto->quantity * $producto->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
