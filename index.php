<?php
require_once 'header.inc';

use AGCURRENCYCONVERTER\Error\ErrorHandler,
    AGCURRENCYCONVERTER\Currencyconverter\Currencyconverter;
use Zend\Validator\Identical,
    Zend\Validator\NotEmpty,
    Zend\Validator\Digits,
    Zend\I18n\Validator\Float;

ErrorHandler::SetHandler();
ini_set("display_errors", 1);
$result = Currencyconverter::sql_load_currency_default();
$result_all_currencies = Currencyconverter::sql_load_currency_all();
$errorMessage = '';
/*
  $(".numericOnly").keypress(function (e) {
  if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
  });
 */
?>
<body>
    <div class="container" style="margin-left: auto; margin-right: auto; margin-top: 5%;">        
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Currency Converter</h3> 
            </div> 
            <div class="well well-sm"><?php
                print $errorMessage;
                if (isset($_POST['submit']) && !empty($_POST['submit'])) {
                    $postedName = $_POST['submit'];
                    switch ($postedName) {
                        case 'Convert':
                            $errorMessage .='Convertion:'; 
                            $getbasecurrency = $_POST['getbasecurrency'];
                            $gettargetcurrency = $_POST['gettargetcurrency'];
                            $convertionamount = $_POST['convertamount'];
                            $NotEmpty = new NotEmpty();
                            $resultbase = $NotEmpty->isValid($getbasecurrency);
                            $resulttarget = $NotEmpty->isValid($gettargetcurrency);
                            $resultamout = $NotEmpty->isValid($convertionamount);
                            $notEmptyArrray= array($resultbase,$resulttarget,$resultamout);
                            switch ($notEmptyArrray) {
                                case array(true,true,true):
                                   $Identical = new Identical($getbasecurrency);
                                   if ($Identical->isValid($gettargetcurrency)) {
                                       $errorMessage .='Failed: Please select differente currencies';
                                   } else {
                                       $isFloat = filter_var($convertionamount, FILTER_VALIDATE_FLOAT);
                                       if($isFloat !=false){
                                            $errorMessage .='Success: OK'.$isFloat ;                                                                            
                                       }
                                       else{
                                          $errorMessage .='The amount to convert must be valid! "x.xxxx" or "xxxxx" and Greater to Zero';    
                                       }                                     
                                   }
                                    break;
                                default:
                                   $errorMessage .='Please all input are required:**';   
                                    break;
                            }                           
                            print $errorMessage;
                            var_dump($_POST);
                            break;
                        case 'add':
                            //$errorMessage = NULL;
                            $errorMessage .= 'add';
                            print $errorMessage;
                            var_dump($_POST);
                            break;
                        case 'edit':
                            //$errorMessage = NULL;
                            $errorMessage .= 'edit';
                            print $errorMessage;
                            var_dump($_POST);
                            //$_POST[0];
                            break;
                        default:
                            break;
                    }
                }
                //$errorMessage 
                ?></div>
            <div class="panel-body"> 
                <form name="currenyconvertion" action="<?= htmlentities(strip_tags($_SERVER['PHP_SELF'], ''), ENT_QUOTES, 'UTF-8'); ?>" method="post"   class="form-inline" role="form">
                    <div class="form-group">
                        <label for="name">From</label>
                        <select class="form-control" name="getbasecurrency" id="getbasecurrency"> 
                            <?php
                            print '<option value =" "> --Select the base currency--</option>';
                            for ($i = 0; $i < count($result); $i++) {
                                $optionValue = $result[$i]['basecurrency'];
                                $optionText = $result[$i]['currency_name'];
                                print '<option value = "' . $optionValue . '">' . $optionText . '</option>';
                            }
                            ?>
                        </select>
                    </div> 
                    <div class="form-group"> 
                        <div class="col-sm-10"> <input  name="convertamount" value="" type="text" class="form-control" id="amount" placeholder="Enter the amount"> </div>
                    </div>  
                    <div class="form-group" > 
                        <label for="name">To:</label>
                        <select class="form-control" name="gettargetcurrency" id="gettargetcurrency"> 
                            <?php
                            print '<option value =" "> --Select the target currency--</option>';
                            for ($i = 0; $i < count($result); $i++) {
                                $optionValue = $result[$i]['basecurrency'];
                                $optionText = $result[$i]['currency_name'];
                                print '<option value = "' . $optionValue . '">' . $optionText . '</option>';
                            }
                            ?>
                        </select>
                    </div> 
                    <noscript>
                    <div class="form-group  bordered">
                        <div class="col-sm-10" style="float:right;">
                            <button  name="submit" value="Convert"  type="submit" class="btn btn-primary">Convert</button>
                        </div> 
                    </div>
                    </noscript>
                    <div class="form-group  bordered">
                        <div class="col-sm-10" style="float:right;">
                            <button    name="submit" value="Convert"  type="submit" class="btn btn-primary">Convert</button>
                        </div> 
                    </div>
                </form>
            </div> 
        </div> 
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Add more default currency exchange per unit</h3> 
            </div> 
            <div class="well well-sm hide">Message</div>
            <div class="panel-body"> 
                <form name="currenyconvertionadd" action="<?= htmlentities(strip_tags($_SERVER['PHP_SELF'], ''), ENT_QUOTES, 'UTF-8'); ?>" method="post"   class="form-inline" role="form">
                    <div class="form-group">
                        <label for="name">From</label>
                        <select name="addbasecurrency" id="addbasecurrency" class="form-control" style="width: 250px"> 
                            <?php
                            print '<option value =" "> --Select the base currency--</option>';
                            for ($i = 0; $i < count($result_all_currencies); $i++) {
                                $optionValue = $result_all_currencies[$i]['currency_code'];
                                $optionText = $result_all_currencies[$i]['name'] . ' ' . $result_all_currencies[$i]['currency_name'];
                                print '<option value = "' . $optionValue . '|' . $optionText . '">' . $optionText . '</option>';
                            }
                            ?>
                        </select>
                    </div> 

                    <div class="form-group"> 
                        <label for="name">To:</label>
                        <select name="addtargetcurrency" id="addtargetcurrency" class="form-control" style="width: 250px"> 
                            <?php
                            print '<option value =" "> --Select the target currency--</option>';
                            for ($i = 0; $i < count($result_all_currencies); $i++) {
                                $optionValue = $result_all_currencies[$i]['currency_code'];
                                $optionText = $result_all_currencies[$i]['name'] . '  ' . $result_all_currencies[$i]['currency_name'];
                                print '<option value = "' . $optionValue . '|' . $optionText . '">' . $optionText . '</option>';
                            }
                            ?>
                        </select>
                    </div>  
                    <div class="form-group"> 
                        <div class="col-sm-10"> <input  name="amountrated" value="" type="text" class="form-control" id="amountrated" placeholder="Please enter rate/unit"> </div>
                    </div><br/><br/>
                    <div class="form-group  bordered">
                        <div class="col-sm-10" style="float:right;">
                            <button name="submit" value="add"  type="submit" class="btn btn-primary">Save</button>
                        </div> 
                    </div>
                </form>
            </div> 
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Default currency rate per unit</h3> 
            </div> 
            <div class="panel-body"> 
                <table class="table table-bordered table-hover"> 
                    <thead> 
                        <tr class="active"> 
                            <th>Base currency</th> 
                            <th>Target currency</th> 
                            <th>Amount/Unit (Editable)</th> 
                            <th>Edit</th>
                        </tr> 
                    </thead> 
                    <tbody> 
                        <tr>  <form name="currenyconvertionedit" action="<?= htmlentities(strip_tags($_SERVER['PHP_SELF'], ''), ENT_QUOTES, 'UTF-8'); ?>" method="post"   class="form-inline" role="form">
                        <td>

                            <input type="text"  style=" outline: 0; width: 100%;border:none" name="base-currency" value="base" readonly></td> 
                        <td><input type="text"  style=" outline: 0; width: 100%;border:none" name="target-currency" value="target" readonly></td> 
                        <td><input type="text"  style=" outline: 0; width: 100%;border:none" name="currency_per_unit" value="2.2345"></td>
                        <td><button  name="submit" value="edit" type="submit" class="btn btn-primary">Save</button>

                        </td>
                    </form>
                    </tr> 
                    </tbody> 
                </table> 
            </div>
        </div>
    </div>
    <script type="text/javascript" src="style/js/jquery.min.js"></script>
    <script type="text/javascript" src="style/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]><script type="text/javascript" src="style/js/html5.js"></script><![endif]-->
    <!-- START CONVERTER ENGINE -->   
    <?php
    require_once 'footer.inc';
    