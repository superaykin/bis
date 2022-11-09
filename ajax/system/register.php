<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      // ADD NEW USER
      //validate data
      $lastname = valinputupper($_POST["lastname"]);
      $firstname = valinputupper($_POST["firstname"]);
      $middlename = valinputupper($_POST["middlename"]);
      $suffix = valinputupper($_POST["suffix"]);
      $remarks = valinputupper($_POST["remarks"]);
      $actor = $GLOBALS["_uid"];

      // system will create username
      // username will be comming from lastname and firstname initials
      // CHECK FOR TWO NAMES
      if ($firstname == trim($firstname) && strpos($firstname, ' ') !== false) {
        $initials = explode(" ", $firstname);
        $initials = $initials[0][0] . $initials[1][0];
      } else {
        $initials = $firstname[0];
      }
      $username = $initials . str_replace(' ', '', $lastname);
      $un = false;
      while($un == false) {
        // check for username availability
        $res = is_username_taken($username);
        if($res == true) {
          // if username is taken then ADD random numbers from 1-100 in the username
          $username = $username . rand(1,100);
        } else {
          break;
        }
      }

      $defaultpass = 'secret';
      // hash password
      $password = crypt($defaultpass, "");

      $acctid = create_user_id();

      // insert user
      $user_objid = create_uuid("USR");
      $insert_user = query("INSERT INTO sys_user (uid, username, userhash, lastname, firstname, middlename, suffix, actor_id, user_remarks, acctid)
          VALUES (?,?,?,?,?,?,?,?,?,?)",
        $user_objid, $username, $password, $lastname, $firstname, $middlename, $suffix, $actor, $remarks, $acctid);
      if($insert_user === false) {
        throw_error("insert_user_error");
      }
      else {
        // insert to logs
        $action = 'insert new user info (id: ' . $user_objid . ')';
        $res = storetologs($action);
        if($res === false) {
          echo 'failed'; exit();
        }
        else {
          echo 'success'; exit();
        }
      }

		}
    else {
      redirect("./");
    }
