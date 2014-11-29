<?php require_once 'header.inc'; 
use AGCURRENCYCONVERTER\Error\ErrorHandler;
ErrorHandler::SetHandler();
/*
$(".numericOnly").keypress(function (e) {
    if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
});
*/
?>
<body>
    <div class="container" style="margin-left: auto; margin-right: auto; margin-top: 5%;width: 44%">        
       <div class="panel panel-primary">
           <div class="panel-heading">
               <h3 class="panel-title">Currency Converter</h3> 
           </div> 
           <div class="well well-sm hide">Message</div>
           <div class="panel-body"> 
               <form class="form-inline" role="form">
          <div class="form-group">
              <label for="name">From</label>
              <select class="form-control"> 
                  <option>1</option> 
                  <option>2</option> 
                  <option>3</option> 
                  <option>4</option> 
                  <option>5</option> 
              </select>
          </div> 
          <div class="form-group"> 
              <div class="col-sm-10"> <input type="text" class="form-control" id="amount" placeholder="Enter the amount"> </div>
          </div>  
                   <div class="form-group"> 
                       <label for="name">To:</label>
              <select class="form-control"> 
                  <option>1</option> 
                  <option>2</option> 
                  <option>3</option> 
                  <option>4</option> 
                  <option>5</option> 
              </select>
          </div>  
               </form>
           </div> 
       </div> 
        <div class="panel panel-primary">
           <div class="panel-heading">
               <h3 class="panel-title">Add more currencies</h3> 
           </div> 
           <div class="well well-sm hide">Message</div>
           <div class="panel-body"> 
               <form class="form-inline" role="form">
          <div class="form-group">
              <label for="name">From</label>
              <select class="form-control"> 
                  <option>1</option> 
                  <option>2</option> 
                  <option>3</option> 
                  <option>4</option> 
                  <option>5</option> 
              </select>
          </div> 
          
                   <div class="form-group"> 
                       <label for="name">To:</label>
              <select class="form-control"> 
                  <option>1</option> 
                  <option>2</option> 
                  <option>3</option> 
                  <option>4</option> 
                  <option>5</option> 
              </select>
          </div>  
              <div class="form-group"> 
              <div class="col-sm-10"> <input type="text" class="form-control" id="amountrated" placeholder="base rate"> </div>
              </div><br/><br/>
                   <div class="form-group  bordered">
                       <div class="col-sm-10" style="float:right;">
                           <button   type="submit" class="btn btn-primary">Save</button>
                       </div> 
                   </div>
               </form>
           </div> 
       </div> 
</div>
<script type="text/javascript" src="style/js/jquery.min.js"></script>
<script type="text/javascript" src="style/js/bootstrap.min.js"></script>
<!--[if lt IE 9]><script type="text/javascript" src="style/js/html5.js"></script><![endif]-->
    <!-- START CONVERTER ENGINE -->   
 <?php
 require_once 'footer.inc';