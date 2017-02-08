<?php
if($_SESSION['user']->Lesson()!=""&&$_SESSION['user']->Lesson()!="-1"){
$tcman = new TopicManager();
$sbman = new SubjectManager();
$ls = $sbman->ListSubjects("id=".$_SESSION['user']->Lesson(),"normal");
$lesson = $ls[0]->Name();
$section = $ls[0];
$last_topic = $tcman->ListTopics("secid=2 AND solved=0", $format="normal", 0, 0, 1);
$last_topic = $last_topic[0];

?>

<div class="col-md-12">

  <div class="panel panel-default">
    <div class="panel-heading">Dernière question en <?php echo $lesson; ?></div>
    <div class="panel-body">
      <h4><?php echo $last_topic->Title(); ?></h4>
      <div class="well">
        <?php echo $last_topic->Content(); ?>
      </div>
      <div class="btn  btn-submit" style="width: 30%;padding: 5px;" onclick="window.location.href='../forums/view.php?<?php echo "q=".$section->Id()."&s=2&title=".$lesson."&tid=".$last_topic->Id(); ?>';" >Répondre</div>
    </div>
  </div>

</div>
<?php } ?>
