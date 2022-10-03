<?php
    // configuration
    require("includes/config.php");
    if($_SERVER["REQUEST_METHOD"] === "POST") {
      gotomain();
    }
  	else {
      if(isset($_GET["page"])) {
        $page = valinput($_GET["page"]);
        if($page == "401") {
          // error 401
          render("./system/system_error401.php");
        }
        else if($page == "error") {
          render("./system/system_error.php");
        }
      }
  	}
?>
