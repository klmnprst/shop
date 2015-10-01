<?php
include '../../libs/db.php'; 
include '../../libs/function.php';



if(isset($_GET['product_id'])) {$product_id = $_GET['product_id'];}
//if(isset($_GET['priceProduct'])) {$priceProduct = $_GET['priceProduct'];}

if(isset($_COOKIE['product'])) {
		//IF COOKIE HAVE DATA
		$product = unserialize($_COOKIE['product']);
		//print_arr($product);
		unset($product["$product_id"]);
		SetCookie("product", serialize($product), time()+360000,"/");
}