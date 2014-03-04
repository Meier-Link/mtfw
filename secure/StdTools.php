<?php
/*
 *  StdTools.php
 *  
 *  Copyright 2010 Meier Link <lucian.von.ruthven@autistici.org>
 *  
 *  This program is free software licensed under the Creative Commons Attribution-NonCommercial-ShareAlike 3.0 France License.
 *  To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-sa/3.0/fr/
 *  or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
 *
 *
 */

/**
 * StdTools
 *  Provide some basic tools for controllers
 */
class StdTools
{
  public function tr($field = null)
  {
    if (is_null($field)) return "";
    
    if (is_null($_SESSION['hl']))
      $_SESSION['hl'] = 'fr';
    
    if (is_null($_SESSION['static']))
      $_SESSION['static'] = array();
    
    if (array_key_exists($field, $_SESSION['static']) && $_SESSION['static'][$field] != $field)
    {
      return $_SESSION['static'][$field];
    }
    else
    {
      $tr = StaticContent::findByTitleLanguage($field, $_SESSION['hl']);
      if (is_null($tr))
      {
        if ($_SESSION['hl'] == 'fr') // if translation not found and language == fr
        {
          //$_SESSION['static'][$field] = $field;
          return $field;
        }
        else // if translation not found and language != fr, get Fr translation
        {
          $tr = StaticContent::findByTitleLanguage($field);
          if (is_null($tr)) // if translation not found again ...
          {
            //$_SESSION['static'][$field] = $field;
            return $field;
          }
          else
          {
            $_SESSION['static'][$field] = $tr->sc_content();
          }
        }
      }
      else
      {
        $_SESSION['static'][$field] = $tr->sc_content();
      }
      return $_SESSION['static'][$field];
    }
  }

  public function sendJSON($data)
  {
    header('Content-Type: application/json; charset=utf8');
    header('Access-Control-Allow-Origin: http://dashboard.localhost.net/');
    header('Access-Control-Max-Age: 3600');
    header('Access-Control-Allow-Methods: POST');
    
    echo '( ' . json_encode($data) . ');';
  }
  
  public function genCaptchaCode()
  {
    $charset = 'ABCDEFGHKLMNPRSTUVWYZabcdefhkmnprstuvwyz2345678';

    $captcha = "";
    $_SESSION['captcha'] = "";
    for ($i = 0; $i < 6; $i++)
    {
      $char_pos = rand(0, strlen($charset) - 1);
      $captcha .= $charset[$char_pos];
    }
    $_SESSION['captcha'] = $captcha;
  }
  
  public function isValidCaptcha($code)
  {
    if (!is_null($_SESSION['captcha']) && $_SESSION['captcha'] == $code)
      return true;
    else
      return false;
  }
  
  public function sqlDateToHuman($sql_date)
  {
    if (is_null($sql_date))
      return null;
    
    list($ymd, $his) = split(' ', $sql_date);
    list($y, $m, $d) = split('-', $ymd);
    
    if (is_null($his))
      list($h, $i, $s) = array(null, null, null);
    else
      list($h, $i, $s) = split(':', $his);
    
    if (isset($_SESSION['hl']))
      $hl = $_SESSION['hl'];
    else
      $hl = 'fr';
    
    switch($hl)
    {
      case 'en':
        if ($his != null)
          return "$m-$d-$y at " . $h . ":" . $i;
        else
          return "$m-$d-$y";
        break;
      case 'jp':
        if ($his != null)
          return $y . "年" . $m . "月" . $d . "日 " . $h . "時" . $i . "分";
        else
          return $y . "年" . $m . "月" . $d . "日 ";
        break;
      default:
        if ($his != null)
          return "$d/$m/$y à " . $h . "h " . $i . "m";
        else
          return "$d/$m/$y";
    }
  }
  
  public function titleToURL($title)
  {
    $reserved = array(' ', '!', '?', '$', '&', '+', '/', ';', ':', '=', '@');
    $replace  = array('_', '', '', '', '', '', '', '', '', '', '(at)');
    return trim(str_replace($reserved, $replace, $title), '_');
  }
}
