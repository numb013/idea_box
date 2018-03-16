<?php
class Util {

  function Util() {
  }

  /**
   * a-z、0-9でランダムに構成された文字列を返します。
   * 
   * @param int $arg 作成する文字列の桁数
   * @return String
   */
  function makeRandomStr($arg) {
    $str = "abcdefghijkmnpqrstuvxyz23456789";
    mt_srand((double)microtime()*1000000);
    $return_str = "";
    for($i = 0; $i < $arg; $i++) {
      $return_str .= substr($str, mt_rand(0, strlen($str) - 1), 1);
    }
    return $return_str;
  }

 /**
  * 現在の日時を"Y/m/d H:i:s"形式で返します。
  * 
  * @return String
  */
  function getYmdHis() {
    return date("Y/m/d H:i:s", time());
  }

  /**
   * 画像をリサイズし保存します。(リネイムも可能)
   * 指定された画像の幅、高さを比較し長い方を$sizeに縮小しそれを元に短い方を等倍で縮小します。
   * jpg, gif, pngに対応しています。
   * 
   * @param String $path リサイズ対象ファイルパス(C:/Program Files/Apache Group/Apache2/htdocs/hoge/img/temp/hoge.jpg)
   * @param String $path2 保存ファイルパス       (C:/Program Files/Apache Group/Apache2/htdocs/hoge/img/rename_hoge.jpg)
   * @param int $size リサイズ後の幅または高さ
   * @return void
   */
  function resizeImg($path, $path2, $size) {
    $path_parts = pathinfo($path);
    $extension  = strtolower($path_parts['extension']);

    if ($extension == 'jpeg' || $extension == 'jpg') {
      $im = imagecreatefromjpeg($path);
    } else if ($extension == 'gif') {
      $im = imagecreatefromgif($path);
    } else if ($extension == 'png') {
      $im = imagecreatefrompng($path);
    }

    $x = imagesx($im);   // 読み込んだ画像の横サイズを取得
    $y = imagesy($im);   // 読み込んだ画像の縦サイズを取得

    // どちらが長いか
    if ($x >= $y) {
      $case = '1';   // 横の方が長い or 縦横同じ
    } else {
      $case = '2';   // 縦の方が長い
    }

    if ($case == '1') {
      $rx = $size;             // サイズ変更後の横サイズ
      $ry = ($rx * $y) / $x;   // サイズ変更後の横サイズ
    } else {
      $ry = $size;             // サイズ変更後の縦サイズ
      $rx = ($ry * $x) / $y;   // サイズ変更後の横サイズ
    }

    // TrueColorイメージを新規に作成
    if ($extension == 'jpeg' || $extension == 'jpg') {
      $im_new = imagecreatetruecolor((int)$rx, (int)$ry);
    } else if ($extension == 'gif') {
      $im_new = imagecreate((int)$rx, (int)$ry);
    } else if ($extension == 'png') {
      $im_new = imagecreatetruecolor((int)$rx, (int)$ry);
    }

    // 画像の一部の複製とサイズ変更
    imageCopyResampled($im_new, $im, 0, 0, 0, 0, (int)$rx, (int)$ry, (int)$x, (int)$y);

    // 画像をファイルに出力
    if ($extension == 'jpeg' || $extension == 'jpg') {
      imagejpeg($im_new, $path2);
    } else if ($extension == 'gif') {
      imagegif($im_new, $path2);
    } else if ($extension == 'png') {
      imagepng($im_new, $path2);
    }

    // メモリの解放
    imagedestroy($im);
    imagedestroy($im_new);
  }

 /**
  * 拡張子を小文字にして返します。
  * 例：
  * hoge.JPG → jpg
  * hoge.Jpg → jpg
  * 
  * @param String $arg
  * @return String
  */
  function getFileExtension($arg) {
    $parts = explode('.', $arg);
    return strtolower($parts[1]);
  }

 /**
  * 文字列を出力します。
  * 
  * @param String $arg
  * @return String
  */
  function echoString($arg) {
    $str = "";
    $str.= "<html>";
    $str.= "<head>";
    $str.= "<meta http-equiv=\"content-type\" content=\"text/html; charset=euc-jp\">";
    $str.= "</head>";
    $str.= "<body>";
    $str.= $arg;
    $str.= "</body>";
    $str.= "</html>";

    echo($str);
  }

