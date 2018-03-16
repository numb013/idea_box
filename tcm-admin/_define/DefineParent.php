<?php
/**
 * 定義クラスの親クラスです。
 */
class DefineParent {

  /**
   * デフォルトのコンストラクタです。
   */
  function DefineParent() {
  }

  /** 値の配列 */
  var $value_list;
  /** 表示文字列の配列 */
  var $string_list;
  /** テーブルカラム名の配列 */
  var $column_name_list;

  /**
   * 値を引数に取り、その値に紐づく表示文字列を返します。
   *
   * @param String $arg 値
   * @return String 表示文字列
   */
  function getStringByValue($arg) {
    $value_cnt = count($this->value_list);
    for ($cnt = 0; $cnt < $value_cnt; $cnt++) {
      if($arg == $this->value_list[$cnt]) {
        return $this->string_list[$cnt];
      }
    }
    return "";
  }

  /**
   * 表示文字列を引数に取り、その表示文字列に紐づく値を返します。
   *
   * @param String $arg 表示文字列
   * @return String 値
   */
  function getValueByString($arg) {
    $string_cnt = count($this->string_list);
    for ($cnt = 0; $cnt < $string_cnt; $cnt++) {
      if($arg == $this->string_list[$cnt]) {
        return $this->value_list[$cnt];
      }
    }
    return "";
  }

  /**
   * 値を引数に取り、その値に紐づくテーブルカラム名を返します。
   *
   * @param String $arg 値
   * @return String テーブルカラム名
   */
  function getColumnNameByValue($arg) {
    $value_cnt = count($this->value_list);
    for ($cnt = 0; $cnt < $value_cnt; $cnt++) {
      if($arg == $this->value_list[$cnt]) {
        return $this->column_name_list[$cnt];
      }
    }
    return "";
  }

  /**
   * 配列の値から、連結された定義値を返します。
   *
   * @param Array $array_arg 配列値
   * @param INT $turn_num  改行したい表示番目
   * @return String 連結された定義値
   */
  function getStringByArrayValue($array_arg, $turn_num) {
    $str_value = "";
    if (!$array_arg || count($array_arg) == 0) {
      return $str_value;
    }
    $turn      = 1;
    $start_num = 1;
    for ($array_cnt = 0; $array_cnt < count($array_arg); $array_cnt++) {
      $arg = $array_arg[$array_cnt];
      $value_cnt = count($this->value_list);
      for ($cnt = 0; $cnt < $value_cnt; $cnt++) {
        if ($arg == $this->value_list[$cnt]) {
          $str_value = $str_value.$this->string_list[$cnt];
        }
      }
      if ($array_cnt != count($array_arg) - 1) {
        $str_value = $str_value.",&nbsp;";
      }
      if ($turn == $turn_num) {
        $turn = 1;
        if ($start_num != count($array_arg)) {
          $str_value = $str_value."<br>\n";
        }
      } else {
        $turn = $turn + 1;
      }
      $start_num = $start_num + 1;
    }
    return $str_value;
  }

  /**
   * value_listの件数分のoptionタグを返します。
   * optionタグの属性値は、value=値、ラベル=表示値となります。
   * 引数で受け取った値のoptionタグには、selected属性が付加されます。
   *
   * @param String $value selected属性を付加する値
   * @return String optionタグ
   */
  function getOptionTags($value) {
    $return_str = "";
    $value_cnt = count($this->value_list);
    for ($cnt = 0; $cnt < $value_cnt; $cnt++) {
      $selected = "";
      if ($value == $this->value_list[$cnt]) {
        $selected = " selected";
      }
      $return_str = $return_str."<option value=\"".$this->value_list[$cnt]."\"".$selected.">".$this->string_list[$cnt]."</option>\n";
    }
    return $return_str;
  }

