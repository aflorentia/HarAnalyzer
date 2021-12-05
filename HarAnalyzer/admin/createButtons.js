function createButtons(ttlResp, buttonStart, mode ){

    const unique = (value, index, self) => {
        return self.indexOf(value) === index
    }

    if (mode==='isp') {
        // usage example:
        alfa = [];
        for (y = 0; y < ttlResp.length; y++)
            alfa.push(((ttlResp[y].isp).split(' '))[0])
        // console.table(alfa);
    }
    else if (mode==='content_type'){
        // usage example:
        alfa = [];
        for (y = 0; y < ttlResp.length; y++)
            alfa.push(ttlResp[y].content_type)
        // console.table(alfa);

    }
    var uniqueA = alfa.filter(unique);
    // console.table(uniqueA);
    for (i = 0; i < uniqueA.length; i++) {
        let moby = '<button type="submit" id=' + uniqueA[i] + ' class="submit btn btn-outline btn-lg">'
            + uniqueA[i] + '</button>';
        // console.log(moby);
        $(buttonStart).append(moby);
        // $('#btnGroup').append(moby);
    }

    return uniqueA

}