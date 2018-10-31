jQuery(document).ready(function($) {
    $('form#login').on('submit', function(e){
        $('form#login p.status').show().text(ajax_login_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajaxlogin', 
                'username': $('form#login #username').val(), 
                'password': $('form#login #password').val(), 
                'security': $('form#login #security').val() 
            },
            success: function(data){
                if (data.loggedin == false) {
                    $('form#login p.status').addClass('text-error');    
                } else {
                    $('form#login p.status').removeClass('text-error');                        
                }
                $('form#login p.status').text(data.message);
                if (data.loggedin == true){
                    document.location.href = ajax_login_object.redirecturl;
                }
            }
        });
        e.preventDefault();
    });

	$('form#register').on('submit', function (e) {
        $('p.status', this).show().text(ajax_login_object.loadingmessage);
		action = 'ajaxregister';
		username = $('#signonname').val();
		password = $('#signonpassword').val();
       	email = $('#email').val();
       	security = $('#signonsecurity').val();	
		ctrl = $(this);
		$.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': action,
                'username': username,
                'password': password,
				'email': email,
                'security': security
            },
            success: function (data) {
                if (data.loggedin == false) {
                    $('form#register p.status').addClass('text-error');    
                } else {
                    $('form#register p.status').removeClass('text-error');                        
                }                
				$('p.status', ctrl).text(data.message);
				if (data.loggedin == true) {
                    document.location.href = ajax_login_object.redirecturl;
                }
            }
        });
        e.preventDefault();
    });    

    $('.link-lost-password').click(function(e) {
        e.preventDefault();
        $('.modal-login-form').fadeOut(function() {
            $('.modal-lostpassword-form').fadeIn();
        });
    });

	$('form#forgot_password').on('submit', function(e){
		$('p.status', this).show().text(ajax_login_object.loadingmessage);
		ctrl = $(this);
		$.ajax({
			type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
			data: { 
				'action': 'ajaxforgotpassword', 
				'user_login': $('#user_login').val(), 
				'security': $('#forgotsecurity').val(), 
			},
			success: function(data){		
                if (data.loggedin == false) {
                    $('form#forgot_password p.status').addClass('text-error');    
                } else {
                    $('form#forgot_password p.status').removeClass('text-error');                        
                }                			
				$('p.status',ctrl).text(data.message);				
			}
		});
		e.preventDefault();
		return false;
    });
        
});