  /**
   * selectタグと、value_listの件数分のoptionタグを返します。
   * selectタグの属性値は、name=第1引数($name)、style=第2引数($width)となります。
   * optionタグの属性値は、value=値、ラベル=表示値となります。
   * 第3引数で受け取った値のoptionタグには、selected属性が付加されます。。
   *
   * 第4引数の$blank_textに文字列をセットすると、
   * 先頭に、[値=""][表示文字="文字列"]のOPTIONタグが追加されます。
   * $blank_textに""をセットすると、先頭にOPTIONタグは追加されません。
   * $blank_textに"BLANK"をセットすると、
   * 先頭に、[値=""][表示文字=""]のOPTIONタグが追加されます。
   *
   * @param String $name セレクトタグ名
   * @param String $width セレクトタグ幅
   * @param String $selected_value selected属性を付加する値
   * @param String $blank_text 1番目のOPTIONタグに指定する値
   * @return String selectタグとoptionタグ
   */
  function getSelectTags($name, $width, $selected_value, $blank_text) {
    $return_str = "<select style=\"width:".$width."\" name=\"".$name."\">\n";

    if (strlen($blank_text)) {
      if ($blank_text == "BLANK") {
        if (!strlen($selected_value)) {
          $return_str = $return_str."<option value=\"\" selected></option>\n";
        } else {
          $return_str = $return_str."<option value=\"\"></option>\n";
        }
      } else {
        if (!strlen($selected_value)) {
          $return_str = $return_str."<option value=\"\" selected>".$blank_text."</option>\n";
        } else {
          $return_str = $return_str."<option value=\"\">".$blank_text."</option>\n";
        }
      }
    }

    $value_cnt = count($this->value_list);
    for ($cnt = 0; $cnt < $value_cnt; $cnt++) {
      $selected = "";
      if ($selected_value == $this->value_list[$cnt]) {
        $selected = " selected";
      }
      $return_str = $return_str."<option value=\"".$this->value_list[$cnt]."\"".$selected.">".$this->string_list[$cnt]."</option>\n";
    }
    $return_str = $return_str."</select>\n";
    return $return_str;
  }

  function getSelectTagsMultiple($name, $width, $size, $selected_value, $blank_text) {
    $return_str = "<select style=\"width:".$width."\" name=\"".$name."\" multiple size=\".$size.\">\n";

    if (strlen($blank_text)) {
      if ($blank_text == "BLANK") {
        if (!strlen($selected_value)) {
          $return_str = $return_str."<option value=\"\" selected></option>\n";
        } else {
          $return_str = $return_str."<option value=\"\"></option>\n";
        }
      } else {
        if (!strlen($selected_value)) {
          $return_str = $return_str."<option value=\"\" selected>".$blank_text."</option>\n";
        } else {
          $return_str = $return_str."<option value=\"\">".$blank_text."</option>\n";
        }
      }
    }

    $value_cnt = count($this->value_list);
    for ($cnt = 0; $cnt < $value_cnt; $cnt++) {
      $selected = "";
      if ($selected_value == $this->value_list[$cnt]) {
        $selected = " selected";
      }
      $return_str = $return_str."<option value=\"".$this->value_list[$cnt]."\"".$selected.">".$this->string_list[$cnt]."</option>\n";
    }
    $return_str = $return_str."</select>\n";
    return $return_str;
  }

