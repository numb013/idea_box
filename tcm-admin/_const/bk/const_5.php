<?php
/**-------------------------------------------------------------------------------------------------
  導入時設定必要
--------------------------------------------------------------------------------------------------*/
/**-----------------------------------------------
  データベース接続情報
------------------------------------------------*/
/** server */
//define("SERVER", "127.0.0.1");
define("SERVER", "localhost");

/** username */
//define("USERNAME", "root");
define("USERNAME", "mailing_list");

/** password */
//define("PASSWORD", "hoge");
define("PASSWORD", "TYrTdN9T");

/** database_name */
//define("DATABASE_NAME", "srxec");
//define("DATABASE_NAME", "mailing_list");
define("DATABASE_NAME", "211123027_mailing_list");
/**-----------------------------------------------
  URL情報
------------------------------------------------*/
/** ルートURL */
define("URL_ROOT", "http://www.training-c.co.jp/mailing_list");
//define("URL_ROOT", "http://localhost/mailing_list");

/** ルートURL(https用) */
define("URL_ROOT_HTTPS", "http://www.training-c.co.jp/mailing_list");
//define("URL_ROOT_HTTPS", "http://localhost/mailing_list");

/** ルートURL(モバイル版) */
define("URL_ROOT_MOBILE", "http://www.training-c.co.jp/mobile");
//define("URL_ROOT_MOBILE", "http://localhost/mailing_list/mobile");

/**-----------------------------------------------
  PATH情報
------------------------------------------------*/
/** ルートPATH */
define("PATH_ROOT", "/var/www/vhosts/training-c.co.jp/httpdocs/mailing_list");
//define("PATH_ROOT", "C:\Apache Software Foundation\Apache2.2\htdocs\mailing_list");

/** ルートPATH(モバイル版) */

define("PATH_ROOT_MOBILE", "/var/www/vhosts/training-c.co.jp/httpdocs/mailing_list/mobile");
//define("PATH_ROOT_MOBILE", "C:\Apache Software Foundation\Apache2.2\htdocs\mailing_list/mobile");
//define("PATH_ROOT_MOBILE", "/var/www/vhosts/red-store.jp/httpdocs/srx/mobile");

/**-----------------------------------------------
  その他
------------------------------------------------*/
/** 管理システムtitleタグ */
define("ADMIN_TITLE", "メーリスト テストサーバー");

/**-------------------------------------------------------------------------------------------------
  導入時設定必要なし
--------------------------------------------------------------------------------------------------*/
/**-----------------------------------------------
  PATH情報
------------------------------------------------*/
/** ログPATH */
define("LOG", PATH_ROOT."/tcm-admin/_log");

/** $smarty->template_dir */
define("TEMPLATE_DIR", PATH_ROOT."/templates");

/** $smarty->compile_dir */
define("COMPILE_DIR", PATH_ROOT."/templates_c");

/** $smarty->template_dir(モバイル版) */
define("TEMPLATE_DIR_MOBILE", PATH_ROOT_MOBILE."/templates");

/** $smarty->compile_dir(モバイル版) */
define("COMPILE_DIR_MOBILE", PATH_ROOT_MOBILE."/templates_c");

/**-----------------------------------------------
  その他情報
------------------------------------------------*/
/** TEXT型のMAX値(バイト) */
define("TEXT_MAX", "3000");



/** exeのでバックモード */
define("DEBUG_MODE","0");


/**-----------------------------------------------
  linux情報
------------------------------------------------*/
/** ルートURL */
//define("URL_ROOT_LINUX", "/var/www/html/mailing_list");
//define("URL_ROOT", "http://www.red-store.jp/srx");

/** ルートURL */
define("URL_ROOT_MAILMAN", "/var/www/vhosts/training-c.co.jp/httpdocs/mailing_list");
//define("URL_ROOT_MAILMAN", "C:/Apache Software Foundation/Apache2.2/htdocs/mailing_list");
//define("URL_ROOT_MAILMAN", "/var/www/vhosts/training-c.co.jp/httpdocs/mailing_list");

/** ルートURL */
define("URL_ROOT_FCE", "@training-c.co.jp");
//define("URL_ROOT_FCE", "@fcetc-7habits.jp");

/** 管理者アドレス */
//define("HOST_ADDRESS", "mail_master@training-c.co.jp");
define("HOST_ADDRESS", "a_nakamura@fujiball.co.jp");

/** ドメイン */
define("DOMAIN", "training-c.co.jp");

/** テキストURL */
define("FCE_ROOT", "/var/www/vhosts/training-c.co.jp/httpdocs");
//define("FCE_ROOT", "C:/Apache Software Foundation/Apache2.2/htdocs");
//define("FCE_ROOT", "/var/www/vhosts/training-c.co.jp/httpdocs");

/** リストPASS */
//define("LIST_PASSWARD", "34fjaeo4%ioIejfofaopd");
define("LIST_PASSWARD", "numb013013");


?>
