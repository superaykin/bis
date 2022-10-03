<?php

	function create_uuid($id_type) {
		$arr = array(":","-");
		$rk = array_rand($arr,2);
		$g_uuid = generate_uuid();
		$pad = generate_pad();
		$generated_id = $id_type . $arr[$rk[0]] . $g_uuid . $arr[$rk[1]] . $pad;
		return $generated_id;
	}

	function generate_uuid($lenght = 15) {
		// uniqid gives 13 chars, but you could adjust it to your needs.
		if (function_exists("random_bytes")) {
			$bytes = random_bytes(ceil($lenght / 2));
		} elseif (function_exists("openssl_random_pseudo_bytes")) {
			$bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
		} else {
			throw new Exception("no cryptographically secure random function available");
		}
		return substr(bin2hex($bytes), 0, $lenght);
	}

	function generate_pad($lenght = 4) {
		// uniqid gives 13 chars, but you could adjust it to your needs.
		if (function_exists("random_bytes")) {
			$bytes = random_bytes(ceil($lenght / 2));
		} elseif (function_exists("openssl_random_pseudo_bytes")) {
			$bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
		} else {
			throw new Exception("no cryptographically secure random function available");
		}
		return substr(bin2hex($bytes), 0, $lenght);
	}


?>
