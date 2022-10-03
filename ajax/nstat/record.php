<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $res_arr = []; // results array

      //print_r($_POST); exit();

      // validate
      $classid = valinput($_POST["class_id"]);
      $eid = valinput($_POST["eid"]);
      $sid = valinput($_POST["sid"]);
      $remarks = valinputupper($_POST["remarks"]);
      $actorid = $GLOBALS['_uid'];
      $created = date("Y-m-d H:i:s");
      $td = new DateTime(valinput($_POST["testdate"]));
      $testdate = $td->format("Y-m-d");
      $nstat = valinputupper($_POST["nutstat"]);

      // CREATE THE RECORD ID
      $nh_id = create_uuid("NH");

      // identify if child has no existing nutritional record // DATA TABLE has been deleted
      if(has_nstat_record($eid) === false) {
        // insert to nutritional record
        $nr_id = create_uuid("NR");
        $res = query("INSERT INTO nutritional_record (nid, nstat_id, entity_id, nh_id, ns_testdate, nstat_remarks, nstat_added) VALUES (?,?,?,?,?,?,?)",
            $nr_id, $nstat, $eid, $nh_id, $testdate, $remarks, $created);
        if($res === false) {
          throw_error("insert_nutritional_stat_failed");
        }
      } else {
        // update the nutritional record of the child
        $res = query("UPDATE nutritional_record SET nstat_id = ?, nh_id = ?, ns_testdate = ?, nstat_remarks = ?, nstat_added = ? WHERE entity_id = ?",
            $nstat, $nh_id, $testdate, $remarks, $created, $eid);
        if($res === false) {
          throw_error("update_nutritional_record_failed");
        }
      }

      // insert to nutritional history
      $res = query("INSERT INTO nutritional_history (nh_id, nstat_id, student_id, entity_id, ns_testdate, class_id, actor_id, nstat_remarks, nstat_added) VALUES (?,?,?,?,?,?,?,?,?)",
          $nh_id, $nstat, $sid, $eid, $testdate, $classid, $actorid, $remarks, $created);
      if($res === false) {
        throw_error("insert_nutritional_stat_record_failed");
      }
      else {
        // insert to logs
        $action = 'insert nutritional status to student (studentid: ' . $eid . ' / classid: ' . $classid . ')';
        $res = storetologs($action);
        if($res === false) {
          $res_arr = [
            "result" => "failed"
          ];
        }
        else {
          $res_arr = [
            "result" => "success"
          ];
        }

        echo json_encode($res_arr); exit();
      }

    }
    else
    {
		    exit("ERROR");
    }
?>
