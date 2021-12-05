function calculateStaleFreshInitial(ttlRespStaleFresh, labelsStaleFresh){

    var dataStaleFresh = [];

    // console.log(labelsStaleFresh.length)
    for (i = 0; i < labelsStaleFresh.length; i++) {
        min_fresh = 0;
        max_stale = 0;


        max_ageStaleFresh = 0;

        for (y = 0; y < ttlRespStaleFresh.length; y++) {
            if (labelsStaleFresh[i] === ttlRespStaleFresh[y].content_type) {
                max_ageStaleFresh ++;
                if ( ttlRespStaleFresh[y].cache_dir == 'min-fresh') {
                    min_fresh ++;
                }
                else if (ttlRespStaleFresh[y].stale_while_revalidate !== false){
                    max_stale ++;
                }
            }
        }
        // console.log(max_ageStaleFresh);
        no = 100*(max_ageStaleFresh-(min_fresh+max_stale))/max_ageStaleFresh;
        // console.log(no)
        dataStaleFresh.push([100*min_fresh/max_ageStaleFresh, 100*max_stale/max_ageStaleFresh, no])
    }

    minFreshDataset = getColumn(dataStaleFresh,0);
    maxStaleDataset= getColumn(dataStaleFresh,1);
    noDirectiveDataset= getColumn(dataStaleFresh,2);

    return {minFreshDataset,maxStaleDataset,noDirectiveDataset}

}


function calculateStaleFresh(ttlRespStaleFresh, labelsStaleFresh, ispFilter){

    var dataStaleFresh = [];

    // console.log(labelsStaleFresh.length)
    for (i = 0; i < labelsStaleFresh.length; i++) {
        min_fresh = 0;
        max_stale = 0;


        max_ageStaleFresh = 0;

        for (y = 0; y < ttlRespStaleFresh.length; y++) {
            if (ispFilter === null || !(((ttlRespStaleFresh[y].isp).split(' '))[0].localeCompare(ispFilter))) {
                if (labelsStaleFresh[i] === ttlRespStaleFresh[y].content_type) {
                    max_ageStaleFresh ++;
                    if ( ttlRespStaleFresh[y].cache_dir == 'min-fresh') {
                        min_fresh ++;
                    }
                    else if (ttlRespStaleFresh[y].stale_while_revalidate !== false){
                        max_stale ++;
                    }
                }
            }
        }
        // console.log(max_ageStaleFresh);
        no = 100*(max_ageStaleFresh-(min_fresh+max_stale))/max_ageStaleFresh;
        // console.log(no)
        dataStaleFresh.push([100*min_fresh/max_ageStaleFresh, 100*max_stale/max_ageStaleFresh, no])
    }

    minFreshDataset = getColumn(dataStaleFresh,0);
    maxStaleDataset= getColumn(dataStaleFresh,1);
    noDirectiveDataset= getColumn(dataStaleFresh,2);

    return {minFreshDataset,maxStaleDataset,noDirectiveDataset}


}
