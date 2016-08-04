<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="Albo pretorio ufficiale dell'Istituto comprensivo Nivola, di Serra Perdosa, a Iglesias." />
    <meta name="keywords" content="Project Keywords" />
    <title>Albo pretorio</title>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,400italic,600,600italic,700,700italic,900,200' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../rclasse/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../rclasse/css/general.css" type="text/css" media="screen,projection" />
    <link href="../rclasse/css/site_themes/light_blue/reg.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="../rclasse/js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="../rclasse/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script type="text/javascript" src="../rclasse/js/page.js"></script>
    <script type="text/javascript">
    function load(element, field, is_char){
        if(element == 0){
            document.location.href = "index.php";
            return false;
        }
        $('#field').val(field);
        $('#param').val(element);
        if(is_char)
            $('#param_type').val("char");
        else
            $('#param_type').val("num");

        $('#search_form').submit();
    }

    $(function(){
        load_jalert();
        setOverlayEvent();
        $('#top_btn').click(function() {
            $('html,body').animate({
                scrollTop: 0
            }, 700);
            return false;
        });

        var amountScrolled = 200;

        $(window).scroll(function() {
            if ($(window).scrollTop() > amountScrolled) {
                $('#plus_btn').fadeOut('slow');
                $('#float_btn').fadeIn('slow');
                $('#top_btn').fadeIn('slow');
            } else {
                $('#float_btn').fadeOut('slow');
                $('#plus_btn').fadeIn();
                $('#top_btn').fadeOut('slow');
            }
        });
    });
    </script>
    <style>
        body {
            color: #4b4b4b !important;;
        }
    </style>
</head>
<body>
<header id="header">
    <div id="sc_firstrow">
        <img src="<?php echo $_SESSION['__path_to_root__'] ?>css/site_themes/light_blue/images/icona_scuola.gif" style="width: 20px"/>
        <span style="position: relative; bottom: 5px">Albo pretorio on line</span>
    </div>
    <div id="sc_secondrow">
        <span style="margin-left: 5px">
            <a href="http://www.istitutoiglesiasserraperdosa.it">
                <?php print $_SESSION['__config__']['intestazione_scuola'] ?> - Iglesias
            </a>
        </span>
    </div>
</header>
<nav id="navigation">
    <div id="head_label">
        <img src="<?php echo $_SESSION['__path_to_root__'] ?>images/ic_navigation_drawer3.png" id="open_drawer" style="float: left; position: relative; top: 18px" />
        <p id="drawer_label" style="margin-top: 17px; vertical-align: top; margin-left: 10px; float: left; color: white"><?php echo $drawer_label ?></p>
    </div>
    <div class="nav_div" style="float: right; margin-right: 50px; position: relative; top: 20px; text-align: right">Albo pretorio on line</span></div>
    <div class="nav_div" style="clear: both"></div>
</nav>
<div id="main">
    <div id="right_col">
        <div class="smallbox" id="working">
            <p class="menu_label act_icon">Categorie</p>
                <ul class="menublock" style="" dir="rtl">
                    <li><a href="index.php">Tutte</a></li>
                    <?php
                    foreach ($categorie as $cat){
                        ?>
                        <li><a href="#" onclick="load(<?php echo $cat['id_categoria'] ?>, 'categoria',  false)" title="<?php echo $cat['descrizione'] ?>"><?php echo $cat['nome'] ?></a></li>
                    <?php } ?>
                </ul>
            <p class="menu_label classbook_icon">Archivio</p>
            <ul class="menublock" style="" dir="rtl">
                <li><a href="index.php">Tutti</a></li>
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
            <p class="menu_label gradebook_icon">Archivio anni precedenti</p>
                <ul class="menublock" style="" dir="rtl">
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
    <div id="left_col">
				<?php
if(!isset($_REQUEST['month'])){
	$x = 1;
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
					<div class="albo_document <?php if($x%2) echo 'odd' ?>">
					    <div class="normal albo_title fleft">
                            <?php if($doc['titolo'] == "") print "Nessuna descrizione presente"; else print $ab ?>
					    </div>
                        <div class="fright" style="width: 5%">
                            <a href="../rclasse/modules/documents/download_manager.php?doc=document&id=<?php print
                                    $doc['id'] ?>" style="padding-top: 3px">
                                <img src="../rclasse/images/mime/<?php echo $img ?>" style="margin-right: 5px; width: 25px" />
                            </a>
                        </div>
                        <div class="albo_data">
                            <p class="albo_data_line">
                                Pubblicato il <?php print format_date(substr($doc['data_upload'], 0, 10), SQL_DATE_STYLE, IT_DATE_STYLE, "/") ?> alle ore <?php
                                print substr($doc['data_upload'], 11, 5) ?> da <?php echo $doc['owner'] ?>
                            </p>
                            <p class="albo_data_line">
                                Tipologia: <span class="accent_color" style="font-weight: normal"><?php echo $doc['nome'] ?></span>
                            </p>
                        </div>
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
            <div class="albo_document <?php if($x%2) echo 'odd' ?>">
                <div class="normal albo_title fleft">
                    <?php if($doc['titolo'] == "") print "Nessuna descrizione presente"; else print $ab ?>
                </div>
                <div class="fright" style="width: 5%">
                    <a href="../rclasse/modules/documents/download_manager.php?doc=document&id=<?php print
                            $doc['id'] ?>" style="padding-top: 3px">
                        <img src="../rclasse/images/mime/<?php echo $img ?>" style="margin-right: 5px; width: 25px" />
                    </a>
                </div>
                <div class="albo_data">
                    <p class="albo_data_line">
                        Pubblicato il <?php print format_date(substr($doc['data_upload'], 0, 10), SQL_DATE_STYLE, IT_DATE_STYLE, "/") ?> alle ore <?php
                        print substr($doc['data_upload'], 11, 5) ?> da <?php echo $doc['owner'] ?>
                    </p>
                    <p class="albo_data_line">
                        Tipologia: <span class="accent_color" style="font-weight: normal"><?php echo $doc['nome'] ?></span>
                    </p>
                </div>
            </div>
<?php
		$x++;
		}
	}
}
?>
        <p class="spacer"></p>
			</div>
		</div><!-- // end #main -->
<form method="post" id="search_form" action="index.php" style="display: none">
	<input type="hidden" id="field" name="field" />
	<input type="hidden" id="param" name="param" />
	<input type="hidden" id="param_type" name="param_type" />
</form>

<footer id="footer">
    <span>Copyright <?php echo date("Y") ?> Riccardo Bachis | <a href="<?php print $_SESSION['__config__']['root_site'] ?>"><?php print $_SESSION['__config__']['intestazione_scuola'] ?></a></span>
</footer>
<div id="alert" class="alert_msg" style="display: none">
    <div class="alert_title">
        <i class="fa fa-thumbs-up"></i>
        <span>Successo</span>
    </div>
    <p id="alertmessage" class="alertmessage"></p>
</div>
<div id="error" class="error_msg" style="display: none">
    <div class="error_title">
        <i class="fa fa-warning"></i>
        <span>Errore</span>
    </div>
    <p class="errormessage" id="errormessage"></p>
</div>
<div id='background' class="alert_msg" style='display: none'>
    <div class="alert_title">
        <i class="fa fa-spin fa-circle-o-notch"></i>
        <span>Attendi...</span>
    </div>
    <p id="background_msg" class="alertmessage"></p>
</div>
<div class="overlay" id="overlay" style="display:none;"></div>
</body>
<a href="#" id="top_btn" style="left: 70%" class="rb_button float_button top_button">
    <i class="fa fa-arrow-up"></i>
</a>
</html>
