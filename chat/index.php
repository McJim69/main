<?php 
	require_once(__DIR__ . "/../connect.php"); 
	require_once(__DIR__ . "/version.php"); 

	// Auth guard — redirect unauthenticated users to login
	if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
		header('Location: ../login.php');
		exit;
	}

	// Assign session variables for use in this page
	$currentUser    = $_SESSION['user'];
	$currentUserImg = $_SESSION['imgUrl'] ?? 'blank.jpg';
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Chat | McJim Cyberworks</title>
	<!-- Stylesheets -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link href="../vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
	<link href="chat.css?v=<?= SITE_VERSION ?>" rel="stylesheet">	
</head>
<body>
	<!-- Main Workspace -->
	<div class="workspace-container">
		<!-- Sidebar -->
		<div class="chat-sidebar">
			<div class="sidebar-header">
				<div class="sidebar-title-row">
					<div class="d-flex align-items-center gap-3 dropdown">
						<a href="#" class="dropdown-toggle d-block position-relative" data-toggle="dropdown" id="userMenuDropdown" style="text-decoration:none;">
							<img src="<?php echo ($currentUserImg && $currentUserImg !== 'blank.jpg' && $currentUserImg !== 'mcjim.jpg') ? '../images/users/'.$currentUserImg : '../images/user.webp'; ?>" class="rounded-circle" style="width:36px; height:36px; object-fit:cover; border:2px solid var(--accent);">
							<div class="online-indicator" style="bottom:-1px; right:-1px; width:10px; height:10px; border-width:1.5px; box-shadow:none;"></div>
						</a>
						<div class="dropdown-menu dropdown-menu-dark p-2 animate-fade-in" aria-labelledby="userMenuDropdown" style="background: rgba(15, 23, 42, 0.95); border: 1px solid var(--border-color); border-radius: 12px; box-shadow: var(--glass-shadow); backdrop-filter: blur(8px);">
							<div class="px-3 py-2">
								<span class="d-block font-weight-bold text-white" style="font-size:13px;"><?php echo htmlspecialchars($currentUser); ?></span>
								<span class="small text-muted" style="font-size:10.5px;">Active Session</span>
							</div>
							<div class="dropdown-divider" style="border-color: var(--border-color);"></div>
							<a class="dropdown-item d-flex align-items-center gap-2 rounded text-light" style="font-size:12.5px; padding: 8px 12px;" href="../home.php">
								<i class="fas fa-home text-muted"></i> Return to Portal
							</a>
							<a class="dropdown-item d-flex align-items-center gap-2 rounded text-danger" style="font-size:12.5px; padding: 8px 12px;" href="../logout.php">
								<i class="fas fa-sign-out-alt"></i> Logout
							</a>
						</div>
						<h3 class="sidebar-title" style="font-size: 21px; font-weight:800; margin:0;">Chats</h3>
					</div>
					<button class="action-btn" title="Create Group Chat" onclick="openNewGroupModal()">
						<i class="fa fa-users"></i>
					</button>
				</div>
				<div class="search-container">
					<i class="fa fa-search search-icon"></i>
					<input type="text" class="search-input" id="searchBar" placeholder="Search people and groups..." oninput="handleSearch()">
				</div>
			</div>
			
			<div class="conversation-list" id="convListFeed">
				<!-- Loaded via AJAX -->
				<div class="text-center py-4 text-secondary"><i class="fas fa-spinner fa-spin mr-2"></i> Loading conversations...</div>
			</div>
		</div>

		<!-- Chat Panel -->
		<div class="chat-main-pane" id="emptyPane" style="display: flex; align-items: center; justify-content: center;">
			<div class="text-center text-secondary">
				<i class="fa fa-comments" style="font-size: 56px; margin-bottom: 15px; opacity: 0.35;"></i>
				<h6>Select a conversation to start messaging</h6>
			</div>
		</div>

		<div class="chat-main-pane" id="chatActivePane" style="display: none;">
			<!-- Header -->
			<div class="chat-pane-header">
				<div class="header-user-info">
					<button class="btn btn-link text-muted p-0 mr-1" id="mobileBackBtn" style="display: none;">
						<i class="fas fa-arrow-left"></i>
					</button>
					<div class="avatar-wrapper">
						<img id="activeRoomAvatar" src="../images/user.webp" class="user-avatar" alt="User">
					</div>
					<div>
						<h5 class="header-name" id="activeRoomName">Name</h5>
						<p class="header-status" id="activeRoomStatus">Active Session</p>
					</div>
				</div>
				<div class="header-actions">
					<button class="action-btn text-danger" id="deleteGroupBtn" title="Delete Group" style="display: none;" onclick="deleteGroupChat()"><i class="fas fa-trash-alt"></i></button>
					<button class="action-btn" id="callAudioBtn" title="Audio Call"><i class="fas fa-phone"></i></button>
					<button class="action-btn" id="callVideoBtn" title="Video Call"><i class="fas fa-video"></i></button>
				</div>
			</div>
			
			<!-- Messages Feed -->
			<div class="feed-container" id="chatMessageFeed">
				<!-- Loaded via AJAX -->
			</div>
			
			<!-- Reply Preview Header -->
			<div id="replyPreviewBar" style="display: none; background: var(--bg-sidebar); border-top: 1px solid var(--border-color); padding: 8px 20px; align-items: center; justify-content: space-between; font-size: 12.5px;">
				<div class="text-muted d-flex align-items-center gap-2">
					<i class="fas fa-reply"></i>
					<span>Replying to <b id="replyToUser">User</b>: <span id="replyToText" class="font-italic">"Message text"</span></span>
				</div>
				<button class="btn btn-link btn-xs text-danger p-0 border-0" onclick="cancelReply()"><i class="fas fa-times"></i></button>
			</div>

			<!-- Input Footer -->
			<div class="chat-pane-footer">
				<button class="input-action-btn" title="Attach file" onclick="triggerFileUpload()">
					<i class="fas fa-paperclip"></i>
				</button>
				<input type="file" id="attachmentInput" style="display: none;" onchange="handleFileSelected()">
				
				<div class="footer-input-wrapper" style="position: relative;">
					<textarea class="footer-input" id="messageInput" placeholder="Write a message..." rows="1" maxlength="5000" onkeydown="handleInputKeyDown(event)"></textarea>
					
					<!-- Emoji Trigger Button -->
					<button class="emoji-trigger-btn" id="emojiPickerBtn" title="Insert Emoji" type="button" onclick="toggleEmojiPicker(event)">
						<i class="far fa-smile"></i>
					</button>

					<!-- Emoji Picker Popover -->
					<div class="emoji-picker-popover" id="emojiPickerPopover" style="display: none;">
						<div class="emoji-picker-header">Recent & Popular Emojis</div>
						<div class="emoji-picker-grid" id="emojiPickerGrid"></div>
					</div>
				</div>
				
				<button class="send-btn" id="sendMessageBtn" onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
			</div>
		</div>
	</div>

	<!-- Custom Standalone Lightbox Overlay HTML -->
	<div id="customMediaLightbox" class="custom-lightbox" onclick="hideLightboxModal()">
		<button type="button" class="custom-lightbox-close" onclick="hideLightboxModal()" title="Close Lightbox">
			<i class="fas fa-arrow-left"></i>
		</button>
		<img id="lightbox-image" class="custom-lightbox-content" src="" style="display: none;" alt="Preview" onclick="event.stopPropagation()">
		<video id="lightbox-video" class="custom-lightbox-content" controls preload="metadata" style="display: none; background: #000; outline: none;" onclick="event.stopPropagation()"></video>
	</div>

	<!-- Jitsi Call Overlay Modal -->
	<div id="jitsiCallOverlay">
		<div style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 12px 20px; background: #111; color: #fff; box-sizing: border-box; border-bottom: 1px solid #222;">
			<div style="display: flex; align-items: center;">
				<i class="fas fa-phone-volume" style="margin-right: 8px; color: #28a745; font-size: 18px;"></i>
				<span class="font-weight-bold" id="jitsiCallTitle" style="font-size: 14px; font-weight: bold; color: #fff;">Call Room</span>
			</div>
			<div style="display: flex; align-items: center;">
				<button id="minimizeJitsiBtn" onclick="toggleMinimizeJitsiCall()" style="background: #333; color: #fff; border: none; padding: 6px 12px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 13px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
					<i class="fas fa-compress-alt" style="margin-right: 6px;"></i> Minimize
				</button>
				<button onclick="hangupJitsiCall()" style="background: #dc3545; color: #fff; border: none; padding: 6px 15px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 13px; display: flex; align-items: center; justify-content: center;">
					<i class="fas fa-phone-slash" style="margin-right: 6px;"></i> End Call
				</button>
			</div>
		</div>
		<div id="jitsiIframeContainer" style="width: 100%; flex-grow: 1; background: #000; position: relative; height: calc(100vh - 55px); box-sizing: border-box;">
			<div id="jitsiLoading" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; color: #fff; background: #141414; z-index: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; box-sizing: border-box;">
				<i class="fas fa-circle-notch fa-spin" style="font-size: 40px; margin-bottom: 15px; color: #007bff;"></i>
				<h6 style="font-weight: bold; margin: 0 0 5px 0; font-size: 14px; color: #fff;">Connecting to WebRTC media servers...</h6>
				<small style="color: #6c757d; font-size: 11px;">Please allow camera and microphone access when prompted</small>
			</div>
		</div>
	</div>

	<!-- Incoming Call Custom Mockup Overlay -->
	<div id="incomingCallOverlay">
		<div style="background: #2a2a2a; color: #fff; width: 340px; border-radius: 24px; padding: 25px; box-shadow: 0 15px 40px rgba(0,0,0,0.5); text-align: center; position: relative; box-sizing: border-box; display: flex; flex-direction: column; align-items: center;">
			<button onclick="declineCall()" style="position: absolute; top: 15px; right: 15px; width: 32px; height: 32px; border-radius: 50%; background: #444; border: none; color: #ccc; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 14px; transition: background 0.2s;" onmouseover="this.style.background='#555'" onmouseout="this.style.background='#444'">
				<i class="fas fa-times"></i>
			</button>
			<h5 style="margin: 0 0 20px 0; font-size: 17px; font-weight: 600; color: #eee; letter-spacing: 0.5px;">Incoming Call...</h5>
			<img id="incomingCallAvatar" src="../images/user.webp" style="width: 100px; height: 100px; border-radius: 50%; border: 3px solid #fff; object-fit: cover; margin-bottom: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.3);" alt="Avatar">
			<h6 id="incomingCallName" style="margin: 0 0 5px 0; font-size: 21px; font-weight: bold; color: #fff; line-height: 1.25;">Caller Name</h6>
			<p id="incomingCallTypeLabel" style="margin: 5px 0 25px 0; font-size: 13.5px; color: #aaa; line-height: 1.4;">Invitation to connect...</p>
			
			<div style="display: flex; justify-content: center; gap: 30px; width: 100%;">
				<div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
					<button onclick="acceptCall()" style="width: 56px; height: 56px; border-radius: 50%; background: #2baf4a; border: none; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 20px; box-shadow: 0 4px 15px rgba(43,175,74,0.4); transition: transform 0.15s, background 0.2s;" onmouseover="this.style.transform='scale(1.08)'; this.style.background='#22963d';" onmouseout="this.style.transform='scale(1)'; this.style.background='#2baf4a';">
						<i class="fas fa-phone-alt"></i>
					</button>
					<span style="font-size: 12.5px; color: #ccc; font-weight: 500;">Accept</span>
				</div>
				<div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
					<button onclick="declineCall()" style="width: 56px; height: 56px; border-radius: 50%; background: #e52b2b; border: none; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 20px; box-shadow: 0 4px 15px rgba(229,43,43,0.4); transition: transform 0.15s, background 0.2s;" onmouseover="this.style.transform='scale(1.08)'; this.style.background='#d02222';" onmouseout="this.style.transform='scale(1)'; this.style.background='#e52b2b';">
						<i class="fas fa-phone-slash"></i>
					</button>
					<span style="font-size: 12.5px; color: #ccc; font-weight: 500;">Decline</span>
				</div>
			</div>
		</div>
	</div>

	<!-- Outbound Calling Overlay Banner -->
	<div id="outboundCallOverlay">
		<div style="background: transparent; color: #fff; width: 340px; text-align: center; position: relative; box-sizing: border-box; display: flex; flex-direction: column; align-items: center;">
			<img id="outboundCallAvatar" src="../images/user.webp" style="width: 100px; height: 100px; border-radius: 50%; border: none; object-fit: cover; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.5);" alt="Avatar">
			<h6 id="outboundCallReceiver" style="margin: 0 0 10px 0; font-size: 24px; font-weight: bold; color: #fff; line-height: 1.25;">Receiver Name</h6>
			<p id="outboundCallStatus" style="margin: 0 0 40px 0; font-size: 15px; color: #bbb; font-weight: 500;">Calling...</p>
			
			<div id="outboundCallingActions" style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
				<button onclick="hangupJitsiCall()" style="width: 56px; height: 56px; border-radius: 50%; background: #e52b2b; border: none; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 20px; box-shadow: 0 4px 15px rgba(229,43,43,0.4); transition: transform 0.15s, background 0.2s;" onmouseover="this.style.transform='scale(1.08)'; this.style.background='#d02222';" onmouseout="this.style.transform='scale(1)'; this.style.background='#e52b2b';">
					<i class="fas fa-phone-slash"></i>
				</button>
				<span style="font-size: 12.5px; color: #ccc; font-weight: 500;">End Call</span>
			</div>
			
			<div id="outboundNoAnswerActions" style="display: none; gap: 40px; justify-content: center; width: 100%;">
				<div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
					<button id="redialBtn" style="width: 56px; height: 56px; border-radius: 50%; background: #2baf4a; border: none; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 20px; box-shadow: 0 4px 15px rgba(43,175,74,0.4); transition: transform 0.15s, background 0.2s;" onmouseover="this.style.transform='scale(1.08)'; this.style.background='#22963d';" onmouseout="this.style.transform='scale(1)'; this.style.background='#2baf4a';">
						<i class="fas fa-phone-alt"></i>
					</button>
					<span style="font-size: 12.5px; color: #ccc; font-weight: 500;">Redial</span>
				</div>
				<div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
					<button onclick="hangupJitsiCall()" style="width: 56px; height: 56px; border-radius: 50%; background: #444; border: none; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.3); transition: transform 0.15s, background 0.2s;" onmouseover="this.style.transform='scale(1.08)'; this.style.background='#555';" onmouseout="this.style.transform='scale(1)'; this.style.background='#444';">
						<i class="fas fa-times"></i>
					</button>
					<span style="font-size: 12.5px; color: #ccc; font-weight: 500;">Close</span>
				</div>
			</div>
		</div>
	</div>

	<!-- Floating Group Modal -->
	<div class="modal fade" id="newGroupModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content" style="background: var(--bg-sidebar); border: 1px solid var(--border-color); color: #fff; border-radius: 16px;">
				<div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
					<h5 class="modal-title font-weight-bold">Create Group Chat</h5>
					<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label class="font-weight-bold small text-muted">Group Name</label>
						<input type="text" class="form-control text-white" id="newGroupName" style="background: var(--bg-card); border-color: var(--border-color); border-radius: 8px;" placeholder="e.g. LGU Task Force">
					</div>
					<div class="form-group mb-0">
						<label class="font-weight-bold small text-muted">Add Members</label>
						<div id="searchUserResultsModal" class="mb-3" style="max-height: 180px; overflow-y: auto;">
							<!-- Dynamic checkbox user list -->
						</div>
					</div>
				</div>
				<div class="modal-footer" style="border-top: 1px solid var(--border-color);">
					<button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
					<button type="button" class="btn btn-primary font-weight-bold" onclick="createGroupRoom()" style="border-radius: 8px;">Create Group</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Jitsi API JS -->
	<script src="https://meet.mcjim-server.com/external_api.js"></script>
	<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<script>
		var myUsername = <?php echo json_encode($currentUser); ?>;
		var myAvatar = <?php echo json_encode($currentUserImg); ?>;
		
		function getAvatarUrl(imgUrl) {
			if (!imgUrl || imgUrl === 'blank.jpg' || imgUrl === 'blank.png' || imgUrl === 'mcjim.jpg') {
				return '../images/user.webp';
			}
			return '../images/users/' + imgUrl;
		}
		
		var activeChatId = null;
		var isGroupChat = 0;
		var replyToMsgId = null;
		
		// Jitsi variables
		var activeJitsiAPI = null;
		var jitsiIncomingRoom = null;
		var jitsiIncomingType = null;
		var jitsiIncomingTimer = null;
		
		var lastOutboundRoom = null;
		var lastOutboundType = null;
		var lastOutboundTarget = null;
		var lastOutboundAvatar = null;
		
		// Web Audio API Synthesizers
		var ringAudioCtx = null;
		var ringInterval = null;
		var ringTimeout = null;
		
		var outboundAudioCtx = null;
		var outboundInterval = null;
		var outboundTimeout = null;
		
		// Loader / Polling
		function refreshConversations(selectRoomId = null) {
			// Skip fetching active conversations if the user is currently searching/filtering
			var searchQuery = $('#searchBar').val().trim();
			if (searchQuery.length >= 2) {
				return;
			}
			
			$.ajax({
				url: 'chat_actions.php?action=fetch_conversations',
				type: 'GET',
				dataType: 'json',
				success: function(res) {
					if (res.status === 'success') {
						var html = '';
						res.conversations.forEach(function(conv) {
							var activeClass = conv.id === activeChatId ? 'active' : '';
							var avatarPath = getAvatarUrl(conv.imgUrl);
							
							html += `
								<div class="conv-item ${activeClass}" onclick="selectConversation(${conv.id}, '${escapeHtml(conv.name)}', '${avatarPath}', ${conv.is_group})">
									<div class="avatar-wrapper">
										<img src="${avatarPath}" class="user-avatar" alt="Avatar">
										${!conv.is_group && conv.is_online ? '<div class="online-indicator"></div>' : ''}
									</div>
									<div class="conv-details">
										<div class="conv-name-row">
											<h6 class="conv-name">${escapeHtml(conv.name)}</h6>
											<span class="conv-time">${conv.last_message_time}</span>
										</div>
										<p class="conv-preview">${escapeHtml(conv.last_message || 'No messages yet')}</p>
									</div>
								</div>
							`;
						});
						$('#convListFeed').html(html || '<div class="text-center py-4 text-muted">No conversations yet.</div>');
						
						if (selectRoomId) {
							activeChatId = selectRoomId;
							var activeItem = res.conversations.find(c => c.id === selectRoomId);
							if (activeItem) {
								selectConversation(activeItem.id, activeItem.name, getAvatarUrl(activeItem.imgUrl), activeItem.is_group);
							}
						}
					}
				}
			});
		}

		function selectConversation(roomId, name, avatarUrl, isGroup) {
			activeChatId = roomId;
			isGroupChat = isGroup;
			replyToMsgId = null;
			$('#replyPreviewBar').hide();
			
			$('#emptyPane').hide();
			$('#chatActivePane').show();
			$('#activeRoomName').text(name);
			$('#activeRoomAvatar').attr('src', avatarUrl);
			$('#activeRoomStatus').text(isGroup ? 'Group Conversation' : 'Private Message');
			
			if (isGroup) {
				$('#deleteGroupBtn').show();
			} else {
				$('#deleteGroupBtn').hide();
			}
			
			$('.conv-item').removeClass('active');
			$(`[onclick*="selectConversation(${roomId},"]`).addClass('active');
			
			$('.workspace-container').addClass('active-chat-open');
			
			// Setup call click actions
			var callRoomName = "McJimServer_Call_" + roomId + "_" + Math.min(roomId, 100);
			$('#callAudioBtn').off('click').on('click', function() {
				startCall(callRoomName, 'audio', name, avatarUrl);
			});
			$('#callVideoBtn').off('click').on('click', function() {
				startCall(callRoomName, 'video', name, avatarUrl);
			});
			
			lastMessagesJson = "";
			lastMessagesLength = 0;
			fetchMessages();
		}

		var lastMessagesLength = 0;
		var lastMessagesJson = "";
		function fetchMessages() {
			if (!activeChatId) return;
			
			$.ajax({
				url: 'chat_actions.php?action=fetch_messages&room_id=' + activeChatId,
				type: 'GET',
				dataType: 'json',
				success: function(res) {
					if (res.status === 'success') {
						var currentJson = JSON.stringify(res.messages);
						if (currentJson !== lastMessagesJson) {
							lastMessagesJson = currentJson;
							renderMessages(res.messages);
						}
					}
				}
			});
		}

		function renderMessages(messages) {
			var html = '';
			messages.forEach(function(msg) {
				var isSelf = msg.sender === myUsername;
				var chatClass = isSelf ? 'self' : 'other';
				var avatarPath = getAvatarUrl(msg.imgUrl);
				
				var bubbleContent = '';
				if (msg.is_unsent) {
					bubbleContent = `<i>This message was unsent</i>`;
				} else {
					bubbleContent = parseMessageBody(msg.message);
					if (msg.is_edited) {
						bubbleContent += ` <small class="text-muted font-italic" style="font-size:9px;">(edited)</small>`;
					}
				}
				
				// Quote reply block
				var replyHtml = '';
				if (msg.reply_to) {
					var parentMsg = messages.find(m => m.id === msg.reply_to);
					if (parentMsg) {
						var previewText = parentMsg.is_unsent ? "Unsent message" : parentMsg.message;
						if (previewText.startsWith('[FILE:')) previewText = "Attachment";
						if (previewText.startsWith('[CALL:')) previewText = "Call invitation";
						
						replyHtml = `<div class="bubble-reply-quote"><b>${parentMsg.fullname}:</b> "${escapeHtml(previewText)}"</div>`;
					}
				}

				// Hover menu controls
				var hoverControls = '';
				if (!msg.is_unsent) {
					hoverControls = `<div class="d-flex align-items-center gap-1 mt-1 ${isSelf ? 'justify-content-end' : ''}">`;
					if (isSelf) {
						hoverControls += `
							<button class="btn btn-link btn-xs text-muted p-0 mr-2" style="font-size:11px;" onclick="unsendMessage(${msg.id})"><i class="fas fa-trash"></i> Unsend</button>
							<button class="btn btn-link btn-xs text-muted p-0 mr-2" style="font-size:11px;" onclick="editMessage(${msg.id}, '${escapeJsonString(msg.message)}')"><i class="fas fa-edit"></i> Edit</button>
						`;
					}
					hoverControls += `
						<button class="btn btn-link btn-xs text-muted p-0 mr-2" style="font-size:11px;" onclick="setReply(${msg.id}, '${escapeHtml(msg.fullname)}', '${escapeJsonString(msg.message)}')"><i class="fas fa-reply"></i> Reply</button>
					`;
					
					// Emojis reaction dropdown removed - reactions now trigger on hover
					hoverControls += `</div>`;
				}
				
				// Render reactions badge
				var reactionBadge = '';
				if (msg.reactions && msg.reactions.length > 0) {
					reactionBadge = `<div class="d-flex gap-1 mt-1 justify-content-start" style="flex-wrap:wrap;">`;
					msg.reactions.forEach(function(r) {
						reactionBadge += `<span class="badge badge-pill badge-dark px-2 py-1" style="background:#222; border:1px solid #333; font-size:10px;">${r.reaction} ${r.count}</span>`;
					});
					reactionBadge += `</div>`;
				}

				html += `
					<div class="chat-row ${chatClass}">
						${!isSelf ? `<img src="${avatarPath}" class="bubble-avatar" alt="Avatar">` : ''}
						<div class="bubble-container">
							${!isSelf ? `<span class="bubble-sender">${msg.fullname}</span>` : ''}
							<div class="chat-bubble">
								${replyHtml}
								<div>${bubbleContent}</div>
								${reactionBadge}
								${!msg.is_unsent ? `
								<!-- Reaction Hover Bar -->
								<div class="reaction-hover-bar">
									<a href="#" onclick="sendReaction(${msg.id}, '👍'); return false;">👍</a>
									<a href="#" onclick="sendReaction(${msg.id}, '❤️'); return false;">❤️</a>
									<a href="#" onclick="sendReaction(${msg.id}, '😂'); return false;">😂</a>
									<a href="#" onclick="sendReaction(${msg.id}, '😮'); return false;">😮</a>
									<a href="#" onclick="sendReaction(${msg.id}, '😢'); return false;">😢</a>
									<a href="#" onclick="sendReaction(${msg.id}, '🙏'); return false;">🙏</a>
								</div>
								` : ''}
							</div>
							<div class="bubble-meta">
								<span>${msg.sent_at}</span>
								${hoverControls}
							</div>
						</div>
					</div>
				`;
			});
			
			var feed = $('#chatMessageFeed');
			feed.html(html);
			
			if (messages.length > lastMessagesLength) {
				scrollToBottom();
			}
			lastMessagesLength = messages.length;
			
			// Detect incoming calls from message log
			var latestMsg = messages[messages.length - 1];
			if (latestMsg && !latestMsg.is_unsent && latestMsg.sender !== myUsername) {
				var match = latestMsg.message.match(/^\[CALL:(.+?)\|(.+?)\]$/);
				if (match) {
					var room = match[2];
					var type = match[1];
					// Trigger incoming call if not active/suppressed
					if (jitsiIncomingRoom !== room) {
						showIncomingCallOverlay(latestMsg.fullname, room, type, getAvatarUrl(latestMsg.imgUrl));
					}
				}
			}
		}

		function parseMessageBody(msgText) {
			msgText = trim(msgText);
			
			// File parsing
			var fileMatch = msgText.match(/^\[FILE:(.+?)\|(.+?)\]$/);
			if (fileMatch) {
				var name = fileMatch[1];
				var path = fileMatch[2];
				var ext = name.split('.').pop().toLowerCase();
				
				if (['png','jpg','jpeg','gif','webp'].includes(ext)) {
					return `<img src="${path}" class="img-fluid rounded shadow-xs" style="max-width:240px; cursor:zoom-in;" onclick="openLightbox('${path}', 'image')">`;
				} else if (['mp4','webm','ogg'].includes(ext)) {
					return `
						<div style="position:relative; max-width:240px; border-radius:12px; overflow:hidden;" onclick="openLightbox('${path}', 'video')">
							<video src="${path}#t=0.1" style="width:100%; aspect-ratio:3/2; object-fit:cover; display:block;" preload="auto" muted playsinline></video>
							<div style="position:absolute; top:0; left:0; right:0; bottom:0; display:flex; align-items:center; justify-content:center; background:rgba(0,0,0,0.3); font-size:32px; color:#fff;"><i class="fas fa-play-circle"></i></div>
						</div>
					`;
				} else {
					return `
						<a href="${path}" download class="btn btn-outline-light btn-sm text-left p-2 d-flex align-items-center gap-2" style="border-radius:12px; background:rgba(255,255,255,0.05);">
							<i class="fas fa-file-download" style="font-size:18px;"></i>
							<div style="line-height:1.2;">
								<span class="d-block font-weight-bold" style="font-size:11.5px;">${truncateString(name, 20)}</span>
								<span class="small text-muted" style="font-size:9.5px;">Click to download</span>
							</div>
						</a>
					`;
				}
			}
			
			// Call parsing
			var callMatch = msgText.match(/^\[CALL:(.+?)\|(.+?)\]$/);
			if (callMatch) {
				var type = callMatch[1];
				var room = callMatch[2];
				var title = type === 'video' ? 'Video Call' : 'Audio Call';
				var icon = type === 'video' ? 'fa-video' : 'fa-phone';
				
				return `
					<div class="p-3 border mt-1 shadow-sm text-center" style="background:#111e2e; border-color:#1e3a5f; color:#fff; border-radius:16px; min-width:200px; max-width:240px;">
						<div class="mb-2 text-primary" style="font-size:22px;"><i class="fas ${icon}"></i></div>
						<h6 class="font-weight-bold mb-1" style="font-size:13px; color:#fff;">${title}</h6>
						<p class="text-muted small mb-3" style="font-size:9.5px;">Click below to join the call room.</p>
						<button class="btn btn-success btn-sm btn-block font-weight-bold py-1.5" style="border-radius:8px;" onclick="joinJitsiCall('${escapeHtml(room)}', '${escapeHtml(type)}'); return false;">
							<i class="fas fa-phone-volume mr-1"></i> Join Call
						</button>
					</div>
				`;
			}
			
			return escapeHtml(msgText);
		}

		// Send operations
		function sendMessage() {
			var message = $('#messageInput').val().trim();
			if (message === '' && $('#attachmentInput')[0].files.length === 0) return;
			
			var formData = new FormData();
			formData.append('room_id', activeChatId);
			formData.append('message', message);
			if (replyToMsgId) {
				formData.append('reply_to', replyToMsgId);
			}
			
			var file = $('#attachmentInput')[0].files[0];
			if (file) {
				formData.append('file', file);
			}
			
			$.ajax({
				url: 'chat_actions.php?action=send_message',
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function(res) {
					if (res.status === 'success') {
						$('#messageInput').val('');
						$('#attachmentInput').val('');
						replyToMsgId = null;
						$('#replyPreviewBar').hide();
						fetchMessages();
						refreshConversations();
					} else {
						alert("Error: " + res.message);
					}
				}
			});
		}

		function unsendMessage(msgId) {
			if (!confirm("Are you sure you want to unsend this message?")) return;
			$.ajax({
				url: 'chat_actions.php?action=unsend_message',
				type: 'POST',
				data: { message_id: msgId },
				success: function(res) {
					if (res.status === 'success') {
						fetchMessages();
						refreshConversations();
					}
				}
			});
		}

		function editMessage(msgId, oldText) {
			var newText = prompt("Edit your message:", oldText);
			if (newText === null || newText.trim() === '') return;
			
			$.ajax({
				url: 'chat_actions.php?action=edit_message',
				type: 'POST',
				data: { message_id: msgId, message: newText },
				success: function(res) {
					if (res.status === 'success') {
						fetchMessages();
					}
				}
			});
		}

		function sendReaction(msgId, reaction) {
			$.ajax({
				url: 'chat_actions.php?action=send_reaction',
				type: 'POST',
				data: { message_id: msgId, reaction: reaction },
				success: function(res) {
					if (res.status === 'success') {
						fetchMessages();
					}
				}
			});
		}

		function setReply(msgId, username, text) {
			replyToMsgId = msgId;
			$('#replyToUser').text(username);
			$('#replyToText').text(truncateString(text, 35));
			$('#replyPreviewBar').css('display', 'flex');
			$('#messageInput').focus();
		}

		function cancelReply() {
			replyToMsgId = null;
			$('#replyPreviewBar').hide();
		}

		// Group Modal
		function openNewGroupModal() {
			// Fetch users to populate list
			$.ajax({
				url: 'chat_actions.php?action=search_users&term=',
				type: 'GET',
				dataType: 'json',
				success: function(res) {
					if (res.status === 'success') {
						var html = '';
						res.users.forEach(function(user) {
							html += `
								<div class="form-check p-2 border-bottom" style="border-color:var(--border-color) !important;">
									<input class="form-check-input" type="checkbox" name="group_members" value="${user.username}" id="chk_${user.username}">
									<label class="form-check-label d-flex align-items-center gap-2" for="chk_${user.username}">
										<img src="${getAvatarUrl(user.imgUrl)}" class="rounded-circle" style="width:30px; height:30px; object-fit:cover;">
										<span>${escapeHtml(user.fullname)}</span>
									</label>
								</div>
							`;
						});
						$('#searchUserResultsModal').html(html || '<p class="text-muted small">No other users found.</p>');
						$('#newGroupName').val('');
						$('#newGroupModal').modal('show');
					}
				}
			});
		}

		function createGroupRoom() {
			var groupName = $('#newGroupName').val().trim();
			var selectedMembers = [];
			$('input[name="group_members"]:checked').each(function() {
				selectedMembers.push($(this).val());
			});
			
			if (groupName === '') {
				alert("Please enter a group name");
				return;
			}
			
			$.ajax({
				url: 'chat_actions.php?action=create_room',
				type: 'POST',
				data: {
					is_group: 1,
					name: groupName,
					members: selectedMembers
				},
				dataType: 'json',
				success: function(res) {
					if (res.status === 'success') {
						$('#newGroupModal').modal('hide');
						refreshConversations(res.room_id);
					}
				}
			});
		}

		function deleteGroupChat() {
			if (!activeChatId) return;
			if (!confirm("Are you sure you want to delete this group chat? This will remove all members and messages permanently.")) {
				return;
			}
			
			$.ajax({
				url: 'chat_actions.php?action=delete_group',
				type: 'POST',
				data: { room_id: activeChatId },
				dataType: 'json',
				success: function(res) {
					if (res.status === 'success') {
						activeChatId = null;
						isGroupChat = 0;
						$('#chatActivePane').hide();
						$('#emptyPane').show();
						$('.workspace-container').removeClass('active-chat-open');
						refreshConversations();
					} else {
						alert("Error: " + res.message);
					}
				}
			});
		}

		// User Search
		function handleSearch() {
			var query = $('#searchBar').val().trim();
			if (query.length < 2) {
				refreshConversations();
				return;
			}
			
			$.ajax({
				url: 'chat_actions.php?action=search_users&term=' + query,
				type: 'GET',
				dataType: 'json',
				success: function(res) {
					if (res.status === 'success') {
						var html = '';
						res.users.forEach(function(user) {
							html += `
								<div class="conv-item" onclick="startPrivateDM('${user.username}', '${escapeHtml(user.fullname)}')">
									<div class="avatar-wrapper">
										<img src="${getAvatarUrl(user.imgUrl)}" class="user-avatar" alt="Avatar">
										${user.is_online ? '<div class="online-indicator"></div>' : ''}
									</div>
									<div class="conv-details">
										<h6 class="conv-name">${escapeHtml(user.fullname)}</h6>
										<p class="conv-preview">Start a private message</p>
									</div>
								</div>
							`;
						});
						$('#convListFeed').html(html || '<div class="text-center py-4 text-muted">No users found.</div>');
					}
				}
			});
		}

		function startPrivateDM(username, fullname) {
			$.ajax({
				url: 'chat_actions.php?action=create_room',
				type: 'POST',
				data: { is_group: 0, target: username },
				dataType: 'json',
				success: function(res) {
					if (res.status === 'success') {
						$('#searchBar').val('');
						refreshConversations(res.room_id);
					}
				}
			});
		}

		// Call Management
		function startCall(roomName, type, receiverName, avatarUrl) {
			// Send call invitation message
			$.ajax({
				url: 'chat_actions.php?action=send_message',
				type: 'POST',
				data: {
					room_id: activeChatId,
					message: `[CALL:${type}|${roomName}]`
				},
				success: function() {
					fetchMessages();
					refreshConversations();
					joinJitsiCall(roomName, type);
					showOutboundCallOverlay(receiverName, roomName, type, avatarUrl);
				}
			});
		}

		function showOutboundCallOverlay(receiverName, roomName, callType, avatarUrl) {
			lastOutboundRoom = roomName;
			lastOutboundType = callType;
			lastOutboundTarget = receiverName;
			lastOutboundAvatar = avatarUrl;
			
			$('#outboundCallReceiver').text(receiverName);
			$('#outboundCallAvatar').attr('src', avatarUrl || '../images/user.webp');
			$('#outboundCallStatus').text("Calling...");
			
			$('#outboundCallingActions').css('display', 'flex');
			$('#outboundNoAnswerActions').hide();
			
			$('#outboundCallOverlay').css('display', 'flex');
			playOutboundRingSound();
		}

		function showIncomingCallOverlay(callerName, room, type, avatarUrl) {
			jitsiIncomingRoom = room;
			jitsiIncomingType = type;
			
			$('#incomingCallName').text(callerName);
			$('#incomingCallAvatar').attr('src', avatarUrl || '../images/user.webp');
			$('#incomingCallTypeLabel').text(`Incoming ${type === 'video' ? 'Video' : 'Voice'} Call...`);
			
			$('#incomingCallOverlay').css('display', 'flex');
			playRingSound();
			
			// 30 seconds ring timeout
			clearTimeout(jitsiIncomingTimer);
			jitsiIncomingTimer = setTimeout(function() {
				declineCall();
			}, 30000);
		}

		function acceptCall() {
			declineCallSilently();
			joinJitsiCall(jitsiIncomingRoom, jitsiIncomingType);
		}

		function declineCall() {
			declineCallSilently();
		}

		function declineCallSilently() {
			stopRingSound();
			clearTimeout(jitsiIncomingTimer);
			$('#incomingCallOverlay').hide();
		}

		function joinJitsiCall(roomName, callType) {
			stopRingSound();
			stopOutboundRingSound();
			
			$('#outboundCallOverlay').hide();
			$('#incomingCallOverlay').hide();
			
			$('#jitsiCallTitle').text(callType === 'video' ? 'Video Call' : 'Voice Call');
			$('#jitsiCallOverlay').css('display', 'flex');
			$('#jitsiLoading').show();
			
			// Initialize Jitsi API
			try {
				if (typeof JitsiMeetExternalAPI !== 'undefined') {
					activeJitsiAPI = new JitsiMeetExternalAPI('meet.mcjim-server.com', {
						roomName: roomName,
						width: '100%',
						height: '100%',
						parentNode: document.getElementById('jitsiIframeContainer'),
						configOverwrite: {
							prejoinPageEnabled: false,
							prejoinConfig: {
								enabled: false
							},
							deeplinking: {
								disabled: true
							},
							startWithVideoMuted: (callType === 'audio')
						},
						interfaceConfigOverwrite: {
							TOOLBAR_BUTTONS: [
								'microphone', 'camera', 'closedcaptions', 'desktop', 
								'fullscreen', 'fodeviceselection', 'hangup', 'profile', 
								'settings', 'videoquality', 'tileview'
							]
						}
					});
					
					activeJitsiAPI.addEventListener('videoConferenceLeft', function() {
						hangupJitsiCall();
					});
					
					activeJitsiAPI.addEventListener('participantJoined', function() {
						stopOutboundRingSound();
						$('#outboundCallOverlay').hide();
					});
					
					var iframe = document.querySelector('#jitsiIframeContainer iframe');
					if (iframe) {
						iframe.onload = function() {
							$('#jitsiLoading').hide();
						};
						setTimeout(function() {
							$('#jitsiLoading').hide();
						}, 4000);
					} else {
						$('#jitsiLoading').hide();
					}
				} else {
					// Fallback raw iframe
					var iframe = document.createElement('iframe');
					var isVideoMuted = (callType === 'audio') ? 'true' : 'false';
					var jitsiUrl = `https://meet.mcjim-server.com/${roomName}#config.prejoinPageEnabled=false&config.prejoinConfig.enabled=false&config.deeplinking.disabled=true&config.startWithVideoMuted=${isVideoMuted}`;
					
					iframe.setAttribute('src', jitsiUrl);
					iframe.setAttribute('allow', 'camera; microphone; fullscreen; display-capture; autoplay');
					iframe.style.border = 'none';
					iframe.style.width = '100%';
					iframe.style.height = '100%';
					iframe.onload = function() {
						$('#jitsiLoading').hide();
					};
					document.getElementById('jitsiIframeContainer').appendChild(iframe);
				}
			} catch(e) {
				console.error(e);
				$('#jitsiLoading').hide();
			}
		}

		function hangupJitsiCall() {
			stopRingSound();
			stopOutboundRingSound();
			
			$('#jitsiCallOverlay').hide();
			$('#outboundCallOverlay').hide();
			$('#incomingCallOverlay').hide();
			
			if (activeJitsiAPI) {
				activeJitsiAPI.dispose();
				activeJitsiAPI = null;
			}
			
			// Remove any fallback elements
			var container = document.getElementById('jitsiIframeContainer');
			var children = container.children;
			for (var i = children.length - 1; i >= 0; i--) {
				if (children[i].id !== 'jitsiLoading') {
					children[i].remove();
				}
			}
		}

		function showNoAnswerScreen() {
			stopOutboundRingSound();
			
			$('#jitsiCallOverlay').hide();
			if (activeJitsiAPI) {
				activeJitsiAPI.dispose();
				activeJitsiAPI = null;
			}
			
			$('#outboundCallStatus').text("No answer");
			$('#outboundCallingActions').hide();
			$('#outboundNoAnswerActions').css('display', 'flex');
			
			$('#redialBtn').off('click').on('click', function() {
				if (lastOutboundRoom && lastOutboundType) {
					joinJitsiCall(lastOutboundRoom, lastOutboundType, lastOutboundTarget, lastOutboundAvatar);
				}
			});
		}

		// Ringtone Audio Synthesizers (Web Audio API)
		function playRingSound() {
			stopRingSound();
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

		function stopRingSound() {
			if (ringInterval) clearInterval(ringInterval);
			if (ringAudioCtx) {
				try { ringAudioCtx.close(); } catch(e){}
				ringAudioCtx = null;
			}
		}

		function playOutboundRingSound() {
			stopOutboundRingSound();
			try {
				var AudioCtx = window.AudioContext || window.webkitAudioContext;
				if (!AudioCtx) return;
				outboundAudioCtx = new AudioCtx();
				
				var playRing = function() {
					if (!outboundAudioCtx) return;
					if (outboundAudioCtx.state === 'suspended') outboundAudioCtx.resume();
					
					var osc1 = outboundAudioCtx.createOscillator();
					var osc2 = outboundAudioCtx.createOscillator();
					var mainGain = outboundAudioCtx.createGain();
					
					osc1.type = 'sine';
					osc1.frequency.value = 400;
					osc2.type = 'sine';
					osc2.frequency.value = 450;
					
					mainGain.gain.setValueAtTime(0, outboundAudioCtx.currentTime);
					mainGain.gain.linearRampToValueAtTime(0.12, outboundAudioCtx.currentTime + 0.1);
					mainGain.gain.setValueAtTime(0.12, outboundAudioCtx.currentTime + 1.0);
					mainGain.gain.exponentialRampToValueAtTime(0.001, outboundAudioCtx.currentTime + 1.2);
					
					osc1.connect(mainGain);
					osc2.connect(mainGain);
					mainGain.connect(outboundAudioCtx.destination);
					
					osc1.start();
					osc2.start();
					
					osc1.stop(outboundAudioCtx.currentTime + 1.2);
					osc2.stop(outboundAudioCtx.currentTime + 1.2);
				};
				
				playRing();
				outboundInterval = setInterval(playRing, 4000);
				
				outboundTimeout = setTimeout(function() {
					showNoAnswerScreen();
				}, 45000);
			} catch(e) {
				console.error(e);
			}
		}

		function stopOutboundRingSound() {
			if (outboundInterval) clearInterval(outboundInterval);
			if (outboundTimeout) clearTimeout(outboundTimeout);
			if (outboundAudioCtx) {
				try { outboundAudioCtx.close(); } catch(e){}
				outboundAudioCtx = null;
			}
		}

		// Jitsi Minimize/Maximize
		var isJitsiMinimized = false;
		function toggleMinimizeJitsiCall() {
			var overlay = document.getElementById('jitsiCallOverlay');
			var container = document.getElementById('jitsiIframeContainer');
			var title = document.getElementById('jitsiCallTitle');
			var minBtn = document.getElementById('minimizeJitsiBtn');
			
			if (!overlay) return;
			
			if (!isJitsiMinimized) {
				// Minimize
				overlay.style.width = '280px';
				overlay.style.height = '220px';
				overlay.style.top = 'auto';
				overlay.style.left = 'auto';
				overlay.style.bottom = '20px';
				overlay.style.right = '20px';
				overlay.style.borderRadius = '16px';
				overlay.style.border = '2px solid #28a745';
				overlay.style.boxShadow = '0 10px 40px rgba(0,0,0,0.6)';
				
				if (container) container.style.height = 'calc(100% - 45px)';
				if (title) title.style.display = 'none';
				if (minBtn) minBtn.innerHTML = '<i class="fas fa-expand-alt"></i>';
				isJitsiMinimized = true;
			} else {
				// Restore
				overlay.style.width = '100vw';
				overlay.style.height = '100vh';
				overlay.style.top = '0';
				overlay.style.left = '0';
				overlay.style.bottom = 'auto';
				overlay.style.right = 'auto';
				overlay.style.borderRadius = '0';
				overlay.style.border = 'none';
				overlay.style.boxShadow = 'none';
				
				if (container) container.style.height = 'calc(100% - 55px)';
				if (title) title.style.display = 'inline';
				if (minBtn) minBtn.innerHTML = '<i class="fas fa-compress-alt" style="margin-right: 6px;"></i> Minimize';
				isJitsiMinimized = false;
			}
		}

		// Lightbox Management
		function openLightbox(src, type) {
			var lightbox = $('#customMediaLightbox');
			var img = $('#lightbox-image');
			var video = $('#lightbox-video');
			
			img.hide();
			video.hide();
			video.attr('src', '');
			
			if (type === 'image') {
				img.attr('src', src).show();
			} else if (type === 'video') {
				video.attr('src', src).show();
				video[0].play();
			}
			
			lightbox.addClass('show');
		}

		function hideLightboxModal() {
			var lightbox = $('#customMediaLightbox');
			var video = $('#lightbox-video');
			video[0].pause();
			video.attr('src', '');
			lightbox.removeClass('show');
		}

		// Input and Helpers
		function triggerFileUpload() {
			$('#attachmentInput').click();
		}

		function handleFileSelected() {
			var input = $('#attachmentInput')[0];
			if (input.files.length > 0) {
				sendMessage();
			}
		}

		function handleInputKeyDown(event) {
			if (event.key === 'Enter' && !event.shiftKey) {
				event.preventDefault();
				sendMessage();
			}
		}

		function scrollToBottom() {
			var feed = document.getElementById('chatMessageFeed');
			if (feed) {
				feed.scrollTop = feed.scrollHeight;
			}
		}

		function escapeHtml(text) {
			if (!text) return '';
			return text
				.replace(/&/g, "&amp;")
				.replace(/</g, "&lt;")
				.replace(/>/g, "&gt;")
				.replace(/"/g, "&quot;")
				.replace(/'/g, "&#039;");
		}

		function truncateString(str, num) {
			if (!str) return '';
			if (str.length <= num) return str;
			return str.slice(0, num) + '...';
		}

		function trim(str) {
			return str.replace(/^\s+|\s+$/g, '');
		}

		function escapeJsonString(str) {
			return str
				.replace(/\\/g, '\\\\')
				.replace(/'/g, "\\'")
				.replace(/"/g, '\\"')
				.replace(/\n/g, '\\n')
				.replace(/\r/g, '\\r');
		}

		// Emoji Picker Toggles and Actions
		function toggleEmojiPicker(e) {
			e.stopPropagation();
			$('#emojiPickerPopover').toggle();
		}

		function insertEmoji(emoji) {
			var textarea = document.getElementById('messageInput');
			var start = textarea.selectionStart;
			var end = textarea.selectionEnd;
			var text = textarea.value;
			textarea.value = text.substring(0, start) + emoji + text.substring(end);
			textarea.focus();
			var newPos = start + emoji.length;
			textarea.setSelectionRange(newPos, newPos);
		}

		// Initialize
		$(document).ready(function() {
			refreshConversations();
			
			$('#mobileBackBtn').on('click', function() {
				$('.workspace-container').removeClass('active-chat-open');
			});
			
			// Populate Emoji Grid
			var emojis = [
				"😀", "😃", "😄", "😁", "😆", "😅", "😂", "🤣", "😊", "😇", "🙂", "🙃", "😉", "😌", "😍", "🥰", "😘", "😗", "😙", "😚", "😋", "😛", "😝", "😜", "🤪", "🤨", "🧐", "🤓", "😎", "🤩", "🥳", "😏", "😒", "😞", "😔", "😟", "😕", "🙁", "☹️", "😣", "😖", "😫", "😩", "🥺", "😢", "😭", "😤", "😠", "😡", "🤬", "🤯", "😳", "🥵", "🥶", "😱", "😨", "😰", "😥", "😓", "🤗", "🤔", "🤭", "🤫", "🤥", "😶", "😐", "😑", "😬", "🙄", "😯", "😦", "😧", "😮", "😲", "🥱", "😴", "🤤", "😪", "😵", "🤐", "🥴", "🤢", "🤮", "🤧", "😷", "🤒", "🤕",
				"👋", "🤚", "🖐️", "✋", "🖖", "👌", "🤌", "🤏", "✌️", "🤞", "🤟", "🤘", "🤙", "👈", "👉", "👆", "🖕", "👇", "☝️", "👍", "👎", "✊", "👊", "🤛", "🤜", "👏", "🙌", "👐", "🤲", "🤝", "🙏", "✍️", "💅", "🤳", "💪", "🦾", "🦿", "🦵", "🦶", "👂", "🦻", "👃", "🧠", "🫀", "🫁", "🦷", "🦴", "👀", "👁️", "👅", "👄",
				"❤️", "🧡", "💛", "💚", "💙", "💜", "🖤", "🤍", "🤎", "💔", "❤️‍🔥", "❤️‍🩹", "❣️", "💕", "💞", "💓", "💗", "💖", "💘", "💝", "💟",
				"🔥", "✨", "🌟", "⭐", "💫", "💥", "💨", "💦", "💯", "🎉", "🎊", "🎂", "🎈", "🎁", "🎗️", "🎟️", "🎫", "🏆", "🏅", "🥇", "🥈", "🥉", "⚽", "🏀", "🏈", "⚾", "🎾", "🎮", "🕹️", "🎲", "🎯", "🎭", "🎨", "🎬", "🎤", "🎧", "📱", "💻", "⌨️", "🖥️", "📸", "📷", "📽️", "🎬", "📺", "🔍", "🔎", "💡", "🔦", "🕯️", "💵", "🪙", "💳", "✉️", "📦", "✏️", "✒️", "🔑", "🔒", "🔓", "🛠️", "⚙️", "🛡️", "🏹", "🛰️", "🛸", "🚀", "🚗", "🚲", "✈️", "🚢", "🗺️", "⏰", "⌛"
			];
			var gridHtml = '';
			emojis.forEach(function(em) {
				gridHtml += `<span onclick="insertEmoji('${em}')">${em}</span>`;
			});
			$('#emojiPickerGrid').html(gridHtml);

			// Close emoji picker on click outside
			$(document).on('click', function(e) {
				if (!$(e.target).closest('#emojiPickerPopover, #emojiPickerBtn').length) {
					$('#emojiPickerPopover').hide();
				}
			});
			
			// Periodically refresh conversations every 5s (lighter load)
			setInterval(function() {
				refreshConversations();
			}, 5000);

			// Fetch active chat messages every 2s
			setInterval(function() {
				if (activeChatId) {
					fetchMessages();
				}
			}, 2000);
		});
	</script>
</body>
</html>
