<?php
    // configuration
    require("includes/config.php");

    if($_SERVER["REQUEST_METHOD"] === "POST") {


    }
  	else {

      // count profiles
      $entitycount = count_entity();

      $latest_profile_entries = get_profile_entries("DESC");

  		render("main.php",["entitycount" => $entitycount,
        "latestprofiles" => $latest_profile_entries
      ]);
  	}
?>
