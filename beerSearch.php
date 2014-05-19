<?php 
require_once("plugins/Brewerydb.php");
if(isset($_GET['query']) && isset($_GET['page'])) {

	$bdb = new Pintlabs_Service_Brewerydb('0128d8396729aa2d96a304583194c471');
	$bdb->setFormat('json');

	try {
		$params = array('p'=>$_GET['page'], 'q'=>$_GET['query'], 'type'=>'beer', 'withBreweries'=>'Y');
		$results = $bdb->request('search', $params, 'GET');
	} catch (Exception $e) {
		$results = array('error' => $e->getMessage());
	}

	echo json_encode($results); // return result
}

?>