function fileLoad(e, myObject ){
   var file = e.target;

   for(var i=0; i<file.files.length; i++){
   //    alert(file.files[i].name);
       const reader = new FileReader();

       // var myObject = [];

       reader.onload = function(){  filtering(reader,myObject );
                                     return myObject;}
       reader.readAsText(file.files[i]);



   //reader.readAsDataURL(fileList,files)
   }

    kappa = 1;
    // console.log(kappa);
    return myObject;
}

function filtering(reader, myObject) {
    var fileObj = JSON.parse(reader.result);
    console.log(fileObj);

    const entries = fileObj.log.entries;
    // var myObject = [];
    for ( i in entries) {
        
        let blue = entries[i];

        let url = blue.request.url;
        var domain = url.replace('http://','').replace('https://','').split(/[/?#]/)[0];

        myObject[i] = {
            Started_Date_Time: blue.startedDateTime,
            Timings_Wait: blue.timings.wait,
            Server_IP_Address: blue.serverIPAddress,
            Request_Method: blue.request.method,
            Request_URL: domain,
            Response_Status: blue.response.status,
            Response_Status_Text: blue.response.statusText
            };




            // console.log(myObject[i]);




            // console.log(typeof myObject[i]);
            // console.log("Started_Date_Time:", typeof blue.startedDateTime);
            // console.log("Timings_Wait:", typeof blue.timings.wait);
            // console.log("Server_IP_Address:", typeof blue.serverIPAddress);
            // console.log("Request_Method:", typeof blue.request.method);
            // console.log("Request_URL:", typeof domain);
            // console.log("Response_Status:", typeof blue.response.status);
            // console.log("Response_Status_Next:", typeof blue.response.statusText);


        for( j in blue.request.headers )
        {
            let headerName1=blue.request.headers[j].name;
            let headerValue1=blue.request.headers[j].value;

            // console.log(headerName1 , typeof headerValue1);
            // console.log(typeof headerName1);

            if( headerName1 === "content-type")
            {
              myObject[i].Request_content_type=headerValue1;
            }
            else if(headerName1 === "cache-control")
            {
               myObject[i].Request_cache_control=headerValue1;
            }
            else if(headerName1 === "pragma")
            {
               myObject[i].Request_pragma=headerValue1;
            }
            else if(headerName1 === "expires")
            {
               myObject[i].Request_expires=headerValue1;
            } 
            else if(headerName1 === "age")
            {
               myObject[i].Request_age=headerValue1;
            } 
            else if(headerName1 === "last-modified")
            {
               myObject[i].Request_last_modified=headerValue1;
            }
            else if(headerName1 === "host")
            {
               myObject[i].Request_host=headerValue1;
            }
        }        
        
         for( j in blue.response.headers ){
             let headerName=blue.response.headers[j].name;
             let headerValue=blue.response.headers[j].value;

             // console.log(headerName , typeof headerValue);
             // console.log(typeof headerName);

             if( headerName === "content-type")
             {
               myObject[i].Response_content_type=headerValue;
             }
             else if(headerName === "cache-control")
             {
                myObject[i].Response_cache_control=headerValue;
             }
             else if(headerName === "pragma")
             {
                myObject[i].Response_pragma=headerValue;
             }
             else if(headerName === "expires")
             {
                myObject[i].Response_expires=headerValue;
             } 
             else if(headerName === "age")
             {
                myObject[i].Response_age=headerValue;
             } 
             else if(headerName === "last-modified")
             {
                myObject[i].Response_last_modified=headerValue;
             }
             else if(headerName === "host")
             {
                myObject[i].Response_host=headerValue;
             }
         }        
    }
    return myObject;

    // for (i in myObject){
    //     for (y in myObject[i])
    //         console.log( Object.keys(myObject[i][j]) , typeof myObject[i][y]);
    // }

}

var myObject=[];
const input = document.querySelector('input[type="file"]');
input.addEventListener('change',function(e){   fileLoad(e, myObject);  },false);