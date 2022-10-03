<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      // verify values
      $ln = valinputupper($_POST["ln"]);
      $fn = valinputupper($_POST["fn"]);
      $mn = valinputupper($_POST["mn"]);
      $arr = [];
      $res = lookup($ln, $fn);
      if($res === false) {
        $arr = [
          "status" => "NORESULTS",
        ];
      } else {
        $arr = [
          "status" => "SUCCESS",
          "data" => $res
        ];
      }
      echo json_encode($arr);
    }
    else
    {
		    exit("ERROR");
    }
?>
