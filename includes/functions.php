<?php

    /* -------------------------------------------------
		City Administrators Office - I.T. Section
	--------------------------------------------------- */

    require_once("constants.php");
    require("uuid.php");
    require("sessioncode.php");

    /**
     * Facilitates debugging by dumping contents of variable
     * to browser.
     */
    function dump($variable)
    {
        require("./templates/dump.php");
        exit;
    }

    /**
     * Executes SQL statement, possibly with parameters, returning
     * an array of all rows in result set or false on (non-fatal) error.
     */
    function query(/* $sql [, ... ] */)
    {
        // SQL statement
        $sql = func_get_arg(0);

        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);

        // try to connect to database
        static $handle;
        if (!isset($handle))
        {
            try
            {
                // connect to database
                $handle = new PDO("mysql:dbname=" . DATABASE . ";charset=utf8;host=" . SERVER, USERNAME, PASSWORD);

                // ensure that PDO::prepare returns false when passed invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            }
            catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
				       //echo 'Error. No database connection.';
                exit;
            }
        }

        // prepare SQL statement
        $statement = $handle->prepare($sql);
        if ($statement === false)
        {
            // trigger (big, orange) error
            trigger_error($handle->errorInfo()[2], E_USER_ERROR);
            exit;
        }

        // execute SQL statement
        $results = $statement->execute($parameters);

        // return result set's rows, if any
        if ($results !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    function logout()
    {
        $result = query("UPDATE sys_session SET ses_status = ? WHERE ses_code = ?", 'EXPIRED', $_SESSION["bis"]["session_code"]);
        if($result === false) {
          exit("ERROR UPDATE SESSION STATUS");
        }

        // unset any session variables
        $_SESSION["bis"] = [];

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }
        // destroy session
        //session_destroy();
		    unset($_SESSION["bis"]);

        redirect("./");
    }

    /**
     * Redirects user to destination, which can be
     * a URL or a relative path on the local host.
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     */
    function redirect($destination)
    {
        // handle URL
        if (preg_match("/^https?:\/\//", $destination))
        {
            header("Location: " . $destination);
        }

        // handle absolute path
        else if (preg_match("/^\//", $destination))
        {
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            header("Location: $protocol://$host$destination");
        }

        // handle relative path
        else
        {
            // adapted from http://www.php.net/header
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            header("Location: $protocol://$host$path/$destination");
        }

        // exit immediately since we're redirecting anyway
        exit;
    }

    /**
     * Renders template, passing in values.
     */
    function render($template, $values = [])
    {
        // if template exists, render it
        if (file_exists("./templates/$template"))
        {
            // extract variables into local scope
            extract($values);

            // render header
            require("./templates/layouts/header.php");

			      // render sidebar
            require("./templates/layouts/sidebar.php");

            // render template
            require("./templates/$template");

        }

        // else err
        else
        {
            trigger_error("Invalid template: $template", E_USER_ERROR);
        }
    }

    function renderview($template, $values = []) {
        if (file_exists("./templates/$template"))
        {
            extract($values);
            require("./templates/$template");
        }
        else {
            trigger_error("Invalid template: $template", E_USER_ERROR);
        }
    }

    function storetologs($action) {
      // get vars
  		$cdt = date("Y-m-d H:i:s");
  		$userid = $_SESSION["bis"]["userid"];
      $scode = $_SESSION["bis"]["session_code"];
  		$logid = create_uuid("LOG");
      $details = valinputupper($action);

  		// insert to table
  		$result = query("INSERT INTO sys_log (logid, actorid, session_code, details, log_date) VALUES (?,?,?,?,?)",
  			$logid, $userid, $scode, $details, $cdt);
  		if($result !== false) {
  			return true;
  		}
  		else {
  			return false;
  		}
    }

  	function valinputupper($data) {

  	  $data = trim($data);
  	  $data = stripslashes($data);
  	  $data = htmlspecialchars($data);

      mb_internal_encoding('UTF-8');
      if(!mb_check_encoding($data, 'UTF-8')
      OR !($data === mb_convert_encoding(mb_convert_encoding($data, 'UTF-32', 'UTF-8' ), 'UTF-8', 'UTF-32'))) {
        $data = mb_convert_encoding($data, 'UTF-8');
      }
      $data = mb_convert_case($data, MB_CASE_UPPER, "UTF-8");
      //$data = strtoupper($data);
      if(empty($data)) {
        return null;
      }
      else {
        return $data;
      }

  	}

    function valinput($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      // return 0 is allowed.. in php 0 means empty
      return $data;
    }


    function wrap_string($string, $limit) {
      if (strlen($string) <= $limit) {
        return $string;
      } else {
        return substr($string, 0, $limit) . '...';
      }
    }

    function throw_error($string) {
      print_r($string); exit();
    }

    function error401() {
      // invalid or unauthorized access
      redirect("./sys.php?page=401");
    }

    function gotomain() {
      redirect("./");
    }


    function get_age($dob) {
      $dob = new DateTime($dob);
      $now = new DateTime();
      $age = $now->diff($dob);
      return $age->y;
    }

    function get_age_tested($dob, $cdate, $filter = "YM") {
      // filters : Y = Year Only, YM = Year and Month only, YMD = Year Months and days
      // cdate = compare date
      $dob = new DateTime($dob);        // date of birth
      $cdate = new DateTime($cdate);    // check date - eccd test
      $age = $cdate->diff($dob);
      if($filter == "Y") {
        return $age->y . ' year(s)';
      } else if($filter == "YM") {
        return $age->y . ' year(s) and ' . $age->m . ' month(s)';
      } else {
        return $age->y . ' year(s) and ' . $age->m . ' month(s) ' . $age->d . ' day(s)';
      }
    }

    function name_format($last, $first, $middle, $suffix, $format = "D") {
      // arrange the presented name
      // D = default. Firstname Middle initial Lastname Suffix
      // LF = Lastname first. Lastname, Firstname Suffix Middle initial / APA style

      if($middle == "" OR $middle == NULL) {
      	$middle = " ";
      } else {
      	if($format == "D") {
        	$middle = " " . $middle[0] . ". ";
        } else {
        	$middle = " " . $middle[0] . ".";
        }
      }

      if($suffix == "" OR $suffix == NULL) {
      	$suffix = "";
      } else {
      	if($format == "D") {
        	$suffix = ", " . $suffix . " ";
        } else {
        	$suffix = ", " . $suffix . " ";
        }
      }

      if($format == "D") {
        // format
        $nameformat = $first . $middle . $last . $suffix;
      } else {
        $nameformat = $last . ", " . $first . $middle . $suffix;
      }

      return $nameformat;

    }


    function address_format($city, $brgy, $home, $format = "DEFAULT") {
      if(empty($home)) {
        $home = "";
      } else {
        $home = $home . ", ";
      }
      // format
      $address = $home . $brgy . ', ' . $city;
      return $address;
    }


    function validate_form_var($target) {
      // search for form variable in the user session
      $key = array_search($target, $_SESSION["bis"]["frmses"], true);
      if($key !== false) {
      	// found and remove the target from the array
        unset($_SESSION["bis"]["frmses"][$key]);
          return true;
      } else {
      	  return false;
      }
    }

    function generate_form_var() {
      $ses = generate_unique_code(15);
      array_push($_SESSION["bis"]["frmses"], $ses);
      return $ses;
    }

    function generate_unique_code($lenght) {
  		// uniqid gives 4 chars, but you could adjust it to your needs.
  		if (function_exists("random_bytes")) {
  			$bytes = random_bytes(ceil($lenght / 2));
  		} elseif (function_exists("openssl_random_pseudo_bytes")) {
  			$bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
  		} else {
  			throw new Exception("no cryptographically secure random function available");
  		}
  		return substr(bin2hex($bytes), 0, $lenght);
  	}

    function update_session_list() {
      // update previous session to expired. parameter is 1day
      $day = new DateTime();
      $limitday = $day->modify("-1 days")->format('Y-m-d H:i:s');
      $update_all = query("UPDATE sys_session SET ses_status = ? WHERE last_activity <= ?", 'EXPIRED', $limitday);

      // delete more than XX days
      $ts = query("SELECT value FROM sys_setting WHERE setting_id = 'SES_DELETE_THRESHOLD'");
      $max_days = "-" . $ts[0]["value"] . " days";
      $threshold = $day->modify($max_days)->format('Y-m-d H:i:s');
      $delete_all = query("DELETE FROM sys_session WHERE last_activity <= ?", $threshold);
    }

    function verify_session($session_code) {
      // get the session details
      $rows = query("SELECT * FROM sys_session WHERE ses_code = ?", $session_code);
      if(count($rows) > 1) {
        // more than one.. session is compromised
        return "000"; exit();
      }
      else if(count($rows) == 1) {
        // only one session
        $session_info = $rows[0];
      }
      else {
        // no session found
        return "404"; exit();
      }

      // compute idle time
      $last_activity = new DateTime($session_info["last_activity"]);
      $current_datetime = new DateTime(date("Y-m-d H:i:s"));
      $online_time = $current_datetime->getTimestamp() - $last_activity->getTimestamp();

      $mt = query("SELECT value FROM sys_setting WHERE setting_id = 'MAX_IDLE_TIME'");
      $max_time = $mt[0]["value"];

      if($session_info["ses_status"] == "ACTIVE" AND $online_time <= $max_time) {
        // allowed to use the system then update the last activity time
        $result = query("UPDATE sys_session SET last_activity = ? WHERE ses_code = ?", date("Y-m-d H:i:s"), $session_info["ses_code"]);
        return "1000";
      }
      else {
        // force logout
        logout();
      }
    }


    function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                return true;
            }
        }
        return false;
    }


    function is_allowed($allowed) {
      // this function will identify if user is allowed on a certain function of the system
      $user_access = $_SESSION["bis"]["role"];

      $res = false;
      foreach($allowed AS $a) {
        $key = array_search($a, array_column($user_access, 'role_id'));
        if($key !== false) {
          return true; // allowed
        }
      }

      if($res === false) {
        error401();
      }
    }


    function lookup_role($role) {
      $user_access = $_SESSION["bis"]["role"];

       foreach ($user_access as $key => $val) {
           if ($val['role_id'] === $role) {
               return true;
           }
       }
       return false;
    }


    function sys_get_action_logs($user_id) {
      $res = query("SELECT * FROM sys_log WHERE actorid = ? ORDER BY log_date DESC", $user_id);
      if($res !== false) {
        return $res;
      }
    }



    function create_child_id($centerid) {
      // CREATE CHILD ID
      $res = get_center_info($centerid);
      $cdc_no = $res["cdc_controlno"];

      $cdc_code = $GLOBALS["_codings"][$cdc_no];
      $psuedo_no = generate_uuid(5);

      return $cdc_code . valinputupper($psuedo_no) . rand(10, 99);
    }

    function create_user_id() {
      // create user id for users
      $y = date("y");
      $random_char = strtoupper(generate_uuid(7));
      $letter = chr(rand(65,90));
      return $letter . $y . $random_char;
    }


    function verify_login($password) {
      // verify user login password.. used for verification
      $username = $GLOBALS["_uname"];

      $rows = query("SELECT * FROM sys_user WHERE username = ?", $username);
      // if we found user
      if (count($rows) == 1) {
        $row = $rows[0];

        if($row["userhash"] === crypt($password, $row["userhash"])) {
          // password match
          return true;
        } else {
          // wrong password
          return false;
        }
      }
    }

    function create_class_code($center_id, $schoolyear) {
      $info = get_center_info($center_id);
      $random_pad = strtoupper(generate_uuid(7));

      $cdc_code = $GLOBALS["_codings"][$info["cdc_controlno"]];
      $e = explode("-", $schoolyear);
      $sy = substr($e[0], -2) . substr($e[1], -2);

      return $cdc_code . $sy . $random_pad;

    }
