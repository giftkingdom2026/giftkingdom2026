<html>
<head>
<title> Non-Seamless-kit</title>
</head>
<body>
<center>

<?php include('Crypto.php')?>
<?php 
// echo 'sad';exit;
	error_reporting(0);
	
	$merchant_data='';
	$working_key='79F0A735BB60F43FFF6E1DB6F34D5154';//Shared by CCAVENUES
	$access_code='AVGH04KC59AU02HGUA';//Shared by CCAVENUES

	// $working_key='822624264B5FAA9045EA4464B197E747';//Shared by CCAVENUES  Live
	// $access_code='AVMF03ID76AW33FMWA';//Shared by CCAVENUES Live
	
	
	foreach ($_POST as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}

	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.

?>
<form method="post" name="redirect" action="https://secure.ccavenue.ae/transaction/transaction.do?command=initiateTransaction"> 
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
?>
</form>
</center>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>

