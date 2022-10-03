<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $res_arr = []; // results array

      // validate
      $center_id = valinput($_POST["center_id"]);
      $userid = valinput($_POST["userid"]);
      $remarks = valinputupper($_POST["remarks"]);
      $actorid = $GLOBALS['_uid'];
      $created = date("Y-m-d H:i:s");

      $user = sys_get_user_info($userid);
      $idno = $user[0]["acctid"];

      // insert
      $ctid = create_uuid("CT");
      $res = query("INSERT INTO devcenter_teacher (ct_id, center_id, teacher_id, teacher_idno, ct_added, actor_id, ct_remarks)
          VALUES (?,?,?,?,?,?,?)",
        $ctid, $center_id, $userid, $idno, $created, $actorid, $remarks);
      if($res === false) {
        throw_error("insert_class_teacher_failed");
      }
      else {
        // insert to logs
        $action = 'add new teacher to center (center id: ' . $center_id . ' / teacherid: ' . $userid . ')';
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
