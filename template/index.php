<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title><?php if (isset($title)) {echo $title;} ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/foundation.css" />
	<meta name="description" content="<?php if (isset($description)) {echo $description;}  ?>" />
	<meta name="keywords" content="<?php if (isset($keywords)) {echo $keywords;	}  ?>" />
    <script src="/template/js/vendor/modernizr.js"></script>
    <script src="/template/js/vendor/jquery.js"></script>
	<link rel="stylesheet" href="/template/css/foundation.css" />
	<link rel="stylesheet" href="/template/css/custom.css" />
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
</head>
<body>























<script type="text/javascript" >
        $(document).ready(function() {
            $('.amount-minus').click(function () {
                var $input = $(this).parent().find('input');
                var count = parseInt($input.val()) - 1;
                count = count < 1 ? 1 : count;
                $input.val(count);
                $input.change();
                return false;
            });
            $('.amount-plus').click(function () {
                var $input = $(this).parent().find('input');
                $input.val(parseInt($input.val()) + 1);
                $input.change();
                return false;
            });
        });
</script>


















<!-- #### BUSKET FUNCTION -->
	<script type="text/javascript">
	//Update in basket block total of product from cookie
	function UpdateProductFromCokie(){
			 $.ajax({
		        	type: "GET",
					url: "/controllers/cart/numProductUpd.php",  
					success: function(html){  
					$('#numProduct').html(html);
					}  
			}); 
	}
	//Update in basket block total price product from cookie
	function UpdateSumFromCokie(){
			 $.ajax({
		        	type: "GET",
					url: "/controllers/cart/sumProductUpd.php",  
					success: function(html){  
					$('#basketSum').html(html);
					$('#total').html(html);
					}  
			}); 
	}
	</script>
<!-- #### BUSKET FUNCTION -->










<!-- ////////////// ADD INFO IN COOKIE IF ON CLICK /////////////// -->
<script type="text/javascript">

$(document).ready(function(){     
	
	//Update in basket block total of product from cookie
	function UpdateProductFromCokie(){
			 $.ajax({
		        	type: "GET",
					url: "/controllers/cart/numProductUpd.php",  
					success: function(html){  
					$('#numProduct').html(html);
					}  
			}); 
	}
	//Update in basket block total price product from cookie
	function UpdateSumFromCokie(){
			 $.ajax({
		        	type: "GET",
					url: "/controllers/cart/sumProductUpd.php",  
					success: function(html){  
					$('#basketSum').html(html);
					}  
			}); 
	}



    $('.card-order img').click(function(){     
    	
        var idProduct = $(this).attr('id'); 			//product id
        //var priceProduct = $(this).parent().parent().parent().prev().find('.card-price').html(); //product price (work too)
        //var priceProduct = $(this).closest('.card-product-amount').prev().find('.card-price').html(); //product price (work too)
        var priceProduct = $(this).parents('.card-product-amount').prev().find('.card-price').html(); //product price
        var number = $(this).parents('.card-product-amount').find('input:text').val(); //count product
        var basketSum = $('#basketSum').html();			//sum money from block <div>
        var numProduct = $('#numProduct').html();		//number product from <div>

        

        //update cookie:
        $.ajax({
        	type: "GET",
			url: "/controllers/cart/orderAdd.php",  
			data: "idProduct="+idProduct+"&priceProduct="+priceProduct+"&number="+number,
			success: function(html){  
			$("#info").html(html); 

			//update basket block
			UpdateProductFromCokie();
			UpdateSumFromCokie();

			}  
		}); 

    }) 
});

</script>
<!-- ////////////// ADD INFO IN ORDER TABLE /////////////// -->













<!-- ////////////// DROP POSITION (TR)  /////////////// -->
<script type="text/javascript">

$(document).ready(function(){   

    



    $('.drop').click(function(){     
      
	//get product_id
	var product_id = $(this).parent().parent().attr('id');	
		
		//update cookie:
        $.ajax({
        	type: "GET",
			url: "/controllers/cart/orderDel.php",  
			data: "product_id="+product_id,
			success: function(html){  
			$("#info").html(html); 
			$("#"+product_id).remove(); 
			//update basket block
			UpdateProductFromCokie();
			UpdateSumFromCokie();
			}  
		}); 
    }) 




	//update number of one product
   	$("#basketTbl input").keyup(function(){    
	//get product_id
	var product_id = $(this).parent().parent().attr('id');	
	var number = $(this).val();
	if(number < 1) {number = 1; $(this).val('1');}
	$.ajax({
        	type: "GET",
			url: "/controllers/cart/orderSum.php",  
			data: "product_id="+product_id+"&number="+number,
			success: function(html){  
			$("#info").html(html); 
			//update basket block
			UpdateProductFromCokie();
			UpdateSumFromCokie();
			}  
		}); 
	


   });


});

</script>
<!-- ////////////// DROP POSITION (TR)  /////////////// -->



<!-- ########## CART ############ -->
<?php
if(isset($_COOKIE['product']) AND ($_COOKIE['product'] != '0')) {
    $product = unserialize($_COOKIE['product']);
    //print_arr($product);
    $numProduct = count($product);
    $basketSum = 0;
    foreach ($product as $key => $value) 	{
        foreach($value as $product => $amount) 	{

            $productSum = $product * $amount;
            $basketSum = $basketSum + $productSum;
        }
    }

} else {
    $numProduct = 0;
    $basketSum 	= 0;
}
?>
<!-- ########## CART ############ -->











<header id="site-header">
    <div class="row">
        <div class="large-12 columns  contain-to-grid">
            <nav class="top-bar" data-topbar>
                <ul class="title-area">
                    <li class="name">
                        <h1><a href="/">FIRM NAME</a></h1>
                    </li>
                    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a>
                    </li>
                </ul>
                <section class="top-bar-section">
                    <?php echo $top_menu;	?>
                    <ul class="right">
                        <li class="has-form">
                            <form>
                                <div class="row collapse">
                                    <div class="small-8 columns">
                                        <input type="text">
                                    </div>
                                    <div class="small-4 columns">
                                        <a href="#" class="alert button">Search</a>
                                    </div>
                                </div>
                            </form>
                        </li>
                    </ul>
                </section>

            </nav>
        </div>
    </div>
</header>


<div class="wrapper">






    <div class="row">
        <aside class="large-3 columns">
            <div id="info"></div>
            <!-- ########## CART ############ -->
            <p class='menuCat panel'>Корзина</p>
            <div class="basket">
                <p id="info"></p>
                <p>Кол-во товаров: <span id="numProduct"><?php echo $numProduct; ?></span></p>
                <p>Сумма: <span id="basketSum"><?php echo $basketSum; ?> Руб</span></p>
                <p><a href="/cart">Оформить</a></p>
            </div>
            <!-- ########## CART ############ -->
            <p class="panel">МЕНЮ</p>
            <?php echo $cat_menu;	?>
        </aside>
        <div class="large-9 columns">
            <article>
                <ul class="breadcrumbs">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Gene Splicing</a></li>
                    <li class="current"><a href="#">Cloning</a></li>
                </ul>

                <h3 class="panel">Article</h3>
                <?php
                echo $content;
                ?>
            </article>



        </div>
    </div>

</div>

<footer id="site-footer">
    <div class="row">
        <div class="large-12 columns panel radius">
            <p>Copyright &copy; <?php echo date('Y') ?></p>
        </div>
    </div>
</footer>



<script src="/template/js/vendor/jquery.js"></script>
<script src="/template/js/foundation.min.js"></script>
<script>
    $(document).foundation();
</script>
</body>
</html>