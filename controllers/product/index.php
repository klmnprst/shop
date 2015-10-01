<?php
///////////////////////////////////////////////////////////
//	Генерация страницы ошибки при доступе вне системы  
    if(!defined('MY_KEY'))  
    {  
       header("HTTP/1.1 404 Not Found");        
       exit(file_get_contents('./404.html'));  
    }      
///////////////////////////////////////////////////////////  
echo "\n<!-- ################ product ################### -->\n";


//echo $action;



if (isset($action) AND !empty($action)) { //Ищем категорию

$query = "SELECT product.*, main.name AS cat_name, main.url AS cat_url, img.name AS img_name FROM product LEFT JOIN main ON product.cat_id = main.id LEFT JOIN img USING(product_id) WHERE product.url='$action'";
//echo $query;
//exit();
$result = mysqli_query($db, $query);
  if (mysqli_num_rows($result)>0) {
      $row = mysqli_fetch_assoc($result);

      $img = '/img/cat/'.$row['cat_id'].'/'.$row['img_name'];
      $text = $row['pagetext'];
      $title = $row['title'];
      $keywords = $row['keywords'];
      $description = $row['description'];
      $cat_url = $row['cat_url'];
      $cat_name = $row['cat_name'];
/**/
      
      #$price = $row['price'];
      #$cat_id = $row['cat_id'];
      
      
      #$img_name = $row['img_name'];
/**/
      echo "<h1 class=\"first\">".$title."</h1>";
      echo '<p><a href="/cat/'.$cat_url.'">'.$cat_name.'</a></p>';


      build_product($row['name'],$row['price'],$img,$action,$row['product_id'],$text);



  } else {
      header('Location: /404.html');
    exit;
  }
} 