  /**
   * onChange時に実行されるJavaScriptのスクリプト名を含むselectタグと、
   * value_listの件数分のoptionタグを返します。
   * selectタグの属性値は、name=第1引数($name)、style=第2引数($width)となります。
   * optionタグの属性値は、value=値、ラベル=表示値となります。
   * 第3引数で受け取った値のoptionタグには、selected属性が付加されます。。
   * 第4引数で受け取ったスクリプト名を、onChangeで指定します。
   *
   * 第5引数の$blank_textに文字列をセットすると、
   * 先頭に、[値=""][表示文字="文字列"]のOPTIONタグが追加されます。
   * $blank_textに""をセットすると、先頭にOPTIONタグは追加されません。
   * $blank_textに"BLANK"をセットすると、
   * 先頭に、[値=""][表示文字=""]のOPTIONタグが追加されます。
   *
   * @param String $name セレクトタグ名
   * @param String $width セレクトタグ幅
   * @param String $selected_value selected属性を付加する値
   * @param String $script_name JavaScriptのスクリプト名
   * @param String $blank_text 1番目のOPTIONタグに指定する値
   * @return String selectタグとoptionタグ
   */
  function getSelectTagsIncludeScript($name, $width, $selected_value, $script_name, $blank_text) {
    $return_str = "<select style=\"width:".$width."\" name=\"".$name."\" onChange=\"JavaScript:".$script_name."\">\n";

    if (strlen($blank_text)) {
      if ($blank_text == "BLANK") {
        if (!strlen($selected_value)) {
          $return_str = $return_str."<option value=\"\" selected></option>\n";
        } else {
          $return_str = $return_str."<option value=\"\"></option>\n";
        }
      } else {
        if (!strlen($selected_value)) {
          $return_str = $return_str."<option value=\"\" selected>".$blank_text."</option>\n";
        } else {
          $return_str = $return_str."<option value=\"\">".$blank_text."</option>\n";
        }
      }
    }

    $value_cnt = count($this->value_list);
    for ($cnt = 0; $cnt < $value_cnt; $cnt++) {
      $selected = "";
      if ($selected_value == $this->value_list[$cnt]) {
        $selected = " selected";
      }
      $return_str = $return_str."<option value=\"".$this->value_list[$cnt]."\"".$selected.">".$this->string_list[$cnt]."</option>\n";
    }
    $return_str = $return_str."</select>\n";
    return $return_str;
  }

  /**
   * value_listの件数分のラジオボタンタグ(input type="radio")を返します。
   * ラジオボタンタグの属性値は、name=第1引数($name)、value=値、ラベル=表示値となります。
   * 第2引数で受け取った値のラジオボタンタグには、checked属性が付加されます。
   * 第2引数がブランクの場合、checked属性は付加されません
   * 
   * @param String $name ラジオボタンタグ名
   * @param String $checked_value checked属性を付加する値
   * @return String ラジオボタンタグ
   */
  function getRadioTags($name, $checked_value) {
    $return_str = "";
    $value_cnt = count($this->value_list);
    for ($cnt = 0; $cnt < $value_cnt; $cnt++) {
      // VALUEが "" or nullの場合、continueする
      if (!strlen($this->value_list[$cnt])) {
        continue;
      }
      $checked = "";
      if ($checked_value == $this->value_list[$cnt] && strlen($checked_value)) {
        $checked = " checked";
      }
      $return_str = $return_str."<input type=\"radio\" name=\"".$name."\" value=\"".$this->value_list[$cnt]."\"".$checked.">".$this->string_list[$cnt]."\n";
    }
    return $return_str;
  }

  /**
   * value_listの件数分のラジオボタンタグ(input type="radio")をdisabledの状態で返します。
   * ラジオボタンタグの属性値は、name=第1引数($name)、value=値、ラベル=表示値となります。
   * 第2引数で受け取った値のラジオボタンタグには、checked属性が付加されます。
   * 第2引数がブランクの場合、checked属性は付加されません
   * 
   * @param String $name ラジオボタンタグ名
   * @param String $checked_value checked属性を付加する値
   * @return String ラジオボタンタグ
   */
  function getRadioTagsDisabled($name, $checked_value) {
    $return_str = "";
    $value_cnt = count($this->value_list);
    for ($cnt = 0; $cnt < $value_cnt; $cnt++) {
      // VALUEが "" or nullの場合、continueする
      if (!strlen($this->value_list[$cnt])) {
        continue;
      }
      $checked = "";
      if ($checked_value == $this->value_list[$cnt] && strlen($checked_value)) {
        $checked = " checked";
      }
      $return_str = $return_str."<input type=\"radio\" name=\"".$name."\" value=\"".$this->value_list[$cnt]."\"".$checked." disabled>".$this->string_list[$cnt]."\n";
    }
    return $return_str;
  }

