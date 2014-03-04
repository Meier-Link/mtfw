<?php
/*
 *  index.php
 *  
 *  Copyright 2014 Jeremie aka Meier Link <jeremie.balagna@autistici.org>
 *  
 *  This program is free software licensed under the Creative Commons Attribution-NonCommercial-ShareAlike 3.0 France License.
 *  To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-sa/3.0/fr/
 *  or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
 *
 *
 */

session_start();

// Change this if you want to change code organization
$SECURE_PATH = "../secure/";

require_once($SECURE_PATH . 'Conf.php');

function __autoload($classname)
{
  global $SECURE_PATH;
  if (file_exists("controller/$classname.php"))
    include_once("controller/$classname.php");
  else if (file_exists("model/$classname.php"))
    include_once("model/$classname.php");
  else if ($classname == "DbConnect")
    include_once($SECURE_PATH . "DbConnect.php");
  else if ($classname == "Log")
    include_once($SECURE_PATH . "Log.php");
  else if ($classname == "StdTools")
    include_once($SECURE_PATH . "StdTools.php");
}

$controller = Controller::init();

require_once("templates/" . $controller->template() . ".php");
