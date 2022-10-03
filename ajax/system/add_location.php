<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {

      // validate inputs
      $add_val = valinputupper($_POST["addvalue"]);
      $add_type = valinputupper($_POST["loctype"]);
      $parent = valinputupper($_POST["addparent"]);
      $dateadded = date("Y-m-d H:i:s");

      // create id
      $loc_id = create_uuid($add_type);

      // insert
      $result = query("INSERT INTO sys_address (address_id, add_value, add_type, add_parent, date_created) VALUES (?,?,?,?,?)",
      $loc_id, $add_val, $add_type, $parent, $dateadded);

      if($result !== false) {
        // insert to logs
        $action = 'add new location (value: ' . $add_val . ', type: ' . $add_type . ', parent: ' . $parent . ')';
        $logres = storetologs($action);
        if($logres === true) {
          echo 'success'; exit();
        }
      }
      else {
        echo 'failed';
      }

		}
    else {

    }
