function calculateTTL(ttlResp, waxOn, ispFilter){
    newData = [];
    for (y=0; y < waxOn.length; y++){
        newData[y] = 0;
        for (i = 0; i < ttlResp.length; i++) {
            if (ispFilter === null || !(((ttlResp[i].isp).split(' '))[0].localeCompare(ispFilter))) {
                if (ttlResp[i].content_type === waxOn[y])
                {
                    newData[y] += ttlResp[i].max_age;

                }
            }
        }
    }

    return newData;
}