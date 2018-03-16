<?php
//リストにメンバー確認
$list_members = "sudo /usr/local/psa/bin/maillist -i Challengemail20150404_4_a -domain training-c.co.jp";
system("$list_members");
echo ("<br>");
echo ("<br>");
?>