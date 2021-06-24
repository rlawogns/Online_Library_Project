<?php				
session_start();		//세션
if($_SESSION['cno']==null){
echo "<script>alert('세션만료 재로그인해주세요.'); location.href='/login.php';</script>";
}
date_default_timezone_set("Asia/Seoul");
$cno=$_SESSION['cno'];				//cno변수
$resT=date("y/m/d");				//reservationtime변수
$isbn=$_POST["isbn"];				//isbn변수
$dbuser="d201701995";			//디비연결
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
 //echo "Connect Success!";
}

$query = "select * from reservation where cno=$cno";
$stmt = oci_parse($conn,$query);
oci_execute($stmt);
$count=0;				//예약한 도서 수
while($row = oci_fetch_assoc($stmt)){
	if($row['ISBN']==$isbn){		//이미 예약한 도서
	$count=3;
	}
	$count+=1;
}
if($count<3){				//예약도서 3권아래일때는 예약가능
$query = "INSERT INTO RESERVATION VALUES($isbn,$cno,'$resT')"; 	//예약
$stmt = oci_parse($conn,$query);
oci_execute($stmt);
echo "<script>alert('예약되었습니다.'); location.href='/main.php?pagenum=1';</script>";
}
else{
echo "<script>alert('이미 3권 예약했습니다.'); location.href='/main.php?pagenum=1';</script>";
}
?>

