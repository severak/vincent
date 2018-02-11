<!doctype html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?=Flight::base(); ?>/st/css/pure/pure.css">
	<link rel="stylesheet" href="<?=Flight::base(); ?>/st/css/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="<?=Flight::base(); ?>/st/css/vincent.css">
	<meta property="og:title" content="<?php $title; ?>" />
	<script src="<?=Flight::base(); ?>/st/js/zepto.min.js"></script>
	<script src="<?=Flight::base(); ?>/st/js/medium-editor.min.js"></script>
	<link rel="stylesheet" href="<?=Flight::base(); ?>/st/css/medium-editor.min.css" type="text/css" media="screen" charset="utf-8">
	<link rel="stylesheet" href="<?=Flight::base(); ?>/st/css/themes/default.min.css" type="text/css" media="screen" charset="utf-8">
</head>
<body>
<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="<?=Flight::base();?>">Vincent</a>

			<?php if (!empty($menu)) { ?>
            <ul class="pure-menu-list">
			<?php foreach ($menu as $link=>$title) { ?>
                <li class="pure-menu-item"><a href="<?=Flight::base() . $link;?>" class="pure-menu-link"><?=$title; ?></a></li>
            <?php } ?>
			</ul>
			<?php } ?>
        </div>
    </div>

    <div id="main">
<?php if (!empty($_SESSION['flash'])) {
	while ($message = array_shift($_SESSION['flash'])) {
		echo '<div class="kyselo-message kyselo-message-'.$message['class'].'">'.htmlspecialchars($message['msg']).'</div>';
	}
}	
	