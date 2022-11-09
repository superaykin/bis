<?php
    // configuration
    require("includes/config.php");

    if($_SERVER["REQUEST_METHOD"] === "POST") {


    }
  	else {

  		if(isset($_GET["page"])) {
        $page = valinput($_GET["page"]);

        if($page == "new") {
          $centers = get_centers_specific($GLOBALS["_uid"]);
          render("./class/new.php", ["centers" => $centers]);

        } else if($page == "list") {
          $list = get_class_listing();
          render("./class/list.php", ["class" => $list]);

        } else if($page == "info") {
          if(isset($_GET["id"])) {
            $id = valinput($_GET["id"]);

            $info = get_class_info($id);
            if(count($info) <> 1) {
              gotomain();
            } else { $info = $info[0]; }

            $entity = get_unenrolled($info["schoolyear"]);
            $enrolled = get_class_students($id);
            $eccd = get_eccd_list();
            $nstat = sys_get_nutritional_stat();
            $stat = get_class_statistics($id); // class statistics
            $available_class = get_available_class($id, $info["schoolyear"]);

            render("./class/info.php", ["info" => $info, "entity" => $entity, "students" => $enrolled, "eccd" => $eccd, "nstat" => $nstat, "stat" => $stat,
              "av_class" => $available_class
            ]);

          } else {
            gotomain();
          }

        } else if($page == "transferlist") {
          // class request trasnfers
          $list = get_transfer_request();
          render("./class/transferlist.php", ["requests" => $list]);

        } else if($page == "transreqinfo") {
          // class request info
          if(isset($_GET["tid"])) {
            $trans_id = valinput($_GET["tid"]);
          } else {
            //gotomain();
            exit("NO ID SELECTED");
          }
          $info = get_transfer_request_info($trans_id);
          render("./class/transferinfo.php", ["info" => $info]);
        } else {
          gotomain();
        }
      } else {
        gotomain();
      }
  	}
?>
