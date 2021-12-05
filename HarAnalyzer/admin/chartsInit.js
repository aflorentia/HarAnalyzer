function chartsInit(ctx ,labels, data0, data1, data2, data3 , mode){

    var delayed;
    if (mode ==='ttl'){
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "TTL",
                    data: data0,
                    backgroundColor: [
                        'rgba(255, 99, 132,0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                legend:{
                    labels:{
                        fontSize:0
                    },
                    display: false,
                    color: 'rgba(0,0,0)'
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.yLabel;
                        }
                    }
                },
                animation: {
                    onComplete: () => {
                        delayed = true;
                    },
                    delay: (context) => {
                        let delay = 10;
                        if (context.type === 'data' && context.mode === 'default' && !delayed) {
                            delay = context.dataIndex * 300 + context.datasetIndex * 100;
                        }
                        return delay;
                    },
                },
                interaction: {
                    intersect: false
                },
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'TTL per Content Type Chart',
                        padding: {
                            top: 20,
                            bottom: 30
                        }
                        // fullSize: true
                        // font: {weight: 'bold'}
                    },
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });
    }
    else if (mode==='ttlHIST'){
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Number of TTL',
                    data: data0,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235)'
                    ],
                    borderWidth: 1
                }
                ]
            },
            options: {
                animation: {
                    onComplete: () => {
                        delayed = true;
                    },
                    delay: (context) => {
                        let delay = 10;
                        if (context.type === 'data' && context.mode === 'default' && !delayed) {
                            delay = context.dataIndex * 300 + context.datasetIndex * 100;
                        }
                        return delay;
                    },
                },
                interaction: {
                    intersect: false
                },
                responsive: true,
                plugins:
                    {
                        title: {
                            display: true,
                            text: 'TTL Max Age Histogram',
                            padding: {
                                top: 20,
                                bottom: 30
                            }
                            // fullSize: true
                            // font: {weight: 'bold'}
                        },
                        legend: {
                            position: 'top',
                        },
                    },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });

    }
    else if (mode === 'cache'){
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Public',
                    data: data0,
                    backgroundColor: [
                        'rgba(255, 99, 132,0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132)'
                    ],
                    borderWidth: 1
                },{
                    label: 'Private',
                    data: data1,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235)'
                    ],
                    borderWidth: 1
                },{
                    label: 'no-Cache',
                    data: data2,
                    backgroundColor: [

                        'rgba(255, 206, 86, 0.5)'
                    ],
                    borderColor: [

                        'rgba(255, 206, 86)'
                    ],
                    borderWidth: 1
                },{
                    label: 'no-Store',
                    data: data3,
                    backgroundColor: [
                        'rgba(75, 300, 192, 0.5)'
                    ],
                    borderColor: [

                        'rgba(75, 300, 192)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                animation: {
                    onComplete: () => {
                        delayed = true;
                    },
                    delay: (context) => {
                        let delay = 10;
                        if (context.type === 'data' && context.mode === 'default' && !delayed) {
                            delay = context.dataIndex * 300 + context.datasetIndex * 100;
                        }
                        return delay;
                    },
                },
                interaction: {
                    intersect: false
                },
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Cacheablity Chart',
                        padding: {
                            top: 20,
                            bottom: 30
                        }
                        // fullSize: true
                        // font: {weight: 'bold'}
                    },
                    legend: {
                        position: 'top',
                    },
                },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });

    }
    else if (mode==='time'){
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'maxStale',
                    data: data0,
                    backgroundColor: [
                        'rgba(255, 99, 132,0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132)'
                    ],
                    borderWidth: 1
                },{
                    label: 'minFresh',
                    data: data1,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235)'
                    ],
                    borderWidth: 1
                },{
                    label: 'noDirective',
                    data: data2,
                    backgroundColor: [
                        'rgba(99, 300, 132,0.5)'
                    ],
                    borderColor: [
                        'rgba(99, 300, 132)'
                    ],
                    borderWidth: 1
                    }
                ]
            },
            options: {
                animation: {
                    onComplete: () => {
                        delayed = true;
                    },
                    delay: (context) => {
                        let delay = 10;
                        if (context.type === 'data' && context.mode === 'default' && !delayed) {
                            delay = context.dataIndex * 300 + context.datasetIndex * 100;
                        }
                        return delay;
                    },
                },
                interaction: {
                    intersect: false
                },
                responsive: true,
                plugins:
                    {
                        title: {
                            display: true,
                            text: 'Expiration Chart',
                            padding: {
                                top: 20,
                                bottom: 30
                            }
                            // fullSize: true
                            // font: {weight: 'bold'}
                        },
                        legend: {
                            position: 'top',
                        },
                    },
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                }
            }
        });

    }

    return myChart;

}