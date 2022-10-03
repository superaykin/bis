<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $res_arr = []; // results array

      // validate
      $classid = valinput($_POST["class_id"]);
      $entityid = valinput($_POST["entityid"]);
      $idno = valinputupper($_POST["studentidno"]);
      $remarks = valinputupper($_POST["remarks"]);
      $actorid = $GLOBALS['_uid'];
      $created = date("Y-m-d H:i:s");

      $ch_remarks = 'ENROLLED';
      $classinfo = get_class_info($classid);
      $schoolyear = $classinfo[0]["schoolyear"];

      // insert to listing
      $clid = create_uuid("CL");
      $res = query("INSERT INTO class_listing (sid, entity_id, class_id, student_idno, cl_dateadded, actor_id, student_remarks) VALUES (?,?,?,?,?,?,?)",
        $clid, $entityid, $classid, $idno, $created, $actorid, $remarks);
      if($res === false) {
        throw_error("insert_listing_failed");
      }

      // insert to listing history
      $chid = create_uuid("CH");
      $res = query("INSERT INTO class_listing_history (chid, student_id, entity_id, class_id, schoolyear, ch_remarks, ch_dateadded) VALUES (?,?,?,?,?,?,?)",
        $chid, $clid, $entityid, $classid, $schoolyear, $ch_remarks, $created);
      if($res === false) {
        throw_error("insert_listing_history_failed");
      }
      else {
        // insert to logs
        $action = 'enroll student to class (class id: ' . $classid . ' / entityid: ' . $entityid . ')';
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
