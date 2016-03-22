<?php

require_once "../rclasse/lib/start.php";

$to = "webmaster@inrich.it";
$subject = "Errore albo";
while(list($k, $v) = each($_SESSION['no_file'])){
	$text .= "{$k}::{$v}\n";
}
$text .= "\n\nBrowser::{$_SERVER['HTTP_USER_AGENT']}\n";
$text .= "Installazione::{$_SESSION['__config__']['intestazione_scuola']}, {$_SESSION['__config__']['indirizzo_scuola']}\n\n";
$headers = "From: webmaster@inrich.it\r\n" .	"Reply-To: webmaster@inrich.it\r\n" .'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $text, $headers);

$sel_cat = "SELECT id_categoria, codice, nome, descrizione FROM rb_categorie_docs WHERE tipo_documento = 7";
$res_cat = $db->execute($sel_cat);
$categorie = array();
while($cat = $res_cat->fetch_assoc()){
	$categorie[$cat['id_categoria']] = $cat;
}

$mesi = array("", "gennaio", "febbraio", "marzo", "aprile", "maggio", "giugno", "luglio", "agosto", "settembre", "ottobre", "novembre", "dicembre");

setlocale(LC_TIME, "it_IT");

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="Albo pretorio ufficiale dell'Istituto comprensivo Nivola, di Serra Perdosa, a Iglesias. <?php if (isset($_REQUEST['month'])) echo "Archivio mese di ".$mesi[$_REQUEST['month']] ?>" />
<meta name="keywords" content="Project Keywords" />
<title>Albo pretorio</title>	
<link href="css/style.css" rel="stylesheet" type="text/css" />			
<!--[if IE]><link href="css/style-ie.css" rel="stylesheet" type="text/css" /><![endif]-->	
<script type="text/javascript" src="../rclasse/js/prototype.js"></script>
<script type="text/javascript" src="../rclasse/js/scriptaculous.js"></script>
<script type="text/javascript" src="../rclasse/js/page.js"></script>
<script type="text/javascript">

</script>
</head>
<body>
<div id="wrapper">
	<div id="container">
		<div id="header" class="clearfix">
			<div id="logo">
				<h1><a href="http://www.istitutoiglesiasserraperdosa.it" style="color: #898989">Istituto comprensivo C. Nivola</a></h1>
				<p>Serra Perdosa, Iglesias</p>
			</div>
			<ul id="nav">
				<li><a href="index.php">Home</a></li>
				<?php if ($_SESSION['__user__'] && $_SESSION['__user__']->check_perms(DIR_PERM|DSG_PERM|SEG_PERM)): ?>
				<li class="active"><a href="index.php?months=1">Riepilogo mensile</a></li>
				<?php endif; ?>
			</ul>
		</div><!-- // end #header -->
		<div id="banner">
			<h1 class="page-title">Albo pretorio</h1>
		</div><!-- // end #banner -->
		<div id="main" class="clearfix">
			<div id="content">
				<p>
					Il file <span style="color: red"><?php echo basename($_SESSION['no_file']['fn']) ?></span> da te richiesto non &egrave; presente nel server.<br /><br />
					Il problema &egrave; stato segnalato all'amministratore del sito, e sar&agrave; risolto al pi&ugrave; presto.<br /><br />
					Ti preghiamo di riprovare pi&ugrave; tardi e di scusare il disagio.
			 	</p>
			 	<p><a href="../..<?php echo $_SESSION['no_file']['relative'] ?>">Torna alla pagina precedente</a></p>
			</div>
			<div id="sidebar">
				<div class="widget">
					<h2>Categorie</h2>
					<div class="contentarea">
						<ul>
						<?php 
						foreach ($categorie as $cat){
						?>
							<li><a href="#" onclick="load(<?php echo $cat['id_categoria'] ?>, 'categoria',  false)" title="<?php echo utf8_encode($cat['descrizione']) ?>"><?php echo utf8_decode($cat['nome']) ?></a></li>
						<?php } ?>	
						</ul>
					</div>
				</div>
				<div class="widget">
					<h2>Archivio <?php echo date("Y") ?></h2>
					<div class="contentarea">
						<ul>
					<?php 
					$m = intval(date("m"));
					while($m > 0){
					?>
							<li><a href="index.php?month=<?php echo $m ?>"><?php echo $mesi[$m] ?></a></li>
					<?php 
						$m--;
					} 
					?>
							
						</ul>
					</div>
				</div>
			</div><!-- // end #sidebar -->
		</div><!-- // end #main -->
		<div id="footer">
			<p>&copy; copyright 2013 <a href="http://www.istitutoiglesiasserraperdosa.it">Istituto comprensivo Sud Est, Iglesias</a> Tutti i diritti riservati </p>
			
			<!-- Please don't remove my backlink -->
			<p>Free Web Design Templates by <a href="http://www.dkntemplates.com" title="Dkntemplates">Dkntemplates.com</a></p>
			<!-- Please don't remove my backlink -->
			
		</div><!-- // end #footer -->
	</div><!-- // end #container -->
</div><!-- // end #wrapper -->
<form method="post" id="search_form" action="index.php">
	<input type="hidden" id="field" name="field" />
	<input type="hidden" id="param" name="param" />
	<input type="hidden" id="param_type" name="param_type" />
</form>

	
</body>
</html>
