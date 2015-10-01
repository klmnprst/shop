<?php
///////////////////////////////////////////////////////////
//	Генерация страницы ошибки при доступе вне системы  
    if(!defined('MY_KEY'))  
    {  
       header("HTTP/1.1 404 Not Found");        
       exit(file_get_contents('./404.html'));  
    }      
///////////////////////////////////////////////////////////  












//////////////////////////////////////////////////////////
//														//
//					Блок отправки информации  			//
//														//
//////////////////////////////////////////////////////////

//Обработка если нажали кнопку
if (isset($_POST['name'])) { 

	session_start();
	$cap = $_SESSION['captcha'];
	$_SESSION['captcha'] = '';

	$info='';

		$online_theme=strip_tags(stripslashes(substr($_POST['subj'],0,100)));
		$email = strip_tags(stripslashes(substr($_POST['email'],0,30)));
		$name=strip_tags(stripslashes(substr($_POST['name'],0,30)));
		$message = strip_tags(stripslashes(substr($_POST['message'],0,30)));

		if (!empty($_POST['name'])) 			{
		if (!empty($_POST['email'])) 		{	
		if (!empty($_POST['message']))		{	

		//Отправка письмо если все проверено!
            if (check_code($_POST['code'], $cap))
            {
					
			//////////////////////////////////////////////////////////
			//						XXX								//
			//////////////////////////////////////////////////////////

		##### MESSAGE #######
		$txt ="Тема: ".$online_theme."\n";
		$txt.="E-mail: ".$email."\n";
		$txt.="Имя: ".$name."\n";
		$txt.="Сообщение: ".$message;
		##### MESSAGE #######

/* php mailer test */
date_default_timezone_set('Etc/UTC');
require 'PHPM/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isSMTP();
$mail->CharSet = "utf-8";
$mail->SMTPDebug = 0;
$mail->Debugoutput = 'html';
$mail->Host = "smtp.yandex.ru";
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
$mail->SMTPAuth = true;
$mail->Username = "info@adsgrp.ru";
$mail->Password = "19shell84";
$mail->setFrom('info@adsgrp.ru', 'adsgrp.ru');
$mail->addAddress('info@adsgrp.ru', 'prst@narod.ru');
$mail->Subject = 'Сообщение с сайта zeus.ru';
$mail->Body    = $txt;
 
if (!$mail->send()) {
   echo "Произошла ошибка: " . $mail->ErrorInfo . ' ';
} else {
    setcookie("info","Сообщение успешно отправлено",time()+3600);
	header('Location: /contacts');
    exit();
}
/* php mailer test */


		
		
		//////////////////////////////////////////////////////////
		//						XXX								//
		//////////////////////////////////////////////////////////
				
            }
            else 
            {
            	$info .=" Неправильный проверочный код";
            }
        
	
		} else {	$info .= " Введите текст";	}
		} else {	$info .= " Вы не указали email";	}			
		} else {	$info .= " Вы не указали Имя";		}
					
				
} 
//////////////////////////////////////////////////////////
//														//
//					Блок отправки информации  			//
//														//
//////////////////////////////////////////////////////////






































	
	$result = mysqli_query($db, "SELECT * FROM main WHERE url='$url'");
  	if (mysqli_num_rows($result)>0) {
      $row = mysqli_fetch_assoc($result);
		$title = $row['title'];
		$keywords = $row['keywords'];
		$description = $row['description'];
		$text = $row['pagetext'];
		
	}
	
if (isset($_COOKIE['info'])) {
		$info = $_COOKIE['info'];
		setcookie("info","",time()+3600);
}



//////////////////////////////////////////////////////////
?>












		<div>
			<?php 
			echo '<h1 class="first">'.$title.'</h1>'; 
			
			?>

			<?php if (isset($info)) {echo '<h3 style="color:green;">'.$info.'</h3>';}  ?>
		</div>


<div class="promo">
	<div class="left s50">
		<p><img src="/skins/img/adsgroup.jpg"></p>
		<p>107014, Москва, ул. Сокольнический вал, 10 
		<p>Тел.:   +7 (495) 249 39 49</p>
		<p>Факс: +7 (495) 933 35 90</p> 
		<p>E-mail: zeus@adsgrp.ru</p> 
	</div>


<!-- ######################### FORM ################################ -->	
<div class="right s50">
		<p>Все поля обязательны для заполнения</p>


<form action="/contacts" id="myform" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">

	  
					<div class="form-group">						
							<input type="text" placeholder="Имя" required name="name" value="<?php if (isset($_POST['name'])) {echo $_POST['name'];} ?>" />					
					</div>
					<div class="form-group">						
							<input type="email" placeholder="Email" name="email" required value="<?php if (isset($_POST['email'])) {echo $_POST['email'];} ?>" />					
					</div>
					<div class="form-group">						
							<input placeholder="Тема" type="text" name="subj" required value="<?php if (isset($_POST['subj'])) {echo $_POST['subj'];} ?>"  />					
					</div>
					<div class="form-group">						
							<textarea placeholder="Сообщение" name="message" required size="25" maxlength="100" /><?php if (isset($_POST['message'])) {echo $_POST['message'];} ?></textarea>					
					</div>


					<br>
							
			
			<img src='/modules/captcha/captcha.php' id='capcha-image'>
			<a href="javascript:void(0);" onclick="document.getElementById('capcha-image').src='/modules/captcha/captcha.php'"><br/>Обновить</a><br/>
			<!-- Ссылка на обновление капчи. Запрашиваем у captcha.php случайное изображение.  -->
			<br/>

					<div class="form-group">						
							<label for="code">Введите код</label>						
							<input id="code" type="text" name="code" required />					
					</div>


			<div class="form-group">
				<button type="submit" name="go" onclick="document.getElementById('myform').submit(); return false;">Отправить</button>
			</div>
</form>   
</div> 
<div class="clear"></div>


</div>
<?php echo $text; ?><p>&nbsp;</p>
<!-- ######################### FORM ################################ -->






























































