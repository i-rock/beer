<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>

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
					$.each(data['data'], function(i, item) {
						$('#resultsDisplay').append(data['data'][i]['breweries'][0]['name']+' '+data['data'][i]['name']+'<br/>');
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

<div id='resultsDisplay'>
</div>
