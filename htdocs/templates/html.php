<!--
    html.php
    
    Copyright 2010 Meier Link <jeremie.balagna@gmail.com>
    
    This program is free software licensed under the Creative Commons Attribution-NonCommercial-ShareAlike 3.0 France License.
    To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-sa/3.0/fr/
    or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
    
    
-->

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <title><?php echo Conf::get('SITE_NAME'); ?> :: <?php echo $controller->title; ?></title>
  <link type="image/x-icon" href="/includes/img/og-logo.ico" rel="shortcut icon">
  <meta name="og:title" content="MyTinyFrameWork : <?php echo $controller->title; ?>">
  <meta name="description" content="<?php echo $controller->desc(); ?>">
  <meta name="og:description" content="<?php echo $controller->desc(); ?>">
  <meta name="image" content="/includes/img/logo.png">
  <meta name="og:image" content="/includes/img/logo.png">
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <?php
  if (!empty($controller->html_head)) { echo $controller->html_head; }
  ?>
  <script type="text/javascript" src="/includes/js/jquery.js"></script>
  <?php
  foreach (Conf::get('DEFAULT_CSS') as $file)
  echo '<link href="/' . $file . '" rel="stylesheet" type="text/css" />';
  if (!empty($controller->custom_css))
  {
    ?><link href="<?php echo $controller->custom_css; ?>" rel="stylesheet" type="text/css" /><?php
  }
  ?>
</head>

<body>
  <div id="header">
    <h1>MyTinyFrameWork</h1>
    <div style="float:left; text-align:right; width:99%; margin-top:-84px">
      <!--
      <a href="/main/hl/fr"><img alt="fr" title="Français" src="/includes/img/hl/fr.png"/></a>&nbsp;
      <a href="/main/hl/en"><img alt="en" title="English" src="/includes/img/hl/en.png"/></a>
      -->
    </div>
    <div id="menu">
      <a class="menu" style="text-decoration:none" href="/index">Accueil</a>
    </div>
  </div>

  <div id="main">
    <div id="logs">
      <?php
        if (Log::isLogs())
          echo Log::toHTML();
      ?>
    </div>
    <?php
    echo $controller->ariane() . "<br/><hr/>";
    if (!file_exists($controller->relPath()))
      include("view/main/notfound.php");
    else
      include($controller->relPath()); 
    ?>
  </div>
  
  <div id="footer">
    <hr>
    <div style="width:1000px; float:left; text-align:center">
      Site en cours de développement
    </div>
    <hr/>
    <div id="licence_box" style="float: left; margin: 0 auto; width: 1000px;">
      <div style="float: left; width: 80px">
        <a href="/about/licence" rel="license">
          <img src="http://i.creativecommons.org/l/by-sa/2.0/fr/80x15.png" style="border-width: 0pt;" alt="Creative Commons License">
        </a>
      </div>
      <div style="float:left; width: 550px; margin-left: 10px;">
        <span style="">
          <i><?php echo Conf::get('SITE_NAME'); ?></i> by <?php echo Conf::get('SITE_OWNER'); ?><br/>
          <a rel="cc:morePermissions" href="/about/licence" xmlns:cc="http://creativecommons.org/ns#">Plus d'informations</a>
        </span>
      </div>
      <div style="float:left; margin: 2px;">
        <a style="text-decoration:none" href="/about/home" class="link">À propos</a>
      </div>
    </div>
  </div>
</body>
