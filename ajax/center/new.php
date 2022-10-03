<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $res_arr = []; // results array

      $centername = valinputupper($_POST["centername"]);
      $brgy = valinputupper($_POST["brgy"]);
      $remarks = valinputupper($_POST["remarks"]);
      $created = date("Y-m-d H:i:s");
      $actorid = $GLOBALS["_uid"];

      $centerid = create_uuid("CDC");
      // insert into devcenter table
      $res = query("INSERT INTO devcenter (cdc_id, centername, cdc_brgy, cdc_dateadded, actor_id, cdc_remarks) VALUES (?,?,?,?,?,?)",
        $centerid, $centername, $brgy, $created, $actorid, $remarks);
      if($res === false) {
        throw_error("insert_entity_failed");
      }
      else {
        // insert to logs
        $action = 'insert new center info (id: ' . $centerid . ')';
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
