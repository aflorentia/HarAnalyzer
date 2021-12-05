function createDataset(dataset0, dataset1, dataset2, dataset3 , mode){

    if (mode ==='ttl'){
        var dataset = [{
            label: "TTL",
            data: dataset0,
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
        }];

    }
    else if (mode === 'cache'){
        var dataset =
        [ {
            label: 'Public',
            data: dataset0,
            backgroundColor: [
                'rgba(255, 99, 132,0.5)'
            ],
            borderColor: [
                'rgba(255, 99, 132)'
            ],
            borderWidth: 1
        },{
            label: 'Private',
            data: dataset1,
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)'
            ],
            borderColor: [
                'rgba(54, 162, 235)'
            ],
            borderWidth: 1
        },{
            label: 'no-Cache',
            data: dataset2,
            backgroundColor: [

                'rgba(255, 206, 86, 0.5)'
            ],
            borderColor: [

                'rgba(255, 206, 86)'
            ],
            borderWidth: 1
        },{
            label: 'no-Store',
            data: dataset3,
            backgroundColor: [
                'rgba(75, 300, 192, 0.5)'
            ],
            borderColor: [

                'rgba(75, 300, 192)'
            ],
            borderWidth: 1
        }];


    }
    else if (mode==='time'){
        var dataset = [{
            label: 'maxStale',
            data: dataset0,
            backgroundColor: [
                'rgba(255, 99, 132,0.5)'
            ],
            borderColor: [
                'rgba(255, 99, 132)'
            ],
            borderWidth: 1
        },{
            label: 'minFresh',
            data: dataset1,
            backgroundColor: [
                'rgba(54, 162, 235, 0.5)'
            ],
            borderColor: [
                'rgba(54, 162, 235)'
            ],
            borderWidth: 1
        },{
            label: 'noDirective',
            data: dataset2,
            backgroundColor: [
                'rgba(99, 300, 132,0.5)'
            ],
            borderColor: [
                'rgba(99, 300, 132)'
            ],
            borderWidth: 1
        }
        ];

    }

    return dataset;

}