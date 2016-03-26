<?php

require_once "../rclasse/lib/start.php";

ini_set("display_errors", DISPLAY_ERRORS);

check_session();

$to = $from = $_SESSION['__config__']['admin_email'];
$subject = "Errore albo";

$text = "\n\nBrowser::{$_SERVER['HTTP_USER_AGENT']}\n";
$text .= "Installazione::{$_SESSION['__config__']['intestazione_scuola']}, {$_SESSION['__config__']['indirizzo_scuola']}\n\n";
while(list($k, $v) = each($_SESSION['no_file'])){
    $text .= "{$k}::{$v}\n";
}

$headers = "From: {$from}\r\n" .	"Reply-To: {$to}\r\n" .'X-Mailer: PHP/' . phpversion();
//mail($to, $subject, $text, $headers);

$sel_cat = "SELECT id_categoria, codice, nome, descrizione FROM rb_categorie_docs WHERE tipo_documento = 7";
$res_cat = $db->execute($sel_cat);
$categorie = array();
while($cat = $res_cat->fetch_assoc()){
	$categorie[$cat['id_categoria']] = $cat;
}

$mesi = array("", "gennaio", "febbraio", "marzo", "aprile", "maggio", "giugno", "luglio", "agosto", "settembre", "ottobre", "novembre", "dicembre");

$year = $_SESSION['no_file']['year'];
$month = $_SESSION['no_file']['month'];

setlocale(LC_TIME, "it_IT");

$drawer_label = "File non trovato";

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php print $_SESSION['__config__']['intestazione_scuola'] ?>:: file non trovato</title>
    <link rel="stylesheet" href="../../css/general.css" type="text/css" media="screen,projection" />
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,400italic,600,600italic,700,700italic,900,200' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../rclasse/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../rclasse/css/general.css" type="text/css" media="screen,projection" />
    <link href="../rclasse/css/site_themes/light_blue/reg.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="../rclasse/js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="../rclasse/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script type="text/javascript" src="../rclasse/js/page.js"></script>
    <script type="text/javascript">
        $(function() {
            load_jalert();
            setOverlayEvent()
        });
    </script>
</head>
<body>
<header id="header">
    <div id="sc_firstrow">
        <img src="<?php echo $_SESSION['__path_to_root__'] ?>css/site_themes/light_blue/images/icona_scuola.gif" style="width: 20px"/>
        <span style="position: relative; bottom: 5px">Albo pretorio on line</span>
    </div>
    <div id="sc_secondrow">
        <span style="margin-left: 5px"><?php print $_SESSION['__config__']['intestazione_scuola'] ?></span>
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
            <p class="menu_label act_icon">Archivio <?php echo $year ?></p>
            <ul class="menublock" style="" dir="rtl">
                <?php
                reset ($mesi);
                foreach ($mesi as $k => $month){
                    if ($k > 0){
                        ?>
                        <li><a href="archive.php?y=<?php echo $year ?>&m=<?php echo $k ?>"><?php echo $month ?></a></li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <div id="left_col">
        <div class="welcome">
            <p id="w_head" style="font-weight: bold">File non trovato</p>
            <p class="w_text">
                Il file <span class="attention"><?php if ($_SESSION['__user__']->getUsername() == 'rbachis' || $_SESSION['__user__']->getUsername() == 'admin' || isset($_SESSION['__sudoer__'])) echo $_SESSION['no_file']['file'] ?></span> da te richiesto non &egrave; presente nel server.<br /><br />
                Il problema &egrave; stato segnalato all'amministratore del sito, e sar&agrave; risolto al pi&ugrave; presto.<br /><br />
                Ti preghiamo di riprovare pi&ugrave; tardi e di scusare il disagio.
            </p>
            <p class="w_text">
                <a href="../..<?php echo $_SESSION['no_file']['relative'] ?>">Torna alla pagina precedente</a>
            </p>
        </div>
    </div>
    <p class="spacer"></p>
</div>
<footer id="footer">
    <span>Copyright <?php echo date("Y") ?> Riccardo Bachis | <a href="<?php print $_SESSION['__config__']['root_site'] ?>"><?php print $_SESSION['__config__']['intestazione_scuola'] ?></a></span>
</footer>
<div id="drawer" class="drawer" style="display: none; position: absolute">
    <div style="width: 100%; height: 430px">
        <div class="drawer_link"><a href="<?php echo $_SESSION['__modules__']['docs']['path_to_root'] ?>intranet/<?php echo $_SESSION['__mod_area__'] ?>/index.php"><img src="../../images/6.png" style="margin-right: 10px; position: relative; top: 5%" />Home</a></div>
        <div class="drawer_link"><a href="<?php echo $_SESSION['__modules__']['docs']['path_to_root'] ?>intranet/<?php echo $_SESSION['__mod_area__'] ?>/profile.php"><img src="../../images/33.png" style="margin-right: 10px; position: relative; top: 5%" />Profilo</a></div>
        <div class="drawer_link"><a href="index.php"><img src="<?php echo $_SESSION['__modules__']['docs']['path_to_root'] ?>images/11.png" style="margin-right: 10px; position: relative; top: 5%" />Documenti</a></div>
        <?php if(is_installed("com")){ ?>
            <div class="drawer_link"><a href="<?php echo $_SESSION['__modules__']['docs']['path_to_root'] ?>modules/communication/load_module.php?module=com&area=<?php echo $_SESSION['__mod_area__'] ?>"><img src="<?php echo $_SESSION['__modules__']['docs']['path_to_root'] ?>images/57.png" style="margin-right: 10px; position: relative; top: 5%" />Comunicazioni</a></div>
        <?php } ?>
    </div>
    <?php if (isset($_SESSION['__sudoer__'])): ?>
        <div class="drawer_lastlink"><a href="<?php echo $_SESSION['__modules__']['docs']['path_to_root'] ?>intranet/<?php echo $_SESSION['__mod_area__'] ?>/admin/sudo_manager.php?action=back"><img src="../../images/14.png" style="margin-right: 10px; position: relative; top: 5%" />DeSuDo</a></div>
    <?php endif; ?>
    <div class="drawer_lastlink"><a href="<?php echo $_SESSION['__modules__']['docs']['path_to_root'] ?>shared/do_logout.php"><img src="../../images/51.png" style="margin-right: 10px; position: relative; top: 5%" />Logout</a></div>
</div>
</body>
</html>
