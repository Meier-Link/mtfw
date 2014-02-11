<?php
/*
 *      index.php
 *      
 *      Copyright 2010 Meier Link <jeremie.balagna@gmail.com>
 *      
 *      This program is free software licensed under the Creative Commons Attribution-NonCommercial-ShareAlike 3.0 France License.
 *      To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-sa/3.0/fr/
 *      or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
 *
 *
 */

session_start();

require_once('../secure/Conf.php');

function __autoload($classname)
{
  if (file_exists("controller/$classname.php"))
    include_once("controller/$classname.php");
  else if (file_exists("model/$classname.php"))
    include_once("model/$classname.php");
  else if ($classname == "DbConnect")
    include_once("../secure/DbConnect.php");
  else if ($classname == "Log")
    include_once("../secure/Log.php");
  else if ($classname == "StdTools")
    include_once("../secure/StdTools.php");
}

$controller = Controller::init();

require_once("templates/" . $controller->template() . ".php");
