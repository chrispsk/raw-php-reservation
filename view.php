<?php
//Get the response sent in the url of the redirect
if(isset($_GET["m"]) && $_GET["m"] == 1)
{
  echo "Thank you for submitting your form.";
}
else{
	header("Location:contact.php");
}
?>