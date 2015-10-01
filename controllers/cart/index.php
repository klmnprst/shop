<?php
///////////////////////////////////////////////////////////
//	Генерация страницы ошибки при доступе вне системы  
    if(!defined('MY_KEY'))  
    {  
       header("HTTP/1.1 404 Not Found");        
       exit(file_get_contents('./404.html'));  
    }      
///////////////////////////////////////////////////////////  
echo "\n<!-- ################ cart ################### -->\n";
session_start();
if(isset($_SESSION['report'])) {$report = $_SESSION['report']; session_destroy();}







//////////////////////////////////////////////////////////
//                                                      //
//          Блок отправки информации                    //
//                                                      //
//////////////////////////////////////////////////////////

if(isset($_POST['go'])) {
  
  //Get product info from cookie
  if(isset($_COOKIE['product'])) {
    if($_COOKIE['product'] != '0')  {
      //IF COOKIE HAVE DATA
      $product = unserialize($_COOKIE['product']);
      
      $info = ''; //Информация о заказе
      $totalOrderPrice = '0'; //Цена итого
      foreach ($product as $k1 => $v1)  {
        foreach($v1 as $k2 => $amount)  {
          //GET INFO FROM PRODUCT:
          $result = mysqli_query($db,"SELECT `name`,`price` FROM `product` WHERE product_id=$k1");
          $row = mysqli_fetch_assoc($result);
          $info .= $row['name']."\nКол-во: ".$amount."\nЦена: ".$row['price']."\n\n<br>";
          $totalOrderPrice = $totalOrderPrice + $row['price']*$amount;
        }
      }
      $info .= "\n\n<br>Итого: ".$totalOrderPrice;
      //echo $info;
    }
  } 


if (!empty($_POST['orderPhone']))   { 
if (!empty($_POST['orderMail']))  {

$orderName    = mysqli_real_escape_string($db,$_POST['orderName']);
$orderMail    = mysqli_real_escape_string($db,$_POST['orderMail']);
$orderPhone   = mysqli_real_escape_string($db,$_POST['orderPhone']);
$orderAddress = mysqli_real_escape_string($db,$_POST['orderAddress']);
$orderComment = mysqli_real_escape_string($db,$_POST['orderComment']);


//Проверка ящика
if(checkmail($orderMail) !== -1) {
    
    $online_theme = 'Подтверждение заказа';
    $online_theme = '=?UTF-8?B?'.base64_encode($online_theme).'?=';

    //Отправка письмо если все проверено!
    $message = "Письмо с сайта *.ru\nВаши данные:\nИмя: {$orderName}\nТелефон: {$orderPhone}\nE-mail: {$orderMail}\nАдрес: {$orderAddress}\nКомментарий: {$orderComment}\n\nВаш заказ:\n\n{$info}";
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers="Content-type: text/plain; charset=\"UTF-8\"";
    $headers.="From: <{$orderMail}>";
    $headers.="Subject: {$online_theme}";
    $headers.="Content-type: text/plain; charset=\"UTF-8\"";


    
      
      


    if(mail("sidorof@gmail.com, klmnprst@gmail.com",$online_theme,$message,$headers) !== FALSE) 
    {
      #записать в базу данные из кук и в письмо что там заказали, обнулить куки
        if(isset($_COOKIE['product'])) {
          if($_COOKIE['product'] != '0')  {
            //IF COOKIE HAVE DATA
            $product = unserialize($_COOKIE['product']);
            foreach ($product as $k1 => $v1)  {
              foreach($v1 as $k2 => $v2)  {
                //echo "price = ".$k2."<br />";
                //echo "num = ".$v2."<br />";

                
                //WRITE INFO FOR DB
                $result = mysqli_query($db,"INSERT INTO `order` (id_product,price,num,name,phone,mail,address,comment,time) 
                  VALUE ($k1,$k2,$v2,$orderName,$orderPhone,$orderMail,$orderAddress,$orderComment,time())");
         

                //стереть куки
                setcookie ("product", "", time() - 3600);
                
              }
            }
            
          }
        } 





      //echo "<p>Спасибо, ваш заказ принят!</p>";
    session_start();
    $_SESSION['report'] = "<p>Спасибо, ваш заказ принят!</p>";
    header('Location: /cart');  
    } 
      else 
    {
      echo "<p>Возникла ошибка при отправке письма<br/><a href=\"javascript:history.back()\">назад</a></p>";
    }
} 
  else
{
  echo "<p>Введите корректный электронный адрес <a href=\"javascript:history.back()\">назад</a></p>";
}





} else {  echo "<p>Вы не ввели e-mail <a href=\"javascript:history.back()\">назад</a></p>"; }     
} else {  echo "<p>Вы не указали телефон <a href=\"javascript:history.back()\">назад</a></p>";  }






}
























if(isset($_COOKIE['product']) AND ($_COOKIE['product'] != '0')) { ?>

<p class="basketInfo">Пожалуйста, проверьте Ваш заказ:</p>

<table border="0" id="basketTbl">
    <tr class="basketTblHead">
        <td>Фото</td>
        <td>Товар</td>
        <td>Артикул</td>
    <td>Цена, руб</td>
        <td>Кол-во</td>
        <td>Убрать</td>
    </tr>



<?php


$arr = unserialize($_COOKIE['product']);
$total = 0;
  foreach ($arr as $k1 => $v1)  {
    foreach($v1 as $k2 => $v2)  {
      $total = $total + $k2*$v2;
    }
  }


foreach ($arr as $product_id => $value) {  
  
  //GET INFO FROM PRODUCT:
  $query  = "SELECT product.*,img.name AS img_name FROM `product` LEFT JOIN `img` USING(product_id) WHERE product_id=$product_id";
  #echo $query;
  $result = mysqli_query($db,$query);
  if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      $product_name = $row['name'];
      $price = $row['price'];
      $cat_id = $row['cat_id'];
      $product_url = $row['url'];
      $img_name = $row['img_name'];

      //GET IMG BEGIN
      $path = '/img/cat/'.$cat_id.'/'.$img_name;
      #echo $path;
      if(file_exists($_SERVER['DOCUMENT_ROOT'].$path)) {
      $img = '<img src='.$path.' style="height:100px;" />';
      }

    //PRINT DATA ?>  
    <tr id="<?php echo $product_id; ?>" class="basketTblBody">
        <td><?php echo $img; ?></td>
        <td><?php echo $product_name; ?></td>
        <td><?php echo $product_id; ?></td>
        <td class="priceProduct"><?php echo $price; ?></td>
        <td><input type="text" value="<?php numProduct($product_id);?>" style="width:30px;" /></td>
        <td><img src="/template/img/delete.png" alt="Убрать" title="Убрать" class="drop"/></td>
    </tr>

    <?php
    
  }

  



}

?>
</table>


  <p class="basketInfo">Сумма заказа: <strong id="total"><?php echo $total; ?> р.</strong></p>
  <form action="" method="POST" id="orderForm">
    <div>Имя:</div> <input type="text" name="orderName" id="orderName" value="<?php if(isset($_POST['orderName'])) echo $_POST['orderName']; ?>"><br />
    <div>E-mail:*</div>     <input type="text" name="orderMail" id="orderMail" value="<?php if(isset($_POST['orderMail'])) echo $_POST['orderMail']; ?>"><br />
    <div>Телефон:*</div>    <input type="text" name="orderPhone" id="orderPhone" value="<?php if(isset($_POST['orderPhone'])) echo $_POST['orderPhone']; ?>"><br />
    <div>Адрес доставки:</div>  <input type="text" name="orderAddress" id="orderAddress" value="<?php if(isset($_POST['orderAddress'])) echo $_POST['orderAddress']; ?>"><br />
    <div>Комментарий:</div>   <input type="text" name="orderComment" id="orderComment" value="<?php if(isset($_POST['orderComment'])) echo $_POST['orderComment']; ?>"><br />
    <input type="submit" value="оформить" name="go" class="go">
  </form>


<?php 
} else {
  if (isset($report)) {
    echo $report;
  } else {
  echo '<p>Ваша корзина пуста. Выберете понравившиеся продукты из каталога добавив их в корзину</p>';
  }
}

