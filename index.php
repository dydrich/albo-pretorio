<?php

require_once "../rclasse/lib/start.php";
require_once "../rclasse/lib/MimeType.php";

$_SESSION['__path_to_root__'] = "../rclasse/";

if(!isset($_SESSION['__config__'])){
	include_once "../rclasse/lib/load_env.php";
}

define("PUB_SORT", 1);
define("INS_SORT", 2);
define("CAT_SORT", 3);
define("YEAR_SORT", 4);
define("ABS_SORT", 5);
if(isset($_REQUEST['order']))
	$order = $_REQUEST['order'];
else
	$order = INS_SORT;

$label = "Albo pretorio Online";
$year = date("Y");

$sel_docs = "SELECT rb_documents.*, rb_categorie_docs.nome, CONCAT_WS(' ', rb_utenti.nome, rb_utenti.cognome) AS owner FROM rb_documents, rb_categorie_docs, rb_utenti WHERE owner = uid AND rb_documents.categoria = rb_categorie_docs.id_categoria AND doc_type = 7  ";
if(isset($_REQUEST['field'])){
	$sel_docs .= "AND ".$_REQUEST['field']." = ";
	if($_REQUEST['param_type'] == "char")
		$_REQUEST['param'] = "'".$_REQUEST['param']."'";
	$sel_docs .= $_REQUEST['param']." ";
}
else if(!isset($_REQUEST['months']) && !isset($_REQUEST['month'])){
	$sel_docs .= " AND scadenza >= NOW() ";
}
if(isset($_REQUEST['month'])){
	$mnth = intval($_REQUEST['month']);
	$end = $mnth + 1;
	if ($end < 10) $end = "0".$end;
	$sel_docs .= "AND (data_upload >= '{$year}-{$_REQUEST['month']}-01' AND data_upload < '{$year}-{$end}-01') ";
}

switch($order){
	case INS_SORT:
		$sel_docs .= "ORDER BY rb_documents.data_upload DESC";
		break;
	case CAT_SORT:
		$sel_docs .= "ORDER BY rb_documents.categoria";
		break;
	case YEAR_SORT:
		$sel_docs .= "ORDER BY rb_documents.anno_scolastico DESC, rb_documents.data_upload DESC";
		break;
	case ABS_SORT:
		$sel_docs .= "ORDER BY rb_documents.abstract, rb_documents.data_upload DESC";
		break;
	case PUB_SORT:
	default:
		$sel_docs .= "ORDER BY rb_documents.data_upload DESC";
		break;
}
//print $sel_docs;
$res_docs = $db->execute($sel_docs);
if(isset($_REQUEST['months'])){
	$label .= "::riepilogo mensile";
	$data = array();
	
	while($doc = $res_docs->fetch_assoc()){
		list($y, $m, $d) = explode("-", substr($doc['data_upload'], 0, 11));
		if(!isset($data[$y])){
			$data[$y] = array();
		}
		if(!isset($data[$y][$m])){
			$data[$y][$m] = array();
		}
		$data[$y][$m][] = array('id' => $doc['id'], 'title' => $doc['titolo'], 'abs' => $doc['abstract'], 'link' => "get_file.php?dt=7&id=".$doc['id']."&f=".$doc['link']);
		/*
		if(!isset($data[$m])){
			$data[$m] = array();
		}
		$data[$m][] = $doc;
		*/
	}
}

/*
 * documenti anni precedenti
 */
$sel_archive = "SELECT SUBSTRING(data_upload, 1, 4) AS year FROM rb_documents WHERE doc_type = 7 GROUP BY year ORDER BY year DESC";
$res_archive = $db->execute($sel_archive);
$archive = array();
while ($row = $res_archive->fetch_assoc()){
	echo $row['year'];
	if ($row['year'] != $year){
		$archive[] = $row['year'];
	}
}

$sel_cat = "SELECT id_categoria, codice, nome, descrizione FROM rb_categorie_docs WHERE tipo_documento = 7";
$res_cat = $db->execute($sel_cat);
$categorie = array();
while($cat = $res_cat->fetch_assoc()){
	$categorie[$cat['id_categoria']] = $cat;
}

$mesi = array("", "gennaio", "febbraio", "marzo", "aprile", "maggio", "giugno", "luglio", "agosto", "settembre", "ottobre", "novembre", "dicembre");

setlocale(LC_TIME, "it_IT");

$_SESSION['no_file'] = array("referer" => "albo/index.php", "path" => "", "relative" => "{$_SERVER['REQUEST_URI']}");

include "index.html.php";
