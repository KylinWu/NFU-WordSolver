$('document').ready(function(){ 
	$("#course-form").hide();
	$("#action-form").hide();
	/* login validation */
  	$("#login-form").validate({
  		rules:{
   			password: {
   				required: true,
   			},
   			user_id:{
            			required: true,
				number: true
            		},
    		},
       		messages: {
            		password:{
                      		required: "請輸入正確密碼"
                     	},
            		user_id: "請輸入學號(限數字)",
       		},
    		submitHandler: submitLoginForm 
        });  
	/* login validation */
	/* course validation */
	$("#course-form").validate({
		rules:{
			course_list: {
				required: true,
				number: true
			}
		},
		messages:{
			course_list:"請正確選擇",
		},
		submitHandler: submitCourseForm
	});
	/* course validation */

	/* acion validation */
	$("#action-form").validate({
		rules:{
			action_option: {
				required: true,
				number: true
			}
		},
		messages:{
			course_list:"請正確選擇",
		},
		submitHandler: submitActionForm
	});
	/* acion validation */

    	/* login submit */
    function submitLoginForm(){  
   		var data = $("#login-form").serialize();
    
   		$.ajax({
    
   			type : 'POST',
   			url  : 'function.php',
   			data : data,
   			beforeSend: function(){ 
    				$("#error").fadeOut();
    				$("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; 驗證中...');
   			},
   			success :  function(response){
				if(response == "false") {
					$("#error").fadeIn(1000, function(){      
						$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; 登入失敗!請輸入正確學號及密碼！</div>');
						$("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; 下一步');
					});
				} else {
					$("#login-form").fadeOut();
					$("#btn-login").fadeOut();
					$("#course-form").fadeIn(1000, function(){
						$("#course_list").html('<select class="form-control" name="course_id" id="course_id">' + response + '</select>')
					});
     			}
			}
		});
		return false;
  	}
        /* login submit */

		/* course submit */
    	function submitCourseForm(){
   		var data = $("#course-form").serialize();
   		$.ajax({
    
   			type : 'POST',
   			url  : 'function.php',
   			data : data,
   			beforeSend: function(){
				$("#rank_error").fadeOut();
    				$("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; 查詢中...');
   			},
   			success :  function(response){ 
				if (response == "false") {
					$("#rank_error").fadeIn(500, function(){
						$("#rank_error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp;該課程沒有單字考試</div>');
						$("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; 確認');
					});
				} else if(response == "unauth") {
					$("#btn-course").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; 確認');
					$("#course-form").fadeOut();
					$("#login-form").fadeIn();
					$("#error").fadeIn(500, function(){
						$("#rank_error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp;請先登入！</div>');
						$("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; 確認');
						
					});
				} else {
					$("#course-form").fadeOut();
					$("#btn-course").fadeOut();
					$("#action-form").fadeIn(1000, function(){
						$("#div_rank").html('<h4>目前課程級別 : '+ response +'</h4>');
					});
				}
			}
   		});
    		return false;
  	}
	/* course submit */


	/* action submit */
    function submitActionForm(){  
   		var data = $("#action-form").serialize();
   		$.ajax({
    
   			type : 'POST',
   			url  : 'function.php',
   			data : data,
   			beforeSend: function(){ 
    				$("#btn-uaction").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; 執行中...');
				$('#myPleaseWait').modal('show');
   			},
   			success :  function(response){
				if(response == "unauth") {
					$("#btn-uaction").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; 確認');
					$("#action-form").fadeOut();
					$("#login-form").fadeIn();
					$("#error").fadeIn(500, function(){
						$("#rank_error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp;請先登入！</div>');
						$("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; 確認');
					});
				} else {
					$('#myPleaseWait').modal('hide');
					$("#action-form").fadeIn(1000, function(){
						$("#div_rank").html('<h5>執行完畢！</h5><h4>目前課程級別 : '+ response +'</h4>');
						$("#btn-uaction").html('<span></span> &nbsp; 確定');
					});
				}
			}
		});
		return false;
  	}
		/* action submit */
});
