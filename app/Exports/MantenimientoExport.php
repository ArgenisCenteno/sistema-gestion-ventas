<?php

namespace App\Exports;

use App\Models\Venta;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MantenimientoExport implements FromView, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
 
    public function view(): View
    {
        $ventas = Venta::with(['user', 'empleado'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();

        return view('exports.mantenimientos', compact('ventas'));
    }
}
