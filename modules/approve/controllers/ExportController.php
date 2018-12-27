<?php
namespace app\modules\approve\controllers;

use Yii;
use Mypdf;

class ExportController extends CommonController{
    public $title;

    public function actionBaseInfo(){
        $this->title = '资质详情';
        $html = $this->renderPartial("base", [], true);
        $this->pdf($html);
    }

    private function pdf($html=''){
        // create new PDF document
        $pdf = new mypdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('XLH');
        $pdf->SetTitle($this->title);
        $pdf->SetSubject('Tutorial');
        $pdf->SetKeywords('PDF');
        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);
        // remove default footer
        $pdf->setPrintFooter(false);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        // ---------------------------------------------------------
        // set font
        $pdf->SetFont('stsongstdlight', '', 14, '', true);
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output(date('YmdHis').rand(1111, 9999).'.pdf', 'I');
    }
}