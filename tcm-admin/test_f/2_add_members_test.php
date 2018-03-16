<?php

echo "gggg";
echo "<br>";
//リストにメンバー追加
//$list_member = "sudo /usr/local/psa/bin/maillist -u test_test_12 -domain fcetc-7habits.jp -members add:a_nakamura@fujiball.co.jp,b_nakamura@fujiball.co.jp,numb013013@yahoo.co.jp";
//
//system("$list_member");
//echo ("<br>");
//echo ("<br>");
//echo ("<br>");
//echo ("<br>");


//$list_member = "sudo /usr/local/psa/bin/maillist -u test_test_12 -domain fcetc-7habits.jp -members add:a_nakamura@fujiball.co.jp,numb013013@yahoo.co.jp 2>&1";
//
//exec($list_member, $error, $return);
//var_dump($error);
//echo ("<br>");
//echo ($return);
//echo ("<br>");
//echo ("<br>");


echo "ffff";

//リストにメンバー確認
$list_members = "sudo /usr/local/psa/bin/maillist -i Challengemail20150401_1_b -domain fcetc-7habits.jp";
system("$list_members");
echo ("<br>");
echo ("<br>");



//$list_members = "sudo /usr/local/psa/bin/maillist -i test_test_12 -domain fcetc-7habits.jp 2>&1";

//exec($list_members, $error, $return);
//var_dump($error);
//echo ("<br>");
//echo ($return);
//echo ("<br>");
//echo ("<br>");


//リスト確認
//$list = "sudo /usr/lib/mailman/bin/list_lists";
//system("$list");
//echo ("<br>");


//リスト確認
//$list = "sudo /usr/lib/mailman/bin/list_lists";
//system("$list");
//echo ("<br>");


//リスト確認
$list = "sudo /usr/lib/mailman/bin/list_lists 2>&1 tty";
exec($list, $error, $return);
var_dump($error);
echo ("<br>");
echo ($return);
echo ("<br>");
echo ("<br>");



//$kakikae_user = "sudo sed -i -e 's/^.*generic_nonmember_action.*/generic_nonmember_action = 9/g' /var/www/vhosts/fcetc-7habits.jp/httpdocs/test_c/kakunin.txt 2>&1";
////system($kakikae_user);
//exec($kakikae_user, $error, $return);
//var_dump($error);
//echo ("<br>");
//echo ($return);
//echo ("<br>");
//echo ("<br>");







?>