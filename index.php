<style>
	#beerInfo {
		display: none;
	}

	#resultsDisplay {
		display: none;
	}
</style>
<h1>hello world</h1>

<form id='searchForm'>
	<input type='text' id='searchInput' />
	<input type='submit' value='Submit' />
</form>

<div id='content'>
	<div id='beerInfo'></div>

	<div id='resultsDisplay'></div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script>

$(function() {
	var json = null;
	var currPage = 0;
	var noPages = 0;
	var query = "";
	function getBeer(input, page) {
		if(input.length > 0) {
			query = input;

			if ($('#beerInfo').is(':visible')) {
				$('#beerInfo').hide();
			}

			$.ajax({
				type: "GET",
				dataType: "json",
				url: "beerSearch.php",
				data: { query: input, page: page },
				success: function (data) {
					if (!data) { // check that data was returned
						//console.log('no data returned');
						return false;
					}
					var beerObj = {};
					json = data; // move it to scope of onready
					//console.log(JSON.stringify(json));
					$('#resultsDisplay').html('');
					$('#beerPic').html('');

					var j=0;
					//Add beers to appropriate breweries
					for(var i=0; i<data.data.length; i++) {
						if(beerObj[data.data[i].breweries[0].name] === undefined) {
							beerObj[data.data[i].breweries[0].name] = {};
						} 
						beerObj[data.data[i].breweries[0].name][data.data[i].id] = {};
						beerObj[data.data[i].breweries[0].name][data.data[i].id]['name'] = data.data[i].name;
						beerObj[data.data[i].breweries[0].name][data.data[i].id]['i'] = i;
					}

					//console.log(JSON.stringify(data, undefined, 2));

					for(var brewery in beerObj) {
						var htmlstr="";
						htmlstr+="<h3>"+brewery+"</h3><ul id='beerList'>";
						for(var beer in beerObj[brewery]) {
							//in show beer pass the proper beerobj
							//htmlstr+='<li><a href="javascript:void(0)" onclick="showBeer(\''+beer+'\')">'+beerObj[brewery][beer]+"</a></li>";
							htmlstr+='<li><a href="javascript:void(0)" id="'+beerObj[brewery][beer].i+'">'+beerObj[brewery][beer].name+"</a></li>";
						}
						htmlstr+="</ul>";
						$('#resultsDisplay').append(htmlstr);
					}

					currPage = data.currentPage;
					noPages = data.numberOfPages;

					if(currPage != noPages) {	
						$('#resultsDisplay').append("Page "+currPage+"/"+noPages+"&nbsp;&nbsp;<a href='javascript:void(0)' id='moreClick'>more..</a>");
						currPage++;
					}
					$('#resultsDisplay').show();
				}
			});
		}
		$('#searchInput').val('');		
	}

	$(document).on('click', '#beerList li', function (e) {
		var index = e.target.id;
		var html = "<div>";
		var score = -1;

		$.ajax({
			type: "GET",
			url: "getBeer.php",
			data: { id: json.data[index].id },
			async: false,
			success: function (data) {
				if(data >= 0) {
					score = data; 
				} else {
					score = 0;
				}
			}
		});

		$('#resultsDisplay').hide();

		if(json.data[index] === null) {
			e.preventDefault();
			return false;
		}

		html += "<a href='javascript:void(0)' id='backResults'>Back</a>";

		if (json.data[index].breweries[0].images !== undefined) {
			html+="<br/><img src='"+json.data[index].breweries[0].images.large+"' />";
		} 

		if (json.data[index].name !== undefined) {
			html+="<br/><h2>"+json.data[index].breweries[0].name+" "+json.data[index].name+"</h2>";
		}

		if (json.data[index].description !== undefined) {
			html+="<p>"+json.data[index].description+"</p>";
		} else {
			html+="<p><i>No description available</i></p>";
		}

		html += "<h3>Beer Score</h3><p><h4>"+score+"</h4></p>";

		html += "</div>";
		$('#beerInfo').html(html).show();
		e.preventDefault();
	});

	$(document).on('click', '#backResults', function (e) {
		$('#beerInfo').html('');
		$('#resultsDisplay').show();
	});

	$(document).on('click', '#moreClick', function (e) {
		getBeer(query, currPage);
		e.preventDefault();
	});

	$('#searchForm').submit(function (e) {
		e.preventDefault();
		getBeer($('#searchInput').val(), 1);
	});

	$('#searchInput').focus();

})


</script>



