
<div class = "container navbar-inverse left-nav">

  <ul class = "navbar-nav">
    <li>
      <a href="<?php echo GENERAL_PATH; ?>profile.php?q=<?php echo $_SESSION['user']->Last()."-".$_SESSION['user']->First();?>">
        <span data-original-title="<?php echo $_SESSION['user']->WholeName(); ?>" data-toggle="tooltip" data-placement="right">
          <span class = "glyphicon glyphicon-home"></span>
        </span>
      </a>
    </li>

    <li>
      <a href="<?php echo GENERAL_PATH; ?>thread.php">
        <span data-original-title="Actualités" data-toggle="tooltip" data-placement="right">
          <span class = "glyphicon glyphicon-random"></span>
        </span>
      </a>
    </li>
    <li>
      <a href="<?php echo GENERAL_PATH; ?>class.php?q=<?php echo $_SESSION['user']->ClassId();?>">
        <span data-original-title="<?php echo $_SESSION['co_elements']['class']; ?>" data-toggle="tooltip" data-placement="right">
          <span class = "glyphicon glyphicon-education"></span>
        </span>
      </a>
    </li>

    <li>
      <a href="<?php echo GENERAL_PATH; ?>forums/">
        <span data-original-title="Forum" data-toggle="tooltip" data-placement="right">
          <span class = "glyphicon glyphicon-th-list"></span>
        </span>
      </a>
    </li>

    <li>
      <a href="<?php echo GENERAL_PATH; ?>search.php">
        <span data-original-title="Recherche" data-toggle="tooltip" data-placement="right">
          <span class = "glyphicon glyphicon-search"></span>
        </span>
      </a>
    </li>

    <li>
      <a href="<?php echo GENERAL_PATH; ?>files.php">
        <span data-original-title="Fichiers" data-toggle="tooltip" data-placement="right">
          <span class = "glyphicon glyphicon-file"></span>
        </span>
      </a>
    </li>
    <?php

    if($_SESSION['user']->Level()>2){

    ?>

    <li>
      <a href="<?php echo GENERAL_PATH; ?>panel/#0">
        <span data-original-title="Panel" data-toggle="tooltip" data-placement="right">
          <span class = "glyphicon glyphicon-dashboard"></span>
        </span>
      </a>
    </li>

    <?php

    }

    else
    {

    ?>

    <li>
      <a href="<?php echo GENERAL_PATH; ?>messages.php#0">
        <span data-original-title="Messages" data-toggle="tooltip" data-placement="right">
          <span class = "glyphicon glyphicon-envelope"></span>
        </span>
      </a>
    </li>

    <?php

    }

    ?>
  </ul>

</div>
