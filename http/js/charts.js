$(function () {
    var chart = [null, null, null, null];

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

        for (i in data) {
            series[i] = { 
                name: 'Продажи',
                data: data[i]
            }
            xAxis.push(data[i].name);
        }
        switch (id) {
            case 0:
                params = {
                    chart: {
                        renderTo: 'container',
                        type: 'column',
                        margin: 100,
                        options3d: {
                            enabled: true,
                            alpha: 15,
                            beta: 15,
                            depth: 50,
                            viewDistance: 25
                        }
                    },
                    title: {
                        text: 'Продажи в разрезе дня по продавцам'
                    },
                    subtitle: {
                        text: 'гистограмма продавец-продажи'
                    },
                    plotOptions: {
                        column: {
                            depth: 25,
                            events: {
                                legendItemClick: function (event) { 
                                    //nothing todo
                                    return false;
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
                                prepareAjaxRequestForChar1();
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

    function prepareAjaxRequestForChar1() {
        console.log('test');
        var data = [
            {
                name: "Иванов К.С.",
                y: 10
            },
            {
                name: "Петров А.К.",
                y: 653
            },
            {
                name: "Сидоров О.Н.",
                y: 610
            },
            {
                name: "Лазарев Р.В.",
                y: 597
            },
            {
                name: "Ершов В.В.",
                y: 569
            },
            {
                name: "Никитин А.С.",
                y: 547
            },
            {
                name: "Смирнов Н.С.",
                y: 530
            },
            {
                name: "Кузнецов К.С.",
                y: 524
            },
            {
                name: "Соколов И.С.",
                y: 512
            },
            {
                name: "Попов К.Р.",
                y: 501
            }
        ];
        initChart(0, [data]);
    }


    function showValues() {
        $('#R0-value').html(chart.options.chart.options3d.alpha);
        $('#R1-value').html(chart.options.chart.options3d.beta);
    }

    // Activate the sliders
    $('#R0').on('change', function () {
        chart.options.chart.options3d.alpha = this.value;
        showValues();
        chart.redraw(false);
    });
    $('#R1').on('change', function () {
        chart.options.chart.options3d.beta = this.value;
        showValues();
        chart.redraw(false);
    });

    //showValues();
    initChart(0, [[1, 2, 3, 4, 5]]);
    setTimeout(function() {
        //initChart(0, [[1, 2, 3, 24, 5]]);
        //prepareAjaxRequestForChar1();
    }, 1000);
});