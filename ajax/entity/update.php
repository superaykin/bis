<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $res_arr = []; // results array
      $entity_id = valinput($_POST["entity_id"]);

      // validate entries
      $lastname = valinputupper($_POST["lastname"]);
      $firstname = valinputupper($_POST["firstname"]);
      $middlename = valinputupper($_POST["middlename"]);
      $suffix = valinputupper($_POST["suffix"]);
      $sex = valinputupper($_POST["sex"]);
      $dd = new DateTime(valinput($_POST["dob"]));
      $dob = $dd->format("Y-m-d");
      $birthplace = valinputupper($_POST["placeofbirth"]);
      $birthorder = valinput($_POST["birthorder"]);
      $ips = valinputupper($_POST["ips"]);
      $fps = valinputupper($_POST["fourps"]);
      $pwd = valinputupper($_POST["pwd"]);
      $address1 = valinputupper($_POST["city"]);
      $address2 = valinputupper($_POST["brgy"]);
      $address3 = valinputupper($_POST["home"]);
      $religion = valinputupper($_POST["religion"]);
      $ethnicity = valinputupper($_POST["ethnicity"]);
      $contact = valinput($_POST["contactno"]);
      $remarks = valinputupper($_POST["remarks"]);

      $created_date = date("Y-m-d H:i:s");
      $actor = $GLOBALS["_uid"];

      // update entity table
      $res = query("UPDATE entity SET lastname = ?, firstname = ?, middlename = ?, suffix = ?, sex = ?, birthdate = ?, birthplace = ?, birthorder = ?,
        address_city = ?, address_brgy = ?, address_street = ?, ethnicity = ?, religion = ?, ips = ?, 4ps = ?, pwd = ?, contactno = ?, profile_remarks = ?,
        profile_status = ?
        WHERE eid = ?",
        $lastname, $firstname, $middlename, $suffix, $sex, $dob, $birthplace, $birthorder, $address1, $address2, $address3, $ethnicity, $religion,
        $ips, $fps, $pwd, $contact, $remarks, 'LOCKED', $entity_id);
      if($res === false) {
        throw_error("update_entity_failed");
      }
      else {
        // insert to logs
        $action = 'update entity info (id: ' . $entity_id . ')';
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
            "result" => "success",
            "eid" => $entity_id
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
