function setCircle(target, dName1, dName2, color, value) {
    var option = option = {
        tooltip: {
            trigger: 'item',
            formatter: "{b}: {c} "
        },
        legend: {
            selectedMode: true,
            itemWidth: 16,
            itemHeight: 16,
            x: 'right',
            y: 'bottom',
            data: [{
                name: dName1,
                icon: 'rect'
            }, {
                name: dName2,
                icon: 'rect'
            }]
        },
        color: ['#00aeff', color], //'#25d498'
        series: [{
            legendHoverLink: false,
            name: '',
            type: 'pie',
            radius: ['30%', '70%'],
            selectedOffset: 10,
            selectedMode: false,
            label: {
                normal: {
                    show: true,
                    position: 'outside',
                    formatter: "{c} ",
                    textStyle: {
                        fontSize: 20
                    }
                }
            },
            labelLine: {
                normal: {
                    show: true
                }
            },
            data: [{
                value: 100,
                name: dName1
            }, {
                value: value,
                name: dName2,
                selected: true
            }]
        }]
    };
    target.setOption(option);
}
$(function() {
    /*$("#datepicker").datepicker({
        numberOfMonths: 2,
        showButtonPanel: true,

        onSelect: function(dataText, inst) {
            var str = dataText.split('/');
            var selectData = "截止" + str[2] + "年" + str[0] + "月" + str[1] + "日";
            $('.cont-1 > p').text(selectData);
            $(this).val("选择截止日期");
        },
        maxDate: new Date()
    });*/
    var myChart = echarts.init($('.chartshow')[0]);
    var myChart1 = echarts.init($('.chartshow')[1]);
    var myChart2 = echarts.init($('.chartshow')[2]);
    var myChart3 = echarts.init($('.chartshow')[3]);

    setCircle(myChart, '申请数', '通过数', '#a97eec', 30);
    setCircle(myChart1, '申请数', '通过数', '#fd8f24', 40);
    setCircle(myChart2, '银行A', '银行B', '#fd7343', 60);
    setCircle(myChart3, '还款中', '还款结束', '#25d498', 70);

    var lineChart = echarts.init($('.linechart')[0]);
    var option = {
        tooltip: {
            trigger: 'axis'
        },
        legend: {
            selectedMode: true,
            orient: 'vertical',
            x: '93%',
            y: 'bottom',
            itemWidth: 10,
            itemHeight: 10,
            data: [{
                name: '银行A',
                icon: 'rect'
            }, {
                name: '银行B',
                icon: 'rect'
            }, {
                name: '银行C',
                icon: 'rect'
            }, {
                name: '银行D',
                icon: 'rect'
            }]
        },
        xAxis: {
            type: 'category',
            name: '（单位：月）',
            splitLine: {
                show: false
            },
            boundaryGap: false,
            data: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"]

        },
        grid: {
            left: '3%',
            right: '18%',
            bottom: '0%',
            containLabel: true
        },
        yAxis: {
            type: 'value',
            name: '（单位：千万)'
        },
        series: [{
            name: '银行A',
            type: 'line',
            symbol: 'none',
            itemStyle: {
                normal: {
                    color: '#25d498',
                    lineStyle: {
                        color: '#25d498'
                    }
                }
            },
            data: [8, 7, 9, 10, 6, 9, 7, 8, 6.8, 7, 7, 10],
        }, {
            name: '银行B',
            type: 'line',
            symbol: 'none',
            itemStyle: {
                normal: {
                    color: '#00aeff',
                    lineStyle: {
                        color: '#00aeff'
                    }
                }
            },
            data: [7, 8, 6.8, 7, 7, 10, 9, 8, 7, 9, 10, 6]
        }, {
            name: '银行C',
            type: 'line',
            symbol: 'none',
            itemStyle: {
                normal: {
                    color: '#a97eec',
                    lineStyle: {
                        color: '#a97eec'
                    }
                }
            },
            data: [5, 4.2, 4.5, 5, 3, 4, 4, 1.4, 2, 3, 4.3, 3.6]
        }, {
            name: '银行D',
            type: 'line',
            symbol: 'none',
            itemStyle: {
                normal: {
                    color: '#fd7343',
                    lineStyle: {
                        color: '#fd7343'
                    }
                }
            },
            data: [4, 4, 1.4, 2, 3, 5, 2, 3, 4, 4.5, 2, 3.3]
        }]
    };
    lineChart.setOption(option);

    
})