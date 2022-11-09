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

      $ch_remarks = 'TRANSFER';
      $classinfo = get_class_info($info["target_cid"]);
      $schoolyear = $classinfo[0]["schoolyear"];

      // UPDATE THE class id of the student but retain the other info such as idno
      $res = query("UPDATE class_listing SET class_id = ? WHERE sid = ?",
        $info["target_cid"], $info["student_id"]);
      if($res === false) {
        throw_error("error_transfer_student");
      }

      // update transfer request info
      $ures = query("UPDATE class_transfer SET transfer_status = 'APPROVED', approval_date = ?, approver_id = ? WHERE ctid = ?",
        $created, $GLOBALS["_uid"], $request_id);
      if($ures === false) {
        throw_error("error_update_request_transfer");
      }

      // insert to listing history
      $chid = create_uuid("CH");
      $res = query("INSERT INTO class_listing_history (chid, student_id, entity_id, class_id, schoolyear, ch_remarks, ch_dateadded) VALUES (?,?,?,?,?,?,?)",
        $chid, $info["student_id"], $info["eid"], $info["target_cid"], $schoolyear, $ch_remarks, $created);
      if($res === false) {
        throw_error("insert_listing_history_failed");
      }
      else {
        // insert to logs
        $action = 'transfer student (sid: ' . $info["student_id"] . ' classid: ' . $info["target_cid"] . ')';
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
