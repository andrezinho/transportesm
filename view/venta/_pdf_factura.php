<?php
session_start();
require("../lib/fpdf/fpdf.php");
require("../lib/num2letra.php");
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

                
	}
	function Footer()
	{

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
	function FancyTable($head,$detalle,$txttotal)
	{   
            $i = 0;
            $h = 6;
            $w = $this->widths;
            $border = '';
            $this->SetFont('Times','',11);		            
            
            //Numero de Boleta
            $this->Cell(0,25,'',0,1,'C');
            $this->Cell(150,$h,'',$border,0,'C',false);
            $this->Cell(10, $h,  utf8_decode($head->serie." - N° ".$head->numero), $border, 1, 'C', false);
            
            //Pasajero
            $this->Cell(0,5,'',0,1,'C');
            $this->Cell(20,$h,utf8_decode("Señor(es): "),0,0);
            $this->Cell(120,$h,utf8_decode(strtoupper($head->nombre)),$border,1,'L',false);            
            $this->Cell(20,$h,utf8_decode("Direccion: "),0,0);
            $this->Cell(100,$h,utf8_decode(strtoupper($head->direccion)),$border,0,'L',false);
            $this->Cell(10,$h,utf8_decode("Guia de Remision"),0,0);
            $this->Cell(10, $h,$head->guia_remision, $border, 1, 'L', false);
            $this->Cell(20,$h,utf8_decode("RUC: "),0,0);
            $this->Cell(100,$h,utf8_decode(strtoupper($head->nrodoc)),$border,0,'L',false);
            $this->Cell(10, $h,"Fecha: ".$this->ffecha($head->fecha), $border, 1, 'L', false);
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
                $this->Cell(125,$h,$r[1],0,0,'L',false);
                $this->Cell(20,$h,$r[2],0,0,'R',false);
                $this->Cell(20,$h,number_format($importe,2),0,1,'R',false);
            }
            for($i=0;$i<(6-$cont);$i++)
            {
                $this->Cell(15,$h,'',0,0,'C',false);
                $this->Cell(125,$h,'',0,0,'L',false);
                $this->Cell(20,$h,'',0,0,'R',false);
                $this->Cell(20,$h,'',0,1,'R',false);
            }
            
            //Foot                       
            $this->Cell(140,$h,'',0,1,'C');            
            $this->Cell(0,$h,'',0,1,'C');
            $this->Cell(70,$h,'',0,0,'C');
            $f = explode("-", $head->fecha);
            $this->Cell(15,$h,$f[2]."   ".$f[1]."   ".$f[0],0,0,'L');
            
            //Total
            //$pdf->Text(25,102,number_format($total,2));
            $x = $this->GetX();
            $y = $this->GetY();            
            $this->SetXY(170,104);
            $this->Cell(20,$h,number_format($total,2),0,0,'R');
            $this->SetXY(170,104+$h);
            $this->Cell(20,$h,number_format(0,2),0,0,'R');
            $this->SetXY(170,104+$h+$h);
            $this->Cell(20,$h,number_format($total,2),0,0,'R');
	}
}
function getTotal($rows)
{
    $total = 0;
    foreach($rows as $r)
    {
        $total += $r[0]*$r[2];
    }
    return $total;
}
$pdf=new PDF();
$pdf->SetMargins(10,7,10);
$maxw=200;
$w = array(15,140,15,15);
$total = getTotal($detalle);

$pdf->setValues($maxw,$w);
$orientacion = 'P';
$pdf->AddPage($orientacion);
$pdf->AliasNbPages();
$pdf->FancyTable($head,$detalle,$txttotal);

$con=substr(number_format(10,2), -2,2);
if($con!="00") {$con=" CON ".$con."/100 NUEVOS SOLES";}
else $con=" NUEVOS SOLES";
$pdf->Text(25,108,num2letra(floor($total)).$con);


$pdf->Output();
?>