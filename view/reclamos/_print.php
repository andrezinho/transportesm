<?php
session_start();
require("../lib/fpdf/fpdf.php");
class PDF extends FPDF
{
  var $nro;
  function set($nro)
  {
    $this->nro = $nro;
  }
  function Header()
  {          
        
      $maxw = 200;
      $this->SetLineWidth(0.1);
      $this->SetFont('Arial','B',12);
      $this->Ln();
      $h = 5;
      $this->Cell(0, $h, 'REPORTE DE RECLAMO', 0, 1, 'C',$fill);
      $this->Cell(0, $h, utf8_decode('N° '.$this->nro), 0, 0, 'C',$fill);      
      $this->Line(9,20,$maxw,20);
      $this->Ln();
      $this->Ln();

      $this->Ln();

                
  }
  function Footer()
  {
      $this->SetY(-13);
      $this->SetFont('Arial','I',7);
      $this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
  }
  function ffecha($fecha)
  {
      $n = explode("-",$fecha);
      return $n[2]."/".$n[1]."/".$n[0];
  }        
  function background($i)
  {
      if($i%2==0)
      {
          $this->SetFillColor(245, 245, 245);
          $this->SetTextColor(0,0,0);
      }
      else 
      {
          $this->SetFillColor(255, 255, 255);
          $this->SetTextColor(0,0,0);
      }
  }
  function FancyTable($r)
  {
      $i = 0;
      $h = 5;
      $w = $this->widths;
      $border = '0';
      $this->SetFont('Arial','',11); 
      $this->SetLineWidth(0.1);   
      $this->Cell(0, $h,"EMPRESA SAN MARTIN", $border, 1, 'L', $fill);
      $this->Cell(0, $h,"FECHA: ".$r->fecha, $border, 1, 'L', $fill);
      $this->Ln();

      $this->SetFont('Arial','B',11); 
      $this->Cell(0, $h,utf8_decode("1. IDENTIFICACIÓN DEL CONSUMIDOR RECLAMANTE: "), $border, 1, 'L', $fill);
      $this->SetFont('Arial','',11); 
      $this->Cell(120, $h,utf8_decode("    Nombres y Apellidos: ".$r->nombres), $border, 1, 'L', $fill);
      $this->Cell(50, $h,utf8_decode("    DNI: ".$r->dni), $border, 1, 'L', $fill);
      $this->Cell(0, $h,utf8_decode("    Domicilio: ".$r->domicilio), $border, 1, 'L', $fill);
      
      $this->Cell(50, $h,utf8_decode("    Telefono: ".$r->telefono), $border, 1, 'L', $fill);
      $this->Cell(20, $h,utf8_decode("    email: ".$r->email), $border, 0, 'L', $fill);

      $this->Ln(10);
      $this->SetFont('Arial','B',11); 
      $this->Cell(0, $h,utf8_decode("2. IDENTIFICACIÓN DEL BIEN CONTRATADO (Servicio): "), $border, 1, 'L', $fill);      
      $this->SetFont('Arial','',11); 
      $this->Cell(120, $h,utf8_decode("    Descripcion: ".$r->servicio), $border, 0, 'L', $fill);

      $this->Ln(10);
      $this->SetFont('Arial','B',11); 
      $this->Cell(0, $h,utf8_decode("3. DETALLE DE RECLAMACION: "), $border, 1, 'L', $fill);      
      $this->SetFont('Arial','',11); 
      $this->Cell(120, $h,utf8_decode("    Tipo: ".$r->tipo), $border, 1, 'L', $fill);      
      
      $this->Cell(5,$h,'');
      $this->MultiCellp(0,$h,"Detalle: ".$r->detalle,0,'L',false);
      $this->Ln(10);
      $this->SetFont('Arial','B',11); 
      $this->Cell(5,$h,'');
      $this->MultiCellp(0,$h,"Acciones: ".$r->acciones,0,'L',false);
      //$this->Cell(120, $h,utf8_decode("    ), $border, 0, 'L', $fill);

       $to=0;
      
      $this->Ln();
      $this->Cell($w[0], $h,"", 0, 0, 'C', $fill);
      $this->Cell($w[1], $h,"", 0, 0, 'C', $fill);
      $this->Cell($w[2], $h,"", 0, 0, 'C', $fill);
      $this->Cell($w[3], $h,"", 0, 0, 'C', $fill);

                        
  }
}

$pdf=new PDF();
$pdf->set(str_pad($head->idreclamos,6,"0",0)."-".$head->anio);
$orientacion = 'P';
$pdf->AddPage($orientacion);
$pdf->FancyTable($head);
$pdf->AliasNbPages();
$pdf->Output();
?>