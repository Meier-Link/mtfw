<?php
/*
 *  Conf.php
 * 
 *  Copyright 2010 Meier Link <lucian.von.ruthven@autistici.org>
 *  
 *  This program is free software licensed under the Creative Commons Attribution-NonCommercial-ShareAlike 3.0 France License.
 *  To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-sa/3.0/fr/
 *  or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
 *
 *
 */

// Global configuration variables
class Conf
{
  private static $conf = array(
    /* General values */
    'SITE_NAME'   => 'MyTinyFrameWork',
    'SITE_DESC'   => 'A tiny framework for tiny websites',
    'SITE_OWNER'  => 'Meier Link',
    'OWNER_MAIL'  => 'lucian.von.ruthven@autistici.org',
    /* Database specific */
    'DB_PILOT'    => 'mysql',
    'DB_PATH'     => null,
    'DB_SERV'     => 'localhost',
    'DB_NAME'     => 'mtfw',
    'DB_USER'     => 'mtfw_user',
    'DB_PASS'     => 'password',
    /* Admin access */
    'ADMIN'       => array('LOGIN' => 'root', 'PSSWD'  => 'password'),
    /* HTML template specific */
    'DEFAULT_CSS' => array('includes/css/template.css'),
    'DEFAULT_JS'  => array()
  );
  
  public static function get($varname)
  {
    if (array_key_exists(strtoupper($varname), self::$conf))
      return self::$conf[$varname];
    else
      return null;
  }
}
