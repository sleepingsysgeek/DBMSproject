<?php
	session_start();
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body> 
		<?php 
			if($_SESSION["login"] == 1){
				echo "<script type='text/javascript'>location.href='profile.php';</script>";
			}
			$message = "";
			$error = 0;
			$email = $pass = $contact = $question= "";
			$email_err = $pass_err = "";
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				if(empty($_POST["email"])){
					$email_err = "email is required";
					$error = 1;
				}
				$email = $_POST["email"];
				if(empty($_POST["pass"])){
					$pass_err = "password is required";
					$error = 1;
				}
				$pass = md5($_POST["pass"]);
				if($error == 0){
					$server = "localhost";
					$username = "joker";
					$password = "djoker";
					$db = "project";
					$conn = new mysqli($server,$username,$password,$db);
					if($conn->connect_error){
						die ("Connection failed:".$conn->connect_error);
					}
					$sql = "select firstname,lastname,email,contact from user where email = '$email' and password = '$pass'";
					$result = $conn->query($sql);
					if($result -> num_rows > 0){
						while($row = $result -> fetch_assoc()){
							$_SESSION["fname"] = $row["firstname"];
							$_SESSION["lname"] = $row["lastname"];
							$_SESSION["contact"] = $row["contact"];
							$_SESSION["email"] = $row["email"];
							$_SESSION["login"] = 1;
						}
						echo "<script type='text/javascript'>location.href='profile.php';</script>";
					}
					else{
						$message = "email id or password incorrect";
					}
					$conn -> close();
				}
			}
		?> 
		<div id="container">
			<div id = "header">
				<div id="logo" onclick="location.href='index.php';"><img src="logo.png"></div>
				<div id="menu">
					<ul>
						<li><a href="index.php">HOME</a></li>
						<li><a href="index.php#blog">BLOGS</a></li>
						<li><a href="about.php">ABOUT</a></li>
						<li style="border-right: none;"><a href="contact.php ">CONTACT</a></li>
					</ul>
				</div>
				<div id="header_right">
					<button class="header_button" onclick="location.href='register.php';">SignUp</button>
				</div>
			</div>
			<div id="body">	
				<div id = "form">
					<h1>Login</h1>
					<form method="post" action="login.php" name="myform">
						<span class="error"><?php echo "$message";?><br>* required fields</span><br>
						<input type="text" name="contact" pattern="[0-9]{10}" value="<?php echo $contact?>" placeholder="Contact Number" maxlength="10"><span class="error">*<?php echo "";?></span><br>
						<p><?php echo $question ?> </p>
						<?php
							if($question != ""){
								echo 
								'<input type="password" name="pass" id="password" oncopy="return false" placeholder="New Password"><span class="error">*<?php echo "$pass_err";?></span><br>
								<input type="password" name="cnfpass" id="password" oncopy="return false" placeholder="Confirm Password"><span class="error">*<?php echo "$pass_err";?></span><br>
								<input type="submit" id="submit" value="Update">
								<input type="button" id="reset" onclick="location.href=\'login.php\';" value="Cancel"><br><br>';	
						
							}
							else{
								echo
								'<input type="submit" id="submit" value="Verify">
								<input type="button" id="reset" onclick="location.href=\'login.php\';" value="Cancel"><br><br>';	
							}
						?>
						
					</form>
				</div>
			</div>
			<div id="footer">
				<ul>
						<li><a href="index.php"><span id="footerlive">LiveBlog</span></a></li>
						<li><a href="index.php">Home</a></li>
						<li><a href="about.php">About</a></li>
						<li><a href="contact.php">Contact</a></li>
						<li style="border-right: none;"><a href="feedback.php">Feedback</a></li>
						<li style="border-right: none;">&copy;Copyright</li>
					</ul>
			</div>				
		</div>	
	</body>
</html>