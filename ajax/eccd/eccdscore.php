<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $res_arr = []; // results array

      // validate
      $classid = valinput($_POST["class_id"]);
      $eid = valinput($_POST["eid"]);
      $sid = valinput($_POST["sid"]); // class listing student id
      $remarks = valinputupper($_POST["remarks"]);
      $actorid = $GLOBALS['_uid'];
      $created = date("Y-m-d H:i:s");
      $td = new DateTime(valinput($_POST["testdate"]));
      $testdate = $td->format("Y-m-d");

      $eccd_id = array_map('valinput', $_POST["eccd_id"]);
      $eccd_score = array_map('valinput', $_POST["eccd_score"]);

      // get age tested
      $info = get_entity_info($eid);
      $agetested = get_age_tested($info[0]["birthdate"], $testdate);

      // generate the IDS
      $t_id = create_uuid("ET"); // test id
      $ei_id = create_uuid("EI"); // interpretation id

      // sum up the score
      $scount = count($eccd_score);
      $scaled_score = 0;
      for($i = 0; $i < $scount; $i++) {
        $scaled_score = $scaled_score + $eccd_score[$i];
      }

      // get standard score
      $standard_score = get_standard_score($scaled_score);

      // get interpretation
      $interpretation = get_interpretation($standard_score);

      // formulate ECCD scores string
      $str = "INSERT INTO eccd_score (es_id, entity_id, test_id, eccd_id, score, actor_id, added_date) VALUES ";
      for($i = 0; $i < count($eccd_score); $i++) {
        $es_id = create_uuid("ES"); // score id
        $str .= "('" . $es_id . "','" . $eid . "','" . $t_id ."','" . $eccd_id[$i] . "','" . $eccd_score[$i] . "','" . $actorid . "','" . $created . "'),";
      }
      $str = rtrim($str, ','); // TRIM string
      // insert scores
      $res = query($str);
      if($res === false) {
        throw_error("insert_scores_failed");
      }

      // check if entity has already ECCD record
      $res = has_eccd_record($eid);
      if($res === false) {
        // insert the record
        $er_id = create_uuid("ER");
        $res = query("INSERT INTO eccd_record (esr_id, entity_id, esi_id, test_id, test_date, interpretation, age_tested, actor_id, remarks)
          VALUES (?,?,?,?,?,?,?,?,?)",
          $er_id, $eid, $ei_id, $t_id, $testdate, $interpretation, $agetested, $actorid, $remarks);
        if($res === false) {
          throw_error("insert_eccd_record_error");
        }
      } else {
        // update the record
        $res = query("UPDATE eccd_record SET esi_id = ?, test_id = ?, test_date = ?, interpretation = ?, age_tested = ?, actor_id = ?, remarks = ?
          WHERE entity_id = ?", $ei_id, $t_id, $testdate, $interpretation, $agetested, $actorid, $remarks, $eid);
        if($res === false) {
          throw_error("update_eccd_record_error");
        }
      }

      // insert interpretation
      $res = query("INSERT INTO eccd_interpretation (esi_id, student_id, entity_id, class_id, test_id, test_date, standard_score, scaled_score, interpretation, age_tested, actor_id, remarks)
          VALUES (?,?,?,?,?,?,?,?,?,?,?,?)",
          $ei_id, $sid, $eid, $classid, $t_id, $testdate, $standard_score, $scaled_score, $interpretation, $agetested, $actorid, $remarks);
      if($res === false) {
        throw_error("insert_interpretation_failed");
      }
      else {
        // insert to logs
        $action = 'insert eccd interpretation to student (studentid: ' . $sid . ' / classid: ' . $classid . ')';
        $res = storetologs($action);
        if($res === false) {
          $res_arr = [
            "result" => "failed"
          ];
        }
        else {
          $res_arr = [
            "result" => "success"
          ];
        }

        echo json_encode($res_arr); exit();
      }

    }
    else
    {
		    exit("ERROR");
    }
?>
