<?php
    // configuration
    require("includes/config.php");

    if($_SERVER["REQUEST_METHOD"] === "POST") {


    }
  	else {

  		if(isset($_GET["page"])) {
        $page = valinput($_GET["page"]);

        if($page == "registration") {
          // filter user access
          $allowed = ["ENTITY_USER", "ENTITY_ADMIN", "CARDINAL"]; // allowed roles
          if(is_allowed($allowed) == false) {
            error401(); // throw an error
          }

          $city = get_city();
          render("./entity/registration.php", ["city" => $city]);

        } else if($page == "list") {
          // count entity
          $sexcount = count_entity_sex();
          $ipscount = count_entity_ips();
          $fourpscount = count_entity_4ps();

          $list = get_entity();
          render("./entity/list.php", ["entity" => $list, "sexcount" => $sexcount, "ipscount" => $ipscount, "fourpscount" => $fourpscount]);

        } else if($page == "info") {
          // get info
          if(isset($_GET["id"])) {
            $id = valinput($_GET["id"]);
          } else { redirect("./"); }

          $info = get_entity_info($id);
          if(count($info) <> 1) {
            redirect("./");
          }

          $eccd = get_eccd_history($id);
          $class = get_class_enrolled($id);
          $nstat = get_nstat_history($id);
          render("./entity/profile.php", ["info" => $info[0], "eccd" => $eccd, "class" => $class, "nstat" => $nstat]);

        } else if($page == "update") {
          // filter user access
          $allowed = ["ENTITY_USER", "ENTITY_ADMIN", "CARDINAL"]; // allowed roles
          if(is_allowed($allowed) == false) {
            error401(); // throw an error
          }

          // get info
          if(isset($_GET["id"])) {
            $id = valinput($_GET["id"]);
          } else { redirect("./"); }

          $info = get_entity_info($id);
          if(count($info) <> 1) {
            redirect("./");
          } else { $info = $info[0]; }

          $city = get_city();

          // json data
          $json = [
            "add_a" => $info["address_city"],
            "add_b" => $info["address_brgy"]
          ];

          render("./entity/update.php", ["info" => $info, "city" => $city, "json" => json_encode($json)]);
        } else {
          redirect("./");
        }
      } else {
        redirect("./");
      }
  	}
?>
