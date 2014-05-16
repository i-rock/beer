<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
var json = null;

function showBeer(i) {
	if (json === null) {
		console.log('json is null');
		return false;
	}
	var name = ""+json['data'][i]['breweries'][0]['name']+' '+json['data'][i]['name'], image='';

	if(json['data'][i]['breweries'][0]['images'] !== undefined) {
		image = "<img src='"+json['data'][i]['breweries'][0]['images']['large']+"' />";
		$('#beerPic').html(image);
	} else {
		$('#beerPic').html('')
	}

	return false;
}

$(function() {
	$('#searchInput').focus();
	$('#searchForm').submit(function (event) {
		var input = $('#searchInput').val();
		event.preventDefault();
		if(input.length > 0) {
			$.ajax({
				type: "GET",
				dataType: "json",
				url: "beerSearch.php",
				data: { query: input },
				success: function (data) {
					json = data;
					$.each(data['data'], function(i, item) {
						$('#resultsDisplay').append("<a href='javascript:void(0)' onclick='showBeer("+i+")'>"+data['data'][i]['breweries'][0]['name']+' '+data['data'][i]['name']+'</a><br/>');
					});				
				}
			});
		}
		$('#searchInput').val('');
	});
})
</script>

<h1>hello world</h1>

<form id='searchForm'>
	<input type='text' id='searchInput' />
	<input type='submit' value='Submit' />
</form>

<div id='beerPic'></div>

<div id='resultsDisplay'>
</div>
