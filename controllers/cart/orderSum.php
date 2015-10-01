<?php
include '../../libs/db.php'; 
include '../../libs/function.php';



if(isset($_GET['product_id'])) 	{$product_id = $_GET['product_id'];if($product_id < 1) $product_id = 1;} else {$product_id = 1;}
if(isset($_GET['number'])) 		{$number = $_GET['number'];if($number < 1) $number = 1;} else {$number = 1;}


if(isset($_COOKIE['product'])) {
	if($_COOKIE['product'] != '0')  {
		//IF COOKIE HAVE DATA
		$product = unserialize($_COOKIE['product']);
		//change value of massive
		foreach ($product as $k1 => $v1) 	{
			foreach($v1 as $k2 => $v2) 	{
				if($k1 == $product_id) {
					$product[$k1][$k2] = $number;
				}
			}
		}
		SetCookie("product", serialize($product), time()+360000,"/");
	}
}
