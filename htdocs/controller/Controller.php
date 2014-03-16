<?php
/*
 *  Controller.php
 *  
 *  Copyright 2014 Jeremie aka Meier Link <jeremie.balagna@autistici.org>
 *  
 *  This program is free software licensed under the Creative Commons Attribution-NonCommercial-ShareAlike 3.0 France License.
 *  To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-sa/3.0/fr/
 *  or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
 *
 *
 */

class Controller extends StdTools
{
  private $_template      = 'html';
  private $_desc          = '';
  private $_default_home  = '/main/home';
  private $_css           = array();
  private $_js            = array();
  public $query_string  = '/index';
  public $params      = array();
  public $query       = '';
  public $action      = '';
  public $paginate    = 1;
  public $data        = array();
  public $main        = '';
  public $logs        = '';
  public $title       = 'Home';
  public $path        = "";
  public $ariane_file = "";
  public $html_head   = "";
  
  public static function init()
  {
    if (!isset($_SESSION['hl']) || is_null($_SESSION['hl']))
    { // set language to default
      $_SESSION['hl'] = 'fr';
    }
    
    if ($_SERVER['QUERY_STRING'] == "/" OR $_SERVER['QUERY_STRING'] == "/index" OR $_SERVER['QUERY_STRING'] == "")
      $referer = '/main';
    else
      $referer = $_SERVER['QUERY_STRING'];
    
    $params = explode("/", $referer, 5);
    
    if (count($params) <= 2 || $params['2'] == '')
      $params[2] = 'home';
    
    if (preg_match('#^[A-Za-z]$#', $params[1]))
    {
      $params[1] = "main";
      $params[2] = "home";
    }
    
    if (isset($params[3]) && $params[3] != '')
      $query = $params[2];
    else
      $query = 0;
    
    if ($params[2] != 'hl')
      $_SESSION['referer'] = $referer;
    
    $controller_name = ucwords($params[1]);
    
    $action = $params[2];
    // check if this class exists ...
    if (!file_exists('controller/' . $controller_name . '.php'))
    {
      $controller_name = "Main";
      $action = "notfound";
      Log::err("La section (" . $controller_name . ") demandée n'existe pas");
    }
    $mycontroller = new $controller_name();
    //$mycontroller->logs = new Log();
    
    $mycontroller->params       = $params;
    $mycontroller->query        = $params[2];
    $mycontroller->action       = $action;
    $mycontroller->query_string = $referer;
    if (isset($params[3]) && is_numeric($params[3]))
      $mycontroller->paginate = $params[3];
    
    // Hook system
    $mycontroller->hook();
    $action = $mycontroller->action;
    
    if (!method_exists($mycontroller, $action))
    {
      header("http://" . $_SERVER['SERVER_NAME'] . "/home/notfound");
      $params[1] = "main";
      $action = "notfound";
    }
    $mycontroller->$action();
    
    return $mycontroller;
  }
  
  public function notfound()
  {
    $this->path = "/main/notfound";
    $this->title = "Page not found";
    $this->ariane_file = "home";
  }

  public function forbidden()
  {
    $this->path = "/main/forbidden";
    $this->title = "Forbidden access";
    $this->ariane_file = "home";
  }
  
  public function relPath()
  {
    if ($this->path != "")
      return "view" . $this->path . ".php";
    return "view/" . strtolower(get_class($this)) . "/" . $this->action . ".php";
  }
  
  public function ariane()
  {
    $fol_name = strtolower(get_class($this));
    if ($this->ariane_file != "")
      $fil_name = $this->ariane_file;
    else
      $fil_name = $this->action;
    $ariane = "<a href='/$fol_name/home'>$fol_name</a>";
    if ($fil_name != "home")
      $ariane .= " :: <a href='/$fol_name/$fil_name/'>$fil_name</a>";
    else
      $ariane .= " :: home";
      
    return $ariane;
  }
  
