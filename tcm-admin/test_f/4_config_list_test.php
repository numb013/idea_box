<?php

// ���X�g�̐ݒ�t�@�C����config_list_output.txt�ŏo��
//$copy = "sudo /usr/lib/mailman/bin/config_list -o /var/www/vhosts/training-c.co.jp/httpdocs/mailing_list/admin/test_f/config_list_output.txt Challengemail20150619_6_a";
//exec("$copy");
echo "sssss";
echo "<br>";

$copy = "sudo /usr/lib/mailman/bin/config_list -o /var/www/vhosts/training-c.co.jp/httpdocs/mailing_list/tcm-admin/test_f/config_list_output.txt Challengemail20150622_14_a";
exec("$copy");


//$copy = "sudo /usr/lib/mailman/bin/config_list -o /var/www/vhosts/training-c.co.jp/httpdocs/test_e/config_list_output.txt test_test6 2>&1";
//exec($copy, $error, $return);
//var_dump($error);
//echo ("<br>");
//echo ($return);
//echo ("<br>");
//echo ("<br>");



//$kakikae_user = "sudo sed -i -e 's/^.*generic_nonmember_action.*/generic_nonmember_action = 9/g' /var/www/vhosts/training-c.co.jp/httpdocs/test_c/kakunin.txt 2>&1";
////system($kakikae_user);
//exec($kakikae_user, $error, $return);
//var_dump($error);
//echo ("<br>");
//echo ($return);
//echo ("<br>");
//echo ("<br>");



// config_list_output.txt�̕����R�[�h�ύX��config_list_input.txt�ɏ����o��
//$text = file_get_contents("/var/www/vhosts/training-c.co.jp/httpdocs/mailing_list/admin/test_f/config_list_output.txt");
//$text = mb_convert_encoding($text, "UTF-8", "auto");
//file_put_contents("/var/www/vhosts/training-c.co.jp/httpdocs/mailing_list/admin/test_f/config_list_input.txt", $text);


// config_list_input.txt�ɐݒ��ύX��������������������
//$text = file_get_contents("/var/www/vhosts/training-c.co.jp/httpdocs/mailing_list/admin/test_f/config_list_input.txt");
//$from = "/^.*#.*\n/um";
//$to   = null;
//$text = preg_replace("$from", "$to", $text);
//$from = "/^.*generic_nonmember_action =.*$/um";
//$to   = "generic_nonmember_action = 18";
//$text = preg_replace($from, $to, $text);
//$from = "/^.*send_reminders =.*$/um";
//$to   = "send_reminders = 18";
//$text = preg_replace($from, $to, $text);
//$from = "/^.*send_goodbye_msg =.*$/um";
//$to   = "send_goodbye_msg = 17";
//$text = preg_replace($from, $to, $text);
//$from = "/^.*send_welcome_msg =.*$/um";
//$to   = "send_welcome_msg = 17";
//$text = preg_replace($from, $to, $text);


//file_put_contents("/var/www/vhosts/training-c.co.jp/httpdocs/mailing_list/admin/test_f/config_list_input.txt", $text);


//config_list_input.txt�����X�g�ɃC���v�b�g���ݒ�ύX
//$config_list = "sudo /usr/lib/mailman/bin/config_list -i /var/www/vhosts/training-c.co.jp/httpdocs/mailing_list/admin/test_f/config_list_input.txt Challengemail20150619_6_a";
//exec("$config_list");


//$config_list = "sudo /usr/lib/mailman/bin/config_list -i /var/www/vhosts/training-c.co.jp/httpdocs/test_f/config_list_input.txt test_test_12 2>&1";
//exec($config_list, $error, $return);
//var_dump($error);
//echo ("<br>");
//echo ($return);
//echo ("<br>");
//echo ("<br>");



//$copy = "sudo /usr/lib/mailman/bin/config_list -o /var/www/vhosts/training-c.co.jp/httpdocs/mailing_list/admin/test_f/config_list_output_1.txt Challengemail20140610_1_a";
//exec("$copy");


?>