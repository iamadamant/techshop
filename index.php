<!DOCTYPE html>
<html>
<head>
	<title>Магазин по продаже компьютерной техники</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<?php
	 	session_start();
		$target = $_GET['target'];
		$link = mysqli_connect('localhost', 'root', 'pass', 'shop');

		if($target == 'signup'){
			$name = $_POST['name'];
			$password = $_POST['password'];
			$mail = $_POST['mail'];
			$sql = 'insert into users(name, password, mail) values("'.$name.'", "'.$password.'", "'.$mail.'")';
			$result = mysqli_query($link, $sql);
			$_SESSION['user'] = $name;
		}
		elseif ($target == 'signin'){
			$name = $_POST['name'];
			$password = $_POST['password'];
			$sql = 'select * from users where name="'.$name.'" and password="'.$password.'"';
			$result = mysqli_query($link, $sql);
			if(mysqli_num_rows($result)>0){
				$_SESSION['user'] = $name;
			}
			else{
				echo '<div class="alert alert-danger" role="alert" style="z-index: 100; position: absolute; top: 60px; right: 20px;">
						 Неверный логи или пароль
					</div>';
			}
		}
		elseif ($target == 'exit') {
			unset($_SESSION['user']);
			header('Location: index.php');
		}

		if(!empty($_SESSION['user'])){
			include('account.php');
		}
		else{
			include('vhod.php');
		}
		
	 ?>
	<div class="row title-block">	
	</div>


		<!-- Окно Войти -->
		<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <form class="modal-content" action="index.php?target=signin" method="post">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalCenterTitle">Войти</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        	<input type="text" name="name" placeholder="Введите имя" class="form-control mb-3">
	        	<input type="password" name="password" placeholder="Введите пароль" class="form-control">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
	        <button type="submit" class="btn btn-primary">Войти</button>
	      </div>
	    </form>
	  </div>
	</div>

	<!-- Окно Регистрация -->
		<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <form class="modal-content" action="index.php?target=signup" method="post">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalCenterTitle">Регистрация</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">   
	        	<input type="text" name="name" placeholder="Введите имя" class="form-control mb-3">
	        	<input type="password" name="password" placeholder="Введите пароль" class="form-control mb-3">
	        	<input type="mail" name="mail" class="form-control" placeholder="Электронная почта">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
	        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
	      </div>
	    </form>
	  </div>
	</div>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Главная <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">О нас</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Новинки</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Оборудование
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="index.php?type=block">Системные блоки</a>
          <a class="dropdown-item" href="index.php?type=mouse">Компьютерные мышки</a>
          <a class="dropdown-item" href="index.php?type=monitor">Мониторы</a>
        </div>
      </li>
  </div>
</nav>
	<div class="container">
		<?php 
			$type = $_GET['type'];
			if(is_null($type) or $type == 'main'){
				include('main.php');
			}
			elseif($type == 'buy'){
				$order_id = $_GET['order'];
				$link = mysqli_connect('localhost', 'root', 'pass', 'shop');
				$sql = 'insert into orders(equipment_id) values('.$order_id.')';
				$result = mysqli_query($link, $sql);
				$sql = 'select * from orders order by id desc limit 1';
				$result = mysqli_query($link, $sql);
				$row = mysqli_fetch_array($result);
				$_SESSION['order'] = $row['id'];
				include('buy.php');
			}
			else{
				
				$link = mysqli_connect('localhost', 'root', 'pass', 'shop');
				$sql = 'select * from equipment where type="'.$type.'"';
				$result = mysqli_query($link, $sql);
				print('<div class="mt-5 mb-5 row">');
				while ($row = mysqli_fetch_array($result)) {
					print('<div class="col-lg-4 mb-3">');
					print('
						<div class="card h-100">
						  <img src="'.$row['img_path'].'" class="card-img-top" alt="...">
						  <div class="card-body">
						    <h5 class="card-title">'.$row['title'].'</h5>
						    <p class="card-text">'.$row['description'].'</p>
						    <a href="index.php?type=buy&order='.$row['id'].'" class="btn btn-primary">Купить</a>
						  </div>
						  <div class="card-footer text-muted" style="font-weight: bold">
						    Цена: '.$row['price'].' руб.
						  </div>
						</div>');
					print('</div>');
				}
				print('</div>');
			}
		 ?>
	</div>
	<footer class="pt-5 pb-5 bg-dark text-white">
		<div class="container">
			Контактная информация
		</div>
	</footer>
	 <script type="text/javascript" src="js/jquery.js"></script>
	 <script type="text/javascript" src="js/bootstrap.min.js"></script>
	 <script type="text/javascript" src="js/script.js"></script>
</body>
</html>