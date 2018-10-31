<?php
			$mobile_detect = new Mobile_Detect();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">

<link rel="icon" type="image/x-icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />

<title><?php echo wp_title( '' ); ?></title>

<meta name="description" content="<?php _e( 'Encuentre la casa de sus sueños en las mejores promociones de la Costa del Sol', 'flaats' ); ?>">

<link href="<?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo get_stylesheet_directory_uri(); ?>/css/jquery-ui.min.css" rel="stylesheet">
<link href="<?php echo get_stylesheet_directory_uri(); ?>/style.css" rel="stylesheet">
<link href="<?php echo get_stylesheet_directory_uri(); ?>/css/font-awesome.min.css" rel="stylesheet">

<link href="<?php echo get_stylesheet_directory_uri(); ?>/css/aos.min.css" rel="stylesheet">
<link href="<?php echo get_stylesheet_directory_uri(); ?>/css/rangeslider.min.css" rel="stylesheet">
<link href="<?php echo get_stylesheet_directory_uri(); ?>/css/owl.carousel.min.css" rel="stylesheet">
<link href="<?php echo get_stylesheet_directory_uri(); ?>/css/owl.theme.min.css" rel="stylesheet">
<link href="<?php echo get_stylesheet_directory_uri(); ?>/css/selectric.min.css" rel="stylesheet" id="theme">
<link href="<?php echo get_stylesheet_directory_uri(); ?>/css/mapa.min.css" rel="stylesheet" id="theme">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">


<link href="<?php echo get_stylesheet_directory_uri(); ?>/css/addon.min.css?v=<?php echo Flaats_Definitions::$scripts_version; ?>" rel="stylesheet">
<link href="<?php echo get_stylesheet_directory_uri(); ?>/style-be.css?v=<?php echo Flaats_Definitions::$scripts_version; ?>" rel="stylesheet">

 <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

<?php wp_head(); ?>

