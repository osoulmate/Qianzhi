<?php

  //mysql连接测试
  error_reporting(E_ALL ^ E_DEPRECATED);
  $db_host="localhost";
  $db_user="root";
  $db_passwd="root";
  $db_name="qianzhi_db";
  $query = "SELECT SESSION_USER(), CURRENT_USER(),now();";
  echo("<BR>---------------------------mysqli_connect 测试------------------------<BR><BR>");
  $conn = mysqli_connect($db_host, $db_user, $db_passwd,$db_name) ;
  if (!$conn)
  {
   die('Could not connect: ' . mysqli_error());
  }else{
    echo("mysqli_connect 连接测试成功!<BR><BR>");
  }
  //execute the query.
  $result = mysqli_query($conn, $query);
  //display information:
  while($row = mysqli_fetch_array($result)) {
    var_dump($row);
  }
  mysqli_close($conn);
  exit();
?>

