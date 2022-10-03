<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      // verify values
      $eid = valinputupper($_POST["eid"]);

      $res = query("UPDATE entity SET profile_status = ? WHERE eid = ?", 'UNLOCKED', $eid);
      if($res === false) {
        throw_error("unlock_profile_failed");
      }
      else {
        // insert to logs
        $action = 'unlock entity profile (id: ' . $eid . ')';
        $res = storetologs($action);
        if($res === false) {
          //echo 'failed'; exit();
          $res_arr = [
            "result" => "failed"
          ];
          echo json_encode($res_arr); exit();
        }
        else {
          $res_arr = [
            "result" => "success"
          ];
          echo json_encode($res_arr); exit();
        }
      }


    }
    else
    {
		    exit("ERROR");
    }
?>
