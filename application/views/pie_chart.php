<?php
function getFormattedLabel($companyName) {
    $company = explode('_', $companyName)[0];
    $type2 = explode('process', $companyName)[1];
    $year = explode('_', $type2)[1];
    $type4 = explode('_', $type2)[0];
    $monthName = date("F", mktime(0, 0, 0, $type4, 10));
    // $monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
    return $company .' '.$monthName.$year;
}
$dataPointsPie = [];
if (is_array($incomeData)) {
    foreach ($incomeData as $companyName => $income) {
        $dataPointsPie[] = array("label" => getFormattedLabel($companyName), "y" => $income);
    }
}
$dataPointsColumn = [];
if (is_array($incomeData)) {
    foreach ($incomeData as $companyName => $income) {
        $dataPointsColumn[] = array("y" => $income, "label" => getFormattedLabel($companyName));
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<style>
    #chartContainer {
        text-align: center;
        margin-top: 100px;
    }
</style>
<script>
window.onload = function() {
    var pieChart = new CanvasJS.Chart("pieChartContainer", {
        animationEnabled: true,
        title: {
            text: "CSV Report"
        },
        subtitles: [{
            text: "Monthly Report"
        }],
        data: [{
            type: "pie",
            yValueFormatString: "#,##0.00\"\"",
            indexLabel: "{label} ({y})",
            dataPoints: <?php echo json_encode($dataPointsPie, JSON_NUMERIC_CHECK); ?>
        }]
    });
    pieChart.render();
    var columnChart = new CanvasJS.Chart("columnChartContainer", {
        animationEnabled: true,
        theme: "light2",
        title:{
            text: "CSV Report"
        },
        axisY: {
            title: "Total Revenue"
        },
        data: [{
            type: "column",
            yValueFormatString: "#,##0.## tonnes",
            dataPoints: <?php echo json_encode($dataPointsColumn, JSON_NUMERIC_CHECK); ?>
        }]
    });
    columnChart.render();
}
</script>
</head>
<body>
<!-- Added a parent container with ID "chartContainer" for centering and margin-top DEVELOPED & MAINTAINED BY UNIFLYN-->
<div id="chartContainer">
    <div id="pieChartContainer" style="height: 370px; width: 50%; display: inline-block;"></div>
    <div id="columnChartContainer" style="height: 370px; width: 50%; display: inline-block;"></div>
</div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>