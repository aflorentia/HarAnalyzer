function calculateDirectivesInitial(ttlRespCache, labelsCache){

    var dataCache = [];

    // console.log(labelsCache.length)
    for (i = 0; i < labelsCache.length; i++) {
        publics = 0;
        privates = 0;
        no_cache = 0;
        no_store = 0;

        content_type = 0;

        for (y = 0; y < ttlRespCache.length; y++) {
            if (labelsCache[i] === ttlRespCache[y].content_type) {
                content_type ++;
                if ( ttlRespCache[y].cache_dir == 'public') {
                    publics ++;
                }
                else if (ttlRespCache[y].cache_dir == 'private'){
                    privates ++;
                }
                else if (ttlRespCache[y].cache_dir == 'no-cache'){
                    no_cache++;
                }else if (ttlRespCache[y].cache_dir == 'no-store'){
                    no_store++;
                }
            }
        }
        // console.log(content_type);
        dataCache.push([100*publics/content_type,100*privates/content_type,100*no_cache/content_type,100*no_store/content_type])
    }

    publicDataset = getColumn(dataCache,0);
    privateDataset = getColumn(dataCache,1);
    no_cacheDataset = getColumn(dataCache,2);
    no_storeDataset = getColumn(dataCache,3);



    return {publicDataset,privateDataset,no_cacheDataset,no_storeDataset};
}


function calculateDirectives(ttlRespCache, labelsCache,ispFilter){

    var dataCache = [];

    console.log(labelsCache)
    for (i = 0; i < labelsCache.length; i++) {
        publics = 0;
        privates = 0;
        no_cache = 0;
        no_store = 0;

        content_type = 0;

        for (y = 0; y < ttlRespCache.length; y++) {
            if (ispFilter === null || !(((ttlRespCache[y].isp).split(' '))[0].localeCompare(ispFilter))) {
                if (labelsCache[i] === ttlRespCache[y].content_type) {
                    content_type++;
                    if (ttlRespCache[y].cache_dir == 'public') {
                        publics++;
                    } else if (ttlRespCache[y].cache_dir == 'private') {
                        privates++;
                    } else if (ttlRespCache[y].cache_dir == 'no-cache') {
                        no_cache++;
                    } else if (ttlRespCache[y].cache_dir == 'no-store') {
                        no_store++;
                    }
                }
            }
        }
        // console.log(content_type);
        dataCache.push([100*publics/content_type,100*privates/content_type,100*no_cache/content_type,100*no_store/content_type])
    }

    publicDataset = getColumn(dataCache,0);
    privateDataset = getColumn(dataCache,1);
    no_cacheDataset = getColumn(dataCache,2);
    no_storeDataset = getColumn(dataCache,3);



    return {publicDataset,privateDataset,no_cacheDataset,no_storeDataset};
}




function getColumn(anArray, columnNumber) {
    return anArray.map(function(row) {
        return row[columnNumber];
    });
}