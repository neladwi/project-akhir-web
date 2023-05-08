<?php 
session_start();

$users = array(
	array('username' => 'admin', 'password' => 'admin', 'role' => 'admin'),
	array('username' => 'staff', 'password' => 'staff', 'role' => 'staff'),
	array('username' => 'user', 'password' => 'user', 'role' => 'user')
);

if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$role = $_POST['role'];

	foreach ($users as $user) {
		if ($user['username'] == $username && $user['password'] == $password && $user['role'] == $role) {
			$_SESSION['username'] = $username;
			$_SESSION['role'] = $role;

			if ($role == 'admin') {
				header('Location: admin.php');
				exit();
			} else if ($role == 'staff') {
				header('Location: staff.php');
				exit();
			} else if ($role == 'user') {
				header('Location: user.php');
				exit();
			}
		}
	}

	echo "<script>alert('Username, password, atau role yang Anda masukkan salah');</script>";
	echo "<script>window.location = 'sign-in.php'</script>";
}
?>