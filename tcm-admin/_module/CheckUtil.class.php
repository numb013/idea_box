<?php
class CheckUtil {

  function CheckUtil() {
    mb_regex_encoding("UTF-8");
  }

  /** 
   * 入力されたパスワードが適切な文字で構成されているかチェックします。
   * 
   * @param String $arg チェック対象文字列
   * @return String "0":正しいパスワード "9":左記以外
   */
  function checkPassword($arg){
    $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";   // 適切な文字群

    for ($i = 0; $i < mb_strlen($arg); $i++) {
      if (mb_strpos($str, mb_substr($arg, $i, 1)) === false) {
        return "9";
        exit();
      }
    }

    return "0";
    exit();
  }

  /**
   * 電話番号チェックを行ないます。
   * 
   * @param String $arg チェック対象文字列
   * @return String "0":正しい形式です "9":左記以外
   */
  function checkPhone($arg) {
    if (preg_match("/^\d+\-\d+\-\d+$/", $arg)) {
      return("0");
    } else {
      return("9");
    }
  }

  /** 
   * 文字列が全角カタカナのみで構成されているかチェックします。
   * 半角スペース、全角スペースを許容します。
   * 
   * @param String $arg チェック対象文字列
   * @return String "0":全角カタカナのみ "9":左記以外
   */
  function checkZenkakuKatakana($arg){
    if (mb_ereg("^[ァ-ヶ|ー| |　]+$" ,$arg)) {
      return "0";
    } else {
      return "9";
    }
  }

  /**
   * 半角数値[0-9]チェックを行ないます。
   * 
   * @param String $arg チェック対象文字列
   * @return String "0":半角数値 "9":左記以外
   */
  function checkHanSu($arg) {
    if (preg_match("/^[0-9]+$/", $arg)) {
      return "0";
    } else {
      return "9";
    }
  }

  /**
   * 画像がgif、jpg、pngであるかチェックします。
   * bmp、swf等の対応外ファイルの拡張子をjpg等に変更したものでも'9'を返します。
   * 
   * @param String $path チェック対象ファイルパス(C:/Program Files/Apache Group/Apache2/htdocs/hoge/img/hoge.jpg)
   * @return String "0"：右記以外 "9"：不正
   */
  function checkImg($path) {
    $path_parts = pathinfo($path);
    $extension  = strtolower($path_parts["extension"]);

    if ($extension == "jpeg" || $extension == "jpg") {
      $im = @imagecreatefromjpeg($path);
    } else if ($extension == "gif") {
      $im = @imagecreatefromgif($path);
    } else if ($extension == "png") {
      $im = @imagecreatefrompng($path);
    } else {
      return "9";
      exit();
    }

    if (!strlen($im)) {
      return "9";
    } else {
      return "0";
    }
    exit();
  }

  /**
   * メールアドレスの形式が正しいかどうかをチェックします。
   * 
   * @param $mailaddress メールアドレス
   * return "0":正しい形式 "9":不正な形式
   */
  function checkMailForm($mailaddress) {
    if (preg_match('/^([a-z0-9_]|\-|\.|\+)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,6}$/i', $mailaddress)) {
      return "0";
    }
    return "9";
  }

  /**
   * URLの形式が正しいかどうかをチェックします。
   * 
   * @param $url URL
   * return "0":正しい形式 "9":不正な形式
   */
  function checkUrlForm($url){
    if (ereg("^s?https?://[-_.!~*'()a-zA-Z0-9;/?:@&=+$,%#]+$" ,$url)) {
      return "0";
    } else {
      return "9";
    }
  }


}
?>
