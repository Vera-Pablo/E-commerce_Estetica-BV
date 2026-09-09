<?php

namespace App\Libraries;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    /**
     * Genera y transmite la descarga del PDF del recibo.
     *
     * @param array $venta Datos principales de la venta y cliente.
     * @param array $detalles Items comprados con cantidades y precios.
     * @param string $filename Nombre sugerido para el archivo PDF descargado.
     */
    public static function descargarRecibo(array $venta, array $detalles, string $filename = 'Recibo.pdf'): void
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // Permite cargar imágenes/logos si es necesario
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);

        // Renderizar vista HTML exclusiva para PDF
        $html = view('pdf/recibo', [
            'venta'    => $venta,
            'detalles' => $detalles,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Forzar descarga directa en el navegador
        $dompdf->stream($filename, ['Attachment' => true]);
        exit;
    }
}
