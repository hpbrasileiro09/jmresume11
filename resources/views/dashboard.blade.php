<x-app-layout>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>    

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
          </button>
        </div>
    </div>

    <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

    <!--script src=" asset('js/dashboard.js') "></script-->

    <script>
    /* globals Chart:false, feather:false */
    (function () {

      'use strict'

      // Graphs
      var ctx = document.getElementById('myChart')

      if (ctx != null) {

        // chart colors
        var colors = ['#E74C3C','#229954'];    

        /* bar chart */
        var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: [ {!! $meses !!} ],
          datasets: [{
            label: "Débito",
            data: [ {{ $bar1 }} ],
            backgroundColor: colors[0]
          },
          {
            label: "Crédito",
            data: [ {{ $bar2 }} ],
            backgroundColor: colors[1]
          }]
        },
        options: {
          legend: {
            display: false
          },
          scales: {
            xAxes: [{
              barPercentage: 0.7,
              categoryPercentage: 0.5
            }]
          }
        }
        })

        // eslint-disable-next-line no-unused-vars
        /*
        var myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: [
              'Sunday',
              'Monday',
              'Tuesday',
              'Wednesday',
              'Thursday',
              'Friday',
              'Saturday'
            ],
            datasets: [{
              data: [
                15339,
                21345,
                18483,
                24003,
                23489,
                24092,
                12034
              ],
              lineTension: 0,
              backgroundColor: 'transparent',
              borderColor: '#007bff',
              borderWidth: 4,
              pointBackgroundColor: '#007bff'
            }]
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: false
                }
              }]
            },
            legend: {
              display: false
            }
          }
        })
        */

      } // if (ctx != null) ...

    })()
    </script>


</x-app-layout>