 /**
  * メールを送信します。
  * 
  * @param String $to
  * @param String $cc 任意
  * @param String $bcc 任意
  * @param String $from 任意
  * @param String $subject
  * @param String $message
  * @return void
  */
  function sendMail($to, $cc, $bcc, $from, $subject, $message) {
    if (!strlen($cc.$bcc.$from)) {
      mb_send_mail($to, $subject, $message);
    } else {
      $additional_headers = "";
      if (strlen($from)) {
        $additional_headers .= "From: $from";
      }
      if (strlen($cc)) {
        $additional_headers .= "\nCc: $cc";
      }
      if (strlen($bcc)) {
        $additional_headers .= "\nBcc: $bcc";
      }

      $str = "mb_send_mail(\$to, \$subject, \$message, \$additional_headers);";
      eval($str);
    }
  }

 /**
  * 本関数はメール送信時に使用します。
  * テンプレートの指定された個所へ値をセットし文字列を返します。
  * テンプレートへセットする必要がない場合(テンプレートそのままを送信する場合)は
  * 第2引数にブランクをセットして下さい。
  * 
  * @param String $url テンプレートのURL
  * @param String $arg_map セットしたい値
  * @return String
  */
  function setMailValue($url, $arg_map) {

    $return_str = "";

    $lines = file($url);

    if ($arg_map == "") {
      for ($i = 0; $i < count($lines); $i++) {
        $line = $lines[$i];
        $return_str .= $line;
      }
    } else {
      $key_map = array_keys($arg_map);

      for ($i = 0; $i < count($lines); $i++) {
        $line = $lines[$i];
        for ($j = 0; $j < count($key_map); $j++) {
          $str = "\$line = str_replace(\"{[p_".$key_map[$j]."]}\", \$arg_map[\"".$key_map[$j]."\"], \$line);";
          eval($str);
        }
        $return_str .= $line;
      }
    }

    return $return_str;
  }

 /**
  * 現在の日時を"yyyymmdd"形式で返します。
  * 
  * @return String
  */
  function getYyyyMmDd() {
    return date("Ymd", time());
  }

  /**
   * ページングを制御します。
   * 
   * @param $count 全件数
   * @param $page_max 1ページに表示する件数
   */
  function getTotalPage($count, $page_max) {
    $total_page = floor($count / $page_max);
    $rest = $count % $page_max;
    if ($rest != 0) {
      $total_page = $total_page + 1;
    }
    return $total_page;
  }

