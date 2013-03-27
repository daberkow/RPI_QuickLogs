/*function makeChart() {
    /*
     *type is 30,90,365,all,or pick, only on pick does passedStartDate and passedEndDate get used
     
    switch ($('#jobType').val()) {
        case "activity":
            $('input[name=group2]').removeAttr('disabled');
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
                case "pick"://here
                    break;
            }
            $.ajax({
                type: 'POST',
                url: "./chart.php",
                data: {chart: 'json_activity', startTime: StartTime, endTime: EndTime},
                success: function(data) {
                    //console.log(data);
                    jsonData = JSON.parse(data);
                    pie(jsonData, title, "Activity");
                },
                error: function(data) {
                    
                }
            });
            break;
        case "history":
            $.ajax({
                type: 'POST',
                url: "./chart.php",
                data: {chart: 'json_total'},
                success: function(data) {
                    //console.log(data);
                    jsonData = JSON.parse(data);
                    bar(jsonData, "Log Histroy");
                    $('input[name=group2]').attr('disabled', 'disabled');
                },
                error: function(data) {
                    
                }
            });
            break;
        case "user":
            $('input[name=group2]').removeAttr('disabled');
            var StartTime = 0;
            var EndTime = 0;
            var title = "";
            switch ($('input[name=group2]:checked').val()) {
                case '30':
                    CurrentDate = new Date();
                    EndTime = CurrentDate.getTime() / 1000;
                    StartTime = EndTime - (60*60*24*30);
                    title = "30 Days By User";
                    break;
                case '90':
                    CurrentDate = new Date();
                    EndTime = CurrentDate.getTime() / 1000;
                    StartTime = EndTime - (60*60*24*90);
                    title = "90 Days By User";
                    break;
                case '365':
                    CurrentDate = new Date();
                    EndTime = CurrentDate.getTime() / 1000;
                    StartTime = EndTime - (60*60*24*365);
                    title = "365 Days By User";
                    break;
                case 'all':
                    CurrentDate = new Date();
                    EndTime = CurrentDate.getTime() / 1000;
                    StartTime = 0;
                    title = "All Days By User";
                    break;
                case "pick"://here
                    break;
            }
            $.ajax({
                type: 'POST',
                url: "./chart.php",
                data: {chart: 'json_user', startTime: StartTime, endTime: EndTime},
                success: function(data) {
                    //console.log(data);
                    jsonData = JSON.parse(data);
                    pie(jsonData, title, "User Activity");
                },
            });
            break;
        case "trending":
            $.ajax({
                type: 'POST',
                url: "./chart.php",
                data: {chart: 'json_trend'},
                success: function(data) {
                    //console.log(data);
                    jsonData = JSON.parse(data);
                    line(jsonData, title, "User Activity");
                },
            });
            break;
    }
}*/
    
function makeChart() {
    $('input[name=group2]').removeAttr('disabled');
    var aStartTime = 0;
    var aEndTime = 0;
    var atitle = "";
    switch ($('input[name=group2]:checked').val()) {
        case '30':
            CurrentDate = new Date();
            aEndTime = CurrentDate.getTime() / 1000;
            aStartTime = aEndTime - (60*60*24*30);
            atitle = "30 Days of Activity";
            break;
        case '90':
            CurrentDate = new Date();
            aEndTime = CurrentDate.getTime() / 1000;
            aStartTime = aEndTime - (60*60*24*90);
            atitle = "90 Days of Activity";
            break;
        case '365':
            CurrentDate = new Date();
            aEndTime = CurrentDate.getTime() / 1000;
            aStartTime = aEndTime - (60*60*24*365);
            atitle = "365 Days of Activity";
            break;
        case 'all':
            CurrentDate = new Date();
            aEndTime = CurrentDate.getTime() / 1000;
            aStartTime = 0;
            atitle = "All Days of Activity";
            break;
        case "pick"://here
            break;
    }
    $.ajax({
        type: 'POST',
        url: "./chart.php",
        data: {chart: 'json_activity', startTime: aStartTime, endTime: aEndTime},
        success: function(data) {
            //console.log(data);
            var jsonData = JSON.parse(data);
            pie(jsonData, atitle, "Activity", "container");
        },
        error: function(data) {
            
        }
    });
    //code
    var StartTime = 0;
    var EndTime = 0;
    var title = "";
    switch ($('input[name=group2]:checked').val()) {
        case '30':
            CurrentDate = new Date();
            EndTime = CurrentDate.getTime() / 1000;
            StartTime = EndTime - (60*60*24*30);
            title = "30 Days By User";
            break;
        case '90':
            CurrentDate = new Date();
            EndTime = CurrentDate.getTime() / 1000;
            StartTime = EndTime - (60*60*24*90);
            title = "90 Days By User";
            break;
        case '365':
            CurrentDate = new Date();
            EndTime = CurrentDate.getTime() / 1000;
            StartTime = EndTime - (60*60*24*365);
            title = "365 Days By User";
            break;
        case 'all':
            CurrentDate = new Date();
            EndTime = CurrentDate.getTime() / 1000;
            StartTime = 0;
            title = "All Days By User";
            break;
        case "pick"://here
            break;
    }
    $.ajax({
            type: 'POST',
            url: "./chart.php",
            data: {chart: 'json_user', startTime: StartTime, endTime: EndTime},
            success: function(data) {
                //console.log(data);
                var jsonData = JSON.parse(data);
                pie(jsonData, title, "User Activity", "container2");
            },
        });
     $.ajax({
            type: 'POST',
            url: "./chart.php",
            data: {chart: 'json_total'},
            success: function(data) {
                //console.log(data);
                var jsonData = JSON.parse(data);
                bar(jsonData, "Log Histroy", "container3");
            },
            error: function(data) {
                
            }
        });
}

function pie(passedData, passedTitle, passedDescripter, div) {
    passedData.sort(function(a,b){ if(a[1] < b[1]) return 1; if (a[1] == b[1]) return 0; return -1;});
    
    var chart;
    
    chart = new Highcharts.Chart({
        chart: {
            renderTo: div,
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

function bar(passedData, passedTitle, div) {
    var chart;
    
    chart = new Highcharts.Chart({
        chart: {
            renderTo: div,
            type: 'column',
            margin: [ 50, 50, 100, 80]
        },
        title: {
            text: 'Log History'
        },
        xAxis: {
            categories: passedData[0],
            labels: {
                rotation: -45,
                align: 'right',
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Logs'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            formatter: function() {
                return '<b>'+ this.x +'</b><br/>'+
                    Highcharts.numberFormat(this.y, 1) +
                    ' logs';
            }
        },
        plotOptions: {
            column: {
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold'
                    },
                    formatter: function() {
                        return this.y;
                    }
                }
            }
        },
        series: [{
            name: passedTitle,
            data: passedData[1],
        }]
    });
}

function line(passedData, passedTitle, passedDescription, div) {
    
    $('#' + div).highcharts({
            chart: {
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: 'Trends of Tickets',
                x: -20 //center
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Tickets'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '°C'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: 'Tokyo',
                data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
            }, {
                name: 'New York',
                data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
            }, {
                name: 'Berlin',
                data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
            }, {
                name: 'London',
                data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
            }]
        });
}