<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(function() {
	$('#searchForm').submit(function(event) {
		var input = $('#searchInput').val();
		alert(input.length);
		$('#searchInput').val('');
		return false;
	});
})
</script>

<h1>hello world</h1>

<form id='searchForm'>
	<input type='text' name='searchInput' id='searchInput' />
	<input type='submit' value='Submit' />
</form>

