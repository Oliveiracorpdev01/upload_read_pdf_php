<?php

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;

require_once('fpdf/fpdf.php');
require_once('vendor/autoload.php');


class ConcatPdf extends Fpdi
{
  

  // Page header
  function Header()
  {
    // Logo
    $this->Image('logo.png', 25, 6, 20);
    // Arial bold 15
    $this->SetFont('Arial', 'B', 15);
   // $this->SetTextColor(255,255,255);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30, 10, 'code305698725', 0, 0, 'C');  //30 tamaho campo 10 altura
    // Line break
    $this->Ln(20);
  }  

  // Page footer
  function Footer()
  {
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial', 'B', 8);
    // Page number
    $this->Cell(0, 10, 'Cliente: Kelly Pereira Silveira Email: kellypsilveira@live.com Prot: 203541', 0, 0, 'C');
  }

  public $files = array();

  public function setFiles($files)
  {
    $this->files = $files;
  }

  public function concat()
  {
    foreach ($this->files as $file) {
      $pageCount = $this->setSourceFile($file);
      for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
        $pageId = $this->ImportPage($pageNo);
        $s = $this->getTemplatesize($pageId);
        $this->AddPage($s['orientation'], $s);
        $this->useImportedPage($pageId);
      }
    }
  }
}

$pdf = new ConcatPdf();
$pdf->setFiles(array('teste.pdf'));
$pdf->concat();

$pdf->Output('I', 'concat.pdf');