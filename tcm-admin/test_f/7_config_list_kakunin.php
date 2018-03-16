<?php

// リストの設定ファイルをconfig_list_output.txtで出力

$copy = "sudo /usr/lib/mailman/bin/config_list -o /var/www/vhosts/training-c.co.jp/httpdocs/mailing_list/tcm-admin/test_f/config_list_output_kakunin.txt Challengemail20150622_14_a";
exec("$copy");



//config_list_input.txtをリストにインプットし設定変更
$config_list = "sudo /usr/lib/mailman/bin/config_list -i /var/www/vhosts/training-c.co.jp/httpdocs/mailing_list/admin/test_f/config_list_input_kakunin.txt Challengemail20150619_6_a";
exec("$config_list");


$copy = "sudo /usr/lib/mailman/bin/config_list -o /var/www/vhosts/training-c.co.jp/httpdocs/mailing_list/tcm-admin/test_f/config_list_output_kakunin_1.txt Challengemail20150622_14_a";
exec("$copy");


?>