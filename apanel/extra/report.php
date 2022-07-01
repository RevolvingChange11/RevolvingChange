<?php
    include "connect.php";
    $ctable     = "pre_module_form";
    $ctable1    = "question";
    $lesson_id  = $db->clean($_REQUEST['lesson_id']);
    $lesson_rs = $db->getData("lesson","*","isDelete=0 AND id=".$lesson_id);
    $lesson_d = mysqli_fetch_assoc($lesson_rs);
    $que_array=[];
    $ans_array=[];
    $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];

    $get_module_name = $db->getValue("module","name","isDelete=0 AND id=".$lesson_d['module_id']);

    $ctable_where .= "isDelete=0 AND lesson_id=".$_REQUEST['lesson_id']." AND user_id=".$user_id. " AND submission_type=1";
    $ctable_where1 = "isDelete=0 AND lesson_id=".$_REQUEST['lesson_id']." AND user_id=".$user_id. " AND submission_type=3";
    $ctable_r      = $db->getData($ctable,"*",$ctable_where);
    $ctable_r1      = $db->getData($ctable,"*",$ctable_where1);
    $ctable1_row=mysqli_fetch_assoc($ctable_r1);
    $ctable_row=mysqli_fetch_assoc($ctable_r);
    $get_que      = $db->getData($ctable1,"*","id in (".$ctable_row['quetion_id'].")");
    while($que=mysqli_fetch_assoc($get_que))
    {
        array_push($que_array,$que['name']);
    }
    $get_ans      = $db->getData("question_option","*","id in (".$ctable_row['answer_id'].")");
    while($ans=mysqli_fetch_assoc($get_ans))
    {
        array_push($ans_array,$ans['option_value']);
    }


?>
<!DOCTYPE html>
<html lang="en" class="">
    <head>        
        <!-- Site Title -->
        <title>Matthias Grossmann's First Site</title>
        <?php include "front_include/css.php"; ?>
    </head>

    <body>
        <?php include "front_include/header.php"; ?>        
        <!-- Reports section start  -->

        <section class="Reports-section pt-100 pb-100">
             <div class="container">
                <div class="ps-breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="#">Online Module (Demo) </a></li>
                      <li class="breadcrumb-item active" aria-current="page"><?=$get_module_name;?></li>
                    </ol>
                </div>

                <div class="section-header mb-5">
                    <h1><?=$get_module_name;?></h1>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                </div>

                <!-- chart sections start -->

                <div class="Chart-section">
                    <div id="chartdiv"></div>
                     <div class="next-module text-center my-5">
                         <a class="btn" href="#"> Next Module 2 </a>
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
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
        panX: true,
        panY: true,
        wheelX: "panX",
        wheelY: "zoomX",
        pinchZoomX:true
        }));

        chart.get("colors").set("step", 3);


        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
        cursor.lineY.set("visible", false);


        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
        maxDeviation: 0.3,
        baseInterval: {
            timeUnit: "day",
            count: 1
        },
        renderer: am5xy.AxisRendererX.new(root, {}),
        tooltip: am5.Tooltip.new(root, {})
        }));

        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        maxDeviation: 0.3,
        renderer: am5xy.AxisRendererY.new(root, {})
        }));


        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart.series.push(am5xy.LineSeries.new(root, {
        name: "Series 1",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value1",
        valueXField: "date",
        tooltip: am5.Too ltip.new(root, {
            labelText: "{valueX}: {valueY}\n{previousDate}: {value2}"
        })
        }));

        series.strokes.template.setAll({
        strokeWidth: 2
        });

        series.get("tooltip").get("background").set("fillOpacity", 0.5);

        var series2 = chart.series.push(am5xy.LineSeries.new(root, {
        name: "Series 2",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "value2",
        valueXField: "date"
        }));
        series2.strokes.template.setAll({
        strokeDasharray: [2, 2],
        strokeWidth: 2
        });

        // Set date fields
        // https://www.amcharts.com/docs/v5/concepts/data/#Parsing_dates
        root.dateFormatter.setAll({
        dateFormat: "yyyy-MM-dd",
        dateFields: ["valueX"]
        });


        // Set data
        var data = [{
        date: new Date(2019, 5, 12).getTime(),
        value1: 50,
        value2: 48,
        previousDate: new Date(2019, 5, 5)
        }, {
        date: new Date(2019, 5, 13).getTime(),
        value1: 53,
        value2: 51,
        previousDate: "2019-05-06"
        }, {
        date: new Date(2019, 5, 14).getTime(),
        value1: 56,
        value2: 58,
        previousDate: "2019-05-07"
        }, {
        date: new Date(2019, 5, 15).getTime(),
        value1: 52,
        value2: 53,
        previousDate: "2019-05-08"
        }, {
        date: new Date(2019, 5, 16).getTime(),
        value1: 48,
        value2: 44,
        previousDate: "2019-05-09"
        }, {
        date: new Date(2019, 5, 17).getTime(),
        value1: 47,
        value2: 42,
        previousDate: "2019-05-10"
        }, {
        date: 'avc',
        value1: 85,
        value2: 55,
        previousDate: "abc"
        }]

        series.data.setAll(data);
        series2.data.setAll(data);


        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000);
        series2.appear(1000);
        chart.appear(1000, 100);

        }); // end am5.ready()
        </script>

        </body>
        </html>
