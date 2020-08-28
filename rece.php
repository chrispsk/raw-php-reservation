<?php
if($_SERVER['REQUEST_METHOD']=== "GET"){
	echo "NO";
}
else{
header("Content-type:text/html");
header("Content-Disposition:attachment;filename=../receipt.html");
readfile("../receipt.html");
}
