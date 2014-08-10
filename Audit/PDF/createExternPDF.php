<?php
   session_start();
   $auditID = $_GET['a'];
   $_SESSION["AuditIDExtern"] = $auditID;
    // get the HTML
    ob_start();
    include(dirname(__FILE__).'/res/extern.php');
    $content = ob_get_clean();

    // convert in PDF
    require_once(dirname(__FILE__).'/../html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', array(15, 5, 15, 5));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('ExternRapport.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

