$(function () {
    var chart = [null, null, null, null];
    var ajax = JSON.parse($.ajax({
        url: "index.php/Chart/getMaxDate",
        async: false,
        dataType: 'json'
    }).responseText);
    var cur_date = new Date(Date.parse(
        ajax.max_date
    ));
    var start_date = new Date(cur_date.getFullYear(), cur_date.getMonth(), cur_date.getDate(), 0, 0, 0, 0);
    var end_date = new Date(cur_date.getFullYear(), cur_date.getMonth(), cur_date.getDate(), 23, 59, 59, 0);

    $("#range-day").datepicker({
        changeMonth: true,
        changeYear: true,
        changeDay: true,
        dateFormat: 'dd/mm/yy'
    });
    $("#range-day").datepicker('setDate', new Date(cur_date.getFullYear(), cur_date.getMonth(), cur_date.getDate(), 0, 0, 0, 0));

    $("#range-day").on('change', function(){
        cur_date = new Date(Date.parse($(this).datepicker('getDate')));
        start_date = new Date(cur_date.getFullYear(), cur_date.getMonth(), cur_date.getDate(), 0, 0, 0, 0);
        end_date = new Date(cur_date.getFullYear(), cur_date.getMonth(), cur_date.getDate(), 23, 59, 59, 0);
        chartAjaxLoad[0](
            start_date.getFullYear() + '-' + ((start_date.getMonth() + 1).toString().length < 2 ? '0' : '' ) + (start_date.getMonth() + 1) + '-' + (start_date.getDate().toString().length < 2 ? '0' : '' ) + start_date.getDate() + ' 00:00:00',
            end_date.getFullYear() + '-' + ((end_date.getMonth() + 1).toString().length < 2 ? '0' : '' ) + (end_date.getMonth() + 1) + '-' + (end_date.getDate().toString().length < 2 ? '0' : '' ) + end_date.getDate() + ' 23:59:59'
        );
    });

    $("#range-month").datepicker({
        changeMonth: true,
        changeYear: true,
        changeDay: false,
        dateFormat: 'dd/mm/yy',
        beforeShow: function(){
            $(this).val(cur_date.getDate() + '/' + (cur_date.getMonth() + 1) + '/' + cur_date.getFullYear());
        },
        onClose: function(){
            $(this).val((cur_date.getMonth() + 1) + '/' + cur_date.getFullYear());
        }
    });
    $("#range-month").datepicker('setDate', new Date(cur_date.getFullYear(), cur_date.getMonth(), cur_date.getDate(), 0, 0, 0, 0));
    $("#range-month").val((cur_date.getMonth() + 1) + '/' + cur_date.getFullYear());

    $("#range-month").on('change', function(){
        cur_date = new Date(Date.parse($(this).datepicker('getDate')));
        start_date = new Date(cur_date.getFullYear(), cur_date.getMonth(), 1, 0, 0, 0, 0);
        end_date = new Date(cur_date.getFullYear(), cur_date.getMonth(), new Date(cur_date.getFullYear(), cur_date.getMonth()+1, 0).getDate(), 23, 59, 59, 0);
        chartAjaxLoad[0](
            start_date.getFullYear() + '-' + ((start_date.getMonth() + 1).toString().length < 2 ? '0' : '' ) + (start_date.getMonth() + 1) + '-' + (start_date.getDate().toString().length < 2 ? '0' : '' ) + start_date.getDate() + ' 00:00:00',
            end_date.getFullYear() + '-' + ((end_date.getMonth() + 1).toString().length < 2 ? '0' : '' ) + (end_date.getMonth() + 1) + '-' + (end_date.getDate().toString().length < 2 ? '0' : '' ) + end_date.getDate() + ' 23:59:59'
        );
    });


    function initChart(id, data) {
        data = data || null;
        if (chart[id] !== undefined && chart[id] !== null) {
            for (i in data) {
                chart[id].series[i].setData(data[i], false);
            }
            chart[id].redraw(true);
            return;
        }

        var params = {};
        var series = [];
        var xAxis = [];

        var services = JSON.parse($.ajax({
            url: "index.php/Chart/getListServices",
            async: false,
            dataType: 'json'
        }).responseText);

        for (i in services) {
            series[services[i]['id']] = {
                name: services[i]['name'],
                data: data[i],
                visible: false
            }
        }

        series[0] = {
            name: 'Продажи по всем услугам',
            data: data[0]
        }
        for (i in data[0]) {
            xAxis.push(data[0][i].name);
        }

        switch (id) {
            case 0:
                params = {
                    chart: {
                        renderTo: 'chart1',
                        type: 'column',
                        margin: 100,
                        options3d: {
                            enabled: true,
                            alpha: 0,
                            beta: 0,
                            depth: 50,
                            viewDistance: 25
                        }
                    },
                    title: {
                        text: 'Продажи по продавцам'
                    },
                    subtitle: {
                        text: 'графики 1, 2 и 3'
                    },
                    plotOptions: {
                        column: {
                            depth: 25,
                            events: {
                                legendItemClick: function (event) { 
                                    //nothing todo
                                    //return false;
                                },
                                afterAnimate: function (event) {
                                    //chart[id].rangeSelector.select(0);
                                }
                           },
                       }
                    },
                    rangeSelector: {
                        buttonTheme: { // styles for the buttons
                            width: 100
                        },
                        buttons: [
                            {
                                type: 'day',
                                count: 1,
                                text: '1 день'
                            },
                            {
                                type: 'month',
                                count: 1,
                                text: '1 месяц'
                            }
                        ],
                        enabled: true,
                        allButtonsEnabled: true,
                        inputEnabled: false
                    },
                    series: series,
                    xAxis: {
                        startOnTick: false,
                        categories: xAxis,
                        events: {
                            setExtremes: function (event) {
                                $('#settings>div').each(function(index, obj) {
                                    $(obj).css('display', 'none');
                                })
                                if (event.rangeSelectorButton.type == 'month') {
                                    start_date = new Date(cur_date.getFullYear(), cur_date.getMonth(), 1, 0, 0, 0, 0);
                                    end_date = new Date(cur_date.getFullYear(), cur_date.getMonth(), new Date(cur_date.getFullYear(), cur_date.getMonth()+1, 0).getDate(), 23, 59, 59, 0);
                                    $('#settings>[name="chart2"]').css('display', '');
                                }   
                                if (event.rangeSelectorButton.type == 'day') {
                                    start_date = new Date(cur_date.getFullYear(), cur_date.getMonth(), cur_date.getDate(), 0, 0, 0, 0);
                                    end_date = new Date(cur_date.getFullYear(), cur_date.getMonth(), cur_date.getDate(), 23, 59, 59, 0);
                                    $('#settings>[name="chart1"]').css('display', '');
                                }
                                chartAjaxLoad[0](
                                    start_date.getFullYear() + '-' + ((start_date.getMonth() + 1).toString().length < 2 ? '0' : '' ) + (start_date.getMonth() + 1) + '-' + (start_date.getDate().toString().length < 2 ? '0' : '' ) + start_date.getDate() + ' 00:00:00',
                                    end_date.getFullYear() + '-' + ((end_date.getMonth() + 1).toString().length < 2 ? '0' : '' ) + (end_date.getMonth() + 1) + '-' + (end_date.getDate().toString().length < 2 ? '0' : '' ) + end_date.getDate() + ' 23:59:59'
                                );
                                return false;
                            }        
                       }
                    },
                    yAxis: {
                        title: {
                            text: 'Сумма (руб.)'
                        }
                    }
                }
                break;
        }
        chart[id] = new Highcharts.Chart(params);
    }

    var chartAjaxLoad = [
        function(s_date, e_date){
            $.ajax({
                type: 'GET',
                url: 'index.php/Chart/get/1',
                data: {
                    'start_date': s_date,
                    'end_date': e_date
                },
                dataType: 'json',
                success: function(data){
                    var forChart = [];
                    for (i in data) {
                        forChart[i] = [];
                        if (i != 0) {
                            for (j = 0; j < forChart[0].length; j++) {
                                forChart[i][j] = {
                                    name: forChart[0][j].name,
                                    y: 0
                                }
                            }
                        }
                        for (j in data[i]) {
                            var sid = parseInt(data[i][j]['sid']) - 1;
                            forChart[i][sid] = {
                                name: data[i][j]['FIO'],
                                y: parseFloat(data[i][j]['sells'].toString().replace(/,/g, ''))
                            }
                        }
                    }
                    initChart(0, forChart);
                }
            });
        }
    ]

    chartAjaxLoad[0](
        start_date.getFullYear() + '-' + ((start_date.getMonth() + 1).toString().length < 2 ? '0' : '' ) + (start_date.getMonth() + 1) + '-' + (start_date.getDate().toString().length < 2 ? '0' : '' ) + start_date.getDate() + ' 00:00:00',
        end_date.getFullYear() + '-' + ((end_date.getMonth() + 1).toString().length < 2 ? '0' : '' ) + (end_date.getMonth() + 1) + '-' + (end_date.getDate().toString().length < 2 ? '0' : '' ) + end_date.getDate() + ' 23:59:59'
    );


    $(window).on('mousewheel', function (event) {
        return;
        if (delta = event.wheelDelta) {
            delta = event.wheelDelta / 120;
            if (window.opera) delta = -delta;
        } else {
            delta = -event.originalEvent.deltaY / 53;
        }
        chart[0].options.chart.options3d.alpha = chart[0].options.chart.options3d.alpha + delta;
        chart[0].options.chart.options3d.beta = chart[0].options.chart.options3d.beta + delta;
        console.log(chart[0].options.chart.options3d.alpha);
        chart[0].redraw(false);
    });

});