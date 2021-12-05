function fileLoad(input){
    //console.log(input.files)
    const reader = new FileReader();

    reader.onload = function(){ filtering(reader) }
    reader.readAsText(input.files[0]);
   //reader.readAsDataURL(input,files)
}



function filtering(reader){
    
    //    console.log(reader.result)
    /* var    temps=reader.result
    console.log( "entries\n"
        +temps.log.entries.startedDateTime
        +temps.entries.timings
        +temps.entries.serverIPAddress
    )*/

    var fileObj=JSON.parse(reader.result);
    console.log(fileObj);

    const entries=fileObj.log.entries;
    for( i in entries ){

        let blue=entries[i] ;

        console.log( "Started Date Time:\t" + blue.startedDateTime + "\n Timings:\n" + "\t Wait:\t" + blue.timings.wait + "\n Server IP Address:\t" + blue.serverIPAddress + 
        "\n Request:\n" + "\t Method:\t" + blue.request.method + "\n \t url:\t" + blue.request.url + "\n \t Headers:\t"  )  ;  /**!!!!!!!!!!! poia request headers oeo?? */

            
        for( i in blue.request.headers ){
            let headerName=blue.request.headers[i].name;
            let headerValue=blue.request.headers[i].value;

            /**                     Otan apofasisoyn poia pedia theloyn apo ton header toy request tha to epanaferoume
            if( headerName === "content-type" || headerName === "cache-control" || headerName === "pragma" || headerName === "expires" || headerName === "age" || headerName === "last-modified" || headerName === "host" )
                
                    console.log(  "\n\t\t" + headerName + "\t Value: \t" + headerValue);
        
            */

        } 

        console.log( "\n Response:\n" + "\n \t Status:\t" + blue.response.status + "\n \t Status Text:\t" + blue.response.statusText + "\n \t Headers:\t" );

        for( i in blue.response.headers ){
            let headerName=blue.response.headers[i].name;
            let headerValue=blue.response.headers[i].value;

            if( headerName === "content-type" || headerName === "cache-control" || headerName === "pragma" || headerName === "expires" || headerName === "age" || headerName === "last-modified" || headerName === "host" )
                    
                    console.log(  "\n\t\t" + headerName + "\t Value: \t" + headerValue );

        }        
    }
}

/**
 *    "Why doesn't JavaScript need a main() function?"
 * 
 *    <<    Because the entire code block is effectively one big main. In JavaScript, global code can have all of the constructs function code can have, 
 *  and has stepwise execution, just like functions do. In fact, when the JS engine processes the code block as a whole, it does very nearly 
 *  the same things that it does when processing a function call.    >>
 * 
 */
const input =  document.querySelector('input[type="file"]') ;                   //  select the first element which <in HTML code> is : <input type="file">
input.addEventListener('change',function(e){ fileLoad(input) },false)