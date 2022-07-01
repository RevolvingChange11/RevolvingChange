<?php
	include("connect.php");
	$db->checkAdminLogin();

	$get_user_name=$db->getData("user","name","id=".$_REQUEST['user_id']."");
	$user_row=mysqli_fetch_assoc($get_user_name);
	$ctable 	= "pre_module_form";
	$ctable1 	= "Questions";
	$page 		= "user_question";
	$page_title = "Manage ".$ctable1;

	$user_id = $db->clean($_REQUEST['user_id']);
	//print_r($_REQUEST);
	//exit;
	$ctable     = "pre_module_form";
    $ctable1    = "question";
    $lesson_id  = $db->clean($_REQUEST['lesson_id']);
    $lesson_rs = $db->getData("lesson","*","isDelete=0 AND id=".$lesson_id);
    $lesson_d = mysqli_fetch_assoc($lesson_rs);

    $question_array=[];
    $answer_array=[];
    $answer_array1=[];
    
    $user_id = $db->clean($_REQUEST['user_id']);

    $get_module_name = $db->getValue("module","name","isDelete=0 AND id=".$lesson_d['module_id']);

    $ctable_where = "isDelete=0 AND lesson_id=".$_REQUEST['lesson_id']." AND user_id=".$user_id. " AND submission_type=1";
    $ctable_where1 = "isDelete=0 AND lesson_id=".$_REQUEST['lesson_id']." AND user_id=".$user_id. " AND submission_type=3";
    $ctable_r      = $db->getData($ctable,"*",$ctable_where);
    $ctable_row=mysqli_fetch_assoc($ctable_r);

    $que_id=explode(",",$ctable_row['quetion_id']);
    $ans_id=explode(",",$ctable_row['answer_id']);

    $ques_id=count($que_id);
    for($i=0;$i<$ques_id;$i++)
    {
        $get_question      = $db->getData("question","*","id in (".$que_id[$i].")");
        while($question=mysqli_fetch_assoc($get_question))
        {
            //array_push($question_array,$question['name']);
            array_push($question_array,$i+1);
        }
    }
   /* for($i=0;$i<$ques_id;$i++)
    {
        $get_answer      = $db->getData("question_option","*","id in (".$ans_id[$i].")");
        while($answer=mysqli_fetch_assoc($get_answer))
        {
            array_push($answer_array,$answer['option_value']);
        }
    }*/

    $ctable_r1      = $db->getData($ctable,"*",$ctable_where1);
    $ctable1_row=mysqli_fetch_assoc($ctable_r1);
     $ans_id1=explode(",",$ctable1_row['answer_id']);


   /*  for($i=0;$i<$ques_id;$i++)
    {
        $get_answer1      = $db->getData("question_option","*","id in (".$ans_id1[$i].")");
        while($answer1=mysqli_fetch_assoc($get_answer1))
        {
            array_push($answer_array1,$answer1['option_value']);
        }
    }*/
    $data=array();

    for($i=0;$i<$ques_id;$i++)
    { 
       
        array_push($data,array("year" => $question_array[$i] , "italy" => (int)$ans_id[$i], "germany" => (int)$ans_id1[$i]));
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $page_title . ' | ' .  ADMINTITLE; ?></title>
	<?php include("include/css.php"); ?>
	<style>
            #chartdiv {
              width: 100%;
              height: 500px;
            }
            </style>
