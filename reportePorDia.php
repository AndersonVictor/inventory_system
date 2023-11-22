<?php
   require_once('Controllers/load.php');
   require('fpdf/fpdf.php');
   $fechaInicio=$_GET["diaHoy"];
   $fechaFinal=$_GET["diaHoy"];

?>       
<?php
   
if (!empty($_GET["diaHoy"])) {
   

   class PDF extends FPDF
   {

      // Cabecera de página
      function Header()
      {
         
         $this->Image('fpdf/logo.png', 170, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
         $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
         $this->Cell(45); // Movernos a la derecha
         $this->SetTextColor(0, 0, 0); //color
         //creamos una celda o fila
         $this->Cell(110, 15, utf8_decode("FERRETERIA GREYS"), 1, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
         $this->Ln(3); // Salto de línea
         $this->SetTextColor(103); //color

         /* UBICACION */
         $this->Cell(90);  // mover a la derecha
         $this->SetFont('Arial', 'B', 10);
         $this->Cell(96, 10, utf8_decode("Ubicación : Pje. Tovar N° 201, El Tambo, Huancayo"), 0, 0, '', 0);
         $this->Ln(5);

         /* TELEFONO */
         $this->Cell(90);  // mover a la derecha
         $this->SetFont('Arial', 'B', 10);
         $this->Cell(59, 10, utf8_decode("Teléfono : 987654321"), 0, 0, '', 0);
         $this->Ln(5);

         /* RUC */
         $this->Cell(90);  // mover a la derecha
         $this->SetFont('Arial', 'B', 10);
         $this->Cell(85, 10, utf8_decode("Ruc : "), 0, 0, '', 0);
         $this->Ln(10);

         /* Fecha */
         $this->Cell(90);  // mover a la derecha
         $this->SetFont('Arial', 'B', 10);
         $this->Cell(85, 10, utf8_decode("Fecha de reporte de Hoy: ".$_GET["diaHoy"]), 0, 0, '', 0);
         $this->Ln(10);

         /* TITULO DE LA TABLA */
         //color
         $this->SetTextColor(65, 90, 119);
         $this->Cell(45); // mover a la derecha
         $this->SetFont('Arial', 'B', 15);
         $this->Cell(100, 10, utf8_decode("REPORTE DE VENTAS POR FECHA"), 0, 1, 'C', 0);
         $this->Ln(7);

         /* CAMPOS DE LA TABLA */
         //color
         $this->SetFillColor(13, 27, 42); //colorFondo
         $this->SetTextColor(255, 255, 255); //colorTexto
         $this->SetDrawColor(163, 163, 163); //colorBorde
         $this->SetFont('Arial', 'B', 11);
         $this->Cell(18, 10, utf8_decode('N°'), 1, 0, 'C', 1);
         $this->Cell(45, 10, utf8_decode('MATERIAL'), 1, 0, 'C', 1);
         $this->Cell(30, 10, utf8_decode('PRECIO'), 1, 0, 'C', 1);
         $this->Cell(30, 10, utf8_decode('CANTIDAD'), 1, 0, 'C', 1);
         $this->Cell(35, 10, utf8_decode('TOTAL'), 1, 0, 'C', 1);
         $this->Cell(30, 10, utf8_decode('FECHA'), 1, 1, 'C', 1);
      }

      // Pie de página
      function Footer()
      {
         $this->SetY(-15); // Posición: a 1,5 cm del final
         $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
         $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

         $this->SetY(-15); // Posición: a 1,5 cm del final
         $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
         $hoy = date('d/m/Y');
         $this->Cell(350, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
      }
   }

   
   /* CONSULTA INFORMACION DE LA VENTAS Y MATERIALES */
   $reportVentas = reportVentas($fechaInicio,$fechaFinal);
   
   $pdf = new PDF();
   $pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
   $pdf->AliasNbPages(); //muestra la pagina / y total de paginas

   $i = 0;
   $pdf->SetFont('Arial', '', 12);
   $pdf->SetDrawColor(163, 163, 163); //colorBorde

   foreach ($reportVentas as $report):
      /* TABLA */
      $pdf->Cell(18, 10, utf8_decode($report['id']), 1, 0, 'C', 0);
      $pdf->Cell(45, 10, utf8_decode($report['name']), 1, 0, 'C', 0);
      $pdf->Cell(30, 10, utf8_decode($report['sale_price']), 1, 0, 'C', 0);
      $pdf->Cell(30, 10, utf8_decode($report['qty']), 1, 0, 'C', 0);
      $pdf->Cell(35, 10, utf8_decode($report['price']), 1, 0, 'C', 0);
      $pdf->Cell(30, 10, utf8_decode($report['date']), 1, 1, 'C', 0);
   endforeach;
   


   $pdf->Output('Reporte_de_Ventas.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
}

?>       