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
    // The name of your website (displayed in html title
    'SITE_NAME'     => 'MyTinyFrameWork',
    // The displayed description on browser
    'SITE_DESC'     => 'A tiny framework for tiny websites',
    // Creator of this website
    'SITE_OWNER'    => 'Meier Link',
    // His mail address
    'OWNER_MAIL'    => 'lucian.von.ruthven@autistici.org',
    // Default address when web mail used without any address
    'DEFAULT_SEND'  => 'default@virtual.multiverse.cc',
    // A tag associated to mail title to make difference with your other mails (may be null)
    'MAIL_TAG'      => '[MTFW]',
    
    /* Database specific */
    'DB_PILOT'      => 'mysql',
    // Specific to sqlite
    'DB_PATH'       => null,
    'DB_SERV'       => 'localhost',
    'DB_NAME'       => 'mtfw',
    'DB_USER'       => 'mtfw_user',
    'DB_PASS'       => 'password',
    
    /* Admin access */
    'ADMIN'         => array('LOGIN' => 'root', 'PSSWD'  => 'password'), // Set PSWWD to null if you use db storage
    
    /* HTML template specific */
    'DEFAULT_CSS'   => array('includes/css/template.css'),
    'DEFAULT_JS'    => array()
  );
  
  public static function get($varname)
  {
    if (array_key_exists(strtoupper($varname), self::$conf))
      return self::$conf[$varname];
    else
      return null;
  }
}
