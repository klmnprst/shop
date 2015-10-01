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
		$basketSum = 0;
		foreach ($product as $k1 => $v1) 	{
			foreach($v1 as $k2 => $v2) 	{
				$basketSum = $basketSum + $k2*$v2;
			}
		}
		echo $basketSum.' р.';
	}
} else { echo 0;}