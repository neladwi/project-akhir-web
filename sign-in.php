<html>
<head>
    <link rel="stylesheet" href="stylemultirole.css">
    <link rel="icon" href="Bigetron Esports Logo.png">
    <title>Sign In</title>
</head>
<body>
    <header>
        <img src="Bigetron Esports Logo.png" alt="logo" style="float: left;" style="text-align: right;" width="70px" height="70px">
        <h1>BIGETRON SHOP</h1>
    </header>
    <nav>
           <a href="index.php"><span>Home</span></a>
           <a href="about.php"><span>About</span></a>
           <a href="profil.php"><span>Profile</span></a>
           <a href="sign-in.php"><span style="color: red;">Sign In</span></a>
           <a href="shop.php"><img border="0" src="shopping-cart.png" width="30px" style="margin: 0px 5px -8px 840px; color:white;">Shop</a>
    </nav>
<div class="container-box">
    <div class="login-box">
    <h2><span style="color: red">Sign </span>In</h2><br>
		<form method="POST" action="login.php">
			<div class="user-box">
				<input type="text" name="username" required="">
				<label>Username</label>
			</div>
			<div class="user-box">
				<input type="password" name="password" required="">
				<label>Password</label>
			</div>
			<select name="role">
				<option value="admin">Admin</option>
				<option value="staff">Staff</option>
				<option value="user">User</option>
			</select>
			<button type="submit" name="submit">Sign In</button>
		</form>
	</div>
</div>
</html>
    <footer>
        <p>2023 Kelompok 6</p>
    </footer>
</body>
</html>