<?php
    // configuration
    require("includes/config.php");
    $allowed = ["CARDINAL", "SYS_ADMIN"];
    if(is_allowed($allowed) == false) {
      gotomain();
    }


    if($_SERVER["REQUEST_METHOD"] === "POST") {


    }
  	else {

      if(isset($_GET["page"])) {

        $page = valinput($_GET["page"]);
        if($page == "users") {

          $get_users = sys_get_users();
          render("./system/users.php", ["users" => $get_users]);
        }
        else if($page == "account") {
          if(isset($_GET["id"])) {
            $id = valinput($_GET["id"]);

            $user = sys_get_user_info($id);
            $roles = sys_get_user_roles($id);
            $avail_roles = sys_get_available_roles($id);
            $actions = sys_get_action_logs($id);

            render("./system/account.php", ["user" => $user[0], "roles" => $roles, "available_roles" => $avail_roles, "actions" => $actions]);
          } else {
            gotomain();
          }
        } else if($page == "locations") {

          $locations = sys_get_locations();
          render("./system/locations.php", ["locations" => $locations]);
        }

        else if($page == "401") {
          // error 401
          render("./system/system_error401.php");
        }
        else if($page == "error") {
          render("./system/system_error.php");
        }
        else {

        }

      }

      else {
        gotomain();
      }
  	}
?>
