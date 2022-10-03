<?php
    // configuration
    require("includes/config.php");
    require('includes/fpdf/pdf_js.php');

    function default_width($mode = "P") {
      if($mode === "P") {
        return 185;
      } else {
        return 325;
      }
    }

    class PDF_AutoPrint extends PDF_JavaScript
    {
      function AutoPrint($printer='')
      {
        // Open the print dialog
        if($printer)
        {
          $printer = str_replace('\\', '\\\\', $printer);
          $script = "var pp = getPrintParams();";
          $script .= "pp.interactive = pp.constants.interactionLevel.full;";
          $script .= "pp.printerName = '$printer'";
          $script .= "print(pp);";
        }
        else
          $script = 'print(true);';
        $this->IncludeJS($script);
      }
    }
    // FONT SIZE SETTINGS ------------------
    $text12 = 12; // header
    $text10 = 10; // title
    $text9  = 9;
    $text8  = 8; // normal text
    $text7  = 7;
    $text6  = 6;
    $text5  = 5; // normal text

    // PADS
    $minpad = 8;
    $maxpad = 13;
    // -------------------------------------


    if($_SERVER["REQUEST_METHOD"] === "POST") {

    }
  	else {

      if(isset($_GET["reptype"])) {
        if(isset($_GET["sy"])) {
          $sy = valinput($_GET["sy"]);
        } else { error401(); }
        $reptype = valinput($_GET["reptype"]);

        // CDC LIST REPORT ========================================================================================================================
        if($reptype == "cdclisting") {

          $res = query("SELECT
            	src.centername,
            	SUM(src.population) AS population,
            	SUM(src.ips) AS ips,
            	SUM(src.female) AS female,
            	SUM(src.male) AS male,

            	SUM(src.aod) AS aod,
            	SUM(src.haod) AS haod,
            	SUM(src.threemons) AS threemons,
            	SUM(src.sixmons) AS sixmons,
            	SUM(src.saod) AS saod,

            	SUM(src.n) AS n,
            	SUM(src.ow) AS ow,
            	SUM(src.sow) AS sow,
            	SUM(src.suw) AS suw,
            	SUM(src.uw) AS uw

            FROM (
            	SELECT
            		dc.centername,
            		1 AS population,
            		CASE WHEN e.ips = 'YES' THEN 1 ELSE 0 END AS ips,
            		CASE WHEN e.sex = 'FEMALE' THEN 1 ELSE 0 END AS female,
            		CASE WHEN e.sex = 'MALE' THEN 1 ELSE 0 END AS male,

            		CASE WHEN ei.interpretation = 'AVERAGE OVERALL DEVELOPMENT' THEN 1 ELSE 0 END AS aod,
            		CASE WHEN ei.interpretation = 'HIGHLY ADVANCED OVERALL DEVELOPMENT' THEN 1 ELSE 0 END AS haod,
            		CASE WHEN ei.interpretation = 'OVERALL DEVELOPMENT MUST BE MONITORED AFTER 3 MONTHS' THEN 1 ELSE 0 END AS threemons,
            		CASE WHEN ei.interpretation = 'OVERALL DEVELOPMENT MUST BE MONITORED AFTER 6 MONTHS' THEN 1 ELSE 0 END AS sixmons,
            		CASE WHEN ei.interpretation = 'SLIGHTLY ADVANCED OVERALL DEVELOPMENT' THEN 1 ELSE 0 END AS saod,

            		CASE WHEN nh.nstat_id = 'N' THEN 1 ELSE 0 END AS n,
            		CASE WHEN nh.nstat_id = 'OW' THEN 1 ELSE 0 END AS ow,
            		CASE WHEN nh.nstat_id = 'SOW' THEN 1 ELSE 0 END AS sow,
            		CASE WHEN nh.nstat_id = 'SUW' THEN 1 ELSE 0 END AS suw,
            		CASE WHEN nh.nstat_id = 'UW' THEN 1 ELSE 0 END AS uw

            	FROM class_listing AS cl
            		LEFT JOIN class AS c
            			ON c.cid = cl.class_id
            		LEFT JOIN devcenter AS dc
            			ON dc.cdc_id = c.center_id
            		LEFT JOIN entity AS e
            			ON e.eid = cl.entity_id

            		LEFT JOIN eccd_interpretation AS ei
            			ON ei.esi_id =
            				(SELECT eii.esi_id FROM eccd_interpretation AS eii
            				WHERE eii.student_id = cl.sid
            				ORDER BY eii.test_date DESC
            				LIMIT 1)
            		LEFT JOIN nutritional_history AS nh
            			ON nh.nh_id =
            				(SELECT nhh.nh_id FROM nutritional_history AS nhh
            				WHERE nhh.student_id = cl.sid
            				ORDER BY nhh.ns_testdate DESC
            				LIMIT 1)

            	WHERE c.schoolyear = ?
            ) AS src
            GROUP BY src.centername
            ORDER BY src.centername ASC", $sy);

          // RENDER THE PDF
          $mode = "L"; // landscape
          $defwidth = default_width($mode);

          // generate the pdf
          $pdf = new PDF_AutoPrint();
        	$title = "eCMS - Report";
        	$pdf->SetTitle($title);

        	$pdf->SetMargins(15,10);
        	$pdf->AddPage('L','Legal');
        	$pdf->SetFont('Arial','', $text6);
        	$pdf->Image('./public/images/forms/panabo.png', 120,8,15);
        	$pdf->Image('./public/images/forms/dswd.png',220,8,14);
          $pdf->Cell($defwidth,3,'REPUBLIC OF THE PHILIPPINES',0,'','C');
        	$pdf->Ln();
        	$pdf->Cell($defwidth,3,'PROVINCE OF DAVAO DEL NORTE',0,'','C');
        	$pdf->Ln();
        	$pdf->Cell($defwidth,3,'CITY OF PANABO','0','','C');
          $pdf->Ln();
          $pdf->Ln();
          $pdf->SetFont('Arial','B', $text6);
          $pdf->Cell($defwidth,3,'CITY SOCIAL WELFARE AND DEVELOPMENT OFFICE',0,'','C');
          $pdf->Ln();
          $pdf->SetFont('Arial','', $text6);
          $pdf->Cell($defwidth,3,'ECCD REPORT',0,'','C');
          $pdf->Ln();

          // LINE --------------------------------------
          $pdf->Cell($defwidth,2,' ','B','','C');

          $pdf->Ln(5);


          $pdf->SetFont('Arial','', $text6);
          $pdf->Cell(20,2,'Report Type:','','','');
          $pdf->SetFont('Arial','B', $text6);
          $pdf->Cell(50,2,'CENTERS REPORT PER SY','B','','');

          $pdf->SetFont('Arial','', $text6);
          $pdf->Cell(20,2,'Schoolyear:','','','C');
          $pdf->SetFont('Arial','B', $text6);
          $pdf->Cell(50,2, $sy,'B','','');

          $pdf->Ln(5);
          // START OF THE REPORT TABLE
          $pdf->SetFont('Arial','B', $text5);
          $pdf->Cell(5,8, '#','1','','');
          $pdf->Cell(50,8, 'CENTER','1','','C');

          $pdf->Cell(60,4, 'POPULATION','1','','C');
          $pdf->Cell(105,4, 'ECCD','1','','C');
          $pdf->Cell(105,4, 'NUTRITIONAL STATUS','1','','C');
          $pdf->Ln();

          $pdf->Cell(55,8); // spacing
          $pdf->Cell(15,4, 'TOTAL','1','','C');
          $pdf->Cell(15,4, 'MALE','1','','C');
          $pdf->Cell(15,4, 'FEMALE','1','','C');
          $pdf->Cell(15,4, 'IPs Member','1','','C');


          $pdf->Cell(21,4, 'HIGHLY ADVANCED','1','','C');
          $pdf->Cell(21,4, 'SLIGHTLY ADVANCED','1','','C');
          $pdf->Cell(21,4, 'AVERAGE','1','','C');
          $pdf->Cell(21,4, 'AFTER 3 MONTHS','1','','C');
          $pdf->Cell(21,4, 'AFTER 6 MONTHS','1','','C');
          $pdf->Cell(21,4, 'NORMAL','1','','C');
          $pdf->Cell(21,4, 'OVER-WEIGHT','1','','C');
          $pdf->Cell(21,4, 'SEVERE OW','1','','C');
          $pdf->Cell(21,4, 'UNDER-WEIGHT','1','','C');
          $pdf->Cell(21,4, 'SEVERE UW','1','','C');
          $pdf->Ln();

          $pdf->SetFont('Arial','', $text5);
          $c = 1;

          foreach($res AS $r) {
            $pdf->Cell(5,4, $c,'1','','');
            $pdf->Cell(50,4, $r["centername"],'1','','C');

            $pdf->Cell(15,4, $r["population"],'1','','C');
            $pdf->Cell(15,4, $r["male"],'1','','C');
            $pdf->Cell(15,4, $r["female"],'1','','C');
            $pdf->Cell(15,4, $r["ips"],'1','','C');

            $pdf->Cell(21,4, $r["haod"],'1','','C');
            $pdf->Cell(21,4, $r["saod"],'1','','C');
            $pdf->Cell(21,4, $r["aod"],'1','','C');
            $pdf->Cell(21,4, $r["threemons"],'1','','C');
            $pdf->Cell(21,4, $r["sixmons"],'1','','C');

            $pdf->Cell(21,4, $r["n"],'1','','C');
            $pdf->Cell(21,4, $r["ow"],'1','','C');
            $pdf->Cell(21,4, $r["sow"],'1','','C');
            $pdf->Cell(21,4, $r["uw"],'1','','C');
            $pdf->Cell(21,4, $r["suw"],'1','','C');
            $pdf->Ln();
            $c++;
          }




          $pdf->Ln(5);
          $pdf->SetFont('Arial','', $text5);
          $pdf->Cell(325,4, '++++ Nothing follows ++++','1','','C');
          $pdf->Ln(10);

          $pdf->SetFont('Arial','', $text6);
          $pdf->Cell(20,3,'Prepared by:','','','');
          $pdf->Ln(10);
          $pdf->SetFont('Arial','B', $text6);
          $pdf->Cell(20,3, $GLOBALS["_fullname"],'','','');

          $pdf->Ln(5);
          $pdf->SetFont('Arial','I', $text5);
          $pdf->Cell(20,3, '*This form is generated by eCMS on ' . date("Y-m-d H:i:s"),'','','');

          $pdf->AutoPrint();
        	$pdf->Output();





        // CDC INFO - WITH CHILD LIST REPORT ======================================================================================================
        } elseif($reptype == "cdcinfo") {
          if(isset($_GET["cdc"])) {
            $center_id = valinput($_GET["cdc"]);
          }

          $center = get_center_info($center_id);

          // query the list
          $res = query("SELECT c.class_name, e.*,
            	(SELECT interpretation FROM eccd_interpretation WHERE entity_id = cl.entity_id
                ORDER BY test_date DESC LIMIT 1) AS interpretation,
            	(SELECT ns.nstat FROM nutritional_history AS nh
              		LEFT JOIN sys_nutrition_stat AS ns ON nh.nstat_id = ns.nstat_code
              	WHERE nh.entity_id = cl.entity_id
              	ORDER BY ns_testdate DESC LIMIT 1) AS nstat
            FROM class_listing AS cl
            	LEFT JOIN entity AS e ON cl.entity_id = e.eid
            	LEFT JOIN class AS c ON cl.class_id = c.cid
            WHERE c.center_id = ? AND c.schoolyear = ?
            ORDER BY e.lastname ASC", $center_id, $sy);
          if($res === false) {
            throw_error("get_list_error");
          }

          // default Portrait size
          // 185 width
          $mode = "L"; // landscape
          $defwidth = default_width($mode);


          // generate the pdf
          $pdf = new PDF_AutoPrint();
        	$title = "eCMS - Report";
        	$pdf->SetTitle($title);

        	$pdf->SetMargins(15,10);
        	$pdf->AddPage('L','Legal');
        	$pdf->SetFont('Arial','', $text6);
        	$pdf->Image('./public/images/forms/panabo.png', 120,8,15);
        	$pdf->Image('./public/images/forms/dswd.png',220,8,14);
          $pdf->Cell($defwidth,3,'REPUBLIC OF THE PHILIPPINES',0,'','C');
        	$pdf->Ln();
        	$pdf->Cell($defwidth,3,'PROVINCE OF DAVAO DEL NORTE',0,'','C');
        	$pdf->Ln();
        	$pdf->Cell($defwidth,3,'CITY OF PANABO','0','','C');
          $pdf->Ln();
          $pdf->Ln();
          $pdf->SetFont('Arial','B', $text6);
          $pdf->Cell($defwidth,3,'CITY SOCIAL WELFARE AND DEVELOPMENT OFFICE',0,'','C');
          $pdf->Ln();
          $pdf->SetFont('Arial','', $text6);
          $pdf->Cell($defwidth,3,'ECCD REPORT',0,'','C');
          $pdf->Ln();

          // LINE --------------------------------------
          $pdf->Cell($defwidth,2,' ','B','','C');

          $pdf->Ln(5);


          $pdf->SetFont('Arial','', $text6);
          $pdf->Cell(20,2,'Report Type:','','','');
          $pdf->SetFont('Arial','B', $text6);
          $pdf->Cell(50,2,'CENTER SPECIFIC REPORT PER SY','B','','');

          $pdf->SetFont('Arial','', $text6);
          $pdf->Cell(20,2,'Center:','','','C');
          $pdf->SetFont('Arial','B', $text6);
          $pdf->Cell(50,2, $center["centername"],'B','','');

          $pdf->SetFont('Arial','', $text6);
          $pdf->Cell(20,2,'Schoolyear:','','','C');
          $pdf->SetFont('Arial','B', $text6);
          $pdf->Cell(50,2, $sy,'B','','');


          $pdf->Ln(5);
          $pdf->SetFont('Arial','B', $text5);
          $pdf->Cell(5,4, '#','1','','');
          $pdf->Cell(50,4, 'NAME','1','','C');
          $pdf->Cell(80,4, 'ADDRESS','1','','C');
          $pdf->Cell(20,4, 'SEX','1','','C');
          $pdf->Cell(20,4, 'IPs','1','','C');
          $pdf->Cell(40,4, 'DATE OF BIRTH','1','','C');
          $pdf->Cell(40,4, 'NUTRITIONAL STATUS','1','','C');
          $pdf->Cell(70,4, 'ECCD INTERPRETATION','1','','C');
          $pdf->Ln();

          $pdf->SetFont('Arial','', $text5);
          $c = 1;


          foreach($res AS $r) {
            $pdf->Cell(5,4, $c,'1','','');
            $pdf->Cell(50,4, name_format($r["lastname"], $r["firstname"], $r["middlename"], $r["suffix"], "LF"),'1','','');
            $pdf->Cell(80,4, address_format($r["address_city"], $r["address_brgy"], $r["address_street"]),'1','','');
            $pdf->Cell(20,4, $r["sex"],'1','','C');
            $pdf->Cell(20,4, $r["ips"],'1','','C');
            $pdf->Cell(40,4, $r["birthdate"],'1','','C');
            $pdf->Cell(40,4, $r["nstat"],'1','','C');
            $pdf->Cell(70,4, $r["interpretation"],'1','','C');
            $pdf->Ln();

            $c++;


          }

          $pdf->SetFont('Arial','', $text5);
          $pdf->Cell(325,4, '++++ Nothing follows ++++','1','','C');
          $pdf->Ln(10);

          $pdf->SetFont('Arial','', $text6);
          $pdf->Cell(20,3,'Prepared by:','','','');
          $pdf->Ln(10);
          $pdf->SetFont('Arial','B', $text6);
          $pdf->Cell(20,3, $GLOBALS["_fullname"],'','','');

          $pdf->Ln(5);
          $pdf->SetFont('Arial','I', $text5);
          $pdf->Cell(20,3, '*This form is generated by eCMS on ' . date("Y-m-d H:i:s"),'','','');

          $pdf->AutoPrint();
        	$pdf->Output();




        // ========================================================================================================================================
        } else {
          error401();
        }
      } else {
        error401();
      }


  	}
?>
