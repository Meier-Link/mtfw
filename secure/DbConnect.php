<?php
/*
 *  DbConnect.php
 *
 *  Copyright 2014 Jeremie aka Meier Link <jeremie.balagna@autistici.org>
 *  
 *  This program is free software licensed under the Creative Commons Attribution-NonCommercial-ShareAlike 3.0 France License.
 *  To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-sa/3.0/fr/
 *  or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
 *
 *
 */

/**
 * DbConnect
 *  Singleton specific to manage MySQL or SQLite database access
 */
class DbConnect
{
  private static $instance = null;
  private $db = null;

  private function __construct()
  {
    global $conf;
    $dsn = "";
    if (Conf::get('DB_PILOT') == 'sqlite')
      $dsn .= Conf::get('DB_PILOT') . ':.' . Conf::get('DB_PATH') . '/' . Conf::get('DB_NAME');
    else
      $dsn  = Conf::get('DB_PILOT') . ':dbname=' . Conf::get('DB_NAME') . ';host=' . Conf::get('DB_SERV');
    if ($dsn == "")
    {
      Log::err('Unable to create a DB connection. Please check the website configuration !!!');
      return false;
    }
    $user = Conf::get('DB_USER');
    $pass = Conf::get('DB_PASS');
    try
    {
      $this->db = new PDO($dsn, $user, $pass);
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
      Log::err('Connection failed: <br/> ' . $e->getMessage ());
    }
  }

  public static function getInstance()
  {
    if (self::$instance == null)
      self::$instance = new DbConnect();

    return (self::$instance);
  }
  
  public function printDB()
  {
    var_dump($this->db);
  }
  
  private function someError($result)
  {
    $errors = $result->errorInfo();
    if($errors[0] != '00000')
    {
      ob_start();
      echo $result->debugDumpParams();
      $logs = ob_get_contents();
      Log::err("SQL error: " . $errors[2] . ".<br/>Query: " . $logs);
      ob_end_clean();
      //Log::err("Code erreur SQLSTATE : ".$errors[0]."<br/>Code erreur driver SQL : ".$errors[1]."<br/>Erreur SQL : ".$errors[2]."<br/>");
      ob_start();
      debug_print_backtrace();
      $logs = ob_get_contents();
      ob_end_clean();
      Log::dbg($logs);
      return true;
    }
    return false;
  }

  public function query($query, $classname = null, $params = null, $avoid_inlining = false)
  {
    if ($this->db == null)
    {
      Log::err("Not connected to database !");
      return null;
    }
    
    $prepare_opt = array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY);
    if (is_null($params))
      $prepare_opt = array();
    
    try
    {
      $result = $this->db->prepare($query, $prepare_opt);
      if ($result)
      {
        if (is_null($params))
          $result->execute();
        else
          $result->execute($params);
        if ($this->someError($result)) return null;
      }
      else
      {
        Log::err('Unable to send the query, result preparation return "false"');
        return null;
      }
    }
    catch(PDOException $e)
    {
      Log::err($e->getMessage());
      return null;
    }
    
    if (!is_null($classname))
      $return = $result->fetchAll(PDO::FETCH_CLASS, $classname);
    else
      $return = $result->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($return) == 0)
      return null;
    
    if ((count($return) == 1) && (!$avoid_inlining))
      $return = $return[0];
    $result->closeCursor(); // XXX @ controller

    return $return;
  }
}
