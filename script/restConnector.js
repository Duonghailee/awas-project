/* when document ready register all basic listener for base functionality.
	Load base Content into the content field.
*/

$(document).ready(function(){
    $("#new_blog").click(function() {
		event.preventDefault();
		$.ajax({
			type:"PUT",
			data:{
				'subject':$('#subject').val(),
				'author':$('#author').text(),
				'topic':'1',
				'message':$('#message').val()
			},
			url:'posts',
			statusCode:{
				// if a 403 occurs redirect to mainpage.
				//403:$(location).attr('href', 'index.php?p=home&dbrestore=no')
			}
		}).success(function(data) {
			$('#info').text(data);
		}); 
	});
});