<style>
  @font-face{font-family:'FreeSans';src:url(<?php echo get_stylesheet_directory_uri(); ?>/fonts/FreeSans.eot?#iefix) format("embedded-opentype"),url(<?php echo get_stylesheet_directory_uri(); ?>/fonts/FreeSans.woff) format("woff"),url(<?php echo get_stylesheet_directory_uri(); ?>/fonts/FreeSans.ttf) format("truetype"),url(<?php echo get_stylesheet_directory_uri(); ?>/fonts/FreeSans.svg#FreeSans) format("svg");font-weight:400;font-style:normal}
  @font-face{font-family:'FreeSansBold';src:url(<?php echo get_stylesheet_directory_uri(); ?>/fonts/FreeSansBold.eot?#iefix) format("embedded-opentype"),url(<?php echo get_stylesheet_directory_uri(); ?>/fonts/FreeSansBold.woff) format("woff"),url(<?php echo get_stylesheet_directory_uri(); ?>/fonts/FreeSansBold.ttf) format("truetype"),url(<?php echo get_stylesheet_directory_uri(); ?>/fonts/FreeSansBold.svg#FreeSansBold) format("svg");font-weight:400;font-style:normal}

</style>


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-118613181-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-118613181-1');
</script>

<script>
  (function($) {
    $(document).ready(function() {
      $('.tabs').fadeIn();
      $('.listmenu').fadeIn();
    });
  })(jQuery);

</script>

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '232825934000981');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=232825934000981&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

</head>

<body <?php body_class(); ?>>


<section class="header">
	<div class="container">
    <a href="<?php echo pll_home_url(); ?>">
      <div class="logo">
        <?php if( is_front_page() ) $tag = 'h1'; else $tag = 'h2'; ?>
        <<?php echo $tag?>><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo-dreamhomes.png" alt="logo" /><span class="notranslate">dream<em>homes</em></span></<?php echo $tag?>>
      </div>
    </a>
    <div class="mainnav clearfix">
     <div class="top_div clearfix">

        <?php if( !$mobile_detect->isMobile() ) { ?>
          <?php Flaats_Functions::render_popup_favorites(); ?>
          <div class="search"><a id="popup-footer" href="javascript:void(0);"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon-eye2.png" alt="search"></a></div>
        <?php } ?>

        <div class="esp">

            <!-- GTranslate: https://gtranslate.io/ -->
            <!--<a href="#" onclick="doGTranslate('<?php echo pll_current_language(); ?>|es');document.location='https://www.dreamhomes.es/es';return false;" title="Spanish" class="glink nturl notranslate"><img src="//www.dreamhomes.es/wp-content/plugins/gtranslate/flags/24/es.png" height="24" width="24" alt="Spanish" /></a>
            <a href="#" onclick="doGTranslate('<?php echo pll_current_language(); ?>|en');document.location='https://www.dreamhomes.es/';return false;" title="English" class="glink nturl notranslate"><img src="//www.dreamhomes.es/wp-content/plugins/gtranslate/flags/24/en.png" height="24" width="24" alt="English" /></a>-->

            <a href="#" onclick="deleteGTCookie();document.location='https://www.dreamhomes.es/es';return false" title="Spanish" class="glink nturl notranslate"><img src="//www.dreamhomes.es/wp-content/plugins/gtranslate/flags/24/es.png" height="24" width="24" alt="Spanish" /></a>
            <a href="#" onclick="deleteGTCookie();document.location='https://www.dreamhomes.es/';return false" title="English" class="glink nturl notranslate"><img src="//www.dreamhomes.es/wp-content/plugins/gtranslate/flags/24/en.png" height="24" width="24" alt="English" /></a>

            <a href="#" onclick="doGTranslate('<?php echo pll_current_language(); ?>|fr');return false;" title="French" class="glink nturl notranslate"><img src="//www.dreamhomes.es/wp-content/plugins/gtranslate/flags/24/fr.png" height="24" width="24" alt="French" /></a>
            <a href="#" onclick="doGTranslate('<?php echo pll_current_language(); ?>|de');return false;" title="German" class="glink nturl notranslate"><img src="//www.dreamhomes.es/wp-content/plugins/gtranslate/flags/24/de.png" height="24" width="24" alt="German" /></a>
            <a href="#" onclick="doGTranslate('<?php echo pll_current_language(); ?>|sv');return false;" title="Swedish" class="glink nturl notranslate"><img src="//www.dreamhomes.es/wp-content/plugins/gtranslate/flags/24/sv.png" height="24" width="24" alt="Swedish" /></a>
            <a href="#" onclick="doGTranslate('<?php echo pll_current_language(); ?>|no');return false;" title="Norwegian" class="glink nturl notranslate"><img src="//www.dreamhomes.es/wp-content/plugins/gtranslate/flags/24/no.png" height="24" width="24" alt="Norwegian" /></a>
            <a href="#" onclick="doGTranslate('<?php echo pll_current_language(); ?>|ru');return false;" title="Russian" class="glink nturl notranslate"><img src="//www.dreamhomes.es/wp-content/plugins/gtranslate/flags/24/ru.png" height="24" width="24" alt="Russian" /></a>

            <style type="text/css">
            #goog-gt-tt {display:none !important;}
            .goog-te-banner-frame {display:none !important;}
            .goog-te-menu-value:hover {text-decoration:none !important;}
            .goog-text-highlight {background-color:transparent !important;box-shadow:none !important;}
            body {top:0 !important;}
            #google_translate_element2 {display:none!important;}
            </style>

            <div id="google_translate_element2"></div>
            <script type="text/javascript">
            function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: '<?php echo pll_current_language(); ?>',autoDisplay: false}, 'google_translate_element2');}
            </script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>


            <script type="text/javascript">
            function GTranslateGetCurrentLang() {var keyValue = document['cookie'].match('(^|;) ?googtrans=([^;]*)(;|$)');return keyValue ? keyValue[2].split('/')[2] : null;}
            function GTranslateFireEvent(element,event){try{if(document.createEventObject){var evt=document.createEventObject();element.fireEvent('on'+event,evt)}else{var evt=document.createEvent('HTMLEvents');evt.initEvent(event,true,true);element.dispatchEvent(evt)}}catch(e){}}
            function doGTranslate(lang_pair){if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];if(GTranslateGetCurrentLang() == null && lang == lang_pair.split('|')[0])return;var teCombo;var sel=document.getElementsByTagName('select');for(var i=0;i<sel.length;i++)if(/goog-te-combo/.test(sel[i].className)){teCombo=sel[i];break;}if(document.getElementById('google_translate_element2')==null||document.getElementById('google_translate_element2').innerHTML.length==0||teCombo.length==0||teCombo.innerHTML.length==0){setTimeout(function(){doGTranslate(lang_pair)},500)}else{teCombo.value=lang;GTranslateFireEvent(teCombo,'change');GTranslateFireEvent(teCombo,'change')}}

                function deleteGTCookie() {
                  setCookie("googtrans", "", 0, "/", ".dreamhomes.es");
                  setCookie("googtrans", "", 0, "/");
                }
                function setCookie(b, h, c, f, e) {
                    var a;
                    if (c === 0) {
                        a = ""
                    } else {
                        var g = new Date();
                        g.setTime(g.getTime() + (c * 24 * 60 * 60 * 1000));
                        a = "expires=" + g.toGMTString() + "; "
                    }
                    var e = (typeof e === "undefined") ? "" : "; domain=" + e;
                    document.cookie = b + "=" + h + "; " + a + "path=" + f + e
                }

            </script>


          <!--
        	<select id="esp_value">
              <option value="ES" <?php if( 'es' == pll_current_language() ) echo 'selected'; ?> data-imagesrc="<?php echo get_stylesheet_directory_uri(); ?>/images/flag-es.png" data-description="">ES</option>
              <option value="EN" <?php if( 'en' == pll_current_language() ) echo 'selected'; ?> data-imagesrc="<?php echo get_stylesheet_directory_uri(); ?>/images/flag-en.png" data-description="">EN</option>
          </select>
        -->
        </div>

     </div>

    <button class="menu-button"></button>
    <div class="mobile_primary">
      <?php wp_nav_menu( array( 'theme_location' => 'headermenu', 'menu_id' => 'menu-main-navigation-1' ) ); ?>
    </div>
  </div>
</div>
</section>




