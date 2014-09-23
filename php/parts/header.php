<!DOCTYPE HTML>
<html>
<head><meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$page_title?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/css/libs/normalize.css" rel="stylesheet">
    <link href="/css/parts/header.css" rel="stylesheet">
    <link href="/css/parts/template.css" rel="stylesheet">
    <link href="/css/pages/login.css" rel="stylesheet">
    <?
    if (isset($css_files)) {
        foreach($css_files as $css_file) { ?>
            <link href="<?=$css_file?>" rel="stylesheet">
        <? }
    }
    ?>
    <!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script-->
    <script src="/js/libs/tinymce/tinymce.min.js"></script>
    <script src="/js/libs/tinymce/langs/ru.js"></script>
    <script src="/js/libs/jquery.min.js"></script>
    
    <!--script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script-->
    <?
    if (isset($js_files)) {
        foreach($js_files as $js_file) { ?>
            <script src="<?=$js_file?>"></script>
        <? }
    } 
?>
</head>
<body><div class="background">
		<div class="main">
			<div class="header">
				<a class="header__logo" href="/">
					<img src="/img/logo.jpg">
				</a>
				<div class="header__title">
					<h2 class="header__site-name">ГБОУ школа № 643</h2>
					<span class="header__company-description">Официальный сайт ГБОУ школы № 643 Московского района Санкт-Петербурга</span>
				</div>
			</div>
