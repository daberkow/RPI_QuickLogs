function makeChart() {
    /*
     *type is 30,90,365,all,or pick, only on pick does passedStartDate and passedEndDate get used
     */
    switch ($('#jobType').val()) {
        case "Activity":
            var StartTime = 0;
            var EndTime = 0;
            var title = "";
            switch ($('input[name=group2]:checked').val()) {
                case '30':
                    CurrentDate = new Date();
                    EndTime = CurrentDate.getTime() / 1000;
                    StartTime = EndTime - (60*60*24*30);
                    title = "30 Days of Activity";
                    break;
                case '90':
                    CurrentDate = new Date();
                    EndTime = CurrentDate.getTime() / 1000;
                    StartTime = EndTime - (60*60*24*90);
                    title = "90 Days of Activity";
                    break;
                case '365':
                    CurrentDate = new Date();
                    EndTime = CurrentDate.getTime() / 1000;
                    StartTime = EndTime - (60*60*24*365);
                    title = "365 Days of Activity";
                    break;
                case 'all':
                    CurrentDate = new Date();
                    EndTime = CurrentDate.getTime() / 1000;
                    StartTime = 0;
                    title = "All Days of Activity";
                    break;
                case "pick":
                    break;
            }
            $.ajax({
                type: 'POST',
                url: "./chart.php",
                data: {chart: 'json_activity', startTime: StartTime, endTime: EndTime},
                success: function(data) {
                    jsonData = JSON.parse(data);
                    pie(jsonData, title, "Activity");
                },
                error: function(data) {
                    
                }
            });
            break;
        
    }
}

function pie(passedData, passedTitle, passedDescripter) {
    var chart;
    
    chart = new Highcharts.Chart({
        chart: {
            renderTo: 'container',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: passedTitle
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}</b>',
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    formatter: function() {
                        return '<b>'+ this.point.name +'</b>: '+ Highcharts.numberFormat(this.percentage, 1) +' %';
                    }
                }
                
            }
        },
        series: [{
            type: 'pie',
            name: passedDescripter,
            data: passedData
        }]
    });
}