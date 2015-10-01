<?php 


function print_arr($arr) {
  echo '<pre style=font-size:12px;color:gray;>';
  print_r($arr);
  echo '</pre>';

}

/////////////// Функция построения дерева ////////////////
function build_tree_class($arr,$parent,$class=''){
    if (is_array($arr) and isset($arr[$parent])){

        if(empty($class))
            $tree = "\n<ul>";
        else
            $tree = "\n".'<ul class='.$class.'>'."\n";

        foreach($arr[$parent] as $key=>$value){
            if($value['url'] == '/') {$value['url'] = '';}
            //$tree .= '<li class="active"><a href="/'.$value['url'].'">'.$value['name'].'</a>';
            $tree .= '<li><a href="/'.$value['url'].'">'.$value['name'].'</a>';
            $tree .=  build_tree($arr,$key,"dropdown");
            $tree .= "</li>\n";
            $tree .=  '<li class="divider"></li>';
        }
        $tree .= "\n";
    } else { return null; }
    return $tree;
}


function build_tree($arr,$parent,$id=''){
    if (is_array($arr) and isset($arr[$parent])){
        
        if(empty($id)) 
        $tree = "\n<ul>";
        else
        $tree = "\n".'<ul class='.$id.'>'."\n";
        
    	foreach($arr[$parent] as $key=>$value){
        	if($value['url'] == '/') {$value['url'] = '';}
          $tree .= '<li><a href="/'.$value['url'].'">'.$value['name'].'</a>';
          		$tree .=  build_tree($arr,$key);
        	$tree .= "</li>\n";    
    	}
        $tree .= "<div class=\"clear\"></div></ul>\n"; 
	} else { return null; }
    return $tree;
}
/////////////// Функция построения дерева ////////////////

/////////////// Функция построения дерева для каталога ////////////////
function build_cat_tree($arr,$parent,$id=''){

  
    if (is_array($arr) and isset($arr[$parent])){
        
        if(empty($id)) 
        $tree = "\n<ul>\n";
        else
        $tree = "\n".'<ul class='.$id.'>'."\n";
        
      foreach($arr[$parent] as $key=>$value){
          $tree .= '<li><a href="/cat/'.$value['url'].'">'.$value['name'].'</a>'; //просто добавлено в путь 'cat'
              $tree .=  build_cat_tree($arr,$key);
          $tree .= "</li>\n";    
      }
        $tree .= "\n</ul>\n"; 
  } else { return null; }
    
    return $tree;
    
}
/////////////// Функция построения дерева для каталога ////////////////



// Функция выводит id категорий потомков
function find_parent_id($arr,$parent){
  //print_arr($arr);
    if (is_array($arr) and isset($arr[$parent])){
      $tree = '';
      foreach($arr[$parent] as $key=>$value){
          $tree .= $value['id'].",";
          $tree .=  find_parent_id($arr,$key);
      }
  } else { return null; }
    return rtrim($tree,",");
}
// Функция выводит id категорий потомков


/***********************************************************************************
Функция numProduct(): Возвращает кол-во продукта (id_product) в поле Input
***********************************************************************************/
function numProduct($id_product) 
{
if(isset($_COOKIE['product']) AND ($_COOKIE['product'] != '0')) { 
  $product = unserialize($_COOKIE['product']); 
    foreach ($product as $k1 => $v1)  {
      foreach($v1 as $k2 => $v2)  {
        if($k1 == $id_product) {
          echo $v2;
        }
      }
    }
} else {
  echo 1; 
} 
}



