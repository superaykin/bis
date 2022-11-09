<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $res_arr = []; // results array

      $password = valinput($_POST["password"]);
      $res = verify_login($password);
      if($res === false) {
        $res_arr = [
          "result" => "invalidcredentials"
        ];
        echo json_encode($res_arr); exit();
      }

      $sid = valinput($_POST["sid"]);

      // verify if student id has pending transfers
      $res = has_pending_transfer($sid);
      if($res === true) {
        // student has pending transfer
        $res_arr = [
          "result" => "studenthaspendingtransfer"
        ];
        echo json_encode($res_arr); exit();
      }

      $eid = valinput($_POST["eid"]);
      $class_id = valinput($_POST["classid"]);
      $remarks = valinputupper($_POST["remarks"]);
      $transferdate = date("Y-m-d H:i:s");

      $ch_remarks = 'TRANSFER';
      $classinfo = get_class_info($class_id);
      $schoolyear = $classinfo[0]["schoolyear"];
      $origin_class = valinput($_POST["class_id"]);

      $req_trans_id = create_uuid("CT");
      // insert request to class transfer
      $res = query("INSERT INTO class_transfer (ctid, student_id, origin_cid, target_cid, transfer_notes, transfer_date, schoolyear, actor_id)
        VALUES (?,?,?,?,?,?,?,?)",
        $req_trans_id, $sid, $origin_class, $class_id, $remarks, $transferdate, $schoolyear, $GLOBALS["_uid"]);
      if($res === false) {
        throw_error("error_request_transfer_student");
      }
      else {
        // insert to logs
        $action = 'transfer request student (sid: ' . $sid . ' transfer classid: ' . $class_id . ')';
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
