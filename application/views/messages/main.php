<script>
    $(document).ready(function () {
	var oldDate, newDate, days, hours, min, sec, unique_id, bg_image, inter, inter3, inter2,
		chatBox = document.getElementById('chat_message_area');
		

	

	//getting all user list except me
	function getUserList() {
		return new Promise(function (resolve, reject) { //Creating new Promise Chain
			$.ajax({
				url: 'Messages/allUser',
				type: 'get',
				async: false,
				success: function (data) {
					if (data != "") {
						resolve(data);
					}
				}
			})
		}).then(function (data) { //This function setting the user list
			document.getElementById('user_list').innerHTML = data; //setting data to the user list
			
			$('.innerBox').click(function () {

				$('#kt_chat_messenger_footer').show();
				$('.chatting_section').css('display', '');

				unique_id = $(this).find('#user_avtar').children('#hidden_id').val();
				bg_image = '';

				clearInterval(inter);

				main_name = $(this).find('#fullname').html();
				$('#main_name').html(main_name);
				is_active = $(this).find('.is_active').val();
				
				if(is_active==1){
					$('#if_main_active').show();
					$('#if_main_inactive').hide();
				}else{
					$('#if_main_inactive').show();
					$('#if_main_active').hide();
				}

				inter2 = setInterval(getUserList, 5000);
				
				sendUserUniqIDForMsg(unique_id, bg_image , main_name , is_active);

				inter = setInterval(function () {
					sendUserUniqIDForMsg(unique_id, bg_image , main_name, is_active);
				}, 1000);
			})
			$('.innerBox').mouseover(function () {
				clearInterval(inter2);
			})
			$('.innerBox').mouseleave(function () {
				inter2 = setInterval(getUserList, 5000);
			})
		})
	}
	
	
	


	function calculateTime(data) {
		oldDate = new Date(data).getTime();
		newDate = new Date().getTime();
		differ = newDate - oldDate;
		days = Math.floor(differ / (1000 * 60 * 60 * 24));
		hours = Math.floor((differ % (1000 * 60 * 60 * 24)) / (60 * 60 * 1000));
		min = Math.floor((differ % (1000 * 60 * 60)) / (60 * 1000));
		sec = Math.floor((differ % (1000 * 60)) / 1000);
		var obj = {
			hours: hours,
			min: min,
			sec: sec
		};
		return obj;
	}
	//sending unique_id which is clicked for messages
	function sendUserUniqIDForMsg(uniq_id, bg_image , main_name) {
		$.post('Messages/getmessage', { data: uniq_id, image: bg_image , othername: main_name }, function (data) {
			setMessageToChatArea(data, bg_image);//setting messages to the chatting section
		});
	}
	function setMessageToChatArea(data, bg_image) {
		scrollToBottom();
		var res_data;
		if (data.length > 5) {
			$('#chat_message_area').html(data);
		} else {
			$('#chat_message_area').html('<div class="mb-2"><h1 class="fw-semibold text-gray-800 text-center lh-lg"><?php echo lang('type_message') ?><br><span class="fw-bolder"><?php echo lang('and_click_send') ?></span></h1><div class="py-10 text-center"><img src="<?php echo base_url() ?>assets/css_good/media/svg/illustrations/easy/4.svg" class="w-200px" alt=""></div></div>');
		}
	}
	$('#chat_message_area').mouseenter(function () {
		chatBox.classList.add('active');
	});
	$('#chat_message_area').mouseleave(function () {
		chatBox.classList.remove('active');
	});
	function scrollToBottom() {
		inter4 = setInterval(() => {
			if (!chatBox.classList.contains('active')) {
				chatBox.scrollTop = chatBox.scrollHeight;
			}
		});
	}
	$('#search').keyup(function (e) {
		var user = document.querySelectorAll('.user');
		var name = document.querySelectorAll('#user_list h6');
		var val = this.value.toLowerCase();
		if (val.length > 0) {
			clearInterval(inter2);
			for (let i = 0; i < user.length; i++) {
				nameVal = name[i].innerHTML
				if (nameVal.toLowerCase().indexOf(val) > -1) {
					user[i].style.display = '';
				} else {
					user[i].style.display = 'none';
				}
			}
		} else {
			inter2 = setInterval(getUserList, 5000);
		}
	});
	function getCharLength() {
		const MAX_LENGTH = 200;
		var len = document.getElementById('messageText').value.length;
		if (len <= MAX_LENGTH) {
			$('#count_text').html(`${len}/200`);
		}
	}
	setInterval(getCharLength, 10);
	$('#logout').click(function (e) {
		e.preventDefault();
		var date = new Date();
		date = new Date(date);
		date = date.toLocaleString();
		$.ajax({
			url: 'logout',
			type: 'post',
			data: "date=" + date,
			success: function (res) {
				location.href = res;
			}
		})
	});
	//send message after button click
	$('#send_message').click(function (e) {
		var d = new Date(),
			messageHour = d.getHours(),
			messageMinute = d.getMinutes(),
			messageSec = d.getSeconds(),
			messageYear = d.getFullYear(),
			messageDate = d.getDate(),
			messageMonth = d.getMonth() + 1,
			actualDateTime = `${messageYear}-${messageMonth}-${messageDate} ${messageHour}:${messageMinute}:${messageSec}`;
		var message = $('#messageText').val();
		var data = {
			message: message,
			datetime: actualDateTime,
			uniq: unique_id,
			is_email : $('#is_email').is(":checked"),
			is_sms : $('#is_sms').is(":checked")
		}
		var jsonData = JSON.stringify(data);
		$.post('messages/sendMessage', { data: jsonData }, function (data) {
			$('#messageText').val('');
		})
	})
	
	//update form container submit event
	$('#form_details').on('submit', function (e) {
		e.preventDefault();
		var newDate = $('#dob').val();
		var newPhone = $('#phone_num').val();
		var newAddress = $('#address').val();
		var newBio = $('#update_bio').val();
		$.post('Messages/updateBio', { dob: newDate, phone: newPhone, address: newAddress, bio: newBio }, function (data) {
			$('#main').removeClass('blur');
			$('#update_container').hide();
		})
	})
	$('#details_btn').click(function () {
		var bar = document.getElementById('details_of_user').style;
		if (bar.width == "20%") {
			barOut();
		} else {
			barIn();
		}
	})
	$('#btn_block').click(function () {
		var d = new Date(),
			messageHour = d.getHours(),
			messageMinute = d.getMinutes(),
			messageSec = d.getSeconds(),
			messageYear = d.getFullYear(),
			messageDate = d.getDate(),
			messageMonth = d.getMonth() + 1,
			actualDateTime = `${messageYear}-${messageMonth}-${messageDate} ${messageHour}:${messageMinute}:${messageSec}`;
		if (this.innerHTML == "Block User") {
			$.post('Messages/blockUser', { time: actualDateTime, uniq: unique_id })
		} else {
			$.post('Messages/unBlockUser', { uniq: unique_id })
		}
	})
	//working on block & unblock program
	function getBlockUserData() {
		$.post('Messages/getBlockUserData', { uniq: unique_id }, function (data) {
			var jsonData = JSON.parse(data);
			if (jsonData.length == 1) {
				for (var i = 0; i < jsonData.length; i++) {
					if (jsonData[i]['blocked_from'] == unique_id) {
						$('#messageText').attr('disabled', '');
						$('#messageText').attr('placeholder', 'This user is not receiving messages at this time.');
						$('#messageText').css('cursor', 'no-drop');
						$('#btn_block').html('Block User');
						$('#send_message').attr('disabled', '');
						$('#send_message').css('cursor', 'no-drop');
					} else {
						$('#messageText').attr('disabled', '');
						$('#messageText').attr('placeholder', 'You have blocked this user');
						$('#btn_block').html('Unblock User');
						$('#messageText').css('cursor', 'no-drop');

						$('#send_message').attr('disabled', '');
						$('#send_message').css('cursor', 'no-drop');
					}
				}
			} else if (jsonData.length == 2) {
				$('#messageText').attr('disabled', '');
				$('#messageText').attr('placeholder', 'You both are blocked each other');
				$('#btn_block').html('Unblock User');
				$('#messageText').css('cursor', 'no-drop');
				$('#send_message').attr('disabled', '');
				$('#send_message').css('cursor', 'no-drop');
			} else {
				$('#messageText').removeAttr('disabled');
				$('#messageText').attr('placeholder', 'Start Typing. . . .');
				$('#btn_block').html('Block User');
				$('#messageText').css('cursor', '');
				$('#send_message').removeAttr('disabled');
				$('#send_message').css('cursor', '');
			}
		})
	}

	getUserList(); //Calling the root function without interval
	inter2 = setInterval(getUserList, 5000); //Calling the root function with interval
})


</script>