<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IT Assistent |<?php echo $title; ?></title>
    <!-- Bootstrap -->
    <link href="<?php echo TMPL; ?>css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo TMPL; ?>css/font-awesome.css">
    <link href="<?php echo TMPL; ?>css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?php echo TMPL; ?>css/bootstrap-switch.css" rel="stylesheet">
    <link href="<?php echo TMPL; ?>css/footer.css" rel="stylesheet">
    <link href="<?php echo TMPL; ?>css/timeline.css" rel="stylesheet">
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
    <script type="text/javascript" src="http://code.jquery.com/jquery-2.2.3.js"></script>
        <link rel="stylesheet" href="<?php echo LIB; ?>/player/APlayer.min.css">
	<script type="text/javascript" src="<?php echo LIB; ?>/player/pl.js"></script>
    
    <!--ckeditor-->
    <script type="text/javascript" src="<?php echo LIB; ?>ckeditor/ckeditor.js"></script>
    
    <script type="text/javascript">
            $('document').ready(function(){
                $('#modal').modal();
            });
    </script>
    <script type="text/javascript">
            $('document').ready(function(){
                $('#modal2').modal();
            });
    </script>

    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <div class="container">
	<header>
		<nav role="navigation" class="navbar navbar-default">
	  <!-- Brand and toggle get grouped for better mobile display -->
		  <div class="navbar-header">
			<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
			  <span class="sr-only">Toggle navigation</span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			</button>
			<a href="#" class="navbar-brand">Бренд</a>
		  </div>
		  <!-- Collection of nav links, forms, and other content for toggling -->
		  <div id="navbarCollapse" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
			  <li class="active"><a href="/">Главная</a></li>
			  <li class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-paint-brush" aria-hidden="true"></i> Cartriges <b class="caret"></b></a>
				<ul role="menu" class="dropdown-menu">
                                  <li><a href="/cartriges">view</a></li>
                                  <li class="divider"></li>
				  <li><a href="/cartriges/add">add</a></li>
				  <li><a href="#">Remove</a></li>
				  <li><a href="/cartriges/orders">order</a></li>
                                  <li class="divider"></li>
				  <li><a href="#">history</a></li>
				</ul>
			  </li>
			  <li class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-print" aria-hidden="true"></i> Prints <b class="caret"></b></a>
				<ul role="menu" class="dropdown-menu">
				  <li><a href="/printers">search</a></li>
                                  <li class="divider"></li>
				  <li><a href="/printer/add">add</a></li>
				  <li><a href="#">edit</a></li>
				  <li class="divider"></li>
				  <li><a href="#">delete</a></li>
				</ul>
			  </li>
			  <li class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-wrench" aria-hidden="true"></i> Unit <b class="caret"></b></a>
				<ul role="menu" class="dropdown-menu">
				  <li><a href="/unit/requests">history requests</a></li>
				  <li><a href="#">history repairs</a></li>
				  <li><a href="/unit/createrequest">create requests</a></li>
				  <li class="divider"></li>
				  <li><a href="#">doc stor</a></li>
				</ul>
			  </li>
			  <li class="dropdown">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-phone" aria-hidden="true"></i> PhoneBook <b class="caret"></b></a>
				<ul role="menu" class="dropdown-menu">
				  <li><a href="/phonebook">Список телефонов ОЦ</a></li>
				  <li><a href="/phonebook/search">Поиск</a></li>
				  <li class="divider">Админам</li>
				  <li><a href="/phonebook/admsearch">Редактирование</a></li>
                                  <li><a href="#">Добавление</a></li>
				</ul>
			  </li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			  <li class="dropdown">
                              <?php if(user::checkAuth() == false): ?>
                              <a href="/user/login"><i class="fa fa-lock" aria-hidden="true"></i> Войти </a>
                              <?php else: ?>
                              <a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo $_SESSION['name_en']; ?> <!--<img src="data:image/png;base64,<?php //echo base64_encode($_SESSION['photo']); ?>" height="36px" class="img-rounded">--></a> 
                              <ul role="menu" class="dropdown-menu">
				  <li><a href="#">history requests</a></li>
				  <li><a href="#">history repairs</a></li>
				  <li><a href="#">create requests</a></li>
				  <li class="divider"></li>
				  <li><a href="/user/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                              </ul>
                              <?php endif; ?>
                          </li>
			</ul>
		  </div>
		</nav>

</header>
<main>

