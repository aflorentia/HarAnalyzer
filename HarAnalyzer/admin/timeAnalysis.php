<?php
session_start();
if (!$_SESSION["login"]){

    header ("Location: ../home/login.html");
}


   $servername = "127.0.0.1";
   $username = "root";
   $password = "";
   $dbname = "haranalyzer";


// Create connection
   $conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
   if (!$conn) {
       die("Connection failed: " . mysqli_connect_error());
   }


//QUERY 
$sql = "SELECT AVG(Timings_Wait) AS timings, Response_context_type AS content, HOUR (Started_Date_Time) AS tim FROM harfields GROUP BY  tim, content ASC";
$result = $conn->query($sql);

$res = array();
while($row = mysqli_fetch_array($result)) {
    $res[]= array ("timings" =>$row[0],"content" =>$row[1],"tim" =>$row[2]); 
}


$sql1 = "SELECT AVG(Timings_Wait), Started_Date_Time, Response_context_type, HOUR (Started_Date_Time) AS tim FROM harfields GROUP BY Response_context_type,tim ASC";
$result1 = $conn->query($sql1);

$filterPerDayData = array();
while($row = mysqli_fetch_array($result1)) {
    $filterPerDayData[]= array ("timings" =>$row[0],"date" =>$row[1], 'content' => $row[2], 'tim' => $row[3]); 
}

$sql2 = "SELECT AVG(Timings_Wait), Started_Date_Time, Response_context_type, HOUR (Started_Date_Time) AS tim, Request_Method FROM harfields GROUP BY Response_context_type,tim ASC";
$result2 = $conn->query($sql2);

$filterPerRequestData = array();
while($row = mysqli_fetch_array($result2)) {
    $filterPerRequestData[]= array ("timings" =>$row[0],"date" =>$row[1], 'content' => $row[2], 'tim' => $row[3], 'request' => $row[4]); 
}

$sql3 = "SELECT AVG(Timings_Wait),Response_context_type, HOUR (Started_Date_Time), harfiles.ISP AS tim, Request_Method FROM harfields LEFT JOIN harfiles  ON harfields.id_object = harfiles.id GROUP BY Response_context_type,tim ASC";
$result3 = $conn->query($sql3);

$filterPerIspData = array();
while($row = mysqli_fetch_array($result3)) {
    $filterPerIspData[]= array ("timings" =>$row[0], 'content' => $row[1], 'tim' => $row[2], 'isp' => $row[3]); 
}

$conn->close();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Har Analyzer</title>
    <link rel="stylesheet" href="bootstrap-4.1.3-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/fixed.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <link rel="stylesheet" href="timeAnalysis.css"
</head>
<body>
<div id="timeAnalysis" class="data">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container-fluid ">
            <a class="navbar-brand" href="file:///Users/emmaeconomopoulou/Desktop/ceid/7ο%20εξάμηνο/Web/index1.html"><img src="logo.png"></a>
            <div class="title">
                <div>Har Analyzer</div>
            </div>
            <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon "></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="admin.html" class="nav-link">Home</a>
                    </li>

                    <li class="nav-item hid" >
                        <a href="getAdminData.php" class="nav-link">  User's Statistics </a>
                    </li>

                    <li class="nav-item hid" >
                        <a href="visualizeDataAdmin.html" class="nav-link"> Visualize Data </a>
                    </li>

                    <li class="nav-item hid" >
                        <a href="timeAnalysis.php" class="nav-link"> Time Analysis </a>
                    </li>

                    <li class="nav-item hid" >
                        <a href="headersAnalyze.html" class="nav-link"> Analyze Headers </a>
                    </li>
					
                    <li class="nav-item hid" >
                        <a href="logout.php" class="nav-link">Log Out</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    
</div>
<section class='flex-center time-analysis'>
    <div class="row section-background form-group">
        <div class="col-md-12">
            <br>
            <h1>Time Analysis</h1>
            <br>
            <div class='row'>

            <div class='col-md-4'>
                <div class='content-type-dropdown'> </div>
            </div>

            <div class='col-md-2'>
                <div class='days-filtering'>
                    <label for="days">Day of Week:</label>

                    <select name="days" id="days">
                        <option selected='selected' value='all'>All</option>
                        <option value="0">Sunday</option>
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                    </select>
                </div>
            </div>

            <div class='col-md-2'>
                <div class='request-filtering'>
                    <label for='request'>Request Type: </label>

                    <select name='request' id='request'>
                        <option selected='selected' value='all'>All</option>
                        <option value='get'>Get</option>
                        <option value='post'>Post</option> 
                    </select>
                </div>
            </div>

            <div class='col-md-4'>
                <div class='isp-dropdown'></div>
            </div>
            </div>

            <div>
                <canvas id="canvas" width ="900" height= "500"></canvas>
            </div>
            <script type= "text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@3.5.0/dist/chart.min.js"></script>
            <script type= "text/javascript" src="timeAnalysis.js"></script>
            <br>
        </div>
    </div>
