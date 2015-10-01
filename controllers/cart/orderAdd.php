<?php
include '../../libs/db.php'; include '../../libs/function.php';



if(isset($_GET['idProduct'])) {$idProduct = $_GET['idProduct'];} else {$idProduct = 0;}
if(isset($_GET['priceProduct'])) {$priceProduct = $_GET['priceProduct'];} else {$priceProduct = 0;}
if(isset($_GET['number'])) {$number = $_GET['number'];} else $number = 1;




if(isset($_COOKIE['product'])) {
	if($_COOKIE['product'] == '0') { 
		//IF COOKIE EMPTY
		$product[$idProduct][$priceProduct] = $number;
		SetCookie("product", serialize($product), time()+3600,"/");
		
	} else {
		//IF COOKIE HAVE DATA
		$product = unserialize($_COOKIE['product']);
		$product[$idProduct][$priceProduct] = $number;
		SetCookie("product", serialize($product), time()+360000,"/");
		//echo $number;
	}
}