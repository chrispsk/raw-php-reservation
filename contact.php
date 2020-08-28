<?php
session_start();
include("inc/functii.php");
include("inc/header.php"); //------------HEADER-------------
meniu();
include("inc/mijloc.php");
$unaltform = <<<FORM
<form method='POST' action='process.php'>
    Full Name: <br><input type='text' name='full' onfocus='yellow(this)'><br>
	Email: <br><input type='text' name='email' onfocus='yellow(this)'><br>
    Phone: <br><input type='text' name='telefon' onfocus='yellow(this)'><br>
	How did you land here? <br>
	<select name='deUnde'>
	<option value='google'>Google</option>
	<option value='prieten'>Prieten</option>
	<option value='altaSursa'>Alta Sursa</option>
	</select> <br>
	Comment: <textarea name="comment" rows="5" cols="40"></textarea><br>
	| ￣￣￣￣￣￣￣ |<br>  
|    <input type='submit' value='Send' name='send'>                |<br>

|＿＿＿＿＿＿＿＿|<br>
</form>
FORM;
$regex_tel = '/^((00|\+)?4)?07\d\d([\.\- ]?\d{3}){2}$/';

if($_SERVER['REQUEST_METHOD'] === "GET"){
	echo $unaltform;
}

if(isset($_GET['error'])){
	switch($_GET['error']){
		case 1: echo "Invalid Name: ex: John Smith - intre 3 si 20 caractere"; break;
		case 2: echo "Email is required"; break;
		case 3: echo "Invalid email format"; break;
		case 4: echo "Telefon Invalid"; break;
		case 5: echo "Alegeti una dintre operatiile posibile"; break;
		case 6: echo "no comment"; break;
		default: echo "Some Error";
	}
}


include("inc/footer.php");
?>