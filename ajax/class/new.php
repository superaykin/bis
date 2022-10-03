<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $res_arr = []; // results array

      $desc = valinputupper($_POST["classdesc"]);
      $centerid = valinput($_POST["center"]);
      $sy = valinput($_POST["sy"]);
      $remarks = valinputupper($_POST["remarks"]);
      $teacherid = valinput($_POST["cdcteacher"]);
      $created = date("Y-m-d H:i:s");

      $classname = create_class_code($centerid, $sy);

      $class_id = create_uuid("SC");
      // insert into class table
      $res = query("INSERT INTO class (cid, teacher_id, center_id, class_name, class_desc, schoolyear, created_date, actor_id, class_remarks)
        VALUES (?,?,?,?,?,?,?,?,?)", $class_id, $teacherid, $centerid, $classname, $desc, $sy, $created, $GLOBALS["_uid"], $remarks);
      if($res === false) {
        throw_error("insert_entity_failed");
      }
      else {
        // insert to logs
        $action = 'insert new class info (id: ' . $class_id . ')';
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
