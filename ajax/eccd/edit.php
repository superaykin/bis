<?php

    // configuration
    require("../../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $res_arr = []; // results array

      // validate
      $score_id = array_map('valinput', $_POST["eccd_score_id"]);
      $eccd_score = array_map('valinput', $_POST["eccd_score"]);
      $testid = valinput($_POST["test_id"]);
      $eid = valinput($_POST["studentid"]);
      $testdate = valinput($_POST["testdate"]);
      $agetested = valinputupper($_POST["agetested"]);
      $remarks = valinputupper($_POST["remarks"]);
      $currdate = date("Y-m-d H:i:s");

      // editor id
      $actorid = $GLOBALS["_uid"];

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

      // UPDATE THE SCORES
      for($i = 0; $i < $scount; $i++) {
        $res = query("UPDATE eccd_score SET score = ?, update_date = ?, update_actor = ? WHERE es_id = ?", $eccd_score[$i], $currdate, $actorid, $score_id[$i]);
        if($res === false) {
          throw_error("update_scores_failed");
        }
      }
      // IDENTIFY IF THE ECCD IS THE LATEST ON THE RECORD
      $res = is_latest_eccd_test($testid);
      if($res === true) {
        // if its true - the latest then update the record
        $res = query("UPDATE eccd_record SET test_date = ?, interpretation = ?, age_tested = ?, remarks = ?
          WHERE test_id = ?", $testdate, $interpretation, $agetested, $remarks, $testid);
        if($res === false) {
          throw_error("update_eccd_record_error");
        }
      }


      // UPDATE THE ECCD TEST INTERPRETATION
      $res = query("UPDATE eccd_interpretation
          SET test_date = ?, standard_score = ?, scaled_score = ?, interpretation = ?, age_tested = ?, remarks = ?, ei_status = ?
        WHERE test_id = ?", $testdate, $standard_score, $scaled_score, $interpretation, $agetested, $remarks, 'LOCKED', $testid);
      if($res === false) {
        throw_error("update_interpretation_failed");
      }
      else {
        // insert to logs
        $action = 'update eccd test of student (studentid: ' . $eid . ' / testid: ' . $testid . ')';
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
