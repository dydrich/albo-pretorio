<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="Albo pretorio ufficiale dell'Istituto comprensivo Nivola, di Serra Perdosa, a Iglesias. <?php if (isset($_REQUEST['month'])) echo "Archivio mese di ".$mesi[$_REQUEST['month']] ?>" />
<meta name="keywords" content="Project Keywords" />
<title>Albo pretorio</title>	
<link href="css/style.css" rel="stylesheet" type="text/css" />			
<!--[if IE]><link href="css/style-ie.css" rel="stylesheet" type="text/css" /><![endif]-->	
<link href="../rclasse/css/themes/default.css" rel="stylesheet" type="text/css"/>
<link href="../rclasse/css/themes/mac_os_x.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="../rclasse/js/prototype.js"></script>
<script type="text/javascript" src="../rclasse/js/scriptaculous.js"></script>
<script type="text/javascript" src="../rclasse/js/window.js"></script>
<script type="text/javascript" src="../rclasse/js/window_effects.js"></script>
<script type="text/javascript" src="../rclasse/js/page.js"></script>
<script type="text/javascript">
function load(element, field, is_char){
	if(element == 0){
		document.location.href = "index.php";
		return false;
	}
	$('field').value = field;
	$('param').value = element;
	if(is_char)
		$('param_type').value = "char";
	else
		$('param_type').value = "num";

	$('search_form').submit();
}

function show_div(div, lnk){
	/*
	Effect.SlideUp(div, { duration: 1.0 });
	for(var i = 0; i < divs.length; i++){
		if((divs[i] != div) && ($(divs[i]).style.display !== "none")){
			alert("Chiudo "+divs[i]);
			Effect.BlindDown(divs[i], { duration: 1.0 });
		}
	}
	*/
	if($(div).style.display == "none"){
		if(lnk.parentNode){
			lnk.parentNode.setStyle({backgroundColor: 'rgba(216,223,209, .7)', padding: '10px', borderRadius: '5px', fontWeight: 'bold'});
			lnk.setStyle({color: 'black'});
		}
		Effect.BlindDown(div, { duration: 1.0 });
	}
	else{
		if(lnk.parentNode){
			lnk.parentNode.setStyle({backgroundColor: '#EBF3FA'});
			lnk.setStyle({color: ''});
		}
		Effect.SlideUp(div, { duration: 1.0 });
	}
}
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
				<?php if (isset($_SESSION['__user__']) && $_SESSION['__user__']->check_perms(DIR_PERM|DSG_PERM|SEG_PERM)): ?>
				<li class="active"><a href="index.php?months=1">Riepilogo mensile</a></li>
				<?php endif; ?>
			</ul>
		</div><!-- // end #header -->
		<div id="banner">
			<h1 class="page-title">Albo pretorio</h1>
		</div><!-- // end #banner -->
		<div id="main" class="clearfix">
			<div id="content">
				<?php
