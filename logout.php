<?php

    // configuration
    require("./includes/config.php");

	if(!isset($_SESSION["ecmspanabo"])) {
		redirect("./");
	}

	// log out current user, if any
	logout();

	// redirect user
	//redirect("./");

?>
