/* when document ready register all basic listener for base functionality.
	Load base Content into the content field.
*/

$(document).ready(function(){
    $("#new_blog").click(function() {
		
		event.preventDefault();
		$.ajax({
			type:"PUT",
			data:{'subject':$('#subject').val(),
			'message':$('#message').val()
			},
			url:'posts',
			statusCode:{
				403:$(location).attr('href', 'index.php')
			}
		}).success(function(data) {
			alert(data);
		}); 
	});
});