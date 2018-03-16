<?php
//リスト作成
//$newlist = "sudo /usr/local/psa/bin/maillist -c Challengemail20150404_4_a -domain training-c.co.jp -passwd mailingpass -passwd_type plain -email a_nakamura@fujiball.co.jp";
//system("$newlist");
//echo ("<br>");
//echo ("<br>");
//echo ("<br>");
//echo ("<br>");

$newlist = "sudo /usr/local/psa/bin/maillist -c test_mailman_test -domain fcetc-7habits.jp -passwd mailpass -passwd_type plain -email a_nakamura@fujiball.co.jp 2>&1";

exec($newlist, $error, $return);
var_dump($error);
echo ("<br>");
echo ($return);
echo ("<br>");
echo ("<br>");



//リスト確認
$list = "sudo /usr/lib/mailman/bin/list_lists";
system("$list");
echo ("<br>");

?>