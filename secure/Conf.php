<?php
/*
 * Conf.php
 * 
 * Copyright 2013 Jérémie Balagna-Ranin <jeremie.br@fr.ibm.com>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
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
