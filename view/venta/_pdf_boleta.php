<?php
session_start();
require("../lib/fpdf/fpdf.php");
class PDF extends FPDF
{
        var $article;
        var $unidad;
        var $maxw;
        var $widths;
        
        public function setValues($maxw,$widths)
        {            
            $this->maxw = $maxw;
            foreach($widths as $w)
            {
                $this->widths[] = $w;
            }
        }
        
	function Header()
	{                
//                $maxw = $this->maxw;
//                $this->SetLineWidth(0.2);                
//                //$this->Image('../../../images/logo.jpg',10,5,28);
//                $this->SetFont('Arial','B',12);
//                $this->Ln();
//                $this->SetXY(9,8);
//                $this->Write(0,'KARDEX');		
//                $this->Line(9,10,$maxw,10);
//                $this->SetFont('Times','',9);
//                $this->SetXY(9,12);
//                $this->Write(0, '');
//                $this->SetFont('Times','',7);
//                $this->SetXY($maxw-17,12);
//                $fecha = date('d-M-Y');
//                $this->Write(0,$fecha);
//                $this->Ln(8);		
//                
//		$this->SetFont('Times','B',7);		
//		$this->SetFillColor(245, 245, 245);
//                $this->SetTextColor(0,0,0); 
//                $this->SetDrawColor(0,0,0);
//                $fill = true;
//                $h = 4;
//                $border = "TBLR";
//                
//		$this->Cell($this->widths[0], $h, 'CODIGO', $border, 0, 'C',$fill);                
//                $this->Cell($this->widths[1], $h, 'DESCRIPCION', $border, 0, 'C',$fill);
//                $this->Cell($this->widths[2], $h, 'STOCK', $border, 0, 'C',$fill);
//                $this->Cell($this->widths[3], $h, 'UNIDAD', $border, 0, 'C',$fill);
//                //$this->Cell($this->widths[4], $h, 'PRECIO', $border, 0, 'C',$fill);                
               // $this->Ln();
                
	}
	function Footer()
	{
//            $this->SetY(-13);
//            $this->SetFont('Arial','I',7);
//            $this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
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
	function FancyTable($head,$detalle)
	{   
            $i = 0;
            $h = 6;
            $w = $this->widths;
            $border = '';
            $this->SetFont('Times','',11);		            
            
            //Numero de Boleta
            $this->Cell(0,25,'',0,1,'C');
            $this->Cell(120,$h,'',$border,0,'C',false);
            $this->Cell(10, $h,  utf8_decode($head->serie." - N° ".$head->numero), $border, 1, 'C', false);
            
            //Pasajero
            $this->Cell(0,5,'',0,1,'C');
            $this->Cell(100,$h,utf8_decode("Señor(es): ".strtoupper($head->nombre)),$border,0,'L',false);
            $this->Cell(10, $h,"Fecha: ".$this->ffecha($head->fecha), $border, 1, 'L', false);
            $this->Cell(100,$h,utf8_decode("Direccion: ".strtoupper($head->direccion)),$border,0,'L',false);
            $this->Cell(10, $h,"Doc Ident. ".$head->nrodoc, $border, 1, 'L', false);
            $this->Cell(0,1,'',0,1,'C');
            $total = 0;
            
            //Cabecera de Detalle            
            /*
            $this->Cell(15,$h,'CANT',1,0,'C',false);
            $this->Cell(95,$h,'DESCRIPCION',1,0,'L',false);
            $this->Cell(20,$h,'P.UNIT',1,0,'R',false);
            $this->Cell(20,$h,'IMPORTE',1,1,'R',false);            
             * */             
            $this->Cell(0,$h,'',0,1,'C');             
            
            $cont = 0;
            foreach($detalle as $r)
            {
                $cont += 1;
                $importe = $r[0]*$r[2];
                $total += $importe;
                $this->Cell(15,$h,$r[0],0,0,'C',false);
                $this->Cell(95,$h,$r[1],0,0,'L',false);
                $this->Cell(20,$h,$r[2],0,0,'R',false);
                $this->Cell(20,$h,number_format($importe,2),0,1,'R',false);
            }
            for($i=0;$i<(6-$cont);$i++)
            {
                $this->Cell(15,$h,'',0,0,'C',false);
                $this->Cell(95,$h,'',0,0,'L',false);
                $this->Cell(20,$h,'',0,0,'R',false);
                $this->Cell(20,$h,'',0,1,'R',false);
            }
            
            //Foot
            $this->Cell(0,5,'',0,1,'C');
            $this->Cell(80,$h,'',0,0,'C');
            $this->Cell(15,$h,"Fecha: ".$this->ffecha($head->fecha),0,0,'L');
            
            //Total
            $x = $this->GetX();
            $y = $this->GetY();            
            $this->SetXY($x+35,$y-4);
            $this->Cell(20,$h,number_format($total,2),0,0,'R');
            
	}
}

$pdf=new PDF();
$pdf->SetMargins(30,7,30);
$maxw=200;
$w = array(15,140,15,15);
$pdf->setValues($maxw,$w);
$orientacion = 'P';
$pdf->AddPage($orientacion);
$pdf->AliasNbPages();
$pdf->FancyTable($head,$detalle);
$pdf->Output();
?>