@extends('layouts/template')

@section('title', 'inicio')

@section('content')
    <div class="container-fluid">
        <div class="row row-no-gutters">
            <div class="col-md-4">
                <div class="form-wrapper">
                    <h2>Agregar Personal</h2>
                    <form action="{{ route('store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="celular">Celular</label>
                            <input type="text" name="celular" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="dni">DNI</label>
                            <input type="text" name="dni" class="form-control" required>
                        </div>
                        <hr>
                        <h5>Prendas</h5>
                        <div id="prendas-container">
                            <div class="form-group row">
                                <div class="col-md-5">
                                    <label for="productos[]">Producto</label>
                                    <select name="productos[]" class="form-control select2">
                                        @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}" data-price="{{ $producto->price }}">
                                                {{ $producto->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="cantidad[]">Cantidad</label>
                                    <input type="number" name="cantidad[]" class="form-control cantidad" value="1"
                                        min="1" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="total[]">Total</label>
                                    <input type="text" name="total[]" class="form-control total" value="0" readonly>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger remove-row mt-4">-</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-row" class="btn btn-secondary">Agregar Prenda</button>
                        <hr>
                        <div class="form-group">
                            <label for="total-pagar">Total a Pagar</label>
                            <input type="text" name="total_pagar" class="form-control" id="total-pagar" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Adelanto</label>
                            <input type="number" name='adelanto' class="form-control" step="0.01" min="0">
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </form>
                </div>
            </div>

            <div class="col-md-8">
                <div class="table-wrapper">
                    <h2>Lista de Personal</h2>
                    @if ($order->isEmpty())
                        <p>No se encontraron registros de personal.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Celular</th>
                                    <th>DNI</th>
                                    <th>Estado</th>
                                    <th>Adelanto</th>
                                    <th>Total</th>
                                    <th>--</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->celular }}</td>
                                        <td>{{ $item->dni }}</td>
                                        <td>{{ $item->estadoTexto();}}</td>
                                        <td>{{ $item->adelanto}}</td>
                                        <td>{{ $item->total}}</td>
                                        <td>
                                            <form action="{{ route('update', $item->id) }}" method="POST" style="display:inline-block; margin: 0;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="estado" value="1">
                                                <button type="submit" class="btn btn-success btn-custom" onclick="return confirm('¿Estás seguro de actualizar el estado a Entregado?');" style="display:inline-block;">Entregado</button>
                                            </form>
                                            <a href="{{ route('show', $item->id) }}" class="btn btn-info btn-custom"
                                                style="display:inline-block;">Ver</a>
                                            
                                            <form action="{{ route('delete', $item->id) }}" method="POST"
                                                style="display:inline-block; margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-custom"
                                                    onclick="return confirm('¿Estás seguro de eliminar este registro?');"
                                                    style="display:inline-block;">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $order->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            function calculateTotal() {
                let totalPagar = 0;
                $('.total').each(function() {
                    totalPagar += parseFloat($(this).val());
                });
                $('#total-pagar').val(totalPagar.toFixed(2));
            }

            function updateRowTotal($row) {
                const price = parseFloat($row.find('select option:selected').data('price'));
                const quantity = parseInt($row.find('.cantidad').val());
                const total = price * quantity;
                $row.find('.total').val(total.toFixed(2));
            }

            $('#prendas-container').on('change', 'select, .cantidad', function() {
                const $row = $(this).closest('.row');
                updateRowTotal($row);
                calculateTotal();
            });

            $('#add-row').click(function() {
                const $row = $('#prendas-container .row:first').clone();
                $row.find('input').val('');
                $row.find('.total').val('0.00');
                $('#prendas-container').append($row);
            });

            $('#prendas-container').on('click', '.remove-row', function() {
                if ($('#prendas-container .row').length > 1) {
                    $(this).closest('.row').remove();
                    calculateTotal();
                }
            });
        });
    </script>

@endsection
