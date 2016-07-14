@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">ECG</div>

        <?php $data = str_split("006e013101f100b200740037000100d4ffb4ffa2ff9effa2ffa9ffafffb2ffb4ffb4ffb4ffb4ffb5ffb5ffb6ffb7ffb8ffb9ffbaffbbffbdffc0ffc5ffcdffd6ffe0ffebfff6ff00000a0014001e0026002e0035003a003f00440048004c004f005200550056005700580057005500530050004d00490044003e0038003000290020001800100008000000f7ffedffe5ffdeffd8ffd4ffd2ffd0ffd0ffd1ffd1ffd2ffd4ffd5ffd6ffd7ffd9ffdaffdbffdbffdbffdbffdbffdcffdcffddffdeffdfffdfffdfffdfffdfffdfffe0ffe1ffe2ffe3ffe5ffe6ffe7ffe8ffe9ffeaffebffecffedffedffedffedffedffedffedffedffedffedffeeffeeffefffefffefffefffefffefffeeffedffedffedffedffedffedffeeffeeffeeffeeffefffefffefffeeffedffecffebffebffebffebffecffedffeeffefffefffeeffecffeaffe8ffe6ffe5ffe5ffe6ffe7ffe7ffe7ffe7ffe6ffe6ffe6ffe6ffe6ffe7ffe7ffe6ffe6ffe5ffe4ffe3ffe3ffe2ffe2ffe1ffe0ffe0ffdfffdeffddffdcffdbffdaffd9ffd8ffd7ffd6ffd5ffd4ffd3ffd3ffd2ffd2ffd2ffd2ffd2ffd1ffd0ffceffcdffccffccffccffcbffcbffcbffcaffc9ffc8ffc8ffc7ffc7ffc6ffc5ffc3ffc1ffc0ffbfffbfffbeffbeffbeffc1ffcaffddfffbff240058009400d300140154019001c301e701f701f001d401a6016e013101f200b40076003a000400d7ffb7ffa4ff9fffa3ffaaffb1ffb6ffb7ffb8ffb7ffb7ffb6ffb7ffb8ffb9ffbbffbcffbdffbfffc1ffc6ffccffd4ffddffe6ffeffff8ff0000080010001800200028002f0036003c00410046004b004f005200540056005600560056005500530051004e004a0045003f00390032002a0022001900110008000000f6ffedffe3ffdbffd5ffd1ffcfffcfffd1ffd2ffd3ffd3ffd3ffd3ffd3ffd3ffd4ffd5ffd6ffd7ffd9ffdaffdbffdbffdbffdbffdcffdcffddffdeffe0ffe1ffe3ffe4ffe5ffe5ffe4ffe4ffe4ffe5ffe6ffe7ffe8ffe9ffeaffebffebffecffeeffeffff0fff1fff2fff2fff2fff1fff0ffefffefffeeffefffeffff0fff1fff1fff0ffefffeeffeeffedffedffecffecffecffecffecffecffecffecffebffebffebffebffebffebffebffebffecffedffedffeeffeeffeeffedffecffeaffe9ffe8ffe8ffe8ffe7ffe7ffe6ffe5ffe4ffe4ffe4ffe4ffe4ffe3ffe3ffe3ffe2ffe2ffe2ffe1ffe1ffe0ffe0ffdeffddffddffdcffdcffdcffdbffdbffdbffd9ffd8ffd7ffd6ffd6ffd5ffd5ffd4ffd3ffd1ffd0ffcfffcdffccffccffcbffcbffcbffcbffcbffcaffc8ffc6ffc5ffc4ffc4ffc3ffc3ffc3ffc2ffc1ffc0ffbfffbeffbeffbeffc2ffcbffdefffcff240057009100d000110152018f01c201e701f701f001d401a7016e013101f200b300750039000200d5ffb5ffa3ff9effa2ffa9ffb0ffb5ffb7ffb8ffb8ffb9ffb9ffbaffbaffbaffb9ffb9ffb9ffbaffbcffc1ffc7ffcfffd9ffe3ffedfff7ff0000090012001b0023002b00320038003e00430048004d0050005300540055005600560056005500530050004d00490044003e0038003100290022001a00120009000000f7ffeeffe6ffdeffd7ffd3ffd0ffcfffcfffd1ffd2ffd3ffd4ffd5ffd5ffd5ffd5ffd6ffd6ffd6ffd7ffd8ffd9ffdbffdcffddffdeffdfffe0ffe1ffe2", 4) ?>

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