  /**
   * value_listの件数分のラジオボタンタグ(input type="radio")を返します。
   * ラジオボタンタグの属性値は、name=第1引数($name)、value=値、ラベル=表示値となります。
   * 第2引数で受け取った値のラジオボタンタグには、checked属性が付加されます。
   * 第2引数がブランクの場合、checked属性は付加されません
   * 
   * @param String $name ラジオボタンタグ名
   * @param String $checked_value checked属性を付加する値
   * @return String ラジオボタンタグ
   */
  function getRadioTagsIncludeBR($name, $checked_value) {
    $return_str = "";
    $value_cnt = count($this->value_list);
    for ($cnt = 0; $cnt < $value_cnt; $cnt++) {
      // VALUEが "" or nullの場合、continueする
      if (!strlen($this->value_list[$cnt])) {
        continue;
      }
      $checked = "";
      if ($checked_value == $this->value_list[$cnt]) {
        $checked = " checked";
      }
      if ($cnt + 1 == $value_cnt) {
        $return_str = $return_str."<input type=\"radio\" name=\"".$name."\" value=\"".$this->value_list[$cnt]."\"".$checked.">".$this->string_list[$cnt]."\n";
      } else {
        $return_str = $return_str."<input type=\"radio\" name=\"".$name."\" value=\"".$this->value_list[$cnt]."\"".$checked.">".$this->string_list[$cnt]."<br>\n";
      }
    }
    return $return_str;
  }

  /**
   * checkboxタグを返します。
   *
   * @param String $name checkboxタグ名
   * @param String $checked_value_list checked="checked"属性を付加するvalueのlist
   * @param int $row いくつで折り返すか
   * @param String $table_tag 例：<table border="0">
   * @param String $tr_tag 例：<tr bgcolor="red">
   * @param String $td_tag 例：<td bgcolor="red">
   * @return String checkboxタグ
   */
  function getCheckBoxTag($name, $checked_value_list, $row, $table_tag, $tr_tag, $td_tag) {
    $return_string  = "";
    $return_string .= $table_tag."\n";

    $row_count = 0;

    for ($i = 0; $i < count($this->value_list); $i++) {
      if ($i == 0) {
        $return_string .= $tr_tag."\n";
      }

      if ($row == $row_count) {
        $return_string .= "</tr>\n";
        $return_string .= $tr_tag."\n";

        $row_count = 0;
      }

      $temp_string = "";

      $return_string .= $td_tag;
      if (is_array($checked_value_list)) {
        for ($j = 0; $j < count($checked_value_list); $j++) {
          if ($checked_value_list[$j] == $this->value_list[$i]) {
            $temp_string = " checked=\"checked\"";
            break;
          }
        }
      }
      $return_string .= "<input type=\"checkbox\" name=\"".$name."[]\" value=\"".$this->value_list[$i]."\"".$temp_string." />".$this->string_list[$i];
      $return_string .= "</td>\n";

      $row_count = $row_count + 1;   // 列目
    }

    if (count($this->value_list) % $row != 0) {
      $temp_integer = $row - (count($this->value_list) % $row);
        for ($k = 0; $k < $temp_integer; $k++) {
          $return_string .= $td_tag;
          $return_string .= "&nbsp;";
          $return_string .= "</td>\n";
        }
    }

    $return_string .= "</tr>\n";
    $return_string .= "</table>\n";

    return $return_string;
  }

  /**
   * 値を引数に取り、その値に紐づく表示文字列を返します。
   *
   * @param array $arg 値
   * @return String 表示文字列
   */
  function getStringByValueList($arg) {
    $return_string = "";
    $value_cnt = count($this->value_list);
    for ($cnt = 0; $cnt < $value_cnt; $cnt++) {
      for ($i = 0; $i < count($arg); $i++) {
        if($arg[$i] == $this->value_list[$cnt]) {
          $return_string .= $this->string_list[$cnt]."　";
        }
      }
    }
    return $return_string;
  }



}
?>