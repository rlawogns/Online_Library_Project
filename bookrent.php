<?php
session_start();		//세션
if($_SESSION['cno']==null){
echo "<script>alert('세션만료 재로그인해주세요.'); location.href='/login.php';</script>";
}
else{
echo $_SESSION['cno'];
}
$pagenum=$_POST['pagenum'];
$text=$_POST["searchtext"];
$bookcount=1;

 ?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<title>메인사이트</title>
<link rel="stylesheet" type="text/css" href="/bookrent.css" />
</head>
<body>
	<div class="mbody">
	<div id="top">
		<div id="logo">
			<a>로고</a>
		</div>
		<div id="logout">
			<input id="menubutton" type='button' value='로그아웃'onclick='location.href="/login.php"'/>
		</div>
	</div>
	<div id="mid">
		<div id="menu">
			<table>
			<form method="post" action="/main.php">
			<tr>
				<td>
				<button id="menubutton" type="submit" value= "1"  name="pagenum">도서</button>
				</td>
			</tr>
			</form>
			<form method="post" action="/bookrent.php">
			<tr>
				<td>
				<input type = "hidden" value = "" name = "searchtext">
				<button id="menubutton" type="submit" value= "1"  name="pagenum">도서대여</button>
				</td>
			</tr>
			</form>
			<form method="post" action="/mypage.php">
			<tr>
				<td>
				<input type = "hidden" value = "" name = "searchtext">
				<button id="menubutton" type="submit" value= "1"  name="pagenum">마이페이지</button>
				</td>
			</tr>
			</form>
			</table>
			</form>
		</div>


		<div id="main_box">
		<div id="search">		<?--검색기능-->
			<form method="post" action="/bookrent.php?">
			<input id= "searchbar" type="text" name="searchtext">
			<button type="submit" value= "1"  name="pagenum" id="searchbutton" >검색</button>
			</form>
		</div>			<?--검색끝-->
<table class="booktable">			<?--책정보 보여주기-->
<thead class="bookth">
<tr>
<th class="isbninfo">도서번호</th>
<th class="titleinfo">제목</th>
<th class="authorinfo">저자</th>
<th class="authorinfo">도서대여</th>
<th class="authorinfo">도서예약</th>

</tr>
</thead>
<tbody>
<?php				//디비연결
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
 //echo "Connect Success!";
}
$query = "select e.isbn, title, a.author,publisher,year from ebook e,authors a where e.isbn = a.isbn and title like '%$text%'";
$stmt = oci_parse($conn,$query);
oci_execute($stmt);
while($row = oci_fetch_assoc($stmt))
{
if($pagenum*10>=$bookcount and ($pagenum-1)*10<$bookcount){	//한페이지에 10개씩
?>

    <tr>
	<td class="isbninfo"><?= $row['ISBN'] ?></td>
	<td class="titleinfo"><?= $row['TITLE'] ?></td>
	<td class="authorinfo"><?= $row['AUTHOR'] ?></td>
	<td>
	<form method="post" action="/rent.php">
	<input type = "hidden" value = "<?php echo $row['ISBN'];?>" name = "isbn">		<!--도서대여 -->
	<button type="submit" value= "1"  name="pagenum">도서 대여</button>
	</form>
	</td>
	<td>
	<form method="post" action="/reservation.php">
	<input type = "hidden" value = "<?php echo $row['ISBN'];?>" name = "isbn">		<!-- 도서 예약 -->
	<button type="submit" value= "1"  name="pagenum">도서 예약</button>
	</form>
	</td>
    </tr>
<?php
}
$bookcount+=1;
}
if($pagenum*10>$bookcount){$bookcount=0;}		//빈페이지
elseif($pagenum==$bookcount){$bookcount=$bookcount%10;}	//페이지에 10개이하의 책
else{$bookcount=10;}				
while($bookcount!=10){
?>
    <tr>						<!--칸맞추기 위한 부분-->
	<td class="isbninfo blank"></td>
	<td class="titleinfo blank"></td>
	<td class="authorinfo blank"></td>
    </tr>
<?php
$bookcount+=1;
}
?>
</tbody>
</table>
		<div class=pagen>		<?--페이지 번호  post를 통해 넘겨줌-->
			<form method="post" action="/bookrent.php">
			<input type = "hidden" value = "<?php echo $text;?>" name = "searchtext">		<!-- 검색내용 -->
			<button type="submit" value= "1"  name="pagenum">1</button>			<!-- 페이지 -->
			<button type="submit" value= "2"  name="pagenum">2</button>
			<button type="submit" value= "3"  name="pagenum">3</button>
			<button type="submit" value= "4"  name="pagenum">4</button>
			<button type="submit" value= "5"  name="pagenum">5</button>
			<!--<input type='button' value='1' onclick='location.href="/booksearch.php?pagenum=1"'/>-->
			<!--<input type='button' value='2' onclick='location.href="/booksearch.php?pagenum=2"'/>-->

			</form>
		</div>			<?--페이지번호 끝-->

		</div>
	</div>
	</div>
</body>
</html>