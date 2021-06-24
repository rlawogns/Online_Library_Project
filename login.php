<?php   
 ?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<title>회원가입 및 로그인 사이트</title>
<link rel="stylesheet" type="text/css" href="/login_css.css" />
</head>
<body>
	<div class="mbody">
	<div id="top">
		<div id="logo">
			<a>로고</a>
		</div>
	</div>
	<div id="mid">
		<div id="menu">
			<table>
			<tr>
			<td>
			<input id="menubutton" type='button' value='도서'onclick='location.href="/member.php"'/>
			</td>
			</tr>
			<tr>
			<td>
			<input id="menubutton" type='button' value='도서대여'onclick='location.href="/member.php"'/>
			</td>
			</tr>
			<tr>
			<td>
			<input id="menubutton" type='button' value='마이페이지'onclick='location.href="/member.php"'/>
			</td>
			</tr>
			</table>
		</div>
		<div id="main_box">
			<div id="login_box">			
			<form method="post" action="/login_ok.php">
				<table align="center" border="0" cellspacing="0" width="500">
        			<tr>
            			<td width="150" colspan="3"> 
                		<input type="text" name="userid" class="inph">
            		</td>
            		<td rowspan="2" width="150" > 
                		<button type="submit" id="btn" >로그인</button>
            		</td>
        			</tr>
        			<tr>
            		<td width="130" colspan="3"> 
               		<input type="password" name="userpw" class="inph">
            		</td>
        			</tr>
        			<tr>
           			<td class="mem" colspan="1"> 
              		<a href="/member.php">회원가입</a>
           			</td>
			<td class="findid" colspan="1"> 
              		<a href="/member.php">아이디찾기</a>
           			</td>
			<td class="findpw" colspan="1"> 
              		<a href="/member.php">비밀번호찾기</a>
           			</td>
        			</tr>
    			</table>
  			</form>
			</div>
		</div>
	</div>
	</div>
</body>
</html>