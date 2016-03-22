<?php
/**
 * Created by PhpStorm.
 * User: riccardo
 * Date: 25/02/14
 * Time: 20.11
 */

require_once "../rclasse/lib/start.php";
require_once "../rclasse/lib/MimeType.php";

$_SESSION['__path_to_root__'] = "../rclasse/";

define("PUB_SORT", 1);
define("INS_SORT", 2);
define("CAT_SORT", 3);
define("YEAR_SORT", 4);
define("ABS_SORT", 5);

$label = "Albo pretorio Online";
$year = $_REQUEST['y'];
if (isset($_REQUEST['m'])){
	$sel_docs = "SELECT rb_documents.*, rb_categorie_docs.nome, CONCAT_WS(' ', rb_utenti.nome, rb_utenti.cognome) AS owner FROM rb_documents, rb_categorie_docs, rb_utenti WHERE owner = uid AND rb_documents.categoria = rb_categorie_docs.id_categoria AND doc_type = 7  AND YEAR(data_upload) = '{$year}' AND MONTH(data_upload) = '{$_REQUEST['m']}' ORDER BY data_upload DESC";
	$res_docs = $db->executeQuery($sel_docs);
}

$mesi = array("", "gennaio", "febbraio", "marzo", "aprile", "maggio", "giugno", "luglio", "agosto", "settembre", "ottobre", "novembre", "dicembre");

include 'archive.html.php';