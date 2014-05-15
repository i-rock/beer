<?php 

require("plugins/Brewerydb.php");

$bdb = new Pintlabs_Service_Brewerydb('0128d8396729aa2d96a304583194c471');
$bdb->setFormat('php');

try {
	$params = array('p'=>'1', 'q'=>'yuengling', 'type'=>'beer');
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

print_r('number of pages: '.$results['numberOfPages']);
echo '<br/><br/>';

foreach ($results['data'] as $res) {
	print_r($res['name']);
	echo '<br/>';
}
?>