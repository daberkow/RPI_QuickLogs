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
    makeWeekTime(5, 7, "container4");
    makeDayTime(7, 1, "container5");
}

function makeWeekTime(passedUnits, passedDaysPer, passedDiv) {//stopped here, zm keeps changing
    searches = 0;
    weekholder = new Array();
    for (zm = 0; zm < passedUnits; zm++) {
        var dater = new Date();
        var aEndTime = ((dater.getTime()) / 1000) - (60*60*24*passedDaysPer*zm);
        var aStartTime = aEndTime - (60*60*24*passedDaysPer);
        //console.log(aStartTime + ' ' +  aEndTime);
        $.ajax({
            type: 'POST',
            url: "./chart.php",
            data: {chart: 'json_activity', startTime: aStartTime, endTime: aEndTime, id: zm},
            success: function(data) {
                //console.log(data);
                jsonData = JSON.parse(data);
                var tempID = jsonData[0];
                jsonData.splice(0,1);
                weekholder[tempID] = jsonData;
                searches++;
                if (searches == 4) {
                    generateWeekTime(passedDiv);   
                }
            },
        }); 
    }
}

function makeDayTime(passedUnits, passedDaysPer, passedDiv) {//stopped here, zm keeps changing
    daysearches = 0;
    dayholder = new Array();
    for (zm = 0; zm < passedUnits; zm++) {
        var dater = new Date();
        var aEndTime = ((dater.getTime()) / 1000) - (60*60*24*passedDaysPer*zm);
        var aStartTime = aEndTime - (60*60*24*passedDaysPer);
        //console.log(aStartTime + ' ' +  aEndTime);
        $.ajax({
            type: 'POST',
            url: "./chart.php",
            data: {chart: 'json_activity', startTime: aStartTime, endTime: aEndTime, id: zm},
            success: function(data) {
                //console.log(data);
                jsonData = JSON.parse(data);
                var tempID = jsonData[0];
                jsonData.splice(0,1);
                dayholder[tempID] = jsonData;
                daysearches++;
                if (daysearches == passedUnits) {
                    generateDayTime(passedDiv);
                }
            },
        }); 
    }
}

function generateWeekTime(passedDiv) {
    var convertedData = normalizer(weekholder);
    //console.log(convertedData);
    line(convertedData,"Activity Per Week Change", "Type of activity", passedDiv, ["This Week", "-1 Week", "-2 Weeks", "-3 Weeks", "-4 Weeks"]);
}

function generateDayTime(passedDiv) {
    var convertedData = normalizer(dayholder);
    //console.log(convertedData);
    line(convertedData,"Activity Per Day Change", "Type of activity", passedDiv, ["Today", "-1 Day", "-2 Days", "-3 Days", "-4 Days", "-5 Days", "-6 Days"]);
}

function normalizer(passedData) {
    //console.log(passedData);
    //class[week][catergory] = number of events
    var Events = new Array();
    for (var z = 0; z < passedData.length; z++) {
        for (var x in passedData[z]) {
            if (typeof(Events[passedData[z][x][0]]) == "undefined") {
                Events[passedData[z][x][0]] = new Array();
            }
        }
    }
    
    var ReturningArray = new Array();
    //returningarray[0-...]['name','data']
    for (var z = 0; z < passedData.length; z++) {
        for (var x in passedData[z]) {
            Events[passedData[z][x][0]].push(passedData[z][x][1]);
        }
        for (var x in Events) {
            if (typeof(Events[x][z]) == "undefined") {
                Events[x][z] = 0;
            }
        }
    }
    //console.log(Events);
    FinalArray = new Array();
    for (var x in Events) {
        tempArray = new Array();
        tempArray['name'] = x;
        tempArray['data'] = Events[x];
        FinalArray.push(tempArray);
    }
    return FinalArray;
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
            text: passedTitle
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

function line(passedData, passedTitle, passedDescription, div, passedXAxis) {
    var charts;
    
    charts = new Highcharts.Chart({
            chart: {
                type: 'line',
                marginRight: 130,
                marginBottom: 25,
                renderTo: div
            },
            title: {
                text: passedTitle,
                x: -20 //center
            },
            xAxis: {
                categories: passedXAxis
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
            plotOptions: {
                series: {
                    threshold: 0
                }
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
            series: passedData
        });
}