//Построение блока с продуктом /* взять карточку с материал дизайна */ 
function build_product($name,$price,$img,$url,$id,$text='') {
if (empty($text)) {
  

?>
<!-- CARD -->
<div class="card shadow--2dp">
  <div class="card-img">
    <a href="/product/<?php echo $url; ?>"><img src="<?php echo $img; ?>"></a>
  </div>
  
  <div class="card-text">
    <a href="/product/<?php echo $url; ?>"><?php echo $name; ?></a>
  </div>
  
  <div class="card-action">
      <div class="card-price"><?php echo $price; ?> руб.</div>
  </div>

  <div class="card-product-amount">
    <div class="card-total">
      <span>Количество</span>
      <button type="button" class="amount-minus">−</button>
      <input type="text" name="amount" maxlength="4" value="1" style="width:30px;">
      <button type="button" class="amount-plus">+</button>
    </div>
    <div class="card-order">
      <a href="#"><img src="/template/img/basket-put-icon.png" id="<?php echo $id; ?>"></a>
    </div>
  </div>
</div>

<!-- CARD -->
<?php } else { ?>


    

<div class="card-product">
  <div class="card-img">
    <img src="<?php echo $img; ?>" class="shadow--2dp">
  </div>
  
  <div class="card-action">
      <div class="card-price"><?php echo $price; ?> руб.</div>
  </div>

  <div class="card-product-amount">
    <div class="card-total">
      <span>Количество</span>
      <button type="button" class="amount-minus">−</button>
      <input type="text" name="amount" maxlength="4" value="1" style="width:30px;">
      <button type="button" class="amount-plus">+</button>
    </div>
    <div class="card-order">
      <a href="#"><img src="/template/img/basket-put-icon.png" id="<?php echo $id; ?>"></a>
    </div>
  </div>
  <div class="text-product">
    <?php echo $text; ?>
  </div>
</div>



 <?php  }
}





















/***********************************************************************************
Function XMail( $from, $to, $subj, $text, $filename) Письмо с аттачем
***********************************************************************************/
function XMail( $from, $to, $subj, $text, $files=NULL)
{



  

$un        = strtoupper(uniqid(time()));
$head      = "From: $from\n";
$head     .= "To: $to\n";
$head     .= "Subject: $subj\n";
$head     .= "X-Mailer: PHPMail Tool\n";
$head     .= "Reply-To: $from\n";
$head     .= "Mime-Version: 1.0\n";
$head     .= "Content-Type:multipart/mixed;";
$head     .= "boundary=\"----------".$un."\"\n\n";
$zag       = "------------".$un."\nContent-Type:text/html;\n";
$zag      .= "Content-Transfer-Encoding: 8bit\n\n$text\n\n";



  foreach($files as $key=>$value) {
    $filename = './img/'.$key;
    $f = $value['num'];
    $f         = fopen($filename,"rb");
  
  
      $zag      .= "------------".$un."\n";
      $zag      .= "Content-Type: application/octet-stream;";
      $zag      .= "name=\"".basename($filename)."\"\n";
      $zag      .= "Content-Transfer-Encoding:base64\n";
      $zag      .= "Content-Disposition:attachment;";
      $zag      .= "filename=\"".basename($filename)."\"\n\n";
    $zag      .= chunk_split(base64_encode(fread($f,filesize($filename))))."\n";

  }






if (!@mail("$to", "$subj", $zag, $head))
 return 0;
else
 return 1;
}

/***********************************************************************************
Функция генерации кода например для капчи
***********************************************************************************/
    function generate_code() 
    {    
          $chars = 'abdefhknrstyz23456789'; // Задаем символы, используемые в капче. Разделитель использовать не надо.
          $length = rand(3, 4); // Задаем длину капчи, в нашем случае - от 4 до 7
          $numChars = strlen($chars); // Узнаем, сколько у нас задано символов
          $str = '';
          for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, rand(1, $numChars) - 1, 1);
          } // Генерируем код

        // Перемешиваем, на всякий случай
            $array_mix = preg_split('//', $str, -1, PREG_SPLIT_NO_EMPTY);
            srand ((float)microtime()*1000000);
            shuffle ($array_mix);
        // Возвращаем полученный код
        return implode("", $array_mix);
    }
/***********************************************************************************
Функция проверки кода капчи
***********************************************************************************/
function check_code($code,$cap) 
{
    $code = trim($code);
    $code = md5($code);
    if ($code == $cap){return TRUE;}else{return FALSE;}
}

/***********************************************************************************
Функция checkmail() проверки почты
$email - проверочный e-mail 
***********************************************************************************/
function checkmail($email) {
$email=trim($email);
if (strlen($email)==0) return -1;
if (!preg_match("/^[a-z0-9_-]{1,20}+(\.){0,2}+([a-z0-9_-]){0,5}@(([a-z0-9-]+\.)+(com|net|org|mil|edu|gov|arpa|info|biz|inc|name|[a-z]{2})|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})$/is",$email))
return -1;
return $email;
}