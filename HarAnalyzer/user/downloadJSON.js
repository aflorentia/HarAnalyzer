
const buttonPressed = document.getElementById('saveButton');
buttonPressed.addEventListener('click',function(){
    console.log(myObject[1]);
    console.log(JSON.stringify(myObject));


    const data = JSON.stringify(myObject);


    var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(data);
    var downloadAnchorNode = document.createElement('a');
    downloadAnchorNode.setAttribute("href",     dataStr);
    downloadAnchorNode.setAttribute("download", "please" + ".json");
    document.body.appendChild(downloadAnchorNode); // required for firefox
    downloadAnchorNode.click();
    downloadAnchorNode.remove();


},false);

