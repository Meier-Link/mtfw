<?php
/*
 *      Model.php
 *
 *      Copyright 2012 Meier Link <jeremie.balagna@gmail.com>
 *
 *      This program is free software licensed under the Creative Commons Attribution-NonCommercial-ShareAlike 3.0 France License.
 *      To view a copy of this license, visit http://creativecommons.org/licenses/by-nc-sa/3.0/fr/
 *      or send a letter to Creative Commons, 444 Castro Street, Suite 900, Mountain View, California, 94041, USA.
 *
 *
 */

interface Model
{
  /*
   * @func table_size
   * @desc static method who set (if necessary) and return size of the table
   **/
  public static function table_size($force = false);
  /*
   * @func findAll
   * @desc static method who return all fields of DB Table to an array of object
   **/
  public static function findAll($page_num = 1, $by_page = 0);

  /*
   * @func findById
   * @desc static method who return a field of DB Table selected by it's id to an object
   * @params $id
   **/
  public static function findById($id);

  /*
   * @func save
   * @desc method who provide a simple method to update or create an entry on DB Table from current object
   **/
  public function save($force = true);

  /*
   * @func delete
   * @desc a simple method designed to delete the current object from DB Table. Note that object already exist after call to delete()
   **/
  public function delete();
}
