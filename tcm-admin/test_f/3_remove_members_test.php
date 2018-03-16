<?php

//リストにメンバー削除
//$remove_members = " sudo /usr/local/psa/bin/maillist -u test_test_12 -domain fcetc-7habits.jp -members del:b_nakamura@fujiball.co.jp";
//system("$remove_members");
//echo ("<br>");
//echo ("<br>");
//echo ("<br>");
//echo ("<br>");


$remove_members = " sudo /usr/local/psa/bin/maillist -u test_test_12 -domain fcetc-7habits.jp -members del:b_nakamura@fujiball.co.jp 2>&1";
exec($remove_members, $error, $return);
var_dump($error);
echo ("<br>");
echo ($return);
echo ("<br>");
echo ("<br>");


//リストにメンバー確認
$list_members = "sudo /usr/local/psa/bin/maillist -i test_test_12 -domain fcetc-7habits.jp";
system("$list_members");
echo ("<br>");
echo ("<br>");



//$list_members = "sudo /usr/local/psa/bin/maillist -i test_test6 -domain 7-habits.jp 2>&1";
//exec($list_members, $error, $return);
//var_dump($error);
//echo ("<br>");
//echo ($return);
//echo ("<br>");
//echo ("<br>");



?>