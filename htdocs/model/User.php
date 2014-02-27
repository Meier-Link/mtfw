<?php

class User implements Model
{
  private $u_id   = 0;
  private $u_name = 'guest';
  private $u_pwd  = '';
  private $u_mail = '';
  
  private static  $table_size = 1;
  
  // Attributs
  public function u_id($value = null)
  {
    return 0;
  }
  
  public function u_name($value = null)
  {
    return $this->u_name;
  }
  
  public function u_pwd($value = null)
  {
    return null;
  }
  
  public function u_mail($value = null)
  {
    
  }
  
  // @Implmented methods
  public static function table_size($force = false)
  {
    return self::$table_size;
  }
  
  public static function findAll($page_num = 1, $by_page = 0)
  {
    array(array(new User()), 1);
  }
  
  public static function findById($id)
  {
    if ($id != 1)
      return null;
    
    return new User();
  }
  
  public function save()
  {}
  
  public function delete()
  {}
  
  //@Specific methods
  public static function findByLoginPwd($uname, $upwd)
  {
    if ($uname == get_conf('adm') && $upwd == get_conf('pwd'))
      return new User();
    else
      return null;
  }
}
