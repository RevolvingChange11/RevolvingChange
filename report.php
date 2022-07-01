<?php
    include "connect.php";
    $ctable     = "pre_module_form";
    $ctable1    = "question";
    $lesson_id  = $db->clean($_REQUEST['lesson_id']);
    $lesson_rs = $db->getData("lesson","*","isDelete=0 AND id=".$lesson_id);
    $lesson_d = mysqli_fetch_assoc($lesson_rs);

    $question_array=[];
    $answer_array=[];
    $answer_array1=[];
    
    $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];

    $get_module_name = $db->getValue("module","name","isDelete=0 AND id=".$lesson_d['module_id']);

    $ctable_where = "isDelete=0 AND lesson_id=".$_REQUEST['lesson_id']." AND user_id=".$user_id. " AND submission_type=1";
    $ctable_where1 = "isDelete=0 AND lesson_id=".$_REQUEST['lesson_id']." AND user_id=".$user_id. " AND submission_type=3";
    $ctable_r      = $db->getData($ctable,"*",$ctable_where);
    $ctable_row=mysqli_fetch_assoc($ctable_r);

    $que_id=explode(",",$ctable_row['quetion_id']);
    $ans_id=explode(",",$ctable_row['answer_id']);
    //$ans_id=array('Strongly Agree', 'Agree', 'Strongly Disagree', 'Neutral');

    $ques_id=count($que_id);
    for($i=0;$i<$ques_id;$i++)
    {
        $get_question      = $db->getData("question","*","id in (".$que_id[$i].")");
        while($question=mysqli_fetch_assoc($get_question))
        {
            array_push($question_array,$question['name']);
            //array_push($question_array,$i+1);
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
    // $ans_id1=explode(",",$ctable1_row['answer_id']);
    $ans_id1=explode(",",$ctable1_row['answer_id']);
    //$ans_id1=array('Neutral', 'Strongly Agree', 'Agree', 'Strongly Disagree');


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
       
        array_push($data,array("year" => $question_array[$i] , "pre" => (int)$ans_id[$i], "post" => (int)$ans_id1[$i]));
    }
    
    
?>
<!DOCTYPE html>
<html lang="en" class="">
    <head>        
        <!-- Site Title -->
        <title>Matthias Grossmann's First Site</title>
        <?php include "front_include/css.php"; ?>
        <style>
            #chartdiv {
              width: 100%;
              height: 500px;
            }
            </style>
    </head>

    <body>
        <?php include "front_include/header.php"; ?>        
        <!-- Reports section start  -->

        <section class="Reports-section pt-100 pb-100">
             <div class="container">
                <div class="ps-breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="#">Online Module (Demo) </a></li>
                      <li class="breadcrumb-item active" aria-current="page"><?=$get_module_name; ?></li>
                    </ol>
                </div>

                <div class="section-header mb-5">
                    <h1><?=$lesson_d['name'];?></h1>

                  
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    
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
                </div>

                <!-- chart sections start -->

                <div class="Chart-section">
                    <div id="chartdiv"></div>
                     <div class="next-module text-center my-5">
                       
                        <a class="btn" href='<?php echo SITEURL; ?>updatestage.php?userid=<?php echo $user_id; ?>&lesson_id=<?php echo $lesson_id; ?>' > Done </a>
                     </div>
                </div>
               

                <!-- chart sections end -->

             </div>
        </section>

        <!-- Reports section end  -->

        <?php include "front_include/footer.php"; ?>
        <?php include "front_include/js.php"; ?>  

        <!-- Resources -->
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
// var label1 = am5.Label.new(root, {
//   rotation: 0,
//   text: "Axis title 1",
//   y: am5.p25,
//   centerX: am5.p100
//   // x: am5.p100,
//   // centerY: am5.p100
// })

// yAxis.children.unshift(
//   label1
// );

xAxis.get("renderer").labels.template.setAll({
  oversizedBehavior: "truncate",
  maxWidth: 100
});

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
        labelText: "[bold]{name}[/]\n\n{categoryX}: {valueY}"
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
 // stroke: am5.color(0x00ff33),
  series.appear(1000);
}

createSeries("Pre", "pre");
createSeries("Post", "post");
// createSeries("1", "Strongly disagree", "Strongly disagree");
// createSeries("2", "	Disagree");
// createSeries("3", "Neutral");
// createSeries("4", "Agree");
// createSeries("5", "Strongly agree");


// Add scrollbar
// https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
chart.set("scrollbarX", am5.Scrollbar.new(root, {
  orientation: "horizontal",
  marginBottom: 20
}));

// var legend = chart.children.push(
//   am5.Legend.new(root, {
//     centerX: am5.p50,
//     x: am5.p50
//   })
// );

// // Make series change state when legend item is hovered
// legend.itemContainers.template.states.create("hover", {});

// legend.itemContainers.template.events.on("pointerover", function(e) {
//   e.target.dataItem.dataContext.hover();
// });
// legend.itemContainers.template.events.on("pointerout", function(e) {
//   e.target.dataItem.dataContext.unhover();
// });

// legend.data.setAll(chart.series.values);
var legend = chart.children.push(am5.Legend.new(root, {
  nameField: "categoryX",
  centerX: am5.percent(50),
  x: am5.percent(50)
}));

legend.data.setAll(chart.series.values);

// legend.data.setAll(series.dataItems);

// legend.data.setAll(series.dataItems);

// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
chart.appear(1000, 100);

}); // end am5.ready()
</script>
 

       
        </body>
        </html>
