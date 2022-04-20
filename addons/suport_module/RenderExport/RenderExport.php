<?php

use Dompdf\Dompdf;

include_once __DIR__ . '/../Report/Report.php';

class RenderExport
{


    public static function renderExel($data, $bool = false)
    {
        if (empty($bool) && $bool == false) {

            return false;
        }
        Report::exportExel($data);
    }

    public static function renderPdf($data,$bool=false)
    {
        if ($bool==false && empty($bool))
        {

            return false;
        }
            ob_start();
            include_once __DIR__.'/../Template/PDF.php';
            $out=ob_get_contents();
            ob_end_clean();
        $mpdf = new mPDF('ar-s', 'A4');
        $mpdf->WriteHTML($out);
        header("Content-type:application/pdf");
        echo $mpdf->Output();
        exit;
    }

    public static function irenderExel($data, $bool = false)
    {
        if (empty($bool) && $bool == false) {

            return false;
        }
        return Report::importExel($data);
    }
}