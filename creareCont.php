<?php
session_start();
$altForm = <<<FORM
<form method='POST' action='$_SERVER[PHP_SELF]' enctype='multipart/form-data'>
    Full Name: <br><input type='text' name='fullname' onfocus="yellow(this)"><br>
	User: <br><input type='text' name='username' onfocus="yellow(this)"><br>
    Set Password: <br><input type='password' name='pass' onfocus="yellow(this)"><br>
    Picture: <br><input type='file' name='poza'>(only .jpg)<br>
	| ￣￣￣￣￣￣￣ |<br>  
|    <input type='submit' value='Register'>                |<br>

|＿＿＿＿＿＿＿＿|<br>
</form>
FORM;
include("inc/functii.php");
include("inc/header.php"); //------------HEADER-------------
meniu();
include("inc/mijloc.php");
echo $altForm;
include("inc/footer.php");
?>

<?php
$produse = [];

if($_SERVER['REQUEST_METHOD'] === "POST"){
	
    if (!isset($_POST['fullname']) || !preg_match('/^([A-Z][a-z]+)\s([A-Z][a-z]+)$/', $_POST['fullname']) || strlen($_POST['fullname'])>20 || strlen($_POST['fullname'])<2) {
        echo "<h3>ex: John Smith</h3> intre 3 si 20 caractere";
		exit;
    }
	elseif (!isset($_POST['username']) || !preg_match('/^([a-z]+)$/', $_POST['username']) || strlen($_POST['username'])>20 || strlen($_POST['username'])<2) {
        echo "error - intre 3 si 20 caractere";
		exit;
    }
	elseif (empty($_FILES['poza'])){
	    echo "poza empty";
        exit;		
	}
	elseif (!isset($_POST['pass']) || !preg_match("/^([a-z](?=.*\d)(?=.*[_]).{3,20})$/", $_POST['pass'])) {
        echo "parola invalida: Minim 3 caractere, minim 1 underscore, minim 1 cifra";
		exit;
    }
	elseif ($_FILES['poza']['error'] !== UPLOAD_ERR_OK){
		echo "eroare la upload";
		exit;
	}
	 else {
        $f = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($f, $_FILES['poza']['tmp_name']);
        finfo_close($f);
        if ($mime !== 'image/jpeg') {
            echo 'Fisierul nu este de tip jpeg';
			exit;
        }
		else {
		$newname = tempnam('poze', 'poza_') . ".jpg";
        if (!move_uploaded_file($_FILES['poza']['tmp_name'], $newname)) {
            echo 'Eroare la salvarea fisierului';
			exit;
        } else {
			$myarr = duplicatUser();
			if (in_array($_POST['username'], $myarr)) {
            echo "Username exista deja!";
			exit;
            }
			else{
            $produse[] = [
			    'fullname' => $_POST['fullname'],
                'username' => $_POST['username'],
                'pass' => md5($_POST['pass']),
                'poza' => basename($newname)
            ];
			
			}
        }
		}
    }
saveDB($produse);
header("Location:dashboard.php?ok");	
}//end if mare 

?>