  public function hl()
  {
    if ($this->params[3] != null)
    {
      if ($this->params[3] == "fr")
      { // select french
        $_SESSION['hl'] = 'fr';
      }
      else if ($this->params[3] == "en")
      { // select english
        $_SESSION['hl'] = 'en';
      }
      else if ($this->params[3] == "jp")
      { // select japanese
        $_SESSION['hl'] = 'jp';
      }
      else
      { // unknow language
        // XXX
      }
      header("http://" . $_SERVER['SERVER_NAME'] . $_SESSION['referer']);
    }
    $translations = StaticContent::findByLanguage($_SESSION['hl']);
    if (is_null($translations)) $translations = array();
    foreach ($translations as $trans)
    {
      $_SESSION['static'][$trans->sc_title()] = $trans->sc_content();
    }
  }

  public function template($template = null)
  {
    if ($template != null && file_exists("templates/$template.php"))
      $this->_template = $template;
    return $this->_template;
  } 

  public function desc($desc = null)
  {
    if (!is_null($desc))
      $this->_desc = $desc;
    if (!is_null($this->_desc))
      return $this->_desc;
    return Conf::get('SITE_DESC');
  } 
  
  public function hook()
  {
    // implement this method to hook normal run of 'init'
  }
  
  public function getHl()
  {
    if (isset($_SESSION['hl']) && !empty($_SESSION['hl']))
      return $_SESSION['hl'];
    else
      return "fr";
  }

  public function isEnable()
  {
    if (isset($_SESSION['user']))
    {
      if (is_null($_SESSION['user']) || empty($_SESSION['user']))
        return false;
    }
    else
    {
      $_SESSION['user'] = null;
      return false;
    }
    return true;
  }
  
  /**
   * isAdmin()
   *  Check if the current user is the website admin
   */
  public function isAdmin()
  {
    if (!isset($_SESSION['user']))
      $_SESSION['user'] = null;
    if (is_null($_SESSION['user']))
      return false;
    
    if ($_SESSION['user']->u_name() == Conf::get('ADMIN')['LOGIN'])
      return true;
    return false;
  }
  
  public function login()
  {
    if (isset($_POST['log']))
    {
      $loginfos = $_POST['log'];
      $err = false;
      
      if (!isset($loginfos['captcha']) || !$this->isValidCaptcha($loginfos['captcha']))
      {
        Log::err("Captcha invalide !");
      }
      else
      {
        if (!isset($loginfos['name']))
        {
          Log::err("Login undefined !");
          $err = true;
        }
        if (!isset($loginfos['pwd']))
        {
          Log::err("Password undefined !");
          $err = true;
        }
        
        if (!$err)
        {
        
          $_SESSION['user'] = User::findByLoginPwd($loginfos['name'], $loginfos['pwd']);
          
          if ($_SESSION['user'] != null)
            Log::inf("Vous êtes connecté !");
          else
            Log::err("Login and/or password invalid");
        }
      }
    }
    
    if (isset($_SESSION['user']) && !is_null($_SESSION['user']))
    {
      $this->path = $this->_default_home;
      $this->home();
      $this->ariane_file = "home";
    }
  }
  
  public function logout()
  {
    $_SESSION['user'] = null;
    Log::inf('Vous avez bien été déconnecté');
    $this->path = $this->_default_home;
    $this->home();
    $this->ariane_file = "home";
  }
  
  protected function setJsFiles($files)
  {
    if (is_array($files))
    {
      foreach($files as $file)
      {
        $this->_js[] = $file;
      }
    }
    else
    {
      $this->_js[] = $files;
    }
  }
  
  protected function setCssFiles($files)
  {
    if (is_array($files))
    {
      foreach($files as $file)
      {
        $this->_css[] = $file;
      }
    }
    else
    {
      $this->_css[] = $files;
    }
  }
  
  public function getJsFiles()
  {
    $r = array();
    
    foreach(Conf::get('DEFAULT_JS') as $file)
    {
      $r[] = '/includes/js/' . $file;
    }
    
    foreach($this->_js as $file)
    {
      $r[] = '/includes/js/' . $file;
    }
    
    return $r;
  }
  
  public function getCssFiles()
  {
    $r = array();
    
    foreach(Conf::get('DEFAULT_CSS') as $file)
    {
      $r[] = 'includes/css/' . $file;
    }
    
    foreach($this->_js as $file)
    {
      $r[] = 'includes/css/' . $file;
    }
    
    return $r;
  }
}
