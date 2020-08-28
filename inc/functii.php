<?php
const DB = '..'. DIRECTORY_SEPARATOR .'ksjdjfg.txt';
const REZERVARI = '..'. DIRECTORY_SEPARATOR .'rezervari.txt';
if(!isset($_SESSION['bucket'])){$_SESSION['bucket']=array();}
$radio1 = (isset($_SESSION["bucket"]["camere"]) && $_SESSION["bucket"]["camere"] == 'Single') ? 'checked' : '';
$radio2 = (isset($_SESSION["bucket"]["camere"]) && $_SESSION["bucket"]["camere"] == 'Double') ? 'checked' : '';
$noapte = (isset($_SESSION["bucket"]["nopti"])) ? $_SESSION["bucket"]["nopti"] : '';
$radio3 = (isset($_SESSION["bucket"]["plata"]) && $_SESSION["bucket"]["plata"] == 'Integral') ? 'checked' : '';
$radio4 = (isset($_SESSION["bucket"]["plata"]) && $_SESSION["bucket"]["plata"] == 'Rate') ? 'checked' : '';
$radio5 = (isset($_SESSION["bucket"]["rata"]) && $_SESSION["bucket"]["rata"] == '2') ? 'checked' : '';
$radio6 = (isset($_SESSION["bucket"]["rata"]) && $_SESSION["bucket"]["rata"] == '4') ? 'checked' : '';

$form1 = <<<OK
	<form action = "rezervareCamera.php?rezervare" method = "POST">
	     Tip Camera:<br>
         <input type="radio" name="nume2" value="Single" $radio1>Single
         <input type="radio" name="nume2" value="Double" $radio2>Double <br>
		 Numar Nopti (intre 1-31)<br>
		 <input type="text" name="nrNopti" value="$noapte" size="4" onfocus='yellow(this)'><br>
		 Modalitate de plata:<br>
		 <input type="radio" name="tip" value="Integral" $radio3>Integral
         <input type="radio" name="tip" value="Rate" $radio4>Rate<br>
         <input type = "submit" value='NEXT' name='sub1'/>
    </form>
OK;

$form2 = <<<KK
	<form action = "rezervareCamera.php?rezervare" method = "POST">
		 Modalitate de plata:<br>
		 <input type="radio" name="rata" value="2" $radio5>2
         <input type="radio" name="rata" value="4" $radio6>4<br>
		 <input type = "submit" value='PREV' name='prev'/>
         <input type = "submit" value='NEXT' name='nex'/>
    </form>
KK;

function meniu(){
$meniul=<<<GATA
  <a href="dashboard.php">Home</a>
  <a href="rezervareCamera.php?rezervare">Reservation</a>
  <a href="creareCont.php">Register</a>
  <a href="contact.php">Contact</a> 
GATA;
echo $meniul; 
$boom = (isset($_SESSION['username']))?"<b id='green'>◉</b> Howdy ".ucwords($_SESSION['username']):"<b id='red'>◉FF</b>";
$out = (isset($_SESSION['username']))?"<a href='rezervareCamera.php?logout'>►LogOut</a>":"";
$sp = "<span>$boom<br>$out<br>";
echo $sp;
if(isset($_SESSION['poza'])){
echo "<img src='poze/{$_SESSION['poza']}' width='50' height='50' id='myImg'>";
}
echo "</span>";
}

function loadDB(){
	$laUseri = array();
    $xx = file(DB,FILE_IGNORE_NEW_LINES);
    foreach ($xx as $p) {
        $yy = explode(",", $p);
        $laUseri[$yy[1]] = $yy[2] ;
        		
    }
    return $laUseri;
}

function daPoza($v){
	$poza = '';
    $xx = file(DB,FILE_IGNORE_NEW_LINES);
    foreach ($xx as $p) {
		$yy = explode(",", $p);
        if($v == $yy[1]){
		$poza = $yy[3]; }		
    }
    return $poza;
}

function duplicatUser(){
	$doarUseri = array();
    $xy = file(DB,FILE_IGNORE_NEW_LINES);
    foreach ($xy as $pp) {
        $yy = explode(",", $pp);
        $doarUseri[] = $yy[1] ; 
    }
    return $doarUseri;
}

function saveDB(array $produse){
    $data = '';
    foreach($produse as $p){
        $data = implode(",",$p);
    }
    file_put_contents(DB, "$data", FILE_APPEND);
	file_put_contents(DB, "\r\n", FILE_APPEND);
}


function laTable(){
$prevNext=<<<GATA
  <form action = "rezervareCamera.php?rezervare" method = "POST">
         <input type = "submit" value='PREV' name='prev'/>
		 <input type = "submit" value='SAVE' name='save'/>		 
    </form> 
GATA;
echo "<div id='tabelul'>";	
echo "<table>";
echo "<tr><td>Camera</td><td>Numar Camera</td><td>Plata</td></tr>";
echo "<tr><td>".$_SESSION["bucket"]["camere"]."</td><td>".$_SESSION["bucket"]["nopti"]."</td><td>".$_SESSION["bucket"]["plata"]."</td></tr>";
echo "</table>";
echo $prevNext;
echo "</div>";
}
function totalul(){
	$total = 0;
	if($_SESSION["bucket"]["camere"]=="Single"){
	$total = 200 * $_SESSION["bucket"]["nopti"];
}
if($_SESSION["bucket"]["camere"]=="Double"){
	$total = 400 * $_SESSION["bucket"]["nopti"];
}
$_SESSION["bucket"]["total"] = $total;
return $total;
}

function rezervari(){
$information = <<<ENDHEREDOC
<center><table>
<tr><td>Name</td><td>Room</td><td>Nights</td><td>Payment</td><td>Rates</td><td>Per Month</td><td>Total</td></tr>
<tr><td>{$_SESSION["username"]}</td><td>{$_SESSION["bucket"]["camere"]}</td><td>{$_SESSION["bucket"]["nopti"]}</td><td>{$_SESSION["bucket"]["plata"]}</td><td>{$_SESSION["bucket"]["rata"]}</td><td>{$_SESSION["bucket"]["perLuna"]}</td><td>{$_SESSION["bucket"]["total"]}</td></tr>
</table></center>
ENDHEREDOC;
	
    
	
file_put_contents(REZERVARI, $_SESSION['username'].", ".$_SESSION["bucket"]["camere"].", ".$_SESSION["bucket"]["nopti"].", ".$_SESSION["bucket"]["plata"].", ".$_SESSION["bucket"]["rata"].", ".$_SESSION["bucket"]["perLuna"].", ".$_SESSION["bucket"]["total"], FILE_APPEND);
file_put_contents(REZERVARI, "\r\n", FILE_APPEND);
		echo "DONE";
file_put_contents("../receipt.html", $information);

//file_put_contents("receipt.html", "\r\n");
}

?>