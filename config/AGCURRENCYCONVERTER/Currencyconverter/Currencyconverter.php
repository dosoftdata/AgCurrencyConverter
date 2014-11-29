<?php

namespace AGCURRENCYCONVERTER\Currencyconverter;

use AGCURRENCYCONVERTER\Db\DatabaseHandler;

class Currencyconverter {

    // Private constructor to prevent direct creation of object
    private function __construct() {
        
    }
    public static function sql_load_currency_default() {
       $sql = 'CALL sql_load_currency_default()';
      return $result = DatabaseHandler::GetAll($sql);
    }
     public static function sql_load_currency_all(){
       $sql = 'CALL sql_load_currency_all()';
      return $result = DatabaseHandler::GetAll($sql);
    }

}
