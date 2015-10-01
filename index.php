<?php

#Установка ключа доступа к файлам 
define('MY_KEY', true);
if(!isset($_COOKIE['product'])) {SetCookie("product",0,time()+86400,"/");} 


header("Content-Type: text/html; charset=utf-8");  
error_reporting(E_ALL);  

	
#Подключаем библиотеки
include './libs/db.php'; 
include './libs/function.php';






################################################################################################
// Конфигурация маршрутов URL проекта.
$routes = array
(
    // Главная страница сайта (http://localhost/)
    array(
        // паттерн в формате Perl-совместимого реулярного выражения
        'pattern' => '~^/$~',
        // Имя класса обработчика
        'class' => 'Index',
        // Имя метода класса обработчика
        'method' => 'index'
    ),

    // Страница регистрации пользователя (http://localhost/registration.xhtml)
    array(
        'pattern' => '~^/registration\.xhtml$~',
        'class' => 'User',
        'method' => 'registration',
    ),

    // Досье пользователя (http://localhost/userinfo/12345.xhtml)
    array(
        'pattern' => '~^/userinfo/([0-9]+)\.xhtml$~',
        'class' => 'User',
        'method' => 'infoInfo',
        // В aliases перечисляются имена переменных, которые должны быть в дальнейшем созданы
        // и заполнены значениями, взятыми на основании разбора URL адреса.
        // В данном случае в переменную user_id должен будет записаться числовой
        // идентификатор пользователя - 12345
        'aliases' => array('user_id'),
    ),

    // Форум (http://localhost/forum/web-development/php/12345.xhtml)
    array(
        'pattern' => '~^/forum(/[a-z0-9_/\-]+/)([0-9]+)\.xhtml$~',
        'class' => 'Forum',
        'method' => 'viewTopick',
        // Будут созданы переменные:
        // forum_url = '/web-development/php/'
        // topic_id = 12345
        'aliases' => array('forum_url', 'topic_id'),
    ),

    // и т.д.
);

################################################################################################

// Назначаем модуль и действие по умолчанию.
$module = 'Not_Found';
$action = 'main';
// Массив параметров из URI запроса.
$params = array();

foreach ($routes as $map)
{
    $url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    if (preg_match($map['pattern'], $url_path, $matches))
    {
        // Выталкиваем первый элемент - он содержит всю строку URI запроса
        // и в массиве $params он не нужен.
        array_shift($matches);

        // Формируем массив $params с теми названиями ключей переменных,
        // которые мы указали в $routes
        foreach ($matches as $index => $value)
        {
            $params[$map['aliases'][$index]] = $value;
        }

        $module = $map['class'];
        $action = $map['method'];

        break;
    }
}
echo '<div data-alert class="alert-box success radius">';
echo "\$module: $module\n";
echo "\$action: $action\n";
echo "\$params:\n";
print_r($params);
echo '</div>';











################# LITE ROUTING ################
$url = parse_url($_SERVER['REQUEST_URI']);
$url['path'] = trim($url['path'],"/"); //убираем слеши
$arr_url = explode('/',$url['path']); //находим controller и action
$controller  = $arr_url['0']; //controller
if ($controller=='') $controller='default'; //controller по умолчанию
$action = (isset($arr_url[1]) ? $arr_url[1] : ''); //action
$params = (isset($arr_url[2]) ? $arr_url[2] : ''); //params
$query = (isset($url['query']) ? $url['query'] : ''); //params
################# LITE ROUTING ################


############ Генерируем верхнее меню ############
ob_start();   
#Массив рубрик
$result = mysqli_query($db, "SELECT * FROM main WHERE top_menu='1'");
$super_tree = array();
while ($row = mysqli_fetch_assoc($result)) {
    $super_tree[$row['parent_id']][$row['id']] = $row;
}
echo build_tree_class($super_tree,0);
$top_menu = ob_get_contents();   
ob_end_clean();   
############ Генерируем верхнее меню ############


############ Генерируем боковое меню каталога #########
ob_start();   
#Массив рубрик
$result = mysqli_query($db, "SELECT * FROM main WHERE catalog='1'");
$cat_tree = array();
while ($row = mysqli_fetch_assoc($result)) {
    $cat_tree[$row['parent_id']][$row['id']] = $row;
}
echo build_cat_tree($cat_tree,0,"side-nav");
$cat_menu = ob_get_contents();   
ob_end_clean();  
############ Генерируем боковое меню каталога #########


################# CONTENT #################
ob_start();
#Подключаем контроллер
$controller_path = './controllers/' .$controller. '/index.php';
if (file_exists($controller_path)) {
	include $controller_path;
} else {
	include './controllers/default/index.php';
} 
	//header('Location: /404.html');
	//exit;
$content = ob_get_contents();   
ob_end_clean();   
################# CONTENT #################



 

	
#Подключаем главный шаблон   
include './template/index.php';
?>