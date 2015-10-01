<?php
///////////////////////////////////////////////////////////
//	Генерация страницы ошибки при доступе вне системы  
    if(!defined('MY_KEY'))  
    {  
       header("HTTP/1.1 404 Not Found");        
       exit(file_get_contents('./404.html'));  
    }      
///////////////////////////////////////////////////////////  
echo "\n<!-- ################ page ################### -->\n";


$url = $controller;
$url = (($url == 'default')  ? '/' : $url);


if (isset($url) AND !empty($url)) {


$result = mysqli_query($db, "SELECT * FROM main WHERE url='$url'");
  if (mysqli_num_rows($result)>0) {
      $row = mysqli_fetch_assoc($result);
      $title = $row['title'];
      $keywords = $row['keywords'];
      $description = $row['description'];
      $text = $row['pagetext'];
      echo "<h1 class=\"first\">".$title."</h1>";
      echo $text;
  } else {
    header('Location: /404.html');
    exit;
  }



} 