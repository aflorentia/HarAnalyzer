function connectionCheck(){
    var request = new XMLHttpRequest();
     request.onload = function() {
        let answer = this.responseText;
         if (answer){
             // // Simulate an HTTP redirect:
             window.location.replace("../home/login.html");
         }
    }
    request.open("get", "connectionCheck.php", true);
    request.send();
}