<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

      // validate
      $userid = valinput($_POST["userid"]);
      $password = crypt('secret', "");

      $res = query("UPDATE sys_user SET userhash = ? WHERE uid = ?", $password, $userid);
      if($res !== false) {
        // insert to logs
        $action = 'reset password (id: ' . $userid . ')';
        $logres = storetologs($action);
        if($logres === true) {
          echo 'success'; exit();
        }
      }
      else {
        echo 'failed'; exit();
      }


		}
    else {
      echo 'unknownerror'; exit();
    }
