function DetermineBucket(ttlRespTTL, bucket){

    //////      Determine Buckets     //////////////////////////////////////////

    let min,max,range;
    min = ttlRespTTL[0].max_age;
    max = ttlRespTTL[0].max_age;
    for (y = 1; y < ttlRespTTL.length; y++) {
        if (min > ttlRespTTL[y].max_age) min = ttlRespTTL[y].max_age;
        if (max < ttlRespTTL[y].max_age) max = ttlRespTTL[y].max_age;
    }
    // max = max/10;
    console.log("min",min);
    console.log("max",max);

    range = (max - min)/bucket;
    for (let i=0;i<10;i++){
        labelsTTL.pop();
    }
    for (let i=0;i<10;i++){
        labelsTTL.push(i*range+range);
    }
    console.log(labelsTTL);

    return labelsTTL;

}


function FilterData(ttlRespTTL, labelsTTL, bucket) {

    var data = new Array(bucket);
    let prev=0;
    // for (i = 0; i < contentTypesTTL.length; i++) {
    for (i=0; i<labelsTTL.length; i++){
        data[i] = 0;
        // console.log("prev",prev)
        // console.log("now",labelsTTL[i])

        for (y = 0; y < ttlRespTTL.length; y++) {
            if (ttlRespTTL[y].max_age <= labelsTTL[i] && ttlRespTTL[y].max_age >= prev) {
                // if (contentTypesTTL[i] === ttlRespTTL[y].content_type) {
                // if ( "javascript" === ttlRespTTL[y].content_type)
                data[i] ++;
            }
        }
        prev = labelsTTL[i];
        // if (i>0)
        //     data[i]=data[i]-data[i-1];
    }
    console.dir(data);
    // for (i=9;i<-1;i++){
    //         data[i]=data[i]-data[i+1];
    // }

    // console.table(data);
    return data;

}


function RemoveContentType(ttlRespTTL, contentType) {

    let newTTlResp = [];
    let i=0;
    // console.dir(ttlRespTTL);
    // console.log(ttlRespTTL[0].content_type);
    // console.log(contentType);
    for (let y = 0; y < ttlRespTTL.length; y++) {
        // console.log(ttlRespTTL[y].content_type)
            if (ttlRespTTL[y].content_type.localeCompare(contentType)) {
            // if ( "javascript" === ttlRespTTL[y].content_type){
            //     newTTlResp[i] = ttlRespTTL[y];
            //     i++;
        }
    }

    console.dir(newTTlResp);
    return newTTlResp;

}