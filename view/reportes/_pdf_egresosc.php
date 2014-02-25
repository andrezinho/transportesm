<?php
session_start();
require("../lib/fpdf/fpdf.php");
class PDF extends FPDF
{
        var $fechai;
        var $fechaf;
        var $maxw;
        var $widths;
        
        public function setValues($fechai,$fechaf,$maxw,$widths)
        {
            $this->fechai = $fechai;
            $this->fechaf = $fechaf;
            $this->maxw = $maxw;
            foreach($widths as $w)
            {
                $this->widths[] = $w;
            }
        }
        
	function Header()
	{                
                $maxw = $this->maxw;
                $this->SetLineWidth(0.1);                
                //$this->Image('../../../images/logo.jpg',10,5,28);
                $this->SetFont('Arial','B',12);
                $this->Ln();
                $this->SetXY(9,8);
                $this->Write(0,'REPORTE DE EGRESOS POR FECHA');		
                $this->Line(9,10,$maxw,10);
                $this->SetFont('Times','',9);
                $this->SetXY(9,12);
                $this->Write(0, 'FECHA INICIAL: '.$this->fechai.'     FECHA FINAL: '.$this->fechaf);
                $this->SetFont('Times','',7);
                $this->SetXY($maxw-17,12);
                $fecha = date('d-M-Y');
                $this->Write(0,$fecha);
                $this->Ln(8);		
                
		$this->SetFont('Times','B',7);		
		$this->SetFillColor(245, 245, 245);
                $this->SetTextColor(0,0,0); 
                $this->SetDrawColor(0,0,0);
                $fill = true;
                $h = 4;
                $border = "TBLR";
                
		        $this->Cell($this->widths[0], $h, 'ITEM', $border, 0, 'C',$fill);                
                $this->Cell($this->widths[1], $h, 'CONCEPTO', $border, 0, 'C',$fill);
                $this->Cell($this->widths[2], $h, 'PROVEEDOR', $border, 0, 'C',$fill);
                $this->Cell($this->widths[3], $h, 'FECHA', $border, 0, 'C',$fill);
                $this->Cell($this->widths[4], $h, 'COMPROBANT', $border, 0, 'C',$fill);
                $this->Cell($this->widths[5], $h, 'NUM. COMPR.', $border, 0, 'C',$fill);
                $this->Cell($this->widths[6], $h, 'OBSERVACION', $border, 0, 'C',$fill);
                $this->Cell($this->widths[7], $h, 'MONTO', $border, 0, 'C',$fill);
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
	function FancyTable($rowsi,$rows)
	{
            $tingreso = 0;
            $tegresos = 0;
            $saldo = 0;
            $i = 0;
            $h = 4;
            $w = $this->widths;
            $border = 'BLRT';
            $this->SetFont('Times','',5);	
            $this->SetLineWidth(0.1);   
            $to=0;
            foreach($rowsi as $r)
            {
                $i += 1;
                $this->background(1);
                $fill = true;
                $this->Cell($w[0], $h,str_pad($i, 3, '0', 0), $border, 0, 'C', $fill);
                $this->Cell($w[1], $h,$r['concepto'], $border, 0, 'C', $fill);                 
                $this->Cell($w[2], $h, $r['proveedor'], $border, 0, 'C', $fill);                
                $this->Cell($w[3], $h,$this->ffecha($r['fecha']), $border, 0, 'C', $fill);
                $this->Cell($w[4], $h, $r['comprobante'], $border, 0, 'C', $fill);                
                $this->Cell($w[5], $h, $r['serie_numero'], $border, 0, 'C', $fill);                
                $this->Cell($w[6], $h,$r['observacion'], $border, 0, 'C', $fill);
                $this->Cell($w[7], $h,number_format($r['monto'],2), $border, 0, 'C', $fill);
				
		        $to=$to+$r['monto'];
                $y = $this->GetY();
                $this->SetXY(10,$y+$h);
                
            }
			$this->Ln();
			$this->Cell($w[0], $h,"", 0, 0, 'C', $fill);
			$this->Cell($w[1], $h,"", 0, 0, 'C', $fill);
			$this->Cell($w[2], $h,"", 0, 0, 'C', $fill);
			$this->Cell($w[3], $h,"", 0, 0, 'C', $fill);
            $this->Cell($w[4], $h,"", 0, 0, 'C', $fill);
            $this->Cell($w[5], $h,"", 0, 0, 'C', $fill);
			$this->Cell($w[6], $h,"TOTAL", 0, 0, 'C', $fill);
			$this->Cell($w[7], $h,  number_format($to,2), 0, 0, 'C', $fill);
                        
	}
}

$pdf=new PDF();

$maxw=200;
$w = array(10,50,30,10,20,20,40,10);
$pdf->setValues($fechai, $fechaf, $maxw,$w);
$orientacion = 'P';
$pdf->AddPage($orientacion);
$pdf->AliasNbPages();
$pdf->FancyTable($rowsi,$rows);
$pdf->Output();
?>