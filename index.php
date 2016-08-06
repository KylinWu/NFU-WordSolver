<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
 	<head>
    	<meta charset="utf-8">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>NFU Words Solver</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="./css/index.css" rel="stylesheet">

  </head>

  <body>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src = "http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
    <script src = "./js/bootstrap.min.js"></script>
    <script src = "./js/index.js"></script>
<div class="signin-form">

 <div class="container">
     
        
       <form class="form-signin" method="post" id="login-form">
      
        <h2 class="form-signin-heading">NFU Words Solver</h2><hr />
        
        <div id="error">
        <!-- error will be shown here ! -->
        </div>
        
        <div class="form-group">
        <input type="text" class="form-control" placeholder="學號" name="user_id" id="user_id" />
        <span id="check-e"></span>
        </div>
        
        <div class="form-group">
        <input type="password" class="form-control" placeholder="密碼(預設同學號)" name="password" id="password" />
        </div>
       
      <hr />
        
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
      <span class="glyphicon glyphicon-log-in"></span> &nbsp; 下一步
   </button> 
        </div>  
      
      </form>
		
    <form class="form-signin" method="post" id="course-form">
        <h2 class="form-signin-heading">選擇課程.</h2><hr />
				<div class="form-group" id="rank_error">
				<!--Rank Error-->
				</div>
        <div class="form-group" id="course_list">
				<!--Course List Here-->
				</div>
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-course" id="btn-course"><span>確定</span> &nbsp;</button> 
				</div>
		</form>

    <form class="form-signin" method="post" id="action-form">
        <h2 class="form-signin-heading">想怎麼做？</h2><hr />
				<div class="form-group" id="div_rank">
				<!-- Rank list Here -->
				</div>
        <div class="form-group"">
					<div class="radio">
  				<label><input type="radio" name="action_option" checked value="10">First Blood(10個單字)</label>
					</div>
					<div class="radio">
  				<label><input type="radio" name="action_option" value="100">Killing Spree(100個單字)</label>
					</div>
					<div class="radio">
  				<label><input type="radio" name="action_option" value="500">Dominating(500個單字)</label>
					</div>
					<div class="radio">
  				<label><input type="radio" name="action_option" value="1000">Unstopable(1000個單字)</label>
					</div>
					<div class="radio">
  				<label><input type="radio" name="action_option" value="all">GODLIKE(全部做完)</label>
					</div>				
				</div>
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-uaction" id="btn-uaction"><span>確定</span> &nbsp;</button> 
				</div>
		</form>
		

    </div>
    
</div>
	

<!-- Modal Start here-->
<div class="modal fade bs-example-modal-sm" id="myPleaseWait" tabindex="-1"
    role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <span class="glyphicon glyphicon-time">
                    </span>執行中...請等待
                 </h4>
            </div>
            <div class="modal-body">
                <div class="progress">
                    <div class="progress-bar progress-bar-info
                    progress-bar-striped active"
                    style="width: 100%">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal ends Here -->
  </body>
</html>

