(function($) {

    $(document).ready(function() {
        $('.button-login').click(function(e) {
            e.preventDefault();
            $('#modal-login').modal('show');
            $('.wishlist_area').hide();
        });    

        $('.button-register').click(function(e) {
            e.preventDefault();
            $('#modal-register').modal('show');
            $('.wishlist_area').hide();
        });    
        
        $('.popup-close').click(function(e) {
            e.preventDefault();
            $(this).parent().parent().parent().parent().modal('hide');
        });

        $('.close-popup-search').on('click', function(e) {
            e.preventDefault();        
            $('.coming_pop').fadeOut();
        });
        
        var lang_select_counter = 0;
        $('#esp_value, .goog-te-combo').ddslick({
            onSelected: function(data) {
                if(lang_select_counter > 0) {
                    if(data.selectedData.value == 'ES') {
                        document.location.href = home_url_es;
                    }
                    if(data.selectedData.value == 'EN') {                  
                        document.location.href = home_url_en;    
                    }
                } else {
                    lang_select_counter++;                                    
                }
            }
        });

        $('#flags #sortable').prepend('<li id="Spanish"><a title="Spanish" class="notranslate flag es Spanish" data-lang="Spanish"></a></li>');

        $('#flags li a').click(function(e) {
            if($(this).parent().attr('id') == 'Spanish') {
                e.preventDefault();
                document.location.href = home_url_es;                
            }
            if($(this).parent().attr('id') == 'English') {
                e.preventDefault();
                document.location.href = home_url_en;                
            }            
        });

    });

    document.addEventListener( 'wpcf7mailsent', function( event ) {
        var inputs = event.detail.inputs;
        var name;
        var email;
        var phone;
        for(var i = 0; i < inputs.length; i++ ) {
            if('username' == inputs[i].name) {
                name = inputs[i].value;
            }
            if('useremail' == inputs[i].name) {
                email = inputs[i].value;
            }
            if('phone' == inputs[i].name) {
                phone = inputs[i].value;
            }                                            
        }

        if( '473' == event.detail.contactFormId || '697' == event.detail.contactFormId ) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajax_url,
                data: { 
                    'action': 'ajaxdownload', 
                    'promo_id': promo_id,
                    'promo_ref': promo_ref,
                    'name': name,                    
                    'phone': phone,                    
                    'email': email
                },
                success: function(data){
                    if (data.pdf != ''){
                        document.location.href = data.pdf;
                        //window.open(data.pdf);
                    }
                }
            });            
        }
       
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_url,
            data: { 
                'action': 'ajaxwitei', 
                'promo_witei': promo_witei,
                'name': name,                    
                'phone': phone,                    
                'email': email,
            },
            success: function(data){
            }
        });
        
    }, false ); 

    
    /*
    $('#esp_value').on('change', function() {
        if($(this).val() == 'ES') {
            document.location.href = home_url_es;
        } else {         
            document.location.href = home_url_en;            
        }
    });
    */

    /*
    $('a[href^="#"]').click(function () {
        if($(this).data('toggle') == 'modal' || $(this).data('slide') == 'prev' || $(this).data('slide') == 'next') {
        } else {
            $('html, body').animate({
                scrollTop: $('[name="' + $.attr(this, 'href').substr(1) + '"]').offset().top
            }, 500);
            return false;
        }
    });
    */

    $('.datepicker').datepicker({
        dateFormat : 'd/m/yy'
    });

    /*
    if(typeof promo_ref !== 'undefined') {
        $('[name=promo]').val(promo_ref);
    }
    */

    $('#gridviewlist').change(function() {
        if($(this).val() > 0) {
            document.location = developments_url + '/?o=' + $(this).val();
        }
    });

    $('#tablist1-tab1').live('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        document.location = search_url;
    });

    $('#commentform').submit( function(e) {
        if($('#chk-legal-comment').is(':checked')) {
        } else {
            e.preventDefault();
        }
    });




    /********************************************************************/
    AOS.init();

    var FX=function(t,e){return e(".menu-button").click(function(){e(".mobile_primary").toggle({direction:"left"}),e(".menu-button").toggleClass("open"),e(".mainnav .pull--right").toggleClass("open")}),e(".mobile_primary .menu-item-has-children").append('<span class="sub-menu--button"></span>'),e(".sub-menu--button").each(function(){e(this).click(function(){e(this).toggleClass("open"),e(this).prev().slideToggle()})})}(FX||{},jQuery);

	var $item = $('#banner .item'); 
	var $wHeight = $(window).height();
	$item.eq(0).addClass('active');
	$item.height($wHeight); 
	$item.addClass('full-screen');

	$('#banner img').each(function() {
		var $src = $(this).attr('src');
		var $color = $(this).attr('data-color');
		$(this).parent().css({
			'background-image' : 'url(' + $src + ')',
			'background-color' : $color
		});
		$(this).remove();
	});

	$(window).on('resize', function (){
		$wHeight = $(window).height();
		$item.height($wHeight);
	});

	$("#banner").owlCarousel({	
		  navigation : true,
		  slideSpeed : 300,
		  paginationSpeed : 400,
		  singleItem : true	
	});
	
	$("#riconvictoria").owlCarousel({	
		  navigation : true,
		  slideSpeed : 300,
		  paginationSpeed : 400,
		  singleItem : true	
	});
	
	$("#showfilter").click(function(){
		$("#showfilterinfo").slideToggle(1000);
	});
	
	 $("#homeareas").owlCarousel({
			autoPlay: 3000,
			loop:true,
			items : 4,
			navigation : true,
			itemsDesktop : [1199,3],
			itemsDesktopSmall : [1023,2]
	});

	 $("#merbellaslider").owlCarousel({
			autoPlay: 3000,
			loop:true,
			items : 3,
			navigation : true,
			itemsDesktop : [1199,3],
			itemsDesktopSmall : [1023,2]
	});	

	$('#popup-footer').on('click', function(e)  {
        $('.coming_pop').fadeIn(350);
        $('#text_search').focus();        
		e.preventDefault();
    });

	$('.popup-close').on('click', function(e)  {
		$('#popup-inner').fadeOut(350);
		$('#overlay').fadeOut(350);
		e.preventDefault();
	});

	$('#overlay').on('click', function(e)  {
		$('#popup-inner').fadeOut(350);
		$('#overlay').fadeOut(350);
        e.preventDefault();
    });

	$('#listview').click(function(event){
        event.preventDefault();
        $('#propertylist .propertyitem').addClass('list-group-item');
    });
       
    $('#gridview').click(function(event){
        event.preventDefault();
        $('#propertylist .propertyitem').removeClass('list-group-item');
        $('#propertylist .propertyitem').addClass('grid-group-item');
    });

	$(".wishicon").click(function () {
    	$(".wishlist_area").slideToggle("fast");
   	});

    var $document   = $(document),
        $inputRange = $('input[type="range"]');
    
    function valueOutput(element) {
        var value = element.value,
            output = element.parentNode.getElementsByTagName('output')[0];
    }
    for (var i = $inputRange.length - 1; i >= 0; i--) {
        valueOutput($inputRange[i]);
	}
	
    $document.on('input', 'input[type="range"]', function(e) {
        valueOutput(e.target);
    });
    // end
  
    $inputRange.rangeslider({
      polyfill: false 
    });
    
    /*
	$("#mapascrollbar").mCustomScrollbar({
		 theme:"rounded-dots",
		 scrollInertia:400
    });
    */
    /********************************************************************/


})(jQuery);

