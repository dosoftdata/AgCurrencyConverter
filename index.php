<?php
require_once 'header.inc';
//Used  load the PHP name space
use AGCURRENCYCONVERTER\Error\ErrorHandler,
    AGCURRENCYCONVERTER\Currencyconverter\Currencyconverter;
//Handle the application error generated 
ErrorHandler::SetHandler();

$currency_rate =Currencyconverter::load_default_currencies_rate_list();
$result = Currencyconverter::sql_load_currency_default();
$result_all_currencies = Currencyconverter::sql_load_currency_all();
$errorMessage = '';
?>
<body>
   <!--Application main container-->
    <div class="container" style="margin-left: auto; margin-right: auto; margin-top: 5%;">        
        <!--Currency converter panel-->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Currency Converter</h3> 
            </div>
            
            <div class="well well-sm convertionmessage"><?php
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
                            //var_dump($_POST);
                            break;
                         } 
                  }
             }    
                      
                ?>
                </div>
            <div class="panel-body"> 
                <form name="currenyconvertion" action="<?= htmlentities(strip_tags('index', ''), ENT_QUOTES, 'UTF-8'); ?>" method="post"   class="form-inline" role="form" id="currenyconvertion">
                    <div class="form-group">
                        <label for="name">From<required>*</required></label>
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
                    <div class="form-group" > 
                        <label for="name">To<required>*</required>:</label>
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
                    <div class="form-group"> 
                        <div class="col-sm-10 input-lg" > <input id="convertionamountset"  name="convertamount" value="" type="text" class="form-control" id="amount" placeholder="Enter the amount"maxlength="10"> 
                        </div>
                    </div>  
                     
                    <noscript>
                    <div class="form-group  bordered">
                        <div class="col-sm-10" style="float:right;">
                            <button  name="submit" value="Convert"  type="submit" class="btn btn-primary">Convert</button>
                        </div> 
                    </div>
                    </noscript>
                </form>
            </div> 
        </div> 
        <!--Add more currencies panel-->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Add more default currency exchange per unit</h3> 
            </div> 
            <div class="well well-sm addmcurrencymessages">
            <?php
               if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
            {
                if (isset($_POST['submit']) && !empty($_POST['submit'])) {
                    $postedName = $_POST['submit'];
                    switch ($postedName) {
                        case 'add':
                        error_reporting(E_ALL ^ E_NOTICE);
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
                            if(empty($db_basecurrency))
                                   {
                              Currencyconverter::updateCurrencybaseList(
                                   $basecurrencyValue,
                                   $basecurrencyText
                                   );
                                   }
                             if(empty($db_targetcurrency))
                                   {
                             Currencyconverter::updateCurrencybaseList(
                                   $gettargetcurrencyValue,
                                   $gettargetcurrencyText
                                   );
                                   }
                           $errorMessage .= Currencyconverter:: addMoreCurrencies(        
                                                    $basecurrencyValue, 
                                                    $basecurrencyText,
                                                    $gettargetcurrencyValue,
                                                    $gettargetcurrencyText,
                                                    $convertionamount,
                                                    $getbasecurrencyall,
                                                    $gettargetcurrencyall
                                                    );
                            print $errorMessage;
                            var_dump($_POST);
                            break;
                         } 
                  }
             }    
                            
            ?>
            
            </div>
            <div class="panel-body"> 
                <form name="currenyconvertionadd" id="currenyconvertionadd" action="<?= htmlentities(strip_tags('index', ''), ENT_QUOTES, 'UTF-8'); ?>" method="post"   class="form-inline" role="form">
                    <div class="form-group">
                        <label for="name">From<required>*</required></label>
                        <select name="addbasecurrency" id="addbasecurrency" class="form-control" style="width: 220px"> 
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
                        <label for="name">To:<required>*</required></label>
                        <select name="addtargetcurrency" id="addtargetcurrency" class="form-control" style="width: 220px"> 
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
                    </div>
                    <div class="form-group  bordered">
                        <div class="col-sm-10" style="float:right;">
                            <button name="submit" value="add"  type="submit" class="btn btn-primary">Save</button>
                        </div> 
                    </div>
                </form>
            </div> 
        </div>
        <!--Edit currency rate panel-->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Default currency rate per unit</h3> 
            </div> 
            <div class="well well-sm editcurrencymessages">
            <?php
               if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
            {
                if (isset($_POST['submit']) && !empty($_POST['submit'])) {
                    $postedName = $_POST['submit'];
                    switch ($postedName) {
                        case 'edit':
                            $errorMessage.='Edit:';
                            $basecurrency = Currencyconverter::safeInput($_POST['base-currency']);
                            $targetcurrency = Currencyconverter::safeInput($_POST['target-currency']);
                            $editconvertionamount = Currencyconverter::safeInput($_POST['currency_per_unit']);
                            $errorMessage .= Currencyconverter::editCurrencyRate(
                                                               $basecurrency,
                                                               $targetcurrency,
                                                               $editconvertionamount);
                            
                            print $errorMessage;
                            //var_dump($_POST);
                            break;
                         } 
                  }
             }    
           
            ?>
            
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
                    <?php   for($i = 0; $i<count($currency_rate); $i++) 
                    {
                    ?>
                    <tr>   
                        <form name="currenyconvertionedit" action="<?= htmlentities(strip_tags('index', ''), ENT_QUOTES, 'UTF-8'); ?>" method="post"   class="form-inline" role="form">                       
                        <td>
                        <input class=" table-hove" type="text"  style=" outline: 0; width: auto;border:none" name="base-currency" value="<?= $currency_rate[$i]['basecurrencyout']; ?>" readonly></td> 
                        <td><input type="text"  style=" outline: 0; width: auto;border:none" name="target-currency" value="<?= $currency_rate[$i]['targetcurrencyout'];  ?>" readonly></td> 
                        <td><input type="text"  style=" outline: 0; width: auto;border:none" name="currency_per_unit" value="<?= $currency_rate[$i]['rateset'];  ?>"></td>
                        <td><button  name="submit" value="edit" type="submit" class="btn btn-primary">Save</button>

                        </td>
                    </form>
                    
                    </tr> 
                    <?php } ?>
                    </tbody> 
                </table> 
            </div>
        </div>
    </div>
    <script type="text/javascript" src="style/js/jquery.min.js"></script>
    <script type="text/javascript" src="style/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="style/js/jquery.numeric.min.js"></script>
    <!--[if lt IE 9]><script type="text/javascript" src="style/js/html5.js"></script><![endif]-->
    <!-- START CONVERTER ENGINE -->
    <script type="text/javascript">
    ;
     jQuery(document).ready(function(){
        $('input[name="convertamount"]').numeric();
        $('input[name="amountrated"]').numeric();
        $('input[name="currency_per_unit"]').numeric();
       //currency_per_unit
       //Ajax handler user if javascript is enable to keep the currency rate added
       $('#currenyconvertionadd').submit(function(e) {
			e.preventDefault();                      
			var dataStream = $('#currenyconvertionadd').serialize()+'&submit=add';
  			$.ajax({
				type: "POST",
				url: "<?= htmlentities(strip_tags('ajaxhandleConvertionInput', ''), ENT_QUOTES, 'UTF-8'); ?>",
				data: dataStream,
				//dataType: "json",
				success: function(data) {
				    var result = $.trim(data);
                    alert(result.length+'/result');
                    if(result.length> 30){
                    $('.addmcurrencymessages').removeClass('successes');
				    $('.addmcurrencymessages').addClass('warning')
                                           .html('<span style="position:relative;margin-left:25px">'+data+'</span>')
                                           .css('color','red','font-size','16px')
				    }
                   
                    if(result.length < 31){
                         $('.addmcurrencymessages').removeClass('warning');
				    $('.addmcurrencymessages').addClass('successes')
                                           .html('<span style="position:relative;margin-left:25px">'+data+'</span>')
                                           .css('color','bleu','font-size','20px')
				   
                    }
				},
			});
            
		}); 
     }); 
     $(function(){
  //Ajax handler used to generate the currency convertion if: javascrip:enabled
   $('#convertionamountset').keyup(function(e)
   {
       	e.preventDefault();                       
			var dataStream = $('#currenyconvertion').serialize()+'&submit=Convert';
           
         $.ajax({
				type: "POST",
				url: "<?= htmlentities(strip_tags('ajaxhandleConvertionInput', ''), ENT_QUOTES, 'UTF-8'); ?>",
				data: dataStream,
				//dataType: "json",
				success: function(data) {
				    var result = $.trim(data);
                    //alert(result.length+'/result');
                    if(result.length> 30){
                    $('.convertionmessage').removeClass('successes');
				    $('.convertionmessage').addClass('warning')
                                           .html('<span style="position:relative;margin-left:25px">'+data+'</span>')
                                           .css('color','red','font-size','16px')
				    }
                   
                    if(result.length < 31){
                         $('.convertionmessage').removeClass('warning');
				    $('.convertionmessage').addClass('successes')
                                           .html('<span style="position:relative;margin-left:25px">'+data+'</span>')
                                           .css('color','bleu','font-size','20px')
				   
                    }
				},
			});
   });

}); 
    </script>   
    <?php
    require_once 'footer.inc';
    