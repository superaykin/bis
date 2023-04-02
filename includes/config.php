<?php
    ini_set("display_errors", true);
    error_reporting(E_ALL);

    require("constants.php");
    require("functions.php");
    require("queries.php");
	  date_default_timezone_set('Asia/Manila');
    session_start();

    // updates
    update_session_list();

    // maintenance mode
    // redirect("./maintenance.php");


    if (!preg_match("{(?:login|logout)\.php$}", $_SERVER["PHP_SELF"]))
    {

      if (empty($_SESSION["bis"]["application"])) {
        redirect("login.php");
      }
      else if($_SESSION["bis"]["application"] != "bis") {
        redirect("login.php");
      }
      else if($_SESSION["bis"]["application"] == "bis") {
        // logged in
        // verify the session
        $result = verify_session($_SESSION["bis"]["session_code"]);
        if($result === "1000") {
          // allowed to access

        }
        else if($result === "000") {
          redirect("logout.php");
        }
        else if($result === "404") {
          redirect("logout.php");
        }
        else {
          redirect("logout.php");
        }

      }


      // set global variables
      $GLOBALS["_uid"] = $_SESSION["bis"]["userid"];
      $GLOBALS["_uname"] = $_SESSION["bis"]["username"];
      $GLOBALS["_fullname"] = $_SESSION["bis"]["fullname"];
      $GLOBALS["_utitle"] = $_SESSION["bis"]["userdesc"];
      $GLOBALS["_sescode"] = $_SESSION["bis"]["session_code"];


      $GLOBALS["_codings"] = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
        "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ",
        "BA", "BB", "BC", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BK", "BL", "BM", "BN", "BO", "BP", "BQ", "BR", "BS", "BT", "BU", "BV", "BW", "BX", "BY", "BZ",
        "CA", "CB", "CC", "CD", "CE", "CF", "CG", "CH", "CI", "CJ", "CK", "CL", "CM", "CN", "CO", "CP", "CQ", "CR", "CS", "CT", "CU", "CV", "CW", "CX", "CY", "CZ",
        "DA", "DB", "DC", "DD", "DE", "DF", "DG", "DH", "DI", "DJ", "DK", "DL", "DM", "DN", "DO", "DP", "DQ", "DR", "DS", "DT", "DU", "DV", "DW", "DX", "DY", "DZ",
        "EA", "EB", "EC", "ED", "EE", "EF", "EG", "EH", "EI", "EJ", "EK", "EL", "EM", "EN", "EO", "EP", "EQ", "ER", "ES", "ET", "EU", "EV", "EW", "EX", "EY", "EZ",
        "FA", "FB", "FC", "FD", "FE", "FF", "FG", "FH", "FI", "FJ", "FK", "FL", "FM", "FN", "FO", "FP", "FQ", "FR", "FS", "FT", "FU", "FV", "FW", "FX", "FY", "FZ",
        "GA", "GB", "GC", "GD", "GE", "GF", "GG", "GH", "GI", "GJ", "GK", "GL", "GM", "GN", "GO", "GP", "GQ", "GR", "GS", "GT", "GU", "GV", "GW", "GX", "GY", "GZ",
      ];

    }

?>
