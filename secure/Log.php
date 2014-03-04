<?php
/*
 *  Log.php
 *  
 *  Copyright 2014 Jeremie aka Meier Link <jeremie.balagna@autistici.org>
 *  
 *  This program is free software licensed under the Creative Commons Attribution-NonCommercial-ShareAlike 3.0 France License.
 *  To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-sa/3.0/fr/
 *  or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
 *
 *
 */

class Log {
  private static $logs = array();
  
  public static function isLogs()
  {
    
    return !empty(self::$logs);
  }
  
  public static function inf($data)
  {
    self::$logs[] = array('level' => 'info', 'log' => $data);
  }
  
  public static function war($data)
  {
    self::$logs[] = array('level' => 'warn', 'log' => $data);
  }
  
  public static function err($data)
  {
    self::$logs[] = array('level' => 'err', 'log' => $data);
  }
  
  public static function dbg($data)
  {
    self::$logs[] = array('level' => 'debug', 'log' => "<pre>" . $data . "</pre>");
  }
  
  public static function toHTML()
  {
    $html = '';
    foreach (self::$logs as $log) {
      $html .= "<div class='".$log['level']."'>".$log['log']."</div>";
    }
    return $html;
  }
  
  public static function getAll()
  {
    return self::$logs;
  }
  
  public static function purge()
  {
    self::$logs = array();
  }
}
