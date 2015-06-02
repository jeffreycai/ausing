<!DOCTYPE html>
<!--[if IEMobile 7]><html class="iem7"  lang="<?php echo get_language(); ?>" dir="ltr"><![endif]-->
<!--[if lte IE 6]><html class="lt-ie9 lt-ie8 lt-ie7"  lang="<?php echo get_language(); ?>" dir="ltr"><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="lt-ie9 lt-ie8"  lang="<?php echo get_language(); ?>" dir="ltr"><![endif]-->
<!--[if IE 8]><html class="lt-ie9"  lang="<?php echo get_language(); ?>" dir="ltr"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)]><!--><html lang="<?php echo get_language(); ?>" dir="ltr"><!--<![endif]-->

<head profile="http://www.w3.org/1999/xhtml/vocab">
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
<link rel="shortcut icon" href="<?php echo uri('favicon/favicon.ico?v=2', false) ?>" />
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo uri('favicon/apple-touch-icon-57x57.png', false) ?>" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo uri('favicon/apple-touch-icon-114x114.png', false) ?>" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo uri('favicon/apple-touch-icon-72x72.png', false) ?>" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo uri('favicon/apple-touch-icon-144x144.png', false) ?>" />
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="<?php echo uri('favicon/apple-touch-icon-60x60.png', false) ?>" />
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo uri('favicon/apple-touch-icon-120x120.png', false) ?>" />
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo uri('favicon/apple-touch-icon-76x76.png', false) ?>" />
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo uri('favicon/apple-touch-icon-152x152.png', false) ?>" />
<link rel="icon" type="image/png" href="<?php echo uri('favicon/favicon-196x196.png', false) ?>" sizes="196x196" />
<link rel="icon" type="image/png" href="<?php echo uri('favicon/favicon-96x96.png', false) ?>" sizes="96x96" />
<link rel="icon" type="image/png" href="<?php echo uri('favicon/favicon-64x64.png', false) ?>" sizes="64x64" />
<link rel="icon" type="image/png" href="<?php echo uri('favicon/favicon-48x48.png', false) ?>" sizes="48x48" />
<link rel="icon" type="image/png" href="<?php echo uri('favicon/favicon-32x32.png', false) ?>" sizes="32x32" />
<link rel="icon" type="image/png" href="<?php echo uri('favicon/favicon-24x24.png', false) ?>" sizes="24x24" />
<link rel="icon" type="image/png" href="<?php echo uri('favicon/favicon-16x16.png', false) ?>" sizes="16x16" />
<link rel="icon" type="image/png" href="<?php echo uri('favicon/favicon-128x128.png', false) ?>" sizes="128x128" />
<meta name="msapplication-square70x70logo" content="<?php echo uri('favicon/mstile-70x70.png', false) ?>" />
<meta name="msapplication-square150x150logo" content="<?php echo uri('favicon/mstile-150x150.png', false) ?>" />
<meta name="msapplication-wide310x150logo" content="<?php echo uri('favicon/mstile-310x150.png', false) ?>" />
<meta name="msapplication-square310x310logo" content="<?php echo uri('favicon/mstile-310x310.png', false) ?>" />
<meta name="application-name" content="<?php echo $settings['sitename'] ?>"/>
<meta name="msapplication-TileColor" content="#ffffff"/>


  <title><?php echo isset($title) ? $title : ''; ?></title>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<?php HTML::renderOutHeaderUpperRegistry(); ?>  
<?php Asset::printTopAssets('frontend'); ?>
<?php HTML::renderOutHeaderLowerRegistry(); ?>
  
</head>

<body class="<?php if (isset($body_class)) {echo $body_class; }?>">

