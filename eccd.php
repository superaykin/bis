<?php
    // configuration
    require("includes/config.php");

    if($_SERVER["REQUEST_METHOD"] === "POST") {


    }
  	else {

  		if(isset($_GET["page"])) {
        $page = valinput($_GET["page"]);

        if($page == "test") {
          // get info
          if(isset($_GET["id"])) {
            $id = valinput($_GET["id"]); // test id
          } else { gotomain(); }

          $eccdinfo = get_eccd_test_info($id);
          if(count($eccdinfo) <> 1) {
            gotomain();
          } else {
            $eccdinfo = $eccdinfo[0];
          }
          // get scores
          $eccdscore = get_eccd_test_score($id);
          // get entity info
          $info = get_entity_info($eccdinfo["entity_id"]);
          // get center info
          $classinfo = get_class_info($eccdinfo["class_id"]);
          render("./eccd/testinfo.php", ["info" => $info[0], "eccdinfo" => $eccdinfo, "eccdscore" => $eccdscore, "classinfo" => $classinfo[0]]);
        } elseif($page == "report") {

          $centers = get_centers();
          render("./eccd/report.php", ["centers" => $centers]);

        } else {
          gotomain();
        }
      } else {
        gotomain();
      }
  	}
?>
