<div class="row">
    <ol class="breadcrumb" style="margin-top: 25px;">
      <li><a href="./index.php">Accueil</a></li>
      <li><a href="./sections.php?q=<?php echo intval($_GET['q']); ?>&title=<?php echo $title; ?>"><?php echo htmlentities($_GET['title']); ?></a></li>
      <li class="active"><?php echo $section; ?></li>
    </ol>
</div>
<div class="row">
  <div class="col-sm-4 col-sm-offset-4">
    <div style = "margin:10px 0px 20px;">
        <div class="input-group stylish-input-group">
            <input type="text" class="form-control" id="forum-search-space"<?php echo  'data-secid="'.intval($_GET['s']).'" data-stid="'.intval($_GET['q']).'"'; ?>  placeholder="Rechercher" >
            <span class="input-group-addon">
                <button>
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </div>
</div>
</div>
