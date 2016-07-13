@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">ECG</div>

        <?php $data = str_split("3c003c003c003c003c003c003c003c003c003c003c003c003c003c003c003c003c003c003c003c00c4ffc4ffc4ffc3ffc3ffc2ffc2ffc1ffc0ffc0ffc1ffc7ffd4ffeaff0b0038006e00aa00e9002a016901a201d001ed01f401e501c201900156011901da009c005f002400f1ffc8ffadffa0ff9effa5ffadffb3ffb6ffb6ffb6ffb6ffb6ffb7ffb8ffb9ffb9ffbaffbaffbbffbdffc0ffc5ffccffd5ffdeffe9fff3fffcff04000e00170020002900310037003d00420047004c00500054005700580059005a00590058005700540051004d00490044003e003800310029002100190010000700fefff5ffebffe3ffdcffd7ffd4ffd2ffd1ffd1ffd1ffd1ffd1ffd1ffd1ffd2ffd4ffd5ffd6ffd7ffd7ffd8ffd8ffd9ffdaffdbffdcffddffdfffe0ffe2ffe2ffe3ffe4ffe5ffe5ffe6ffe7ffe7ffe8ffe8ffe8ffe7ffe7ffe8ffe9ffebffecffedffedffeeffefffeffff0fff1fff1fff2fff2fff3fff3fff3fff3fff2fff1fff0ffefffeeffeeffeeffeeffeeffeeffedffecffecffecffecffecffebffebffebffebffecffecffedffedffedffecffebffeaffeaffe9ffe8ffe7ffe7ffe7ffe8ffe7ffe7ffe7ffe6ffe6ffe5ffe5ffe5ffe5ffe5ffe5ffe5ffe5ffe4ffe4ffe3ffe2ffe2ffe2ffe2ffe1ffe0ffe0ffdfffdeffddffdcffdbffdbffdaffd9ffd8ffd7ffd6ffd5ffd3ffd2ff", 4) ?>

        <div class="panel-body">
          <table class="table">
            <canvas id="myChart" width="100" height="100"></canvas>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.js"></script>
            <script>
            var arr = eval(<?php echo json_encode($data) ?>);
            var l = arr.length;
            var labers = new Array(l);
            var nxja = new Array();
            for (var i=0; i<l; i++){
              var jshh = "0x".concat(arr[i]);
              nxja[i] = parseInt(jshh, 16);
              labers[i] = i;
            }

            var canvas = document.getElementById("myChart");
            var ctx = canvas.getContext("2d");
            var lineData = {
              labels: labers,
              datasets: [{
                label: "My First dataset",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                data: nxja,
            }]
            };
            var myChart = new Chart(ctx, {
              type: "line",
              data: lineData,
              options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
            });
            </script>
          </table>
        </div>
      </div>
    <div>
  </div>
</div>


@endsection
