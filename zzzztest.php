<?php
    require("includes/config.php");

    //require_once("includes\phpqrcode\qrlib.php");
    //QRcode::png("qr testing sample bla bla lba");

    //phpinfo();


    $q = query("SELECT ct.*,
      o.class_name AS origin_code, o.class_desc AS origin_desc, CONCAT(ou.lastname,", ", ou.firstname) AS origin_teacher
FROM class_transfer AS ct
LEFT JOIN class AS o ON ct.origin_cid = o.cid
	LEFT JOIN sys_user AS ou ON o.teacher_id = ou.uid
LEFT JOIN class AS t ON ct.target_cid = t.cid
	LEFT JOIN sys_user AS tu ON t.teacher_id = tu.uid
WHERE t.teacher_id = 'USR:c09241fd3bda91f-083c'");

dump($q);

?>
