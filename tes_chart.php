        <script src="js/amcharts.js" type="text/javascript"></script>        
        <script type="text/javascript">
            var chart;
            var legend;

            var chartData = [{
                country: "Lithuania",
                value: 260
            }, {
                country: "Ireland",
                value: 201
            }, {
                country: "Germany",
                value: 65
            }, {
                country: "Australia",
                value: 39
            }, {
                country: "UK",
                value: 19
            }, {
                country: "Latvia",
                value: 10
            }];

            AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartData;
                chart.titleField = "country";
                chart.valueField = "value";
                chart.outlineColor = "#FFFFFF";
                chart.outlineAlpha = 0.8;
                chart.outlineThickness = 2;
                // this makes the chart 3D
                chart.depth3D = 15;
                chart.angle = 30;

                // WRITE
                chart.write("chartdiv");
            });
        </script>
    
        <div id="chartdiv" style="width: 100%; height: 400px;"></div>

