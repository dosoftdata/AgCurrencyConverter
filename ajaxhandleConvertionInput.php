<?php
/**
 * @author : CMU
 * @tutorial:used 'Currency Convertio php/ajax AND Add more Currency Rate'  
 */
 require_once 'config/libs.inc';
use  AGCURRENCYCONVERTER\Currencyconverter\Currencyconverter;
$errorMessage = '';
if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
            {
                if (isset($_POST['submit']) && !empty($_POST['submit'])) {
                    $postedName = $_POST['submit'];
                    switch ($postedName) {
                        case 'Convert':
                            $errorMessage .=''; 
                            $getbasecurrency = Currencyconverter::safeInput($_POST['getbasecurrency']);
                            $gettargetcurrency = Currencyconverter::safeInput($_POST['gettargetcurrency']);
                            $convertionamount = Currencyconverter::safeInput($_POST['convertamount']);
                            $errorMessage .= Currencyconverter::getConvertionRatePerUnit($getbasecurrency,$gettargetcurrency,$convertionamount);
                            print $errorMessage;
                            break;
                        case 'add':
                            error_reporting(E_ALL ^ E_NOTICE);
                            $result = Currencyconverter::sql_load_currency_default();                           
                            $errorMessage .= 'add :';
                            $getbasecurrencyall = Currencyconverter::safeInput($_POST['addbasecurrency']);
                            $getbasecurrencyall_explode = explode("|",$getbasecurrencyall);
                                $basecurrencyValue =$getbasecurrencyall_explode[0];
                            $basecurrencyText = $getbasecurrencyall_explode[1];
                            $gettargetcurrencyall = Currencyconverter::safeInput($_POST['addtargetcurrency']);
                            $gettargetcurrencyall_explode=explode("|",$gettargetcurrencyall);
                                $gettargetcurrencyValue =$gettargetcurrencyall_explode[0];
                            $gettargetcurrencyText =$gettargetcurrencyall_explode[1];
                            $convertionamount = Currencyconverter::safeInput($_POST['amountrated']);
                            $db_basecurrency ='';
                            $db_targetcurrency ='';
                            for ($i = 0; $i < count($result); $i++) {
                                $optionValue = $result[$i]['basecurrency'];
                                if($optionValue == $basecurrencyValue)
                                  {
                                   $db_basecurrency .=$optionValue;
                                   
                                   break; 
                                  }
                                if($optionValue == $gettargetcurrencyValue)
                                  {
                                   $db_targetcurrency .=$optionValue;
                                  
                                   break; 
                                  }
                            }
                            if(strlen($db_basecurrency) < 0 && $basecurrencyValue != $gettargetcurrencyValue)
                                 {
                                   Currencyconverter::updateCurrencybaseList(
                                   $basecurrencyValue,
                                   $basecurrencyText
                                   );
                                   }
                             if(strlen($db_targetcurrency) < 0 && $basecurrencyValue != $gettargetcurrencyValue )
                                   {
                                 Currencyconverter::updateCurrencybaseList(
                                  $gettargetcurrencyValue,
                                   $gettargetcurrencyText
                                   ); 
                                   }
                           $errorMessage .= Currencyconverter::addMoreCurrencies(        
                                                    $basecurrencyValue, 
                                                    $basecurrencyText,
                                                    $gettargetcurrencyValue,
                                                    $gettargetcurrencyText,
                                                    $convertionamount,
                                                    $getbasecurrencyall,
                                                    $gettargetcurrencyall
                                                    );
                            print $errorMessage;
                            break;;
                    }
                }
                }// request match