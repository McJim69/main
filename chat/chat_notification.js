var notifiedMaxMsgId = localStorage.getItem('notifiedMaxMsgId') ? parseInt(localStorage.getItem('notifiedMaxMsgId')) : 0;

function getAvatarUrl(imgUrl) {
	if (!imgUrl || imgUrl === 'blank.jpg' || imgUrl === '' || imgUrl === 'mcjim.jpg') {
		return 'images/unknown.webp';
	}
	return 'images/users/' + imgUrl;
}

function checkChatNotifications() {
	if (window.location.pathname.indexOf('/chat/') !== -1) {
		return;
	}
	$.ajax({
		url: 'chat/chat_actions.php?action=get_unread_notifications',
		type: 'GET',
		dataType: 'json',
		success: function(res) {
			if (res.status === 'success') {
				// 1. Update the chat badge in the navigation menu
				var unreadCount = parseInt(res.unread_count);
				var badge = $('#chatMenuBadge');
				if (unreadCount > 0) {
					if (badge.length === 0) {
						$('#chat a.nav-link').append('<span id="chatMenuBadge" class="chat-badge">' + unreadCount + '</span>');
					} else {
						badge.text(unreadCount).show();
					}
				} else {
					badge.remove();
				}
				
				// 2. Display toast if there is a new unread message
				var maxUnreadId = parseInt(res.max_unread_id);
				if (unreadCount > 0 && maxUnreadId > notifiedMaxMsgId && res.latest_unread) {
					notifiedMaxMsgId = maxUnreadId;
					localStorage.setItem('notifiedMaxMsgId', notifiedMaxMsgId);
					showChatNotificationToast(res.latest_unread);
				} else if (unreadCount === 0) {
					notifiedMaxMsgId = 0;
					localStorage.setItem('notifiedMaxMsgId', 0);
				}
			}
		}
	});
}

function showChatNotificationToast(msg) {
	var toast = $('#portalChatToast');
	var avatarSrc = getAvatarUrl(msg.sender_avatar);
	var previewMessage = msg.message;
	if (msg.message.indexOf('[FILE:') === 0) {
		previewMessage = '📷 Sent an attachment';
	} else if (msg.message.indexOf('[CALL:') === 0) {
		previewMessage = '📞 Call invitation';
	}
	
	if (toast.length === 0) {
		$('body').append(`
			<div id="portalChatToast" class="portal-chat-toast" onclick="window.location.href='chat/'">
				<div class="toast-avatar-wrapper">
					<img id="toastAvatar" class="toast-avatar" src="${avatarSrc}">
				</div>
				<div class="toast-body">
					<div class="toast-header">
						<strong id="toastSender">${msg.sender_name}</strong>
						<span class="toast-room" id="toastRoom">${msg.room_name}</span>
						<button class="toast-close-btn" onclick="dismissToast(event)">&times;</button>
					</div>
					<div class="toast-message" id="toastMessage">${previewMessage}</div>
				</div>
			</div>
		`);
		toast = $('#portalChatToast');
	} else {
		$('#toastAvatar').attr('src', avatarSrc);
		$('#toastSender').text(msg.sender_name);
		$('#toastRoom').text(msg.room_name);
		$('#toastMessage').text(previewMessage);
		toast.show();
	}
	
	// Auto hide after 6 seconds
	setTimeout(function() {
		toast.fadeOut(300);
	}, 6000);
}

function dismissToast(e) {
	e.stopPropagation();
	$('#portalChatToast').fadeOut(300);
}

jQuery(document).ready(function($) {
	checkChatNotifications();
	setInterval(checkChatNotifications, 3500);
});