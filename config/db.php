<?php
define('LOCAL',true);


if(LOCAL){
  define('GENERAL_PATH','http://'.$_SERVER['HTTP_HOST'].'/CSGNetwork/');
  define('FORUM_PATH','http://'.$_SERVER['HTTP_HOST'].'/CSGNetwork/forums/');
}
else {
  define('GENERAL_PATH','https://'.$_SERVER['HTTP_HOST'].'/');
  define('FORUM_PATH','https://'.$_SERVER['HTTP_HOST'].'/forums/');
}
define('ID_PREFIX','CSG');
define('INCLUDE_FROM_DEEPER','./../');

  function wordsFilter($a){
    return $a;
  }
  function killXss($string){
    $string = str_ireplace(array("='"),"=@/$&'",$string);
    $string = str_ireplace(array("=\""),"=@/$&\"",$string);
    $string = str_ireplace(array("src=@/$&"),"src=",$string);
    $string = str_ireplace(array("href=@/$&"),"href=",$string);
    $string = str_ireplace(array("class=@/$&"),"class=",$string);
    $string = str_ireplace(array("script"),"i-see-u",$string);
    $string = str_ireplace(array("<svg"),"<img /><",$string);
    $string = wordsFilter($string);
    return $string;
  }

  function getBdd(){
    try{
                if(LOCAL)$bdd = new PDO('mysql:host=localhost:3306;dbname=csg;charset=utf8','root','root');
          else $bdd = new PDO('mysql:host=localhost;dbname=csgscribvs;charset=utf8','@-Libert/5030-%','1900@#Bohr:%');
        }
    catch(Exception $e)
        {
                echo "<div style = 'text-align:center;'>Nous vous prions de nous excuser car cette section est actuellement indisponible pour des raisons techniques...
                <br>";
        }
      return $bdd;
  }

  $bdd = getBdd();

  function loadClass($classe){ include_once '../models/'.lcfirst($classe).'.php';include_once './models/'.lcfirst($classe).'.php';include_once INCLUDE_FROM_DEEPER.'models/'.lcfirst($classe).'.$
  spl_autoload_register('loadClass');

?>
