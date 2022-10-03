<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

      // validate
      $userid = valinput($_POST["userid"]);
      $roleid = valinput($_POST["role"]);
      $remarks = valinputupper($_POST["remarks"]);

      $urid = create_uuid("UR");
      $res = query("INSERT INTO sys_user_role (urid, user_id, role_id, ur_remarks) VALUES (?,?,?,?)", $urid, $userid, $roleid, $remarks);
      if($res === false) {
        throw_error("error_insert_role");
      }
      // insert to logs
      $action = 'set role for user (id: ' . $userid . ' roleid: ' . $roleid . ')';
      $logres = storetologs($action);
      if($logres === true) {
        echo 'success'; exit();
      }


		}
    else {
      echo 'unknownerror'; exit();
    }
