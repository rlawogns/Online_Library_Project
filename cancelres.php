<?php				
session_start();		//세션
if($_SESSION['cno']==null){
echo "<script>alert('세션만료 재로그인해주세요.'); location.href='/login.php';</script>";
}
date_default_timezone_set("Asia/Seoul");
$cno=$_SESSION['cno'];				//cno변수
$daterented=date("y/m/d");				//daterented변수
$datedue=date("y/m/d",strtotime("+10 days"));		//datedue변수
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

$query = "delete from reservation where isbn=$isbn and cno=$cno";	//예약취소
$stmt = oci_parse($conn,$query);
oci_execute($stmt);
echo "<script>alert('예약이 취소되었습니다.'); location.href='/main.php?pagenum=1';</script>";
?>