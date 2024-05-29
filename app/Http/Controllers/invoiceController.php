<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\File;

class InvoiceController extends Controller
{
    public function invoice($reservation_id)
    {
        $reservation = Reservation::find($reservation_id);

        // Ensure the invoices directory exists
        $directory = storage_path('app/invoices');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $pdf = PDF::loadView('invoice', compact('reservation'));
        $filename = 'Reservation-' . $reservation_id . '-invoice' . '.pdf';

        $pdf->save($directory . '/' . $filename);

        return $pdf->download($filename);
    }
}
