<?php
///////////////////////////////////////////////////////////
//	Генерация страницы ошибки при доступе вне системы  
    if(!defined('MY_KEY'))  
    {  
       header("HTTP/1.1 404 Not Found");        
       exit(file_get_contents('./404.html'));  
    }      
///////////////////////////////////////////////////////////  
echo "\n<!-- ################ cat ################### -->\n";


//echo $action;



if (isset($action) AND !empty($action)) { //Ищем категорию

$query = "SELECT * FROM `main` WHERE `url`='$action' AND catalog='1'";
$result = mysqli_query($db, $query);
  if (mysqli_num_rows($result)>0) {
    
      $row = mysqli_fetch_assoc($result);
      $title = $row['title'];
      $keywords = $row['keywords'];
      $description = $row['description'];
      $text = $row['pagetext'];
      echo "<h1 class=\"first\">".$title."</h1>";
      echo $text;


      ############# вывод всех продуктов из категорий потомков ###############
      $idchild = find_parent_id($cat_tree,$row['id']);//Вытавскиваем id категорий всех потомков
      if (!empty($idchild)) {
        $query = "SELECT * FROM `product` WHERE cat_id IN(" . $idchild . ")"; //Вытаскиваем все продукты из категорий потомков если такие есть
        $result3 = mysqli_query($db,$query);
        if (mysqli_num_rows($result3)>0) {
          while ($row3 = mysqli_fetch_assoc($result3)) {
            $query = "SELECT * FROM img WHERE product_id = $row3[product_id]";
            //echo $query;
            $res = mysqli_query($db,$query);
            $rowimg = mysqli_fetch_assoc($res);
            $imgpath = '/img/cat/'.$row3['cat_id'].'/'.$rowimg['name'];
            //echo $imgpath;
            build_product($row3['name'],$row3['price'],$imgpath,$row3['url'],$row3['product_id']);
          }
        }
         echo '<br style="clear:both">';
      }
      ############# вывод всех продуктов из категорий потомков ###############
      
      

      #########Вывод продуктов которые относятся к конкретной категории#######
      $query = "SELECT * FROM `product` WHERE cat_id = $row[id]";
      
      $result2 = mysqli_query($db,$query);


      if (mysqli_num_rows($result2)>0) {



        while ($row2 = mysqli_fetch_assoc($result2)) {
          //show_product($row2['name'], $row2['price']);
          
          $res = mysqli_query($db,"SELECT * FROM img WHERE product_id = $row2[product_id]");
          $rowimg = mysqli_fetch_assoc($res);
          #echo $rowimg['name'];
          #echo $row['id'];
          $imgpath = '/img/cat/'.$row['id'].'/'.$rowimg['name'];
          #echo $imgpath;

          build_product($row2['name'],$row2['price'],$imgpath,$row2['url'],$row2['product_id']);
        }
        echo '<br style="clear:both">';
      }
      #########Вывод продуктов которые относятся к конкретной категории#######


  } else {
      header('Location: /404.html');
    exit;
  }
} 