<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      // get the info
      $loctype = valinput($_POST["loctype"]);

      if($loctype === "BRGY") {
        // get all the cities/municipalities
        $parent = query("SELECT DISTINCT(add_value) FROM sys_address WHERE add_type = ? OR add_type = ? ORDER BY add_value ASC", "CITY", "MUN");
      }
      else if($loctype === "CITY" OR $loctype === "MUN") {
        // get all the province
        $parent = query("SELECT DISTINCT(add_value) FROM sys_address WHERE add_type = ? ORDER BY add_value ASC", "PROV");
      }
      else if($loctype === "PROV") {
        // get all regions
        $parent = query("SELECT DISTINCT(add_value) FROM sys_address WHERE add_type = ? ORDER BY add_value ASC", "REG");
      }
      else {
        echo 'wrong input!!!!!'; exit();
      }


      if(!empty($parent)) {
        echo '<div class="form-group"><label>Parent</label>';
        echo '<select name="addparent" class="form-control">';
        echo '<option value="" disable selected>Select parent...</option>';
        foreach($parent AS $p) {
          echo '<option value="' . $p["add_value"] . '">' . $p["add_value"] . '</option>';
        }

        echo '</div>';
      }

      else {
        echo 'empty'; exit();
      }



		}
    else {

    }
