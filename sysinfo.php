<?php
    // configuration
    require("includes/config.php");

    if($_SERVER["REQUEST_METHOD"] === "POST") {


    }
  	else {

      if(isset($_GET["page"])) {
        $page = valinput($_GET["page"]);

        if($page === "about") {
          render("about.php");
        }
      }


  	}
?>
