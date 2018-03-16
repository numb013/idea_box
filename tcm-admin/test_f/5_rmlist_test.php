<?php

//リスト削除
//$rmlist = "sudo /usr/local/psa/bin/maillist -r Challengemail20150404_4_a -domain training-c.co.jp";
//system("$rmlist");
//echo ("<br>");
//echo ("<br>");

//$newlist = "sudo /usr/local/psa/bin/maillist -c Challengemail20150404_4_a -domain training-c.co.jp -passwd mailingpass -passwd_type plain -email a_nakamura@fujiball.co.jp 2>&1";
$rmlist = "sudo /usr/local/psa/bin/maillist -r Challengemail_testtt -domain training-c.co.jp 2>&1";
exec($rmlist, $error, $return);
var_dump($error);
echo ($return);


echo ("<br>");
echo ("<br>");


//リスト確認
$list = "sudo /usr/lib/mailman/bin/list_lists";
system("$list");
echo ("<br>");


?>