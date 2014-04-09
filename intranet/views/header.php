<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>K/R +P | Intranet</title>
        <meta charset="UTF-8"> 
        <meta property="og:site_name" content="" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <meta name="author" content="" />

        <link rel="shortcut icon" href="<?php echo URL; ?>../favicon.png" Content-type="image/x-icon" />
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/style.css" />
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/zebra_form.css" />
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/jquery.Jcrop.css" />
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/HTML5Upload.css" />
<!--        <link rel="stylesheet" href="<?php //echo URL; ?>public/css/file-upload.css" />-->
        <!-- <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/sunny/jquery-ui.css" />-->
       
    </head>
    <body>
        <?php Session::init();
        $strNoCache = "?nocache=".time();
        ?>
            <header>
                <div class="header_logo">
                    <div class="wrapper">
                        <a href="<?=URL ; ?>/"><div id="logo"><img src="<?=URL?>/public/img/logo.png"></div></a>
                    <div class="header_login"><a onClick="location.href = '<?= URL  . '/users/editCreateUser/' . Session::get('userid'); ?>'">My account</a> | <a onClick="location.href = '<?= URL . 'users/out'; ?>'">Logout</a></div>
                  
                    </div>
                </div> 
                <nav class="header_menu" id="sidebarnav">
                    <div class="wrapper">
                    <ul id="menuNav">
                        <li><a href="<?= URL  ?>bg">bg</a></li>
                        <li><a href="<?= URL  ?>works">works</a></li>
                        <li><a href="<?= URL  ?>archive">archive</a></li>
                        <? if (Session::get('role') == 3) { ?><li><a href="<?php echo URL ; ?>users/lista">users</a></li><? } ?>
                        <? if (Session::get('role') == 3) { ?><li><a href="<?php echo URL ; ?>log/lista">log</a></li><? } ?>
                    </ul>
                    </div>
                </nav>
                <div class="header_shadow"></div>
            
            </header>
        <div id="wrapper">
            
            <div id="mainarea">
                <div class="white_full hide" id="white_full" onclick="$('.hide').css('display', 'none')"></div>
                <div id="container">

