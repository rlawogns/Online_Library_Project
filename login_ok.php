<meta charset="utf-8" />
<?php
session_start();
$dbuser="d201701995";
$dbpass="asd487900";
$dbsid = "(
  DESCRIPTION =
  (ADDRESS_LIST = 
   (ADDRESS = 
    (PROTOCOL = TCP)
    (HOST = localhost)
    (PORT = 1521)
   )
  )
) ";

$conn = @oci_connect($dbuser,$dbpass,$dbsid);
if(!$conn) {
  echo "No Connection ".oci_error();
  exit;
} else {
 echo "Connect Success!";
}
	
	
	if($_POST["userid"] == "" || $_POST["userpw"] == ""){	//POST로 받아온 아이디와 비밀번호가 비었다면 알림창을 띄우고 전 페이지로 돌아감
		echo '<script> alert("아이디나 패스워드 입력하세요"); history.back(); </script>';
	}else{
	$id=$_POST['userid'];
	$password = $_POST['userpw'];					//post로 받은 패스워드 저장
	$query = "select * from customer where ID='$id'";		//입력한 아이디와 같은 디비값 추출을 위한 쿼리문
	$stmt = oci_parse($conn,$query);
	oci_execute($stmt);
	$row = oci_fetch_assoc($stmt);
	if ($row == NULL){					//디비에 입력한 아이디와 동일한 계정없음
	echo "<script>alert('아이디 혹은 비밀번호를 확인하세요.'); history.back();</script>";	//로그인 실패 알림창 띄우고 로그인화면으로
	}
	else						//계정은 존재
	{
	    if($row['PASSWD'] == $password){					//비밀번호가 동일
		$_SESSION['cno'] = $row['CNO'];			//회원아이디 넘기기
		echo "<script>alert('로그인되었습니다.'); location.href='/main.php?pagenum=1';</script>";		//로그인 알림창 띄우고 메인화면으로 
	    }
	    else{								//비밀번호가 틀림
		echo "<script>alert('아이디 혹은 비밀번호를 확인하세요.'); history.back();</script>";	//로그인 실패 알림창 띄우고 로그인화면으로
	    }
	}
}
?>