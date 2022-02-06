<?php

include_once 'header.php';
include_once '../src/model/DataContext.php';
include_once '../src/model/natureReserves.php';


if(!isset($db)) {
    $db = new DataContext();
}


?>
<head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
          integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
          crossorigin=""/>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"
            integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
            crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>
<body>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Data</li>
    </ol>
</nav>

<div class="container-fluid col-md-12">
    <h1>Nature Reserve Areas</h1>
    <p>This data is displayed from the csv data set provided from the Plymouth OpenData repository
        found here.  <a href="https://plymouth.thedata.place/dataset/local-nature-reserves">
            https://plymouth.thedata.place/dataset/local-nature-reserves</a></p>

    <div class="container-fluid col-12">
        <div class="row">
            <div class="col-6">
                <table class="table table-striped table-bordered border-success">
                    <thead class="bg-success text-white">
                    <tr>
                        <th>Site</th>
                        <th>Area</th>
                        <th>Ownership</th>
                    </tr>
                    </thead>
                    <tbody class="border-success">
                    <?php
                    $HTML = "";
                    $site = [];
                    $area = [];
                    $sites = $db->natureReserves(); // calling the function from DataContext and putting in variable to loop through.
                    if($sites)
                    {
                        foreach($sites as $data)
                        {
                            $HTML .= "<tr>";
                            $HTML .= "<td>".$data->site()."</td>"; // adding specific data to the table.
                            $HTML .= "<td>".$data->area()."</td>";
                            $HTML .= "<td>".$data->ownership()."</td>";
                            $HTML .= "</tr>";
                            $site[] = $data->site(); // these variables are used for the chart.
                            $area[] = $data->area();
                        }
                    }
                    echo $HTML;
                    ?>

                    </tbody>
                </table>
            </div>
            <div class="col-1">
            </div>
            <div class="col-5">
                <div><canvas id="myChart"></canvas></div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
<script>
    // chart.js template to view csv file.
    const labels = <?php echo json_encode($site) ?> ; // pass in $site array.
    const data = {
        labels: labels,
        datasets: [{
            label: 'Nature Reserve Areas',
            data: <?php echo json_encode($area)?>, // pass in $area array.
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 205, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
            ],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    };

    // initialize the chart
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>
