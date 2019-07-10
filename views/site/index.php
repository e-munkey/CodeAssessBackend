<?php

/* @var $this yii\web\View */

$this->title = 'NSW Government Schools: Enrolment Data';
$thc = Array();
$ahc = Array();
foreach($data as $key=>$value){
	for($i=2004; $i<2019; $i++){
	$thc[$i] = $thc[$i] ?? 0;
	$thc[$i] = $thc[$i] + (int)$value['HC_'.$i];
	}
}
$total_schools = count($data);
foreach($thc as $key=>$value){
	$ahc[$key] = $value/$total_schools;
}
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<div class="site-index">
<div class="container">
<div class="row">
<h1> Total Number of Schools: <?php echo $total_schools ?> </h1>
</div>
<div class="row">
<div class="col-md-6">
<h1>Total Head Count</h1>
<canvas id="chart1"></canvas>
</div>
<div class="col-md-6">
<h1>Average Head Count</h1>
<canvas id="chart2"></canvas>
</div>
</div>
<div class="row">
<div class="col-md-6">
<h1>Search By School Code</h1>
  <div class="form-group">
    <label for="code">Enter School Code:</label>
    <input type="number" class="form-control" id="school_code">
  </div>
  <button type="submit" class="btn btn-default" onclick="schoolData()">Submit</button>
</div>
<div class="col-md-6">
<p id="error">School code does not exist! Please try again with a vaild school code or search by school name instead.</p>
<canvas id="chart3"></canvas>
</div>
</div>
<div class="row">
<div class="col-md-6">
<h1>Search By School Name</h1>
  <div class="form-group">
    <label for="code">Select School Name:</label>
   <select id="school_name">
   <option value="">Please select a school</option>
	<?php
		foreach($data as $key => $value) {
			echo '<option value="' . $value['School Name'] . '">' . $value['School Name'] . '</option>';
		}
	?>
	</select>
  </div>
  <button type="submit" class="btn btn-default" onclick="nameData()">Submit</button>
</div>
<div class="col-md-6">
<canvas id="chart4"></canvas>
</div>
</div>
</div>
</div>
<script>
var data = <?php echo json_encode($data)?>;
var school_code;
var error = document.getElementById("error");
var chart_code = document.getElementById("chart3");
var chart_name = document.getElementById("chart4");
error.style.display = "none";
chart_code.style.display = "none";
function schoolData(){
	error.style.display = "none";
	chart_code.style.display = "none";
	var error_flag=1;
	school_code = document.getElementById("school_code").value;
	for (var i=0 ; i < data.length ; i++){
		if (data[i]['School Code'] == school_code) {
			error_flag=0;
			console.log(data[i]['School Name']);
			var ctx3 = document.getElementById('chart3').getContext('2d');
			var chart = new Chart(ctx3, {
				// The type of chart we want to create
				type: 'line',

				// The data for our dataset
				data: {
					labels: ['2004', '2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018'],
					datasets: [{
						label: 'Head Count for: '+data[i]['School Name']+' School Code: '+school_code,
						backgroundColor: 'rgb(1, 92, 150)',
						borderColor: 'rgb(226, 56, 63)',
						data: [data[i]['HC_2004'], data[i]['HC_2005'], data[i]['HC_2006'], data[i]['HC_2007'], data[i]['HC_2008'], data[i]['HC_2009'], data[i]['HC_2010'], data[i]['HC_2011'], data[i]['HC_2012'], data[i]['HC_2013'], data[i]['HC_2014'], data[i]['HC_2015'], data[i]['HC_2016'], data[i]['HC_2017'], data[i]['HC_2018']]
					}]
				},

				// Configuration options go here
				options: {}
			});
			break;
		}
	}
	
	if(error_flag==1){
		error.style.display = "block";
	}else{
		error.style.display = "none";
		chart_code.style.display = "block"
	}
}
function nameData(){
	chart_name.style.display = "none";
	school_name = document.getElementById("school_name").value;
	for (var i=0 ; i < data.length ; i++){
		if (data[i]['School Name'] == school_name) {
			var ctx4 = document.getElementById('chart4').getContext('2d');
			var chart = new Chart(ctx4, {
				// The type of chart we want to create
				type: 'line',

				// The data for our dataset
				data: {
					labels: ['2004', '2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018'],
					datasets: [{
						label: 'Head Count for: '+data[i]['School Name']+' School Code: '+data[i]['School Code'],
						backgroundColor: 'rgb(1, 92, 150)',
						borderColor: 'rgb(226, 56, 63)',
						data: [data[i]['HC_2004'], data[i]['HC_2005'], data[i]['HC_2006'], data[i]['HC_2007'], data[i]['HC_2008'], data[i]['HC_2009'], data[i]['HC_2010'], data[i]['HC_2011'], data[i]['HC_2012'], data[i]['HC_2013'], data[i]['HC_2014'], data[i]['HC_2015'], data[i]['HC_2016'], data[i]['HC_2017'], data[i]['HC_2018']]
					}]
				},

				// Configuration options go here
				options: {}
			});
			break;
		}
	}
	chart_name.style.display = "block";
}
var ctx1 = document.getElementById('chart1').getContext('2d');
var chart = new Chart(ctx1, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ['2004', '2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018'],
        datasets: [{
            label: 'Combined Data of all Schools',
            backgroundColor: 'rgb(1, 92, 150)',
            borderColor: 'rgb(226, 56, 63)',
            data: [<?php echo implode(",",$thc) ?>]
        }]
    },

    // Configuration options go here
    options: {}
});
var ctx2 = document.getElementById('chart2');
var myChart = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ['2004', '2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018'],
        datasets: [{
            label: 'Avg number of children per school',
            data: [<?php echo implode(",",$ahc) ?>],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>