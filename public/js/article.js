$(document).ready(function(){
	
	$('.like-click').on('click', function(e){
		e.preventDefault();
		
		let count = $('.like-count').text();
		let $link = $(e.currentTarget);
		
		$(this).toggleClass('fa-heart-o').toggleClass('fa-heart');
		
		$.ajax({
			url: $(this).attr('href'),
			method: 'post',
			success: function(result){
				$('.like-count').empty().html(result.heart + parseInt(count));
			},
			error: function(error){
				alert(error);
			}
		});
		
	});

});