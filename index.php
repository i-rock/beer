<h1>hello world</h1>

<form id='searchForm'>
	<input type='text' id='searchInput' />
	<input type='submit' value='Submit' />
</form>

<div id='content'>
	<div id='beerPic'></div>

	<div id='resultsDisplay'></div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>
var json = null;

function showBeer(i) {
	if (json === null) {
		console.log('json is null');
		return false;
	}

	var name = ""+json.data[i].breweries[0].name+' '+json.data[i].name, image='';

	if(json.data[i].breweries[0].images !== undefined) {
		image = "<img src='"+json.data[i].breweries[0].images.large+"' />";
		$('#beerPic').html(image);
	} else {
		$('#beerPic').html('');
	}

	return false;
}

$(function() {
	var currPage = 0;
	var noPages = 0;
	var query = "";
	function getBeer(input, page) {
		if(input.length > 0) {
			query = input;
			$.ajax({
				type: "GET",
				dataType: "json",
				url: "beerSearch.php",
				data: { query: input, page: page },
				success: function (data) {
					if (!data) { // check that data was returned
						console.log('no data returned');
						return false;
					}
					var beerObj = {};
					//var breweryArray = [];
					json = data; // move it global

					//clear content children
					//$('#content div').html('');
					$('#resultsDisplay').html('');
					$('#beerPic').html('');

					//Get unique breweries
					/*for(var i=0; i<data.data.length; i++) {
						var breweryName = data.data[i].breweries[0].name;
						if(breweryName.length > 0 && breweryArray.indexOf(breweryName) === -1) {
							breweryArray.push(breweryName);
						}
						
					}*/

					//Add beers to appropriate breweries
					for(var i=0; i<data.data.length; i++) {
						if(beerObj[data.data[i].breweries[0].name] === undefined) {
							beerObj[data.data[i].breweries[0].name] = [data.data[i].name];
						} else {
							beerObj[data.data[i].breweries[0].name].push(data.data[i].name);
						}
					}

					for(var brewery in beerObj) {
						$('#resultsDisplay').append("<h3>"+brewery+"</h3>");
						$('#resultsDisplay').append("<ul>");
						for(var i=0; i<beerObj[brewery].length; i++) {
							$('#resultsDisplay').append("<li style='margin-left: 1em;'>"+beerObj[brewery][i]+"</li>");
						}
						$('#resultsDisplay').append("</ul>");
					}

					currPage = data.currentPage;
					noPages = data.numberOfPages;

					if(currPage != noPages) {	
						$('#resultsDisplay').append("Page "+currPage+"/"+noPages+"&nbsp;&nbsp;<a href='javascript:void(0)' id='moreClick'>more..</a>");
						currPage++;
					}

				}
			});
		}
		$('#searchInput').val('');		
	}

	$(document).on('click', '#moreClick', function (e) {
		getBeer(query, currPage);
		e.preventDefault();
	});

	$('#searchForm').submit(function (event) {
		event.preventDefault();
		var input = $('#searchInput').val();
		getBeer(input, 1);
	});

	$('#searchInput').focus();

})


</script>