if (isset($_REQUEST['months'])){
	while(list($k, $anno) = each($data)){
	?>
	<p class="doc_type" style="">
		<a href='#' onclick="show_div('anno<?php echo $k ?>', this)" style=''>
			Anno <?php echo $k ?>
		</a>
	</p>
	<div id="anno<?php echo $k ?>" style="display: none; background-color: rgba(228, 228, 228, 0.3); border-radius: 0px 0px 0px 0px; border: 1px solid rgba(216,223,209, 1); margin-top: 0px; padding-bottom: 20px">
<?php 
		/*
		 * ciclo mesi
		 */
		while(list($mk, $month) = each($anno)){
			$mese_str = strftime("%B", strtotime(date("Y-m-d"), mktime(0, 0, 0, intval($mk), 1, $k)));
?>
		<p class="mese" style="text-align: center">
			<a href="#" onclick="show_div('anno<?php echo $k ?>_mese<?php echo $mk ?>', '')" style='color: #4B4B4B; font-weight: bold'><?php echo strtoupper($mesi[intval($mk)]) ?></a> (<a href="riepilogo_mensile.php?m=<?php echo $mk ?>&y=<?php echo $k ?>" style='color: #4B4B4B'>stampa riepilogo</a>)
		</p>
		<div class="link_cont" id="anno<?php echo $k ?>_mese<?php echo $mk ?>" style="display: none; margin-left: 15px">
<?php 
			foreach($month as $file){
?>
			<p class="doc_dw" style="line-height: 5px">
				<span style=''><?php print truncateString($file['title'], 70) ?></span>
			</p>
<?php 
			}
?>
		</div>
<?php 
		}
?>
<?php 
	}
?>
	</div>
<?php 
}				
else if(!isset($_REQUEST['month'])){
	$x = 1;
	if (isset($_REQUEST['field']) && $_REQUEST['field'] == "categoria"){
?>
	<div style="width: 95%; margin-top: 5px; text-align: left">
		<p style="font-weight: bold; font-ize: 1.1em">Categoria: <?php echo utf8_decode($categorie[$_REQUEST['param']]['nome']) ?></p>
	</div>
<?php
	}
	if ($res_docs->num_rows < 1){
?>
	<div style="width: 95%; margin-top: 5px; border-bottom: 1px solid rgba(228, 228, 228, 1); text-align: center; border-radius: 10px 0px 0px 0px; ">
		<p style="font-weight: bold; font-ize: 1.1em">Nessun documento presente</p>
	</div>
<?php
	}
	else{
		while($doc = $res_docs->fetch_assoc()){
			$fname = basename($doc['file']);
			$arr = explode("\.", $fname);
			$mime = MimeType::getMimeContentType($fname);
			$img = $mime['image'];
			$ab = $doc['titolo'];
			//if ($doc['abstract'] != ""){
			//	$ab .= " - ".$doc['abstract'];
			//}
?>
					<div style="width: 95%; margin-top: 5px; border-bottom: 1px solid rgba(228, 228, 228, 1); border-radius: 10px 0px 0px 0px; <?php if($x%2) print('background-color: rgba(228, 228, 228, 0.3)') ?>">
					<p style="height: 2px; font-size: 11px; text-transform: uppercase; margin-left: 10px"><?php if($doc['titolo'] == "") print "Nessuna descrizione presente"; else print truncateString($ab, 65) ?>
						<a href="../rclasse/modules/documents/download_manager.php?doc=document&id=<?php print $doc['id'] ?>" style="float: right">
							<img src="../rclasse/images/mime/<?php echo $img ?>" style="margin-right: 5px" />
						</a>
					</p>
					<p style="height: 2px; font-size: 10px; margin-left: 10px">Pubblicato il <?php print format_date(substr($doc['data_upload'], 0, 10), SQL_DATE_STYLE, IT_DATE_STYLE, "/") ?> alle ore <?php print substr($doc['data_upload'], 11, 5) ?> da <?= $doc['owner'] ?></p>
					<p style="height: 2px; font-size: 10px; margin-left: 10px">Tipologia: <span style="font-weight: bold"><?php echo utf8_decode($doc['nome']) ?></span></p>
					</div>
<?php
			$x++;
		}
	}
}
else{
	if ($res_docs->num_rows < 1){
	?>
	<div style="width: 95%; margin-top: 5px; border-bottom: 1px solid rgba(228, 228, 228, 1); text-align: center; border-radius: 10px 0px 0px 0px; ">
		<p style="font-weight: bold; font-ize: 1.1em">Nessun documento presente</p>
	</div>
<?php
	}
	else{
		if ($_SESSION['__user__'] && $_SESSION["__user__"]->check_perms(DSG_PERM)){
?>
				<div style="width: 95%; text-align: right; margin-right: 20px; padding-bottom: 20px">
					<a href="riepilogo_mensile.php?m=<?php echo $_REQUEST['month'] ?>&y=<?php echo date("Y") ?>">Stampa riepilogo mensile</a>
				</div>
<?php
		}
?>
		<div style="width: 95%; margin-top: 5px; text-align: left">
					<p style="font-weight: bold; font-ize: 1.1em">Archivio mese di <?php echo $mesi[$_REQUEST['month']] ?></p>
				</div>
<?php
		$x = 1;
		while($doc = $res_docs->fetch_assoc()){
			$fname = basename($doc['file']);
			$arr = explode("\.", $fname);
			//echo $fname;
			$mime = MimeType::getMimeContentType($fname);
			$img = $mime['image'];
			$ab = $doc['titolo'];
			//if ($doc['abstract'] != ""){
			//	$ab .= " - ".$doc['abstract'];
			//}
	?>
				<div style="width: 95%; margin-top: 5px; border-bottom: 1px solid rgba(228, 228, 228, 1); border-radius: 10px 0px 0px 0px; <?php if($x%2) print('background-color: rgba(228, 228, 228, 0.3)') ?>">
					<p style="height: 5px; font-size: 11px; text-transform: uppercase; margin-left: 10px"><?php if($doc['titolo'] == "") print "Nessuna descrizione presente"; else print truncateString($ab, 65) ?>
						<a href="../rclasse/modules/documents/download_manager.php?doc=document&id=<?php print $doc['id'] ?>" style="float: right">
							<img src="../rclasse/images/mime/<?php echo $img ?>" style="margin-right: 5px" />
						</a>
					</p>
					<p style="height: 5px; font-size: 10px; margin-left: 10px">Pubblicato il <?php print format_date(substr($doc['data_upload'], 0, 10), SQL_DATE_STYLE, IT_DATE_STYLE, "/") ?> alle ore <?php print substr($doc['data_upload'], 11, 5) ?> da <?= $doc['owner'] ?></p>
					<p style="font-size: 10px; margin-left: 10px">Tipologia: <span style="font-weight: bold"><?php print $doc['nome'] ?></span></p>
				</div>
<?php
		$x++;
		}
	}
}
?>
			</div>
			<div id="sidebar">
				<div class="widget">
					<h2>Categorie</h2>
					<div class="contentarea">
						<ul>
						<?php 
						foreach ($categorie as $cat){
						?>
							<li><a href="#" onclick="load(<?php echo $cat['id_categoria'] ?>, 'categoria',  false)" title="<?php echo $cat['descrizione'] ?>"><?php echo utf8_decode($cat['nome']) ?></a></li>
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
				<div class="widget">
					<h2>Archivio anni precedenti </h2>
					<div class="contentarea">
						<ul>
							<?php
							foreach ($archive as $old_year){
							?>
							<li><a href="archive.php?y=<?php echo $old_year ?>"><?php echo $old_year ?></a></li>
							<?php
							}
							?>

						</ul>
					</div>
				</div>
			</div><!-- // end #sidebar -->
		</div><!-- // end #main -->
		<div id="footer">
			<p>&copy; copyright <?php echo date("Y") ?> <a href="http://www.istitutoiglesiasserraperdosa.it">Istituto comprensivo "C. Nivola", Serra Perdosa - Iglesias</a> Tutti i diritti riservati </p>
			
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
