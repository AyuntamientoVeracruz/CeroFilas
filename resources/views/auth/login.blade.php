<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
   <head>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="Cero Filas // Sistema CRM">
        <meta name="author" content="Angel Cobos www.arkanmedia.com">
        <link rel="shortcut icon" href="{{url('/sis/img/favicon.ico')}}">
        <title>Cero Filas // Sistema CRM</title>
        <script type="text/javascript" src="{{url('/js/jquery-2.1.4.min.js')}}"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
		<link href="{{url('/sis/css/style.css')}}" rel="stylesheet">
        <script language="JavaScript">
            $(function() {
                $("#password").on("keyup",function(){
                    if($(this).val()){
                        $(".eye").show();
						$(".lock").hide();
                    }
                    else{
                        $(".eye").hide();
						$(".lock").show();
                    }
                    $("#password").attr('type','password');
                });
                $(".eye").mousedown(function(){
                    $("#password").attr('type','text');
					$(".eye").css({"color":"#333"});
                }).mouseup(function(){
                    $("#password").attr('type','password');
					$(".eye").css({"color":"#999"});
                }).mouseout(function(){
                    $("#password").attr('type','password');
					$(".eye").css({"color":"#999"});
                });
            });                
        </script>
        <style>

            .logo{
              position:absolute;
              z-index:99; top:-150px; width:320px; left:50%; margin-left:-160px}

            body{font-family:'Roboto', sans-serif;background:#f7f7f7;text-align:center; margin:0px; min-height:350px}

    		#error{margin:1em auto;background:#81BEDD;color:#FFFFFF;border:8px solid #FA4956;font-weight:normal;width:500px;text-align:center;position:relative;
            width:90%; max-width:400px; border-radius:3px}

            #entry{margin:0 auto;text-align:left;
            width:90%; max-width:400px; top:calc( 50% + 50px); margin-top:-100px; position:absolute; height:200px; left:50%; margin-left:-200px}

    			#entry p{text-align:center}
    			#entry div{background:rgba(255, 255, 255, 0.35);padding:8px;text-align:right;position:relative; border-radius:4px 4px 0px 0px}
    				#entry div.top{ padding-bottom:0px}
    				#entry div.bottom{ border-radius:0px 0px 4px 4px; padding-top:0px}
    			#entry .field{border:0px none;width:100%;font-size:13px;line-height:1em;padding:10px; border-radius:3px; outline:none; background:#fff;
    			border-bottom:1px solid #ddd;color:#444; font-family:"Roboto"; font-weight:400}
    				#entry div.top .field{ border-radius:4px 4px 0px 0px}
    				#entry div.bottom .field{ border-top:0px none; border-radius:0px 0px 4px 4px; border-bottom:0px none}

    				#entry .field::-webkit-input-placeholder{color:#bbb}
    				 #entry .field:focus{  background:#fafafa; color:#000}

    			#entry div.submit{background:none;text-align:center; margin-top:10px}
    			#entry div.submit label{float:none;display:inline;font-size:11px}

    			#entry button{border:0;padding:0 25px;height:40px;line-height:40px;text-align:center;font-size:13px;font-weight:bold;color:#333;
    			background:#F1C81E;cursor:pointer; border-radius:4px; text-transform:uppercase;
    			 width:100%;font-family:'Roboto', sans-serif; font-weight:500; outline:none; }
    				#entry button:hover{ background:#f1a51e}

    				.eye {
    					display:none;
    					right: 18px;
    					position: absolute;
    					top: 9px;
    					cursor:pointer; z-index:1; color:#999; font-size:20px
    				}

    				.user,.lock {
    					right: 18px;
    					position: absolute;
    					top: 17px;
    					cursor:pointer; color:#ddd; font-size:20px
    				}
    					.lock{ top:9px}

    				.forgot{color:rgba(255,255,255,1);
    				text-align:right; width:calc(50% - 8px); float:right; font-weight:400; font-size:12px; text-decoration:none; margin-right:8px;
    				margin-top:10px}
    				.register{color:rgba(255,255,255,1);
    				text-align:left; width:calc(50% - 8px); float:left; font-weight:400; font-size:12px; text-decoration:none; margin-right:8px;
    				margin-top:10px}

    					.forgot:hover,.register:hover{color:#fff}

    		@media only screen and (max-height: 350px){
    			#entry{ margin-top:150px; top:0%}
    		}

            @media only screen and (max-width: 480px){
                #entry{ left:50%; margin-left:-44.5%}
            }

    		@media only screen and (max-width: 375px){
                #entry{ left:50%; margin-left:-45%}

            }
    		body{ background:url({{url('/images/bg.jpg')}}) center center no-repeat #333; background-attachment:fixed; background-size:cover; height:100%}
    		  body::before{ width: 100%; height:100vh; background: rgba(0,0,0,0.3); position: absolute; left:0px; top: 0px;
                content: ""}
    		.alert{ background:#F1C81E; border-radius:3px; padding:8px; position:absolute; left:0px; top:-60px; color:#333; text-align:center; width:100%; font-size:12px; border:0px none; z-index:99}
    		
    		.top input:focus + span,.bottom input:focus + span{ color:#444}
    		
    		@media screen and (max-width: 400px) {
    			.register{ width:170px}
    			.forgot{ width:auto}
    		}
		
        </style>

    </head>
    
    <body>

		<div class="container">
        <form id="entry" method="POST" action="{{ route('login', app()->getLocale()) }}" autocomplete="off">
		@csrf
            <a href="<?PHP echo url("/") ?>"><img src="{{url('/images/logo-transparent.png')}}" class="logo"/></a>
            @if(session()->has('message'))
                <span class="alert alert-success">
                    {{ session()->get('message') }}
                </span>
            @endif
            @if ($errors->has('email'))
                <span class="alert alert-warning">
                    {{ $errors->first('email') }}
                 </span>
            @endif
            @if ($errors->has('password'))
                <span class="alert alert-warning">
                    {{ $errors->first('password') }}
                </span>
            @endif
            <div class="top" style="margin-bottom:0px; padding-bottom:0px">
                <input id="email" type="email" name="email" class="field required" autocomplete="off" required value="" placeholder="Email" style=" margin-bottom:0px"/>
                <span class="user material-icons">mail_outline</span>
            </div>
            <div class="bottom" style="margin-top:0px">
                <input id="password" type="text"  name="password" class="field required" autocomplete="off" required value="" placeholder="Password" style="margin-top:0px"/>
                <span class="lock material-icons">lock_outline</span>
                <span class="eye material-icons">remove_red_eye</span>
            </div>
            <div class="submit">
                <button type="submit">Ingresar</button>
            </div>
                       
            <a href="<?PHP echo url("forgot") ?>" class="forgot">¿Olvidaste tu password?</a>
        </form>
        </div>
		</div>

		<script language="javascript">
            document.forms[0].password.select();
            document.forms[0].email.focus();
        </script>
    </body>

</html>
