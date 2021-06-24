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

$query = "select * from ebook where cno=$cno";
$stmt = oci_parse($conn,$query);
oci_execute($stmt);
$count=0;				//대여한 도서 수
while($row = oci_fetch_assoc($stmt)){
	//if($row['ISBN']==$isbn){		//이미 예약한 도서		는 밖에서 못하게 만들자
	//$count=3;
	//}
	$count+=1;
}
if($count<3){				//대여도서 3권아래일때는 예약가능
$query = "update ebook set cno = $cno, daterented='$daterented' ,datedue='$datedue' where isbn=$isbn";	//대여
$stmt = oci_parse($conn,$query);
oci_execute($stmt);
echo "<script>alert('대여되었습니다.'); location.href='/main.php?pagenum=1';</script>";
}
?>