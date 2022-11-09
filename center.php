<?php
    // configuration
    require("includes/config.php");

    if($_SERVER["REQUEST_METHOD"] === "POST") {


    }
  	else {

  		if(isset($_GET["page"])) {
        $page = valinput($_GET["page"]);

        if($page == "list") {
          $center = get_centers();
          render("./center/list.php", ["center" => $center]);
        } else if($page == "info") {
          if(isset($_GET["id"])) {
            $centerid = valinput($_GET["id"]);
          } else {
            error_401(); // throw error
          }

          $info = get_center_info($centerid);
          $teachers = get_center_teacher($centerid);
          $class = get_center_class($centerid);
          $avail_teacher = get_available_teacher($centerid);

          render("./center/info.php", ["info" => $info, "teachers" => $teachers, "class" => $class, "avail_teacher" => $avail_teacher]);
        } else if($page == "new") {
          if(lookup_role('SYS_ADMIN') == false AND lookup_role('CARDINAL') == false) {
            error401();
          }
          $brgy = get_brgy('PANABO'); // get all barangay under panabo
          render("./center/new.php", ["brgy" => $brgy]);
        }
      } else {
        gotomain();
      }
  	}
?>
