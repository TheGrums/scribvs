<?php
function loadClass($classname){
  $filename = dirname(__FILE__).DIRECTORY_SEPARATOR.lcfirst($classname).'.php';
  if (is_readable($filename)) {
      require $filename;
  }
}
spl_autoload_register('loadClass',true,true);
?>
