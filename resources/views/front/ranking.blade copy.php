@extends('layouts.app')

@section('content')
<div class="container-fluid row" style="background-color:#fff;">
    <div class="col-md-8">
        <p class="pageTitle">Classification</p>
        <div class="chart-container" style="position: relative; ">
            <canvas id="myChart"></canvas>
        </div>
    </div>
    <div class="col-md-4">
        <table class="table-vsm">
            <tr>
                <th>Nom</th>
                <th>Point Premier tour</th> 
                <th>Point</th>
            </tr>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>
<script>
    $.getJSON("/api/dataset", function (result) {
        // console.log(result);
        // set label
        var labels = [];
        for (var i = 1; i <= result[0]['data'].length; i++) {
            labels.push(i);
        }
        
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: result
            },
            options: {
                animation: {
                    duration: 0, // general animation time
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0, // disables bezier curves
                    }
                }
            }
        });
    });
</script>
@endsection