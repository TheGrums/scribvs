<?php
//ini_set("display_errors",true);
if(!function_exists('loadClass'))require_once './config/db.php';
session_start();

?>
<!DOCTYPE html>

<html>

<head>
	<?php
  $animate = false;
	require(dirname(__FILE__)."/head.php");
	?>
</head>

<body id="files-page">

	<div class="maincontainer">
		<div class="wrapper">


			<div class = "container-fluid" style = "min-height:100vh;">
        <div class="row">
          <div class="col-md-2 file-page-left">
            <div class="list-group">

              <?php

                $filter="(dest LIKE '%|".$_SESSION['user']->Id()."' OR dest LIKE '".$_SESSION['user']->Id()."|%' OR dest LIKE '%|".$_SESSION['user']->Id()."|%' OR dest LIKE '".$_SESSION['user']->Id();
                $filter.="' OR dest LIKE '%|".$_SESSION['user']->ClassId()."' OR dest LIKE '".$_SESSION['user']->ClassId()."|%' OR dest LIKE '%|".$_SESSION['user']->ClassId()."|%' OR dest LIKE '".$_SESSION['user']->ClassId();
                $filter.="' OR dest='school' LIKE '%|y".$_SESSION['user']->Year()."' OR dest LIKE 'y".$_SESSION['user']->Year()."|%' OR dest LIKE '%|y".$_SESSION['user']->Year()."|%' OR dest LIKE 'y".$_SESSION['user']->Year()."' OR uid=".$_SESSION['user']->Id().")";
                $fman = new FileManager();
                $files = $fman->ListFilesSortedBySender($_SESSION['user'],$filter);
                $i=0;
                $tmp="";
                $j=-1;

                while($i<count($files)){
                  if($files[$i]->First()." ".$files[$i]->Last()==$tmp){$i++;continue;}
                  $tmp = $files[$i]->First()." ".$files[$i]->Last();
                  $j++;
                  $i++;
              ?>

                <a data-target-files="<?php echo $j; ?>" class="list-group-item <?php echo ($i==1?'disabled':'') ?>"><?php echo ($tmp==$_SESSION['user']->WholeName()?"Mes fichiers":$tmp); ?></a>

              <?php } ?>

            </div>
          </div>
          <div class="col-md-10" style="padding:30px;background-color: #e3e4ef;">
            <div class="container-fluid">
              <div class="row">
              <?php
								if(count($files)==0){
							?>

								<div class="col-sm-12">
									<img src="./pictures/file-section-help.jpg" />
								</div>

							<?php
								}
                $tmp = "";
                $i=0;
                $j=-1;
                $k = -1;
                while($i<count($files)){
                  $k++;
                  if($files[$i]->First()." ".$files[$i]->Last()!=$tmp){echo "</div><div class='row'>";$k=0;}
                  if($files[$i]->First()." ".$files[$i]->Last()!=$tmp){$j++;}
                  $tmp = $files[$i]->First()." ".$files[$i]->Last();
              ?>
                <a download = "<?php echo $files[$i]->Name(); ?>" data-fl-id="<?php echo $files[$i]->Id(); ?>" target="_blank" href="<?php echo $files[$i]->Path().'" class="user-files user-'.$j; ?>" style="<?php echo ($j>0?"display:none;":""); ?>">
                  <div class="col-md-2 col-sm-4 col-xs-6 file-item file-panel-item" style="height:170px;">
                    <img src="<?php echo $files[$i]->Preview(); ?>"><br>
                    <span class="file-panel-name"><?php echo $files[$i]->Name(); ?></span>
                    <div class="file-panel-info"><?php echo $files[$i]->Send_date(); ?></div>
                  </div>
                </a>
              <?php
                $i++;
                }
              ?>
              </div>
            </div>
          </div>
        </div>
			</div>


		</div>
	</div>
	<?php require(dirname(__FILE__)."/navbar.php");?>
	<?php
	require(dirname(__FILE__)."/scripts.php");
	echo "<script type = 'text/javascript'> detectActive(5); </script>";
	?>
	<script async src="//cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>
	<script type = "text/javascript" src="<?php echo GENERAL_PATH; ?>js/files_page.js"></script>
</body>

</html>
