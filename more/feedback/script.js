;(function($) {
	$(document).ready(function() {

		$('a.feedback').eq(0).on('click', function( event ) {

			event.preventDefault();

			$.arcticmodal({
			    type: 'ajax',
			    url: 'more/feedback/disqus.html',
			    ajax: {
			        type: 'POST',
			        cache: false,
			        dataType: 'html',
			        success: function(data, el, responce) {
			            var h = $('<div class="box-modal">' +
			                    '<div class="box-modal_close arcticmodal-close">X</div>' +
			                    '<p><b /></p><p />' +
			                    '</div>');
			            $('p', h).html(responce);
			            data.body.html(h);
			        }
			    }
			});

		})

	});
})(jQuery);
