<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {



      if($_POST["password"] !== $_POST["confirmation"]) {
        echo 'passwordnotmatch'; exit();
      }

      // validate
      $userid = valinput($_POST["userid"]);
      $oldpass = valinput($_POST["oldpassword"]);
      $newpass = valinput($_POST["confirmation"]);

      // hash password
      $password = crypt($newpass, "");

      // identify if password given is correct
      $rows = query("SELECT userhash FROM sys_user WHERE uid = ?", $userid);

      if(count($rows) == 1) {
        $row = $rows[0];
        if($row["userhash"] === crypt($oldpass, $row["userhash"])) {
          $res = query("UPDATE sys_user SET userhash = ? WHERE uid = ?", $password, $userid);
          if($res !== false) {
            // insert to logs
            $action = 'change password (id: ' . $userid . ')';
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
          echo 'passwordincorrect'; exit();
        }
      }
      else {
        echo 'unknownerror1'; exit();
      }
		}
    else {
      echo 'unknownerror'; exit();
    }
