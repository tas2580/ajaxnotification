(function($) {
	'use strict';
	function ajax_request(){
		var new_html = '';
		$.getJSON(ajaxnotification_url,function(returndata){
			var counts=0;
			$.each(returndata, function(i, item){
				if(item['UNREAD']){
					new_html += '<li class=" bg2"><a class="notification-block" href="'+item['U_MARK_READ']+'"  data-real-url="'+item['URL']+'">'+item['AVATAR']+'<div class="notification_text"><p class="notification-title">'+item['FORMATTED_TITLE']+'</p><p class="notification-time">'+item['TIME']+'</p></div></a><a href="'+item['U_MARK_READ']+'" class="mark_read icon-mark" data-ajax="notification.mark_read" title="'+item['L_MARK_READ']+'"></a></li>';
					counts++;
				}else{
					new_html += '<li class=""><a class="notification-block" href="'+item['URL']+'">'+item['AVATAR']+'<div class="notification_text"><p class="notification-title">'+item['FORMATTED_TITLE']+'</p><p class="notification-reference">'+item['REFERENCE']+'</p><p class="notification-time">'+item['TIME']+'</p></div></a></li>';
				}
				$('#notification_list').find('ul').html(new_html);
			});
			set_counter(counts);
		});
		setTimeout(ajax_request, ajaxnotification_timer);
	}

	function set_counter(counts){
		var counter = $('#notification_list_button').find('strong');
		counter.html(counts);
		if(counts > 0){
			$(document).prop('title', '('+counts+') '+page_title);
		}
	}

	$( document ).ready(function() {
		ajax_request();
	});

})(jQuery);