</head>
<body id="page-top">
	<div id="wrapper">
		<!-- Sidebar -->
		<?php include("include/left.php"); ?>
		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">
				<?php include('include/header.php'); ?>
				<div class="container-fluid">
					<div class="d-sm-flex align-items-center justify-content-between mb-4">
						<h1 class="h4 mb-0 text-gray-900"><?php echo $user_row['name']; ?></h1>
            <div class="col-md-5"></div>
                            <div class="float-right">
                              <a href="<?php echo ADMINURL; ?>manage-user/"><button type="button" class="btn btn-secondary waves-effect w-md waves-light"><i class="fa fa-reply"></i></button></a>
                            </div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="box border-top-info">
								<div class="card">
									<div class="card-body">
										<!-- For Table 1 -->
										<div class="row">
                        <div class="col-md-6">
                            <table class="table table-striped">
                                <tr><th colspan="2">Questions</th></tr>
                                <?php
                                    $no1=0;
                                    $ques_id=count($que_id);
                                    for($i=0;$i<$ques_id;$i++)
                                    {
    
                                        $get_que      = $db->getData("question","*","id in (".$que_id[$i].") AND isDelete=0");
                                        while($que=mysqli_fetch_assoc($get_que))
                                        {
                                            $no1++;
                                            echo "<tr>";
                                            echo "<td>".$no1."</td>";
                                            echo "<td>".$que['name']."</td>";
                                            echo "</tr>";
                                        }
                                    }
   
                                ?>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-striped">
                                <tr><th colspan="2">Answers</th></tr>
                                <?php
                                    $no=0;
                                    $get_answer      = $db->getData("question_option","*","isDelete=0");
                                    while($answer=mysqli_fetch_assoc($get_answer))
                                    {
                                        $no++;
                                        echo "<tr>";
                                        echo "<td>".$no."</td>";
                                        echo "<td>".$answer['option_value']."</td>";
                                        echo "</tr>";
                                    }
   
                                ?>
                            </table>
                        </div>
                    </div>
                    <div class="Chart-section">
                    <div id="chartdiv"></div>
                     <div class="next-module text-center my-5">
                       
                        
                     </div>
                </div>
               


										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include("include/footer.php"); ?>
		</div>

	</div>

	<!-- Bootstrap core JavaScript-->
	<?php include("include/js.php"); ?>
	
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<!-- Chart code -->
<script>





am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);

// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(
  am5xy.XYChart.new(root, {
    panX: true,
    panY: true,
    wheelX: "panX",
    wheelY: "zoomX",
    layout: root.verticalLayout,
  pinchZoomX:true
  })
);

// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
  behavior: "none"
}));
cursor.lineY.set("visible", false);

var data=<?php echo json_encode($data); ?>;




// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xRenderer = am5xy.AxisRendererX.new(root, {});
xRenderer.grid.template.set("location", 0.5);
xRenderer.labels.template.setAll({
  location: 0.5,
  multiLocation: 0.5
});

var xAxis = chart.xAxes.push(
  am5xy.CategoryAxis.new(root, {
    categoryField: "year",
    renderer: xRenderer,
    tooltip: am5.Tooltip.new(root, {})
  })
);

xAxis.data.setAll(data);

var yAxis = chart.yAxes.push(
  am5xy.ValueAxis.new(root, {
    maxPrecision: 0,
    renderer: am5xy.AxisRendererY.new(root, {
      inversed: true
    })
  })
);

// Add series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/

function createSeries(name, field) {
  var series = chart.series.push(
    am5xy.LineSeries.new(root, {
      name: name,
      xAxis: xAxis,
      yAxis: yAxis,
      valueYField: field,
      categoryXField: "year",
      tooltip: am5.Tooltip.new(root, {
        pointerOrientation: "horizontal",
        labelText: "[bold]{name}[/]\n{categoryX}: {valueY}"
      })
    })
  );


  series.bullets.push(function() {
    return am5.Bullet.new(root, {
      sprite: am5.Circle.new(root, {
        radius: 5,
        fill: series.get("fill")
      })
    });
  });

  // create hover state for series and for mainContainer, so that when series is hovered,
  // the state would be passed down to the strokes which are in mainContainer.
  series.set("setStateOnChildren", true);
  series.states.create("hover", {});

  series.mainContainer.set("setStateOnChildren", true);
  series.mainContainer.states.create("hover", {});

  series.strokes.template.states.create("hover", {
    strokeWidth: 4
  });

  series.data.setAll(data);
  series.appear(1000);
}

createSeries("Pre", "italy");
createSeries("Post", "germany");


// Add scrollbar
// https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
chart.set("scrollbarX", am5.Scrollbar.new(root, {
  orientation: "horizontal",
  marginBottom: 20
}));

var legend = chart.children.push(
  am5.Legend.new(root, {
    centerX: am5.p50,
    x: am5.p50
  })
);

// Make series change state when legend item is hovered
legend.itemContainers.template.states.create("hover", {});

legend.itemContainers.template.events.on("pointerover", function(e) {
  e.target.dataItem.dataContext.hover();
});
legend.itemContainers.template.events.on("pointerout", function(e) {
  e.target.dataItem.dataContext.unhover();
});

legend.data.setAll(chart.series.values);

// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
chart.appear(1000, 100);

}); // end am5.ready()
</script>

</body>

</html>
