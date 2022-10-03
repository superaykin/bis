<?php
    // configuration
    require("includes/config.php");

    if($_SERVER["REQUEST_METHOD"] === "POST") {


    }
  	else {

      // count profiles
      $entitycount = count_entity();
      $classcount = count_class();
      $centercount = count_center();
      $teachercount = count_teacher();
      $brgycenter = get_center_count_per_brgy();

  		render("main.php",["entitycount" => $entitycount, "classcount" => $classcount,
        "centercount" => $centercount, "teachercount" => $teachercount, "brgycenter" => $brgycenter]);
  	}
?>
