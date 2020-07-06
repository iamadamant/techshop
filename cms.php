<form action="cms.php" method="post" enctype="multipart/form-data">
	<input type="text" name="title" placeholder="title"><br>
	<textarea name="description" placeholder="description"></textarea><br>
	<input type="number" name="price" placeholder="price"><br>
	<select name="type">
		<option value="block">Системный блок</option>
		<option value="monitor">Монитор</option>
		<option value="mouse">Мышка</option>
	</select><br>
	<input type="file" name="image">
	<input type="submit" name="">
</form>
<?php 
	$title = $_POST['title'];
	$price = $_POST['price'];
	$description = $_POST['description'];
	$type = $_POST['type'];

	$link = mysqli_connect('localhost', 'root', 'pass', 'shop');
	$sql = 'insert into equipment(title, description, price, type, img_path) values("'.$title.'", "'.$description.'", '.$price.', "'.$type.'", "img/'.$_FILES['image']['name'].'")';
	echo $sql;
	$result = mysqli_query($link, $sql);
	$destiation_dir = dirname(__FILE__) .'/img/'.$_FILES['image']['name'];
	move_uploaded_file($_FILES['image']['tmp_name'], $destiation_dir );
 ?>