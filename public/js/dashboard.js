/* globals Chart:false, feather:false */

(function () {

  'use strict'

  // Graphs
  var ctx = document.getElementById('myChart')

  if (ctx != null) {

    // chart colors
    var colors = ['#007bff','#28a745','#333333','#c3e6cb','#dc3545','#6c757d'];    

    /* bar chart */
    var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["S", "M", "T", "W", "T", "F", "S"],
      datasets: [{
        data: [589, 445, 483, 503, 689, 692, 634],
        backgroundColor: colors[0]
      },
      {
        data: [639, 465, 493, 478, 589, 632, 674],
        backgroundColor: colors[1]
      }]
    },
    options: {
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          barPercentage: 0.4,
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
