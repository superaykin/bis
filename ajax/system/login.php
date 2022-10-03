<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

		// validate submission
        if (empty($_POST["username"]))
        { echo 'usernameempty'; die(); }
        else if (empty($_POST["password"]))
        { echo 'userpasswordempty'; die(); }

    		$username = valinputupper($_POST["username"]);
    		$password = valinput($_POST["password"]);

        // query database for user
        $rows = query("SELECT * FROM sys_user WHERE username = ?", $username);
        // if we found user
        if (count($rows) == 1) {
            $row = $rows[0];

            if($row["userhash"] === crypt($password, $row["userhash"])) {

              // create and insert user session
              $session_code = create_session_code();
              $last_activity = date("Y-m-d H:i:s");
              $results = query("INSERT INTO sys_session (ses_code, user_id, last_activity) VALUES (?,?,?)",
                $session_code, $row["uid"], $last_activity);
              if($results === false) {
                // false
                exit("ERRRORRRR");
              }

              // get roles
              $role = query("SELECT ur.*, r.role_desc 
                FROM sys_user_role AS ur
                  LEFT JOIN sys_role AS r ON r.role_id = ur.role_id
                WHERE ur.user_id = ? AND ur.role_status = 'ACTIVE'", $row["uid"]);
              //print_r($role); exit();

              // set session data
              $_SESSION["ecmspanabo"] = [
                  "userid" => $row["uid"],
                  "username" => $row["username"],
                  "fullname" => name_format($row["lastname"], $row["firstname"], $row["middlename"], $row["suffix"], "LF"),
                  "userdesc" => $row["userdesc"],
                  "session_code" => $session_code,
                  "application" => "ecmspanabo",
                  "frmses" => ["sample"],
                  "role" => $role
              ];
              echo 'accessgranted'; die();

            }
            else {
                echo 'invalidaccount'; die();
            }
        }
      	// no username found
      	else {
      	    echo 'invalidaccount'; exit();
      	}

    }
    else
    {
		    exit("ERROR");
    }
?>
