
<html>
<head>
	<link rel="shortcut icon" href="images/2_green.png" type="image/x-icon">
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Вхід або реєстрація</title>
	<style type="text/css">
		html {
  background-color:#191a19;
  background-blend-mode:overlay;
  display:flex;
  align-items:center;
  justify-content:center;
  background-image:url(../../assets/img/image4.jpg);
  background-repeat:no-repeat;
  background-size:cover;
  height:100%;
}

body {
  background-color:#191a19;
}

.registration-cssave{
  padding:50px 0;
}

.registration-cssave form {
  max-width:800px;
  padding:50px 70px;
  border-radius:10px;
  background-color: #212421;
}

.registration-cssave form h3 {
  font-weight:bold;
  margin-bottom:30px;
}

.registration-cssave .item {
  border-radius:10px;
  margin-bottom:25px;
  padding:10px 20px;
	background-color: #191a19;
	border: none;
	color: white;
}
.registration-cssave .create-account {
  border-radius:10px;
  padding:10px 20px;
  font-size:18px;
  font-weight:bold;
  background-color:#4e9f3d;
  border:none;
  color:white;
  margin-top:20px;
}
#button:hover {
	cursor: pointer;
	background-color: #1e5128;
}
#button {
	width: 100%;
}
	</style>
</head>
<body>
	<div class="registration-cssave">
		<div class="row">
			<div class="col">
				<?php
					if($_COOKIE['user'] == ''):
				?>

    <form action="validatoin-form/auth.php" method="post">
        <h3 class="text-center"><font face="Nunito" color="white">Авторизація</font></h3>
        <div class="form-group">
            <input class="form-control item" type="text" name="login" pattern="^[a-zA-Z0-9_.-]*$" id="username" placeholder="Ваш нік" required>
        </div>
        <div class="form-group">
            <input class="form-control item" type="password" name="password" minlength="6" id="password" placeholder="Пароль" required>
        <div class="form-group">
            <button class="btn btn-primary btn-block create-account" type="submit" id="button"><font face="Nunito">Увійти</font></button>
        </div>
    </form>
</div>


	<div class="col">
	<form action="validatoin-form/check.php" method="post">
		<h3 class="text-center"><font face="Nunito" color="white">Реєстрація</font></h3>
		<div class="form-group">
				<input class="form-control item" type="text" name="login" pattern="^[a-zA-Z0-9_.-]*$" id="username" placeholder="Нік на сервері" required>
		</div>
		<div class="form-group">
				<input class="form-control item" type="password" name="password" minlength="6" id="password" placeholder="Придумайте пароль" required>
		<div class="form-group">
				<button class="btn btn-primary btn-block create-account" type="submit" id="button"><font face="Nunito">Зареєструватися</font></button>
		</div>
	</form>
	</div>
<?php else:
	echo "<script>self.location='/pages/content.php';</script>";
	?>
<?php endif;?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
