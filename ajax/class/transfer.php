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
      $eid = valinput($_POST["eid"]);
      $class_id = valinput($_POST["classid"]);
      $remarks = valinputupper($_POST["remarks"]);
      $remarks = "_" . $remarks;
      $created = date("Y-m-d H:i:s");

      $ch_remarks = 'TRANSFER';
      $classinfo = get_class_info($class_id);
      $schoolyear = $classinfo[0]["schoolyear"];

      // UPDATE THE class id of the student but retain the other info such as idno
      $res = query("UPDATE class_listing SET class_id = ?, student_remarks = CONCAT(IFNULL(student_remarks,?), ?) WHERE sid = ?",
        $class_id, '', $remarks, $sid);
      if($res === false) {
        throw_error("error_transfer_student");
      }

      // insert to listing history
      $chid = create_uuid("CH");
      $res = query("INSERT INTO class_listing_history (chid, student_id, entity_id, class_id, schoolyear, ch_remarks, ch_dateadded) VALUES (?,?,?,?,?,?,?)",
        $chid, $sid, $eid, $class_id, $schoolyear, $ch_remarks, $created);
      if($res === false) {
        throw_error("insert_listing_history_failed");
      }
      else {
        // insert to logs
        $action = 'transfer student (sid: ' . $sid . ' classid: ' . $class_id . ')';
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
