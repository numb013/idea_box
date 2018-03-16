<?php
class ChildSmarty extends Smarty {
  function ChildSmarty() {
    $this->Smarty();
    $this->template_dir = TEMPLATE_DIR;
    $this->compile_dir  = COMPILE_DIR;
  }
}
?>
