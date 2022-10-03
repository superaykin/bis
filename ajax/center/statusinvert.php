<?php

    // configuration
    require("../../includes/config.php");

    // STATUS INVERT FOR DEVELOPMENT CENTER TEACHER

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $res_arr = []; // results array

      // validate
      $ctid = valinput($_POST["ctid"]);
      $cts = valinputupper($_POST["ctstat"]);

      if($cts == "ACTIVE") {
        $stat = "INACTIVE";
      } else {
        $stat = "ACTIVE";
      }

      // UPDATE DEV TEACHER STATUS
      $res = query("UPDATE devcenter_teacher SET ct_status = ? WHERE ct_id = ?", $stat, $ctid);
      if($res === false) {
        throw_error("invert_teacher_stat_error");
      }
      else {
        // insert to logs
        $action = 'update teacher status (dev teacher id: ' . $ctid . ' status: ' . $stat . ')';
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