  /**
   * ページングを制御します。
   * 
   * @param $count 全件数
   * @param $page 現在のページ
   * @param $page_max 1ページに表示する件数
   * @param $link_max リンクとして表示する件数
   * @param $forward 遷移先
   * @param $option リンクに付加するオプション (&name1=value1&name2=value2... の形式)
   */
  function getPagingLink($count, $page_no, $page_max, $link_max, $forward, $option) {
    // 総ページ数を決定する
    $total_page = $this->getTotalPage($count, $page_max);

    // ページングの要否
    if ($count >= $page_max + 1) {
      $paging_flag = "1";
    }

    // リンク表示のMAXより総ページ数が多い場合
    if ($link_max < $total_page) {
      $link_max_flag = "1";
    }

    // クリックしたページ番号がリンク表示のMAXの半分より手前かどうか
    if ($page_no <= ($link_max / 2)) {
      $page_no_small_flag = "1";
    }

    // クリックしたページ番号がリンク表示のMAXの半分より先かどうか
    if ($total_page - $page_no <= ($link_max / 2)) {
      $page_no_big_flag = "1";
    }

    // [前を表示]
    if (strlen($page_no) && $page_no != 1) {
      $front      = $page_no - 1;
      $front_link = " <a href=\"".$forward.
                    "?page=".$front.$option."\" class='previous'>".
                    "Prev</a> ";
//                    "前の".$page_max."件</a> ";
    }

    // [次を表示]
    if (strlen($page_no) && $page_no != $total_page) {
      $next      = $page_no + 1;
      $next_link = " <a href=\"".$forward.
                    "?page=".$next.$option."\" class='next'>".
                    "Next</a> ";
//                    "次の".$page_max."件</a> ";
    }

    // リンクスタート
    if ($link_max_flag != "1") {
      $link_start = 1;
    } else if ($page_no_small_flag == "1") {
      $link_start = 1;
    } else if ($page_no_big_flag == "1") {
      $link_start = $page_no - ($link_max - 1) + ($total_page - $page_no);
    } else {
      $link_start = $page_no - (ceil($link_max / 2) - 1);
    }

    // リンクエンド
    if ($link_max_flag != "1") {
      $link_end = $total_page;
    } else if ($page_no_big_flag == "1") {
      $link_end = $total_page;
    } else if ($page_no_small_flag == "1") {
      $link_end = $link_max;
    } else {
      $link_end = $page_no + (floor($link_max / 2));
    }

    if ($paging_flag == "1") {
      // ページ数のリンクを作成する
      for ($cnt = $link_start; $cnt <= $link_end; $cnt++) {
        if ($cnt == $page_no) {
          $paging_link = $paging_link."　".$cnt."　";
        } else {
          $paging_link = $paging_link." <a href=\"".$forward."?page=".$cnt.$option."\" class='page'>　".$cnt."　</a> ";
        }
      }
      //$paging_link = $front_link.$paging_link.$next_link;
      $paging_link = $front_link."　".$paging_link."　".$next_link;
    }
    return $paging_link;
  }

  /**
   * 2次元配列からselectタグを作成して返します。
   * $blank_textに文字列をセットすると、
   * 先頭に、[値=""][表示文字="文字列"]のoptionタグが追加されます。
   * $blank_textに""をセットすると、先頭にoptionタグは追加されません。
   * $blank_textに"BLANK"をセットすると、
   * 先頭に、[値=""][表示文字=""]のoptionタグが追加されます。
   *
   * @param Array $array 2次元配列
   * @param String $name selectタグの名前
   * @param int $width selectタグのwidth
   * @param String $selected selectedを付加する値
   * @param String $blank_text 1番目のoptionタグに指定する値
   * @return String
   */
  function getSelectTag($array, $name, $width, $selected, $blank_text) {
    $return_str = "<select style=\"width:".$width."\" name=\"".$name."\">\n";
    if (strlen($blank_text)) {
      if ($blank_text == "BLANK") {
        if (!strlen($selected)) {
          $return_str = $return_str."<option value=\"\" selected></option>";
        } else {
          $return_str = $return_str."<option value=\"\"></option>";
        }
      } else {
        if (!strlen($selected)) {
          $return_str = $return_str."<option value=\"\" selected>".$blank_text."</option>";
        } else {
          $return_str = $return_str."<option value=\"\">".$blank_text."</option>";
        }
      }
    }

    for ($i = 0; $i < count($array); $i++) {
      if ($array[$i][0] == $selected) {
        $return_str = $return_str."<option value=\"".htmlspecialchars($array[$i][0])."\" selected>";
        $return_str = $return_str.htmlspecialchars($array[$i][1]);
        $return_str = $return_str."</option>";
      } else {
        $return_str = $return_str."<option value=\"".htmlspecialchars($array[$i][0])."\">";
        $return_str = $return_str.htmlspecialchars($array[$i][1]);
        $return_str = $return_str."</option>";
      }
    }
    $return_str = $return_str."</select>\n";
    return $return_str;
  }

