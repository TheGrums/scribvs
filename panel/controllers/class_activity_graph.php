
<?php
$man = new GroupManager();
$group = $man->getGroupByName($_SESSION['user']->ClassId());
$post_data_array=array();
$today = date("Y-m-d");
?>
  <div class="col-md-6 animated fadeIn">

    <div class="panel panel-default">
      <div class="panel-heading">Activité de votre classe</div>
      <div class="panel-body">
        <canvas id="class-activity" width="400" height="200"></canvas>
      </div>
    </div>

    <?php if($_SESSION["user"]->Level()==3){ ?>

      <div class="container-fluid">

        <div class="row">

          <?php
            require("../controllers/topic_info.php");
          ?>

        </div>

        <div class="row">

          <?php
            require("../controllers/last_file.php");
            require("../controllers/owned_groups.php");
          ?>

        </div>

      </div>

    <?php } ?>
  </div>
<script>

var ctx = document.getElementById("class-activity");
var scatterChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels:[
        <?php
          for($i=13;$i>=0;$i--){
            $day = date('d-m-Y',strtotime($today) - (24*3600*$i));
            echo "'".$day."',";
            $post_data_array[$i]=$man->getPostsByDay($group,date('Y-m-d',strtotime($today) - (24*3600*$i)));
            $files_data_array[$i]=$man->getFilesByDay($group,date('Y-m-d',strtotime($today) - (24*3600*$i)));
          }
        ?>],
        datasets: [{
            label: 'Publications',
            lineTension: 0.2,
            backgroundColor: "rgba(60, 60, 103,.3)",
            borderColor: "rgb(60, 60, 103)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgb(29, 29, 50)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgb(29, 29, 50)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            spanGaps: false,
            data: [
              <?php
                for($i=13;$i>=0;$i--){
                  echo "'".$post_data_array[$i]."',";
                }
              ?>
            ]
        },{
            label: 'Fichiers',
            lineTension: 0.1,
            backgroundColor: "rgba(147, 141, 75,.4)",
            borderColor: "#938D4B",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "#938D4B",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "#938D4B",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            spanGaps: false,
            data: [
              <?php
                for($i=13;$i>=0;$i--){
                  echo "'".$files_data_array[$i]."',";
                }
              ?>
            ]
        }]
    },
    options: {
        responsiveAnimationDuration	: 0.4,

        fill:true
    }
});
</script>
