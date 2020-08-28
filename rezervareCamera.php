<?php
ini_set('display_errors', 1);
session_start();

if (empty($_SESSION['username'])) {                 //No Session No access(!!!!!!!)
    header('Location: dashboard.php');
    exit;
} else{
	$now = time();
	if (isset($_SESSION['expire']) && $now > $_SESSION['expire']) {
			unset($_SESSION['expire']);
			unset($_SESSION['username']);
            session_destroy();
            echo "Your session has expired! <a href='dashboard.php'>Login here</a>";
			exit;
        }
}
include("inc/functii.php");
include("inc/header.php"); //------------HEADER-------------
meniu();

//===============================LogOut====================================================
if($_SERVER['REQUEST_METHOD']==="GET" && isset($_GET['logout'])){
     unset($_SESSION['username']);
	 unset($_SESSION['expire']);
	 unset($_SESSION['bucket']);
	 unset($_SESSION['click']);
	 unset($_SESSION['poza']);
	 session_destroy();
     header("Location: dashboard.php");
} 
else {
	include("inc/mijloc.php");
	echo "Single Room = 200$ ][ Double Room = 400$<br><br>";
    //===============================GET====================================================
	if($_SERVER['REQUEST_METHOD']==="GET" && !isset($_SESSION['click'])){echo $form1; $_SESSION['click'] = 0;} //handle GET
    elseif($_SERVER['REQUEST_METHOD']==="GET" && $_SESSION['click'] == 0){echo $form1; }
    elseif($_SERVER['REQUEST_METHOD']==="GET" && $_SESSION['click'] == 1){laTable(); echo totalul();}
	elseif($_SERVER['REQUEST_METHOD']==="GET" && $_SESSION['click'] == 11){echo $form2; echo totalul();}
    elseif($_SERVER['REQUEST_METHOD']==="GET" && $_SESSION['click'] == 2){laTable(); echo totalul()." in total<br>"; echo $_SESSION["bucket"]["perLuna"]." per month";}	
	}
//click button	
//===============================POST====================================================

if(isset($_POST['sub1'])){ //aici incep verificarile
      if(!isset($_POST['nume2']) || !in_array($_POST['nume2'], ['Single','Double'])){
		echo "<h1>Alegeti una dintre operatiile posibile</h1>";
		echo "<br><a href='rezervareCamera.php?rezervare'>Try Again</a>";
		exit;
	}
	elseif(!preg_match("/^([1-9][0-9]?)$/", $_POST['nrNopti']) || $_POST['nrNopti']>31){
		echo "bad number. Doar intre 0-31";
		echo "<br><a href='rezervareCamera.php?rezervare'>Try Again</a>";
		exit;
	}
	elseif(!isset($_POST['tip']) || !in_array($_POST['tip'], ['Integral','Rate'])){
		echo "<h1>Alegeti una dintre operatiile posibile</h1>";
		echo "<br><a href='rezervareCamera.php?rezervare'>Try Again</a>";
		exit;
	}
	else{
	$_SESSION["bucket"]["camere"] = $_POST["nume2"];
	$_SESSION["bucket"]["nopti"] = $_POST["nrNopti"];
	$_SESSION["bucket"]["plata"] = $_POST["tip"];}
	
	if($_SESSION["bucket"]["plata"]=="Rate"){
	echo $form2;
	$_SESSION['click'] = 11;
	echo totalul();	
    } else{
		$_SESSION["bucket"]["rata"]=0;
		$_SESSION["bucket"]["perLuna"]=0;
		$_SESSION['click'] = 1;
		laTable(); //functii.php
		echo totalul();
	}
	}

	
	
	
	
	if(isset($_POST['prev']) && $_SESSION['click'] == 1){
	$_SESSION['click'] = 0;
		echo $form1;
	}
	
if(isset($_POST['prev']) && $_SESSION['click'] == 11){
	$_SESSION['click'] = 0;
		echo $form1;
	}	

	
if(isset($_POST['nex'])){
	if(!isset($_POST['rata']) || !in_array($_POST['rata'], [2,4])){
		echo "<h1>Alegeti una dintre operatiile posibile</h1>";
		echo "<br><a href='rezervareCamera.php?rezervare'>Try Again</a>";
		exit;
	} else {
		$_SESSION['click'] = 2;
		$_SESSION["bucket"]["rata"] = $_POST["rata"];
		laTable(); //functii.php
		echo totalul()." in total<br>";
		$_SESSION["bucket"]["perLuna"] = totalul() / $_POST["rata"];
		echo $_SESSION["bucket"]["perLuna"]." per month";
	}
	}
if(isset($_POST['prev']) && $_SESSION['click'] == 2){
	$_SESSION['click'] = 11;
	echo $form2;
	echo totalul();
	}		
if(isset($_POST['save'])){
	rezervari();
	//header("Location:rece.php?ok=Success");
	echo "Rezervarea s-a facut. Va vom contacta A.S.A.P<br>";
	echo "<form method='POST' action='rece.php'><input type='submit' value='DONWLOAD RECEIPT'></form>";
}
echo "<br>";
include("inc/footer.php");
?>