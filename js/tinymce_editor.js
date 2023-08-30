function startEditor(id) {
}

$( document ).ready(function() {
	startEditor('editor');
	$(document).on('submit','#posts', function(event){
		var formData = $(this).serialize();
		$.ajax({
                url: "action.php",
                method: "POST",
                data: formData,
			        	dataType:"json",
                success: function(data) {
					var html = $("#postHtml").html();
					html = html.replace(/USERNAME/g, data.name);
					html = html.replace(/POSTDATE/g, data.post_date);
					html = html.replace(/POSTMESSAGE/g, data.message);
					html = html.replace(/POSTID/g, data.post_id);
					$(".posts").append(html).fadeIn('slow');
					tinymce.get('editor').setContent('');
					window.location.reload()
					grecaptcha.reset();
                }
        });
		return false;
	});
});
