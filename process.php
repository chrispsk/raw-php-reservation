<?php
//Grab the information sent from the form using $_POST
const CONTACT = '..'. DIRECTORY_SEPARATOR .'contact.txt';

if($_SERVER["REQUEST_METHOD"] === "GET"){
	header("Location:contact.php");
}
else{

if (empty($_POST['full']) || !preg_match('/^([A-Z][a-z]+)\s([A-Z][a-z]+)$/', $_POST['full']) || strlen($_POST['full'])>20 || strlen($_POST['full'])<2) {
        header('Location: contact.php?error=1');
		die("bau");
    }
	elseif (empty($_POST["email"])) {
    header('Location: contact.php?error=2');
	die("bau");
  } else {
    $email = $_POST["email"];
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      header('Location: contact.php?error=3');
	  die("bau");
    }
  }
  if (!isset($_POST['telefon']) || !preg_match('/^((00|\+)?4)?07\d\d([\.\- ]?\d{3}){2}$/', $_POST['telefon'])) {
        header('Location: contact.php?error=4');
		die("bau");
    }
   elseif(!isset($_POST['deUnde']) || !in_array($_POST['deUnde'], ['google','prieten','altaSursa'])){
		header('Location: contact.php?error=5');
		die("bau");
	}elseif(empty($_POST['comment'])){
      header('Location: contact.php?error=6');
	  die("bau");
	} 
	
	else { // ALL GOOD
    $comm = htmlspecialchars($_POST['comment']);		
	file_put_contents(CONTACT, $_POST['full'].", ".$_POST['email'].", ".$_POST['telefon'].", ".$_POST['deUnde'].", ".$comm, FILE_APPEND);
	file_put_contents(CONTACT, "\r\n", FILE_APPEND);
	}

//Redirect the page once all the work is done.
header("location:view.php?m=1");
die("bau");
}
?>