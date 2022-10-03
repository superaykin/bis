<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $parent = valinput($_POST["city"]);
      $res = get_brgy($parent);
      $arr = [];
      if(count($res) >= 1) {
        $arr = [
          "status" => "SUCCESS",
          "data" => $res
        ];
      } else {
        $arr = [
          "status" => "NORESULTS"
        ];
      }

      echo json_encode($arr);
    }
    else
    {
		    exit("ERROR");
    }
?>
