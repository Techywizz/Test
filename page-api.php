<?php 
/**
 *  Template Name: API Page
 * 
 * **/

get_header();
?>
<div class="back-to-city"><button onClick="history.go(0);">Back to City List</button></div>
<div id="div1"><ul></ul></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript">
	$ = jQuery;
	$(document).ready( function() {
		$.ajax({ 
		    type: 'GET', 
		    url: 'https://techsolitaire.com/api/city.list.json', 
		    dataType: 'json',
		    success: function (data) { 
				//console.log(data[0].country);
				//console.log(data.length);
				for(i=0; i < data.length; i++){
					if(data[i].country == 'GB'){
						$('#div1 ul').append('<li class="get-city" id="'+ data[i].name +'">'+ data[i].name + '</li>');
					}
					
				}
			}
		});
	});

		$('body').on('click','.get-city',function(){
			var get_city = $(this).attr('id');
			$.ajax({ 
            type: 'POST',
		    url: "<?php echo get_home_url(); ?>/wp-admin/admin-ajax.php",
		    data: 
		    	{
                	action: 'getWeatherData',
                	get_city: get_city,
                },
		    success: function (data) { 
		    	$('html, body').animate({
		            scrollTop: $(".back-to-city").offset().top
		        }, 2000); 
				$('#div1').html(data);
			}
		});
		});

</script>
<style type="text/css">
	table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<?php get_footer();?>