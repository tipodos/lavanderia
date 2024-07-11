<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\order;
use Illuminate\Http\Request;

class ListaController extends Controller
{
    public function index(Request $request){
        $query = order::query();
    $filter = $request->input('filter');

    switch ($filter) {
        case 'today':
            $query->whereDate('created_at', now()->format('Y-m-d'));
            break;
        case 'month':
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
            break;
        case 'previous':
            $query->whereDate('created_at', '<', now()->format('Y-m-d'));
            break;
        default:
            // Sin filtro, se muestran todas las órdenes
            break;
    }

    $orders = $query->paginate(10);
    $total = $query->sum('total');
    $pending = $query->where('estado', '!=', 1)->sum('total');
    return view('lista', compact('orders', 'total', 'pending'));
    }
    public function export() 
    {
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }
}
