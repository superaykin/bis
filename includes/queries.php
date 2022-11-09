<?php

    /* -------------------------------------------------
		City Administrators Office - I.T. Section
	--------------------------------------------------- */

    function get_entity() {
      $res = query("SELECT * FROM entity ORDER BY lastname ASC");
      if($res !== false) {
        return $res;
      }
    }

    function get_entity_info($id) {
      $res = query("SELECT e.*, CONCAT(u.lastname, ', ', u.firstname) AS actor_name FROM entity AS e
          LEFT JOIN sys_user AS u ON u.uid = e.actor_id
        WHERE e.eid = ?", $id);
      if($res !== false) {
        return $res;
      }
    }

    function get_name($entity_id, $format = "LF") {
      // get the entity name and return with the desired format
      $res = query("SELECT * FROM entity WHERE eid = ?", $entity_id);
      $n = $res[0];
      return name_format($n["lastname"], $n["firstname"], $n["middlename"], $n["suffix"], $format);
    }

    function get_address_bydata($data, $format = "DEFAULT") {
      return address_format($data["address_city"], $data["address_brgy"], $data["address_street"], "DEFAULT");
    }

    function get_city() {
      $res = query("SELECT * FROM sys_address WHERE add_type = 'CITY' OR add_type = 'MUN' ORDER BY add_value ASC");
      if($res !== false) {
        return $res;
      }
    }

    function get_brgy($parent) {
      $res = query("SELECT * FROM sys_address WHERE add_type = 'BRGY' AND add_parent = ? ORDER BY add_value ASC", $parent);
      if($res !== false) {
        return $res;
      }
    }

    /* FUNCTION TO VERIFY IF A CERTAIN ENTITY IS EXISTING */
    function exist($lastname, $firstname, $middlename, $dob) {
      $res = query("SELECT * from entity WHERE lastname = ? AND firstname = ? AND birthdate = ? AND middlename LIKE ?",
        $lastname, $firstname, $dob, '%' . $middlename . '%');
      if($res !== false) {
        if(count($res) >= 1) {
          // found the same data
          return true;
        } else {
          return false;
        }
      }
    }

    function lookup($lastname, $firstname) {
      // search for a matching name and lastname
      $res = query("SELECT * from entity WHERE lastname LIKE ? OR firstname LIKE ?", '%' . $lastname . '%', '%' . $firstname . '%');
      if($res !== false) {
        if(count($res) >= 1) {
          // found the same data
          return $res;
        } else {
          return false;
        }
      }
    }


    function get_class_listing() {
      $is_admin = lookup_role('CLASS_ADMIN');
      if($is_admin <> false) {
        // view all classis if ADMIN
        $res = query("SELECT c.*, CONCAT(u.lastname,', ', u.firstname) AS t_name, dc.centername
          FROM class AS c
            LEFT JOIN sys_user AS u ON u.uid = c.teacher_id
            LEFT JOIN devcenter AS dc ON dc.cdc_id = c.center_id ORDER BY dc.centername ASC");
      } else {
        // USER access only
        $res = query("SELECT c.*, CONCAT(u.lastname,', ', u.firstname) AS t_name, dc.centername
          FROM class AS c
            LEFT JOIN sys_user AS u ON u.uid = c.teacher_id
            LEFT JOIN devcenter AS dc ON dc.cdc_id = c.center_id
          WHERE c.teacher_id = ? ORDER BY dc.centername ASC", $GLOBALS["_uid"]);
      }
      if($res !== false) {
        return $res;
      }
    }

    function get_available_class($class_id, $schoolyear) {
      // get available class where id is not equal to provided id
      $res = query("SELECT c.*, CONCAT(u.lastname,', ', u.firstname) AS t_name, dc.*
        FROM class AS c
          LEFT JOIN sys_user AS u ON u.uid = c.teacher_id
          LEFT JOIN devcenter AS dc ON dc.cdc_id = c.center_id
        WHERE c.cid <> ? AND c.schoolyear = ?
        ORDER BY dc.cdc_brgy, dc.centername ASC", $class_id, $schoolyear);
      if($res !== false) {
        return $res;
      }
    }

    function get_class_enrolled($entity_id) {
      $res = query("SELECT cl.*, c.*, dc.centername, CONCAT(u.lastname,', ', u.firstname) AS teacher_name
        FROM class_listing AS cl
          LEFT JOIN class AS c ON c.cid = cl.class_id
          LEFT JOIN sys_user AS u ON u.uid = c.teacher_id
          LEFT JOIN devcenter AS dc ON dc.cdc_id = c.center_id
        WHERE cl.entity_id = ?
        ORDER BY c.schoolyear DESC", $entity_id);
      if($res !== false) {
        return $res;
      }
    }

    function get_class_history($entity_id) {
      $res = query("SELECT ch.*, c.*, dc.*
        FROM class_listing_history AS ch
          LEFT JOIN class AS c ON c.cid = ch.class_id
          LEFT JOIN sys_user AS u ON u.uid = c.teacher_id
          LEFT JOIN devcenter AS dc ON dc.cdc_id = c.center_id
        WHERE ch.entity_id = ?
        ORDER BY ch.schoolyear DESC", $entity_id);
      if($res !== false) {
        return $res;
      }
    }


    function get_centers() {
      $q = "SELECT * FROM devcenter ORDER BY cdc_brgy, centername ASC";
      $res = query($q);
      if($res !== false) {
        return $res;
      }
    }

    function get_center_info($center_id) {
      $res = query("SELECT * FROM devcenter WHERE cdc_id = ?", $center_id);
      if($res !== false) {
        return $res[0];
      }
    }

    function get_center_class($center_id) {
      $res = query("SELECT c.*, CONCAT(u.lastname,', ', u.firstname) AS teacher_name, dc.centername
        FROM class AS c
          LEFT JOIN sys_user AS u ON u.uid = c.teacher_id
          LEFT JOIN devcenter AS dc ON dc.cdc_id = c.center_id
        WHERE c.center_id = ? ORDER BY dc.centername ASC", $center_id);
      if($res !== false) {
        return $res;
      }
    }

    function get_centers_specific($teacher_id) {
      // get all centers connected to the teacher id
      $res = query("SELECT ct.*, c.*
        FROM devcenter_teacher AS ct
          LEFT JOIN devcenter AS c ON c.cdc_id = ct.center_id
        WHERE ct.teacher_id = ? AND ct.ct_status = 'ACTIVE'", $teacher_id);
      if($res !== false) {
        return $res;
      }
    }

    function get_center_teacher($centerid) {
      $res = query("SELECT dt.*, u.* FROM devcenter_teacher AS dt
          LEFT JOIN sys_user AS u ON u.uid = dt.teacher_id
        WHERE dt.center_id = ? ORDER BY u.lastname", $centerid);
      if($res !== false) {
        return $res;
      }
    }

    function get_center_student_count($centerid) {
      $res = query("SELECT
        	SUM(1) AS population,
        	SUM(CASE WHEN e.sex = 'MALE' THEN 1 ELSE 0 END) AS male,
        	SUM(CASE WHEN e.sex = 'FEMALE' THEN 1 ELSE 0 END) AS female,
        	SUM(CASE WHEN e.ips = 'YES' THEN 1 ELSE 0 END) AS ipscount,
        	SUM(CASE WHEN e.4ps = 'YES' THEN 1 ELSE 0 END) AS 4pscount,
          SUM(CASE WHEN e.pwd = 'YES' THEN 1 ELSE 0 END) AS pwdcount
        FROM class_listing AS cl
        	LEFT JOIN entity AS e ON cl.entity_id = e.eid
        	LEFT JOIN class AS c ON c.cid = cl.class_id
        WHERE c.center_id = ?", $centerid);
      if($res !== false) {
        return $res[0]; // return one row
      }
    }

    function get_center_count_per_brgy() {
      $res = query("SELECT cdc_brgy, COUNT(cdc_id) AS centercount
        FROM devcenter
        	GROUP BY cdc_brgy
        ORDER BY centername ASC");
      if($res !== false) {
        return $res;
      }
    }

    // AVAILABLE TEACHERS FOR CDC
    function get_available_teacher($centerid) {
      // $res = query("SELECT u.* FROM sys_user AS u
      //   WHERE u.uid NOT IN (SELECT teacher_id FROM devcenter_teacher WHERE center_id = ?)", $centerid);

      $res = query("SELECT u.* FROM sys_user AS u
        WHERE ? IN (SELECT sr.role_id FROM sys_user_role AS sr WHERE sr.user_id = u.uid)
          AND u.uid NOT IN (SELECT teacher_id FROM devcenter_teacher WHERE center_id = ?)
        ORDER BY u.lastname ASC", 'CDC_TEACHER', $centerid);

      if($res !== false) {
        return $res;
      }
    }

    function get_class_info($id) {
      $res = query("SELECT c.*, CONCAT(u.lastname,', ', u.firstname) AS t_name, dc.*, dt.ct_status
      FROM class AS c
        LEFT JOIN sys_user AS u ON u.uid = c.teacher_id
        LEFT JOIN devcenter AS dc ON dc.cdc_id = c.center_id
        LEFT JOIN devcenter_teacher AS dt ON c.teacher_id = dt.teacher_id AND c.center_id = dt.center_id
      WHERE c.cid = ?", $id);
      if($res !== false) {
        return $res;
      }
    }

    function is_class_teacher($class_id) {
      // identify if the user is the class teacher of the class
      $res = get_class_info($class_id);
      if($res[0]["teacher_id"] == $GLOBALS["_uid"]) {
        return true;
      } else {
        return false;
      }
    }

    function is_class_teacher_allowed($class_id) {
      // identify if the user is the class teacher of the class
      $res = get_class_info($class_id);
      if($res[0]["teacher_id"] == $GLOBALS["_uid"] AND $res[0]["ct_status"] == "ACTIVE") {
        return true;
      } else {
        return false;
      }
    }


    function get_unenrolled($sy) {
      // get unenrolled entity
      $res = query("SELECT e.* FROM entity AS e WHERE e.eid NOT IN (
          SELECT cl.entity_id
          FROM class_listing AS cl
            LEFT JOIN class AS c ON c.cid = cl.class_id
          WHERE c.schoolyear = ?)
        ORDER BY e.lastname ASC", $sy);
      if($res !== false) {
        return $res;
      }
    }

    function get_class_statistics($class_id) {
      // CLASS STATISTICS
      // student count - sex - ips - 4ps - pwd
      $res = query("SELECT
              	SUM(1) AS population,
              	SUM(CASE WHEN e.sex = 'MALE' THEN 1 ELSE 0 END) AS male,
              	SUM(CASE WHEN e.sex = 'FEMALE' THEN 1 ELSE 0 END) AS female,
              	SUM(CASE WHEN e.ips = 'YES' THEN 1 ELSE 0 END) AS ipscount,
              	SUM(CASE WHEN e.4ps = 'YES' THEN 1 ELSE 0 END) AS 4pscount
              FROM class_listing AS cl
              	LEFT JOIN entity AS e ON cl.entity_id = e.eid
              WHERE cl.class_id = ?", $class_id);
      if($res !== false) {
        return $res[0];
      }
    }


    function get_class_students($classid) {
      $res = query("SELECT cl.*, e.* FROM class_listing AS cl
          LEFT JOIN entity AS e ON cl.entity_id = e.eid
        WHERE cl.class_id = ? ORDER BY e.lastname ASC", $classid);
      if($res !== false) {
        return $res;
      }
    }

    function get_class_students_stat($class_id, $schoolyear) {
      $res = query("SELECT cl.*, e.*,
        	(SELECT interpretation FROM eccd_interpretation WHERE entity_id = cl.entity_id ORDER BY test_date DESC LIMIT 1) AS interpretation,
        	(SELECT ns.nstat FROM nutritional_history AS nh
        		LEFT JOIN sys_nutrition_stat AS ns ON nh.nstat_id = ns.nstat_code
        	WHERE nh.entity_id = cl.entity_id
        	ORDER BY ns_testdate DESC LIMIT 1) AS nstat
        FROM class_listing AS cl
        	LEFT JOIN entity AS e ON cl.entity_id = e.eid
        	LEFT JOIN class AS c ON cl.class_id = c.cid
        WHERE cl.class_id = ? AND c.schoolyear = ?
        ORDER BY e.lastname ASC", $class_id, $schoolyear);
      if($res !== false) {
        return $res;
      }
    }


    function sys_get_users() {
      $res = query("SELECT * FROM sys_user WHERE username <> ? ORDER BY username ASC", "MASTER");
      if($res !== false) {
        return $res;
      }
    }

    function sys_get_user_info($id) {
      $res = query("SELECT * FROM sys_user WHERE uid = ?", $id);
      if($res !== false) {
        return $res;
      }
    }

    function sys_get_user_roles($userid) {
      $res = query("SELECT ur.*, r.role_desc
        FROM sys_user_role AS ur
          LEFT JOIN sys_role AS r ON r.role_id = ur.role_id
        WHERE ur.user_id = ? AND ur.role_status = ?", $userid, 'ACTIVE');
      if($res !== false) {
        return $res;
      }
    }

    function sys_get_available_roles($userid) {

      $res = query("SELECT sr.*
        FROM sys_role AS sr
        WHERE sr.r_status = ? AND sr.role_id <> ?
          AND sr.role_id NOT IN (SELECT role_id FROM sys_user_role WHERE user_id = ?)
        ORDER BY sr.role_type DESC", 'ACTIVE', 'CARDINAL', $userid);
      if($res !== false) {
        return $res;
      }
    }

    function sys_get_locations() {
      $res = query("SELECT * FROM sys_address ORDER BY add_value ASC");
      if($res !== false) {
        return $res;
      }
    }

    function sys_get_nutritional_stat() {
      $res = query("SELECT * FROM sys_nutrition_stat ORDER BY nstat_order ASC");
      if($res !== false) {
        return $res;
      }
    }


    function get_eccd_list() {
      $res = query("SELECT * FROM sys_eccd ORDER BY `order` ASC");
      if($res !== false) {
        return $res;
      }
    }

    function get_eccd_history($eid, $student_id = NULL) {
      if($student_id == NULL) {
        // Student ID (SID) is not defined
        $res = query("SELECT ei.*, CONCAT(u.lastname, ', ', u.firstname) AS actor_name FROM eccd_interpretation AS ei
            LEFT JOIN sys_user AS u ON u.uid = ei.actor_id
          WHERE ei.entity_id = ? ORDER BY ei.test_date DESC", $eid);
      } else {
        $res = query("SELECT ei.*, CONCAT(u.lastname, ', ', u.firstname) AS actor_name FROM eccd_interpretation AS ei
            LEFT JOIN sys_user AS u ON u.uid = ei.actor_id
          WHERE ei.entity_id = ? AND ei.student_id = ? ORDER BY ei.test_date DESC", $eid, $student_id);
      }
      if($res !== false) {
        return $res;
      }
    }

    function get_standard_score($scaled_score) {
      $res = query("SELECT standard_score FROM sys_score_eq WHERE scaled_score = ?", $scaled_score);
      if($res === false) {
        return false;
      }

      if(count($res) == 0 AND $scaled_score < 29) {
        // wala naapil sa rate.. less than 29
        $standard_score = 0;
      }
      else if(count($res) == 0 AND $scaled_score > 98) {
        // nilapas super bright ang bata
        $standard_score = 138; // set to max if not found and score not in list
      }
      else {
        $standard_score = $res[0]["standard_score"];
      }

      return $standard_score; // return number

    }

    function get_interpretation($standard_score) {
      $res = query("SELECT dev_type FROM sys_interpretation WHERE ? BETWEEN threshold_a AND threshold_b", $standard_score);
      if($res !== false) {
        return $res[0]["dev_type"]; // return string
      }
    }


    function get_eccd_test_info($testid) {
      // return ECCD test info
      $res = query("SELECT ei.*, CONCAT(u.lastname,', ', u.firstname) AS actor_name FROM eccd_interpretation AS ei
          LEFT JOIN sys_user AS u ON u.uid = ei.actor_id
        WHERE ei.test_id = ?", $testid);
      if($res !== false) {
        return $res;
      }
    }

    function get_eccd_test_score($testid) {
      // return test scores
      $res = query("SELECT es.* FROM eccd_score AS es
          LEFT JOIN sys_eccd AS se ON se.eccd_id = es.eccd_id
        WHERE es.test_id = ? ORDER BY se.`order` ASC", $testid);
      if($res !== false) {
        return $res;
      }
    }

    function get_eccd_test_count($entityid, $student_id) {
      // return test count
      $res = query("SELECT COUNT(1) AS testcount FROM eccd_interpretation WHERE entity_id = ? AND student_id = ?", $entityid, $student_id);
      if($res !== false) {
        return $res[0]["testcount"]; // return whole number
      }
    }

    function get_eccd_latest_result($entityid, $student_id) {
      //     OLD CODE
      // // get the latest test result for specific entity and classid
      // $res = query("SELECT interpretation FROM eccd_interpretation WHERE entity_id = ? AND class_id = ? ORDER BY test_date DESC LIMIT 1", $entityid, $classid);
      // =====================================================

      // get the latest eccd result based on student_id
      $res = query("SELECT interpretation
          FROM eccd_interpretation
          WHERE student_id = ?
          ORDER BY test_date DESC LIMIT 1", $student_id);
      if($res !== false) {
        if(count($res) == 1) {
          return $res[0]["interpretation"];
        } else {
          return '<i>NA</i>';
        }
      } else {
        return null;
      }
    }


    function count_entity() {
      // if(lookup_role('ENTITY_ADMIN') === false) {
      //   // user level
      //   $res = query("SELECT COUNT(1) AS c FROM entity WHERE actor_id = ?", $GLOBALS["_uid"]);
      // } else {
      //   $res = query("SELECT COUNT(1) AS c FROM entity");
      // }
      $res = query("SELECT COUNT(1) AS c FROM entity");
      if($res <> false) {
        return $res[0]["c"]; // return number
      }
    }

    function count_center() {
      if(lookup_role('SYS_ADMIN') === false) {
        // user level
        $res = query("SELECT COUNT(1) AS c FROM devcenter AS d
          LEFT JOIN devcenter_teacher AS t ON d.cdc_id = t.center_id
          WHERE t.teacher_id = ?", $GLOBALS["_uid"]);
      } else {
        $res = query("SELECT COUNT(1) AS c FROM devcenter");
      }
      if($res <> false) {
        return $res[0]["c"]; // return number
      }
    }

    function count_class() {
      if(lookup_role('SYS_ADMIN') === false) {
        // user level
        $res = query("SELECT COUNT(1) AS c FROM class
          WHERE teacher_id = ?", $GLOBALS["_uid"]);
      } else {
        $res = query("SELECT COUNT(1) AS c FROM class");
      }
      if($res <> false) {
        return $res[0]["c"]; // return number
      }
    }

    function count_teacher() {
      $res = query("SELECT COUNT(DISTINCT(teacher_id)) AS c FROM devcenter_teacher");
      if($res <> false) {
        return $res[0]["c"]; // return number
      }
    }

    function count_entity_sex() {
      // if(lookup_role('ENTITY_ADMIN') === false) {
      //   // user level
      //   $res = query("SELECT SUM(CASE WHEN sex = 'MALE' THEN 1 ELSE 0 END) AS male,
      //         SUM(CASE WHEN sex = 'FEMALE' THEN 1 ELSE 0 END) AS female
      //     FROM entity WHERE actor_id = ?", $GLOBALS["_uid"]);
      // } else {
      //   $res = query("SELECT SUM(CASE WHEN sex = 'MALE' THEN 1 ELSE 0 END) AS male,
      //         SUM(CASE WHEN sex = 'FEMALE' THEN 1 ELSE 0 END) AS female
      //    FROM entity");
      // }
      $res = query("SELECT SUM(CASE WHEN sex = 'MALE' THEN 1 ELSE 0 END) AS male,
            SUM(CASE WHEN sex = 'FEMALE' THEN 1 ELSE 0 END) AS female
       FROM entity");
      if($res <> false) {
        return $res; // return number
      }
    }

    function count_entity_ips() {
      // if(lookup_role('ENTITY_ADMIN') === false) {
      //   // user level
      //   $res = query("SELECT COUNT(1) AS c FROM entity WHERE actor_id = ? AND ips = ?", $GLOBALS["_uid"], 'YES');
      // } else {
      //   $res = query("SELECT sex, COUNT(1) AS c FROM entity WHERE ips = ?", 'YES');
      // }
      $res = query("SELECT sex, COUNT(1) AS c FROM entity WHERE ips = ?", 'YES');
      if($res <> false) {
        return $res[0]["c"]; // return number
      }
    }

    function count_entity_4ps() {
      // if(lookup_role('ENTITY_ADMIN') === false) {
      //   // user level
      //   $res = query("SELECT COUNT(1) AS c FROM entity WHERE actor_id = ? AND 4ps = ?", $GLOBALS["_uid"], 'YES');
      // } else {
      //   $res = query("SELECT sex, COUNT(1) AS c FROM entity WHERE 4ps = ?", 'YES');
      // }
      $res = query("SELECT sex, COUNT(1) AS c FROM entity WHERE 4ps = ?", 'YES');
      if($res <> false) {
        return $res[0]["c"]; // return number
      }
    }

    function count_entity_pwd() {
      // if(lookup_role('ENTITY_ADMIN') === false) {
      //   // user level
      //   $res = query("SELECT COUNT(1) AS c FROM entity WHERE actor_id = ? AND pwd = ?", $GLOBALS["_uid"], 'YES');
      // } else {
      //   $res = query("SELECT sex, COUNT(1) AS c FROM entity WHERE pwd = ?", 'YES');
      // }
      $res = query("SELECT sex, COUNT(1) AS c FROM entity WHERE pwd = ?", 'YES');
      if($res <> false) {
        return $res[0]["c"]; // return number
      }
    }

    function get_nstat_history($eid, $student_id = NULL) {
      if($student_id == NULL) {
        // Class ID is not defined
        $res = query("SELECT nh.*, CONCAT(u.lastname, ', ', u.firstname) AS actor_name, ns.nstat FROM nutritional_history AS nh
            LEFT JOIN sys_nutrition_stat AS ns ON ns.nstat_code = nh.nstat_id
            LEFT JOIN sys_user AS u ON u.uid = nh.actor_id
          WHERE nh.entity_id = ? ORDER BY nh.ns_testdate DESC", $eid);
      } else {
        $res = query("SELECT nh.*, CONCAT(u.lastname, ', ', u.firstname) AS actor_name, ns.nstat FROM nutritional_history AS nh
            LEFT JOIN sys_nutrition_stat AS ns ON ns.nstat_code = nh.nstat_id
            LEFT JOIN sys_user AS u ON u.uid = nh.actor_id
          WHERE nh.entity_id = ? AND nh.student_id = ? ORDER BY nh.ns_testdate DESC", $eid, $student_id);
      }
      if($res !== false) {
        return $res;
      }
    }

    function get_latest_nstat_result($entityid, $student_id) {
      //  OLD CODE
      //  $res = query("SELECT n.nstat
      //   FROM nutritional_history AS nh
      //     LEFT JOIN sys_nutrition_stat AS n ON n.nstat_code = nh.nstat_id
      //   WHERE nh.entity_id = ? AND nh.class_id = ? ORDER BY nh.ns_testdate DESC LIMIT 1", $entityid, $classid);
      $res = query("SELECT n.nstat
        FROM nutritional_history AS nh
          LEFT JOIN sys_nutrition_stat AS n ON n.nstat_code = nh.nstat_id
        WHERE nh.entity_id = ? AND nh.student_id = ? ORDER BY nh.ns_testdate DESC LIMIT 1", $entityid, $student_id);
      if($res !== false) {
        if(count($res) == 1) {
          return $res[0]["nstat"];
        } else {
          return '<i>NA</i>';
        }
      } else {
        return null;
      }
    }

    function has_nstat_record($eid) {
      $res = query("SELECT * FROM nutritional_record WHERE entity_id = ?", $eid);
      if($res !== false) {
        if(count($res) >= 1) {
          return true;
        } else {
          return false;
        }
      }
    }

    function has_eccd_record($eid) {
      $res = query("SELECT * FROM eccd_record WHERE entity_id = ?", $eid);
      if($res !== false) {
        if(count($res) >= 1) {
          return true;
        } else {
          return false;
        }
      }
    }

    function is_latest_eccd_test($test_id) {
      $res = query("SELECT * FROM eccd_record WHERE test_id = ?", $test_id);
      if($res !== false) {
        if(count($res) >= 1) {
          return true; // found match. test id is the latest
        } else {
          return false;
        }
      }
    }

    function is_username_taken($username) {
      $res = query("SELECT * FROM sys_user WHERE username = ?", $username);
      if($res !== false) {
        if(count($res) >= 1) {
          return true;
        } else {
          return false;
        }
      }
    }


    function get_transfer_request() {
      // // identify if user is CENTER teacher
      $is_teacher = lookup_role('CDC_TEACHER');
      if($is_teacher === true) {
        $res = query("SELECT ct.*,
          	o.class_name AS origin_code, o.class_desc AS origin_desc, CONCAT(ou.lastname,', ', ou.firstname) AS origin_teacher, oc.centername AS origin_center,
          	t.class_name AS target_code, t.class_desc AS target_desc, CONCAT(tu.lastname,', ', tu.firstname) AS target_teacher, tc.centername AS target_center,
          	CONCAT(a.lastname,', ', a.firstname) AS requestor,
          	CONCAT(e.lastname,', ', e.firstname) AS student,
          	cl.student_idno AS student_no
          FROM class_transfer AS ct
          LEFT JOIN class AS o ON ct.origin_cid = o.cid
          	LEFT JOIN sys_user AS ou ON o.teacher_id = ou.uid
          	LEFT JOIN devcenter AS oc ON o.center_id = oc.cdc_id
          LEFT JOIN class AS t ON ct.target_cid = t.cid
          	LEFT JOIN sys_user AS tu ON t.teacher_id = tu.uid
          	LEFT JOIN devcenter AS tc ON t.center_id = tc.cdc_id
          LEFT JOIN sys_user AS a ON ct.actor_id = a.uid
          LEFT JOIN class_listing AS cl ON ct.student_id = cl.sid
          LEFT JOIN entity AS e ON cl.entity_id = e.eid
          WHERE t.teacher_id = ? AND ct.transfer_status = 'PENDING'", $GLOBALS["_uid"]);
      } else {
        // identify if admin
        $is_admin = lookup_role('SYS_ADMIN');
        if($is_admin === true) {
          $res = query("SELECT ct.*,
          	o.class_name AS origin_code, o.class_desc AS origin_desc, CONCAT(ou.lastname,', ', ou.firstname) AS origin_teacher, oc.centername AS origin_center,
          	t.class_name AS target_code, t.class_desc AS target_desc, CONCAT(tu.lastname,', ', tu.firstname) AS target_teacher, tc.centername AS target_center,
          	CONCAT(a.lastname,', ', a.firstname) AS requestor,
          	CONCAT(e.lastname,', ', e.firstname) AS student,
          	cl.student_idno AS student_no
          FROM class_transfer AS ct
          LEFT JOIN class AS o ON ct.origin_cid = o.cid
          	LEFT JOIN sys_user AS ou ON o.teacher_id = ou.uid
          	LEFT JOIN devcenter AS oc ON o.center_id = oc.cdc_id
          LEFT JOIN class AS t ON ct.target_cid = t.cid
          	LEFT JOIN sys_user AS tu ON t.teacher_id = tu.uid
          	LEFT JOIN devcenter AS tc ON t.center_id = tc.cdc_id
          LEFT JOIN sys_user AS a ON ct.actor_id = a.uid
          LEFT JOIN class_listing AS cl ON ct.student_id = cl.sid
          LEFT JOIN entity AS e ON cl.entity_id = e.eid
          WHERE ct.transfer_status = 'PENDING'
            ORDER BY ct.transfer_date ASC");
        } else {
          // user only role cannot view notifications
          // should only return 0 results
          $res = query("SELECT ct.*,
          	o.class_name AS origin_code, o.class_desc AS origin_desc, CONCAT(ou.lastname,', ', ou.firstname) AS origin_teacher, oc.centername AS origin_center,
          	t.class_name AS target_code, t.class_desc AS target_desc, CONCAT(tu.lastname,', ', tu.firstname) AS target_teacher, tc.centername AS target_center,
          	CONCAT(a.lastname,', ', a.firstname) AS requestor,
          	CONCAT(e.lastname,', ', e.firstname) AS student,
          	cl.student_idno AS student_no
          FROM class_transfer AS ct
          LEFT JOIN class AS o ON ct.origin_cid = o.cid
          	LEFT JOIN sys_user AS ou ON o.teacher_id = ou.uid
          	LEFT JOIN devcenter AS oc ON o.center_id = oc.cdc_id
          LEFT JOIN class AS t ON ct.target_cid = t.cid
          	LEFT JOIN sys_user AS tu ON t.teacher_id = tu.uid
          	LEFT JOIN devcenter AS tc ON t.center_id = tc.cdc_id
          LEFT JOIN sys_user AS a ON ct.actor_id = a.uid
          LEFT JOIN class_listing AS cl ON ct.student_id = cl.sid
          LEFT JOIN entity AS e ON cl.entity_id = e.eid
          WHERE t.teacher_id = ? AND ct.transfer_status = 'PENDING'", '1');
        }
      }

      return $res;

    }

    function get_transfer_request_info($request_id) {
      $res = query("SELECT ct.*,
          o.class_name AS origin_code, o.class_desc AS origin_desc, CONCAT(ou.lastname,', ', ou.firstname) AS origin_teacher, oc.centername AS origin_center,
          t.class_name AS target_code, t.class_desc AS target_desc, CONCAT(tu.lastname,', ', tu.firstname) AS target_teacher, tc.centername AS target_center,
          CONCAT(r.lastname,', ', r.firstname) AS requestor,
          CONCAT(e.lastname,', ', e.firstname) AS student,
          e.eid,
          CONCAT(a.lastname,', ', a.firstname) AS approver,
          cl.student_idno AS student_no
        FROM class_transfer AS ct
        LEFT JOIN class AS o ON ct.origin_cid = o.cid
          LEFT JOIN sys_user AS ou ON o.teacher_id = ou.uid
          LEFT JOIN devcenter AS oc ON o.center_id = oc.cdc_id
        LEFT JOIN class AS t ON ct.target_cid = t.cid
          LEFT JOIN sys_user AS tu ON t.teacher_id = tu.uid
          LEFT JOIN devcenter AS tc ON t.center_id = tc.cdc_id
        LEFT JOIN sys_user AS r ON ct.actor_id = r.uid
        LEFT JOIN class_listing AS cl ON ct.student_id = cl.sid
        LEFT JOIN entity AS e ON cl.entity_id = e.eid
        LEFT JOIN sys_user AS a ON ct.approver_id = a.uid
        WHERE ct.ctid = ? LIMIT 1", $request_id);
      if($res === false) {
        return false;
      } else {
        if(count($res) <= 0) {
          return false;
        } else {
          return $res[0];
        }
      }
    }


    function has_pending_transfer($student_id) {
      // verify if student has pending transfers
      $res = query("SELECT * FROM class_transfer WHERE student_id = ?", $student_id);
      if($res !== false) {
        if(count($res) >= 1) {
          // has pending transfers
          return true;
        } else {
          return false;
        }
      } else {
        throw_error("get_pending_transfer_failed");
      }
    }


    function get_religion() {
      $res = query("SELECT * FROM settings_religion ORDER BY religion ASC");
      if($res === false) {
        return false;
      } else {
        return $res;
      }
    }


    function get_ethnicity() {
      $res = query("SELECT * FROM settings_ethnicity ORDER BY ethnicity ASC");
      if($res === false) {
        return false;
      } else {
        return $res;
      }
    }
