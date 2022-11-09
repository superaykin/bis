<?php

    // configuration
    require("../../includes/config.php");
    // TRANSFER STUDENT TO OTHER CLASS

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

      $res_arr = []; // results array

      $request_id = valinput($_POST["transfer_id"]);
      // get request info
      $info = get_transfer_request_info($request_id);
      if($info === false) {
        throw_error("error_get_info");
      }

      $created = date("Y-m-d H:i:s");

      // update transfer request info
      $ures = query("UPDATE class_transfer SET transfer_status = 'CANCELLED', approver_id = ? WHERE ctid = ?",
        $GLOBALS["_uid"], $request_id);
      if($ures === false) {
        throw_error("error_update_request_transfer");
      }
      else {
        // insert to logs
        $action = 'transfer request cancel (id: ' . $request_id . ')';
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
