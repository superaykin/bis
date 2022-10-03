<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      // validate
      $cid = valinput($_POST["cid"]); // class id
      $eid = valinput($_POST["eid"]); // entity id
      $sid = valinput($_POST["sid"]); // student id

      $res_arr = [];
      $res = get_eccd_history($eid, $sid);
      if(count($res) >= 1) {
        $res_arr = [
          "status" => "RESULTFOUND",
          "data" => $res
        ];
      } else {
        $res_arr = [
          "status" => "NORESULTS"
        ];
      }

      echo json_encode($res_arr);

    }
    else
    {
		    exit("ERROR");
    }
?>