</section>


<div id="contact" class="offset">
    <footer class="foot container">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-lg-4">
                <div class="contactus">
                    <br>
                    <strong>Contact Us</strong>
                    <p>Phones:<br>
                    Afentaki Florentia : +306982045579<br>
                    Oikonomopoulou Emma : +306988452227<br>
                    Sigourou Alkisti : +306975469110<br>
                    </p>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-lg-4 text-center">
                <div class="cookies">
                    <br>
                    <br>
                    <br>
                    <a href="cookiesa.html" class="cookies"><strong>Cookies</strong></a>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-lg-4 text-right">
                <div class="privacy">
                    <br>
                    <br>
                    <br>
                    <a href="termsa.html" class="privacy"><strong>Terms &amp; Conditions</strong></a>
                </div>
            </div>
        </div>
        
        <hr class="socket col-md-12 col-sm-12 col-lg-12">
        &copy FEA Developers.

    </footer>
    </div>

</body>
</html>

<script>
    const weekDays = ['Sunday','Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    let myData = <?php echo json_encode($res) ?>;
    myData = myData.filter(d => d.timings != '0.0000');

    let filterPerDayData = <?= json_encode($filterPerDayData) ?>;
    filterPerDayData = filterPerDayData.map(d => {
        return {...d, day: (new Date(d.date)).getDay()};
    }); 

    let filterPerRequestData = <?= json_encode($filterPerRequestData) ?>;

    let filterPerIspData = <?= json_encode($filterPerIspData)?>;
    filterPerIspData = filterPerIspData.map(d => {
        if(d.isp == 'Cosmote Mobile Telecommunication S.A.' || d.isp == 'Cosmote Mobile Telecommunication S.A'){
            return {...d, isp:'Cosmote Mobile Telecommunication S.A.'};
        }
        return d;
    })

    const Init = function(myData){

        contents = myData.map(d => d.content);
        differentContents = new Set(contents);
        ctypesPos = document.querySelector('.content-type-dropdown');
        
        differentContents.forEach((item,i) => {
            dContent = myData.filter( d => d.content === item);
            localStorage.setItem(item,JSON.stringify(dContent));
        });

        let contentsArray = [];
        differentContents.forEach((item,i) => {
            contentsArray.push(JSON.parse(localStorage.getItem(item)));
        });

        let datase = [];
        // Create data for chart
        contentsArray.forEach((item,i) => {
            let d = []
            let f = []
            let name
            item.forEach((temp,k) =>{
                name = temp["content"]
                d.push(parseFloat(temp["timings"]));
                f.push(parseInt(temp["tim"]));

            });
            let tempdata= [];
            var flag = 0;
            for (var i = 0; i <=23; i++ ){
                if (i == f[flag]){
                    tempdata.push(d[flag])
                    flag++
                }else{
                    tempdata.push(NaN)
                }
            }
            var jsonVar= {
                    label: name,
                    data: tempdata,
                    backgroundColor: 'transparent',
                    borderColor: getRandomColor(),
                    borderWidth: 2
                    }
            datase.push(jsonVar);
        } );

        //Create Chart
        const ctx = document.getElementById('canvas').getContext('2d');
        window.myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['00','01', '02', '03', '04', '05', '06','07','08', '09', '10', '11', '12', '13','14','15', '16', '17', '18', '19', '20','21','22','23'],
                datasets: datase
            },
            options: {
                spanGaps: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            
            }
        });
    }

    Init(myData);

    // Create content dropdown
    let ctypesOptions = [...differentContents].map(c => `<option value="${c}">${c}</option>`);
    ctypesOptions.unshift('<option value="all-contents">All Contents</option>');
    const ctypesDropdown = `    
    <label for="ctypes">Content Type:</label>
    <select name="ctypes" id="ctypes" class='ctypes-dropdown'>
        ${ctypesOptions}
    </select>`;
    ctypesPos.insertAdjacentHTML('afterbegin', ctypesDropdown);
    
    //filter per content type
    ctypesDrp = document.querySelector('.ctypes-dropdown'); 
    ctypesDrp.addEventListener('change', function(e){
        const selected = e.target.value;
        if (selected === 'all-contents'){
            location.reload();
        }
        const selectedData = specificContentData(selected);
        const formatedSelectedData = formatDataChart(selectedData, selected);
        graph(formatedSelectedData, myChart);
    })

    //filter per day
    daysFilteringDrp = document.querySelector('.days-filtering');
    daysFilteringDrp.addEventListener('change', function(e){
        const day = e.target.value;
        if(day === 'all') location.reload();
        const dataForDay = filterPerDayData.filter(d => d.day == day);
        const formatDataPerDay = dataForDay.map(d => {
            return [{tim:d.tim, timings:d.timings, content:d.content}];
        })
        const datasetPerDay = createDatasetForChart(formatDataPerDay);
        graph(datasetPerDay, myChart);
        
    })

    //filter per request type
    requestTypeFilteringDrp = document.querySelector('.request-filtering');
    requestTypeFilteringDrp.addEventListener('change', function(e){
        const requestType = e.target.value;
        if(requestType === 'all') location.reload();
        const dataForRequest = filterPerRequestData.filter( d => d.request == requestType.toUpperCase());
        const formatDataPerRequest = dataForRequest.map(d => {
            return [{tim:d.tim, timings:d.timings, content:d.content}]
        });
        const datasetPerRequest = createDatasetForChart(formatDataPerRequest);
        graph(datasetPerRequest, myChart);
    })

    //create isp dropdown
    const ispDrp = document.querySelector('.isp-dropdown');
    const differentIsps = new Set(filterPerIspData.map(d => d.isp));
    let ispsOptions = [...differentIsps].map(i => `<option value="${i}">${i}</option>`);
    ispsOptions.unshift('<option value="all">All</option>');
    const ispDropdown = `    
    <label for="isp">Isp:</label>
    <select name="isp" id="isp" class='isp-dropdown'>
        ${ispsOptions}
    </select>`;
    ispDrp.insertAdjacentHTML('afterbegin', ispDropdown);

    //filter per isp 
    ispFilteringDrp = document.querySelector('.isp-dropdown');
    ispFilteringDrp.addEventListener('change', function(e){
        const isp = e.target.value;
        if (isp == 'all') location.reload();
        const dataForIsp = filterPerIspData.filter(d => d.isp == isp);
        const formatDataPerIsp = dataForIsp.map(d => {
            return [{tim:d.tim, timings:d.timings, content:d.content}]
        });
        const datasetPerIsp = createDatasetForChart(formatDataPerIsp);
        graph(datasetPerIsp, myChart);
    })


    // function to return data for specific content
    const specificContentData = function(content){
        let data = myData.filter(d => d.content === content);
        data.forEach(d => {delete d.content});
        return data;
    }

    //function to format data to send to chartjs
    const formatDataChart = function(data,selected){
        const dataHours = data.map(d => +d.tim);
        const dataTimings = data.map(d => +d.timings);
        const hours = Array.from(Array(24).keys());
        const hoursChart = hours.map(h => dataHours.includes(h)? h : NaN);
        dataToSend = [];
        counter = 0;
        hoursChart.forEach(h => {
            if (!isNaN(h)){
                dataToSend.push(dataTimings[counter]);
                counter++;
            }else{
                dataToSend.push(NaN);
            }
        });
        
        const chartObj = [{
            label: selected,
            data: dataToSend,
            backgroundColor: 'transparent',
            borderColor: getRandomColor(),
            borderWidth: 2
        }]
        return chartObj;
    }
    

    //function to create chartjs for specific content
    const graph = function(data, chart){
        if (chart) chart.destroy();
        const ctx = document.getElementById('canvas').getContext('2d');
        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['00','01', '02', '03', '04', '05', '06','07','08', '09', '10', '11', '12', '13','14','15', '16', '17', '18', '19', '20','21','22','23'],
                datasets: data
            },
            options: {
                spanGaps: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            
            }
        });
    }

    //function to get random color
    function getRandomColor() {
        var letters = '0123456789ABCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++ ) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    //function to create dataset for chart
    const createDatasetForChart = function(data){
        let dataset = [];
        // Create data for chart
        data.forEach((item,i) => {
            console.log(item);
            let d = []
            let f = []
            let name
            item.forEach((temp,k) =>{
                name = temp["content"]
                d.push(parseFloat(temp["timings"]));
                f.push(parseInt(temp["tim"]));

            });
            let tempdata= [];
            var flag = 0;
            for (var i = 0; i <=23; i++ ){
                if (i == f[flag]){
                    tempdata.push(d[flag])
                    flag++
                }else{
                    tempdata.push(NaN)
                }
            }
            var jsonVar= {
                    label: name,
                    data: tempdata,
                    backgroundColor: 'transparent',
                    borderColor: getRandomColor(),
                    borderWidth: 2
                    }
            dataset.push(jsonVar);
        } );
        return dataset;
    }

    // //function to reset selects
    // const resetSelects = function(activeSelect){
    //     document.getElementById("select").selectedIndex = 0;
    // }
    

</script>   