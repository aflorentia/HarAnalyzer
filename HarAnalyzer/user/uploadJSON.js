
const buttonPressed2 = document.getElementById('uploadButton');
buttonPressed2.addEventListener('click',function(){
    // window.open("upload.php");

    console.log(myObject[1]);
    console.log(JSON.stringify(myObject));


    const data = JSON.stringify(myObject);

    request= new XMLHttpRequest()
    request.open("POST", "upload.php", true)
    request.onerror = function () {
        console.log("** An error occurred during the transaction");
    };
    request.onload = function () {
        console.log("Transaction was completed succesfully!");
    };

    request.setRequestHeader("Content-type", "application/json");
    request.send(data);


    request.onload = function () {
        if (request.status === 200) {
            //File(s) uploaded
            alert('Upload was successfull!');
        } else {
            alert('An error occurred!');
        }
    };

},false);