  /**
   * 2次元配列からselectタグを作成して返します。
   * $blank_textに文字列をセットすると、
   * 先頭に、[値=""][表示文字="文字列"]のoptionタグが追加されます。
   * $blank_textに""をセットすると、先頭にoptionタグは追加されません。
   * $blank_textに"BLANK"をセットすると、
   * 先頭に、[値=""][表示文字=""]のoptionタグが追加されます。
   * $script_nameにセットしたスクリプト名を、onChangeで指定します。
   * 
   * @param Array $array 2次元配列
   * @param String $name selectタグの名前
   * @param int $width selectタグのwidth
   * @param String $selected selectedを付加する値
   * @param String $blank_text 1番目のoptionタグに指定する値
   * @param String $script_name JavaScriptのスクリプト名
   * @return String
   */
  function getSelectTagIncludeScript($array, $name, $width, $selected, $blank_text, $script_name) {
    $return_str = "<select style=\"width:".$width."\" name=\"".$name."\" onChange=\"JavaScript:".$script_name."\">\n";
    if (strlen($blank_text)) {
      if ($blank_text == "BLANK") {
        if (!strlen($selected)) {
          $return_str = $return_str."<option value=\"\" selected></option>";
        } else {
          $return_str = $return_str."<option value=\"\"></option>";
        }
      } else {
        if (!strlen($selected)) {
          $return_str = $return_str."<option value=\"\" selected>".$blank_text."</option>";
        } else {
          $return_str = $return_str."<option value=\"\">".$blank_text."</option>";
        }
      }
    }

    for ($i = 0; $i < count($array); $i++) {
      if ($array[$i][0] == $selected) {
        $return_str = $return_str."<option value=\"".htmlspecialchars($array[$i][0])."\" selected>";
        $return_str = $return_str.htmlspecialchars($array[$i][1]);
        $return_str = $return_str."</option>";
      } else {
        $return_str = $return_str."<option value=\"".htmlspecialchars($array[$i][0])."\">";
        $return_str = $return_str.htmlspecialchars($array[$i][1]);
        $return_str = $return_str."</option>";
      }
    }
    $return_str = $return_str."</select>\n";
    return $return_str;
  }

  /**
   * テキストボックスの入力制御をするため文字列を返します。
   * 
   * @param String $type 制御タイプ
   * @return String
   */
  function getMobileStyle($arg) {
    if (ereg("^DoCoMo", $_SERVER['HTTP_USER_AGENT'])){
      // i-mode用入力制御
      if ($arg == "1") {
        // 全角かな
        return "style=\"-wap-input-format:&quot;*&lt;ja:h&gt;&quot;\" istyle=\"1\"";
      } else if ($arg == "2") {
        // 英字
        return "style=\"-wap-input-format:&quot;*&lt;ja:en&gt;&quot;\" istyle=\"3\"";
      } else if ($arg == "3") {
        // 数字
        return "style=\"-wap-input-format:&quot;*&lt;ja:n&gt;&quot;\" istyle=\"4\"";
      } else {
        return "";
      }
    } else if(ereg("^J-PHONE|^Vodafone|^SoftBank", $_SERVER['HTTP_USER_AGENT'])){
      // j-sky用入力制御
      if ($arg == "1") {
        // 全角かな
        return "MODE=\"hiragana\"";
      } else if ($arg == "2") {
        // 英字
        return "MODE=\"alphabet\"";
      } else if ($arg == "3") {
        // 数字
        return "MODE=\"numeric\"";
      } else {
        return "";
      }
    } else if(ereg("^UP.Browser|^KDDI", $_SERVER['HTTP_USER_AGENT'])){
      // Ezweb用入力制御
      if ($arg == "1") {
        // 全角かな
        return "FORMAT=\"*M\"";
      } else if ($arg == "2") {
        // 英字
        return "FORMAT=\"*m\"";
      } else if ($arg == "3") {
        // 数字
        return "FORMAT=\"*N\"";
      } else {
        return "";
      }
    } else {
      return "";
    }
  }

  /**
   * 全件数中の何件目から何件目を表示しているかの情報を返します。
   * (例)[11] - [20] 番目を表示 (50件ある商品のうち)
   * 
   * @param $count 全件数
   * @param $page 現在のページ
   * @param $page_max 1ページに表示する件数
   */
  function getPagingInfo($count, $page_no, $page_max) {

    $start_cnt = (($page_no - 1) * $page_max) + 1;
    $end_cnt = $page_no * $page_max;
    if ($end_cnt > $count) {
      $end_cnt = $count;
    }
    //return $start_cnt."件-".$end_cnt."件　（<em>全".$count."件</em>の検索結果）";
    return $start_cnt."件～".$end_cnt."件&nbsp;（".$count."件中）";
  }
}



?>
