<?php
session_start();
include("inc/functii.php");
include("inc/header.php"); //HEADER
meniu();                   //MENU MENU MENU

$form =<<< OK
<form method="post" action="$_SERVER[PHP_SELF]">
User: <br><input type="text" name="nume" onfocus="yellow(this)"><br>
Password: <br><input type="password" name="parola" onfocus="yellow(this)"><br>
<input type="checkbox" name="rem">(remember me for 30 min)<br>
| ￣￣￣￣￣￣￣ |<br>  
|    <input type="submit" name="s" value="Enter">                |<br>

|＿＿＿＿＿＿＿＿|<br>

</form>
OK;

//=====================================GET====================================POST===========================================================================
if($_SERVER['REQUEST_METHOD'] === "GET"){ //GET  
        include("inc/mijloc.php");
	    echo $form;
		echo "<br>";
} 

else { //POST
		if (empty($_POST['nume']) || empty($_POST['parola'])) { //NO NAME || NO PASSWORD - STEP 1
				include("inc/mijloc.php");
				$msg = "Introduceti user si parola!";
				echo "$msg <br> $form";
			}
		else{
                                $x = loadDB();			
								if (!array_key_exists($_POST['nume'], $x) || $x[$_POST['nume']] !== md5($_POST['parola'])) { //in array NOT RECOGNIZED - STEP 2 
								   include("inc/mijloc.php");
								   $msg = "Autentificare esuata!";
								   echo "$msg <br> $form";
								   include("inc/footer.php");
								   exit;
								}
								else {                                 //ALL GOOD set sessions and go to bank
									if($_POST['rem']=='on'){
									$_SESSION['expire'] = time() + 60*30; //30 minute
                                    $_SESSION['username'] = $_POST['nume'];
                                    $_SESSION['poza'] = daPoza($_POST['nume']);									
									header('Location: rezervareCamera.php?rezervare');
									} 
									else {	
									$_SESSION['username'] = $_POST['nume'];  //set session.......................POZE
									$_SESSION['poza'] = daPoza($_POST['nume']);
									header('Location: rezervareCamera.php?rezervare');
									exit; }
									
								}
			}		
}
if(isset($_GET['ok'])){
	echo "<div style='color:red;'>Success!</div>";
}			
include("inc/footer.php"); //------------FOOTER----------------
?>