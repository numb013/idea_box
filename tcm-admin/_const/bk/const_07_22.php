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
define("USERNAME", "mail_list_user");

/** password */
define("PASSWORD", "TYrTdN9T");

/** database_name */
//define("DATABASE_NAME", "srxec");
define("DATABASE_NAME", "mailing_list");

/**-----------------------------------------------
  URL情報
------------------------------------------------*/
/** ルートURL */
define("URL_ROOT", "http://fcetc-7habits.jp/mailing_list");
//define("URL_ROOT", "http://www.red-store.jp/srx");

/** ルートURL(https用) */
define("URL_ROOT_HTTPS", "http://fcetc-7habits.jp/mailing_list");
//define("URL_ROOT_HTTPS", "http://www.red-store.jp/srx");

/** ルートURL(モバイル版) */
define("URL_ROOT_MOBILE", "http://fcetc-7habits.jp/mailing_list//mobile");
//define("URL_ROOT_MOBILE", "http://www.red-store.jp/srx/mobile");

/**-----------------------------------------------
  PATH情報
------------------------------------------------*/
/** ルートPATH */
define("PATH_ROOT", "/var/www/vhosts/fcetc-7habits.jp/httpdocs/mailing_list");
//define("PATH_ROOT", "/var/www/vhosts/red-store.jp/httpdocs/srx");

/** ルートPATH(モバイル版) */
define("PATH_ROOT_MOBILE", "/var/www/vhosts/fcetc-7habits.jp/httpdocs/mailing_list");
//define("PATH_ROOT_MOBILE", "/var/www/vhosts/red-store.jp/httpdocs/srx/mobile");

/**-----------------------------------------------
  その他
------------------------------------------------*/
/** 管理システムtitleタグ */
define("ADMIN_TITLE", "メーリングリスト管理ページ");

/**-------------------------------------------------------------------------------------------------
  導入時設定必要なし
--------------------------------------------------------------------------------------------------*/
/**-----------------------------------------------
  PATH情報
------------------------------------------------*/
/** ログPATH */
define("LOG", PATH_ROOT."/admin/_log");

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

/**-----------------------------------------------
  linux情報
------------------------------------------------*/

/** ルートURL */
define("URL_ROOT_MAILMAN", "/var/www/vhosts/fcetc-7habits.jp/httpdocs/mailing_list");
//define("URL_ROOT_MAILMAN", "/var/www/vhosts/training-c.co.jp/httpdocs/mailing_list");

/** ルートURL */
//define("URL_ROOT_FCE", "@training-c.co.jp");
define("URL_ROOT_FCE", "@fcetc-7habits.jp");

/** 管理者アドレス */
define("HOST_ADDRESS", "mail_master@training-c.co.jp");

/** ドメイン */
define("DOMAIN", "fcetc-7habits.jp");

/** サンキューメール送信者 */
define("THANK_ADDRESS", "mail_master@training-c.co.jp");

/** テキストURL */
//define("FCE_ROOT", "C:/Apache Software Foundation/Apache2.2/htdocs");
define("FCE_ROOT", "/var/www/vhosts/fcetc-7habits.jp/httpdocs");

/** リストPASS */
define("LIST_PASSWARD", "f32fdasJlteFeao39JEa");

?>
