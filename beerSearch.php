<?php 
require_once("plugins/Brewerydb.php");
if(isset($_GET)) {

	$bdb = new Pintlabs_Service_Brewerydb('0128d8396729aa2d96a304583194c471');
	$bdb->setFormat('json');

	try {
		$params = array('p'=>'1', 'q'=>$_GET['query'], 'type'=>'beer', 'withBreweries'=>'Y');
		$results = $bdb->request('search', $params, 'GET');
	} catch (Exception $e) {
		$results = array('error' => $e->getMessage());
	}

	/*try {
		$params = array('abv' => '10.5', 'p' => '1');
		$results = $bdb->request('beers', $params, 'GET');
	} catch (Exception $e) {
		$results = array('error' => $e->getMessage());
	}*/

	echo json_encode($results);

/*	print_r($results['data'][0]);

	print_r('number of pages: '.$results['numberOfPages']);
	echo '<br/><br/>';

	foreach ($results['data'] as $res) {
		print_r($res['breweries'][0]['name'].' '.$res['name']);
		echo '<br/>';
	}*/
}

?>