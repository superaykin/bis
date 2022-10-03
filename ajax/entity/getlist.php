<?php
  require("../../includes/config.php");
  require( '../../includes/ssp.class.php' );
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'entity';

// Table's primary key
$primaryKey = 'eid';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'lastname', 'dt' => 0 ),
    array( 'db' => 'firstname', 'dt' => 1 ),
    array( 'db' => 'middlename', 'dt' => 2 ),
    array( 'db' => 'suffix', 'dt' => 3 ),
    array( 'db' => 'sex', 'dt' => 4 ),
    array(
        'db' => 'birthdate',
        'dt' => 5,
        'formatter' => function($dob) {
            $fdob = new DateTime($dob);
            return $dob = $fdob->format("M d, Y");
        }
    ),
    array(
        'db'        => 'eid',
        'dt'        => 6,
        'formatter' => function($id) {
            return '<a href="./entity.php?page=info&id=' . $id . '" class="btn btn-primary btn-xs btn-flat">View</a>';
        }
    ),
);

// SQL server connection information
$sql_details = array(
    'user' => USERNAME,
    'pass' => PASSWORD,
    'db'   => DATABASE,
    'host' => SERVER
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */


echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);
