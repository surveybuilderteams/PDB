<?php 
session_start();
 
require('libs/ppdb.lib.php');
 require('libs/ppdb.sql.php');

 ?>
<html>
	<head>
		<title>Panel -
			<?php echo $_SERVER['HTTP_HOST'];?>
</title>
		<!-- CSS only -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
			<style>
			*{ margin:0; padding:0; } 
			body{ background-color:rgb(105, 106, 105); } 
			.heading{
				width:100%;
			}
			.panelForm{ width:50%; height:50%; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background-color: rgb(0, 167, 232); } 
			h1{ font-size:52px; color:rgb(115, 234, 7); } 
			.panelCon{ background-color:rgba(16, 213, 5, 0.5); } 
			.logoutbtn{ position:absolute; top:0; right:0; font-size:32px; }
			.panel-header{width:100%;}
			.nav-con{
				background-color:rgb(3, 252, 218);
				width:100%;
			}
			.nav-con a{
				text-decoration:none;
				font-size:32px;
				margin-right:8px;
				color:rgb(255, 213, 0);
				font-weight: bold;
			}
			</style>
		</head>
		<body>
			<?php
echo PPDB::userUI();
if(!file_exists(ROOT.'user.json')){
		session_unset();
}
if(isset($_POST['regbtn'])){
		$username = $_POST['username'];
		$psw = $_POST['psw'];
		
		PPDB::INSTALL($username, $psw);
		$_SESSION['username'] = $username;
	}
	if(isset($_POST['logbtn'])){
		$username = $_POST['username'];
		$psw = $_POST['psw'];
		$psw = PPDB::PSW_ENCRYPT($psw);
		$json = file_get_contents(ROOT."user.json");
		$query = json_decode($json);
		if($username === $query->user && $psw === $query->password){
			$_SESSION['username'] = $username;
				Reload::run();
		}else{
			echo '<p style="'.PPDB::COLOR(255,0,0,1).PPDB::BOLD().PPDB::SIZE(42).PPDB::ALIGN(CENTER).PPDB::TXTRANS(UPPERCASE).'">Error: cannot login correctly!</p>';
		}
		
	}
	echo PPDB::loadPanel();
	echo PPDB::logout();
	

?>
			<!-- JavaScript Bundle with Popper -->
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"/>
		</body>
	</html>
