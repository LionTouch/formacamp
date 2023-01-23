app.controller('DashboardController',function($scope){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    jQuery('.counter').counterUp({
        delay: 10,
        time: 1000
    });
    if(jQuery('#menu-chart-02').length){
        var options = {
            series: [{
                name: 'This Week',
                data: [31, 40, 28, 51, 42, 109, 100]
            }, {
                name: 'Last Week',
                data: [11, 32, 45, 32, 34, 52, 41]
            }],
            chart: {
                height: 350,
                type: 'area'
            },
            colors: ['#827af3','#00ca00'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                type: 'datetime',
                categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#menu-chart-02"), options);
        chart.render();
    }

    if(jQuery('#menu-chart-03').length){
        var options = {
            series: [67],
            chart: {
                height: 350,
                type: 'radialBar',
                offsetY: -10
            },
            plotOptions: {
                radialBar: {
                    startAngle: -135,
                    endAngle: 135,
                    dataLabels: {
                        name: {
                            fontSize: '16px',
                            color: undefined,
                            offsetY: 120
                        },
                        value: {
                            offsetY: 76,
                            fontSize: '22px',
                            color: undefined,
                            formatter: function (val) {
                                return val + "%";
                            }
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.15,
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 65, 91]
                },
            },
            stroke: {
                dashArray: 4
            },
            labels: ['Median Ratio'],
        };

        var chart = new ApexCharts(document.querySelector("#menu-chart-03"), options);
        chart.render();
    }

    if (jQuery("#chart-3").length){
        options = {
            chart: {
                height: 80,
                type: "area",
                sparkline: {
                    enabled: !0
                },
                group: "sparklines"
            },
            dataLabels: {
                enabled: !1
            },
            stroke: {
                width: 3,
                curve: "smooth"
            },
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: .5,
                    opacityTo: 0
                }
            },
            series: [{
                name: "series1",
                data: [75, 30, 60, 35, 60]
            }],
            colors: ["#27b345"],
            xaxis: {
                type: "datetime",
                categories: ["2018-08-19T00:00:00", "2018-09-19T01:30:00", "2018-10-19T02:30:00", "2018-11-19T01:30:00", "2018-12-19T01:30:00"]
            },
            tooltip: {
                x: {
                    format: "dd/MM/yy HH:mm"
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#chart-3"), options);
        chart.render();
    }

    if (jQuery("#chart-8").length) {
        options = {
            chart: {
                height: 112,
                type: "area",
                animations: {
                    enabled: !0,
                    easing: "linear",
                    dynamicAnimation: {
                        speed: 1e3
                    }
                },
                toolbar: {
                    show: !1
                },
                sparkline: {
                    enabled: !0
                },
                group: "sparklines"
            },
            dataLabels: {
                enabled: !1
            },
            stroke: {
                curve: "smooth",
                width: 3
            },
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: .5,
                    opacityTo: 0
                }
            },
            series: [{
                data: data
            }],
            markers: {
                size: 0
            },
            xaxis: {
                type: "datetime",
                range: XAXISRANGE
            },
            yaxis: {
                max: 100
            },
            legend: {
                show: !1
            },
            colors: ["#827af3"]
        };
        var chart_8 = new ApexCharts(document.querySelector("#chart-8"), options);
        chart_8.render()
    }
    jQuery('.iq-progress-bar > span').each(function() {
        let progressBar = jQuery(this);
        let width = jQuery(this).data('percent');
        progressBar.css({
            'transition': 'width 2s'
        });

        setTimeout(function() {
            progressBar.appear(function() {
                progressBar.css('width', width + '%');
            });
        }, 100);
    });
    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
