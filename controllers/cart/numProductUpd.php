<?php
include '../../libs/db.php'; include '../../libs/function.php';
//RETURN FROM COOKIE NUMBER OF TOTAL PRODUCT

if(isset($_COOKIE['product'])) {
	if($_COOKIE['product'] == '0') { 
		//IF COOKIE EMPTY
		echo 0;
	} else {
		//IF COOKIE HAVE DATA
		$product = unserialize($_COOKIE['product']);
		echo count($product);
	}
} else { echo 0;}