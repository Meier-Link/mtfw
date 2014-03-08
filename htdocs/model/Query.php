<?php

class Query/* implements Model*/
{
  public static function send($query)
  {
    $db = DbConnect::getInstance();
    return $db->query($query, null, null, true);
  }
}
