<?php
/**-------------------------------------------------------------------------------------------------
  導入時設定必要
--------------------------------------------------------------------------------------------------*/
/**-----------------------------------------------
  データベース接続情報
------------------------------------------------*/
/** server */
//define("SERVER", "127.0.0.1");
define("SERVER", "192.168.33.10");

/** username */
define("USERNAME", "sample");
//define("USERNAME", "mail_list_user");

/** password */
define("PASSWORD", "sample");
//define("PASSWORD", "TYrTdN9T");

/** database_name */
//define("DATABASE_NAME", "srxec");
define("DATABASE_NAME", "idea_box");
//define("DATABASE_NAME", "211123027_mailing_list");
/**-----------------------------------------------
  URL情報
------------------------------------------------*/
/** ルートURL */
define("URL_ROOT", "/data/idea_box");
//define("URL_ROOT", "http://www.red-store.jp/srx");

/** ルートURL(https用) */
define("URL_ROOT_HTTPS", "/data/idea_box");
//define("URL_ROOT_HTTPS", "http://www.red-store.jp/srx");

/** ルートURL(モバイル版) */
define("URL_ROOT_MOBILE", "/data/idea_box");
//define("URL_ROOT_MOBILE", "http://www.red-store.jp/srx/mobile");

/**-----------------------------------------------
  PATH情報
------------------------------------------------*/
/** ルートPATH */
define("PATH_ROOT", "/var/www/html/data/idea_box");
//define("PATH_ROOT", "/var/www/vhosts/red-store.jp/httpdocs/srx");

/** ルートPATH(モバイル版) */
define("PATH_ROOT_MOBILE", "/var/www/html/data/idea_box/mobile");
//define("PATH_ROOT_MOBILE", "/var/www/vhosts/red-store.jp/httpdocs/srx/mobile");

/**-----------------------------------------------
  その他
------------------------------------------------*/
/** 管理システムtitleタグ */
define("ADMIN_TITLE", "メーリスト マイサーバー");

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



/** exeのでバックモード */
define("DEBUG_MODE","0");


/**-----------------------------------------------
  linux情報
------------------------------------------------*/
/** ルートURL */
//define("URL_ROOT_LINUX", "/var/www/html/mailing_list");
//define("URL_ROOT", "http://www.red-store.jp/srx");

/** ルートURL */
define("URL_ROOT_MAILMAN", "C:/Apache Software Foundation/Apache2.2/htdocs/idea_box");
//define("URL_ROOT_MAILMAN", "/var/www/vhosts/training-c.co.jp/httpdocs/mailing_list");

/** ルートURL */
//define("URL_ROOT_FCE", "@training-c.co.jp");
define("URL_ROOT_FCE", "@fcetc-7habits.jp");

/** 管理者アドレス */
define("HOST_ADDRESS", "nakamura@example.local");

/** ドメイン */
define("DOMAIN", "fcetc-7habits.jp");

/** サンキューメール送信者 */
define("THANK_ADDRESS", "mail_master@training-c.co.jp");

/** テキストURL */
define("FCE_ROOT", "C:/Apache Software Foundation/Apache2.2/htdocs");
//define("FCE_ROOT", "/var/www/vhosts/training-c.co.jp/httpdocs");


?>
