var notifiedMaxMsgId = localStorage.getItem('notifiedMaxMsgId') ? parseInt(localStorage.getItem('notifiedMaxMsgId')) : 0;
var ringInterval = null;
var ringAudioCtx = null;

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
	
	// Play notification sound or ringing
	if (msg.message.indexOf('[CALL:') === 0) {
		playNotificationRingSound();
	} else {
		var audio = new Audio('chat/sounds/notification.mp3');
		audio.play().catch(function(e) {
			console.log("Audio play failed: ", e);
		});
	}

	// Trigger aggressive desktop notification if browser is out of focus/minimized
	if ("Notification" in window && Notification.permission === "granted") {
		// We only want to notify if the document is hidden/unfocused, but for aggressive we can do it anyway
		// or at least if document is not visible.
		if (document.hidden || !document.hasFocus()) {
			var notification = new Notification("New message from " + msg.sender_name, {
				body: previewMessage,
				icon: avatarSrc,
				tag: 'chat-notify-' + msg.room_id // Prevent spamming by grouping by room
			});
			notification.onclick = function() {
				window.focus();
				window.location.href = 'chat/';
				this.close();
			};
		}
	}
	
	// Auto hide
	var hideDelay = msg.message.indexOf('[CALL:') === 0 ? 15000 : 6000;
	setTimeout(function() {
		toast.fadeOut(300);
		if (msg.message.indexOf('[CALL:') === 0) {
			stopNotificationRingSound();
		}
	}, hideDelay);
}

function dismissToast(e) {
	e.stopPropagation();
	$('#portalChatToast').fadeOut(300);
	stopNotificationRingSound();
}

function playNotificationRingSound() {
	stopNotificationRingSound();
	try {
		var AudioCtx = window.AudioContext || window.webkitAudioContext;
		if (!AudioCtx) return;
		ringAudioCtx = new AudioCtx();
		
		var playRing = function() {
			if (!ringAudioCtx) return;
			if (ringAudioCtx.state === 'suspended') ringAudioCtx.resume();
			
			var osc1 = ringAudioCtx.createOscillator();
			var osc2 = ringAudioCtx.createOscillator();
			var lfo = ringAudioCtx.createOscillator();
			var lfoGain = ringAudioCtx.createGain();
			var mainGain = ringAudioCtx.createGain();
			
			osc1.type = 'sine';
			osc1.frequency.value = 440;
			osc2.type = 'sine';
			osc2.frequency.value = 453;
			
			lfo.type = 'sine';
			lfo.frequency.value = 18;
			lfoGain.gain.value = 15;
			
			mainGain.gain.setValueAtTime(0, ringAudioCtx.currentTime);
			mainGain.gain.linearRampToValueAtTime(0.2, ringAudioCtx.currentTime + 0.1);
			mainGain.gain.setValueAtTime(0.2, ringAudioCtx.currentTime + 1.4);
			mainGain.gain.exponentialRampToValueAtTime(0.001, ringAudioCtx.currentTime + 1.5);
			
			lfo.connect(lfoGain);
			lfoGain.connect(osc1.frequency);
			lfoGain.connect(osc2.frequency);
			
			osc1.connect(mainGain);
			osc2.connect(mainGain);
			mainGain.connect(ringAudioCtx.destination);
			
			osc1.start();
			osc2.start();
			lfo.start();
			
			osc1.stop(ringAudioCtx.currentTime + 1.5);
			osc2.stop(ringAudioCtx.currentTime + 1.5);
			lfo.stop(ringAudioCtx.currentTime + 1.5);
		};
		
		playRing();
		ringInterval = setInterval(playRing, 3000);
	} catch(e) {
		console.error(e);
	}
}

function stopNotificationRingSound() {
	if (ringInterval) clearInterval(ringInterval);
	if (ringAudioCtx) {
		try { ringAudioCtx.close(); } catch(e){}
		ringAudioCtx = null;
	}
}

jQuery(document).ready(function($) {
	// Request desktop notification permission on load if not already granted
	if ("Notification" in window) {
		if (Notification.permission !== "granted" && Notification.permission !== "denied") {
			Notification.requestPermission();
		}
	}

	checkChatNotifications();
	setInterval(checkChatNotifications, 3500);
});