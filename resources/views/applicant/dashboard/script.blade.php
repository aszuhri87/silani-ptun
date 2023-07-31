

<script type="text/javascript">


$(function () {
    'use strict';



    var flatPicker = $('.flat-picker'),
    isRtl = $('html').attr('data-textdirection') === 'rtl',
    chartColors = {
        column: {
            series1: '#826af9',
            series2: '#d2b0ff',
        bg: '#f8d3ff'
      },
      success: {
        shade_100: '#7eefc7',
        shade_200: '#06774f'
      },
      donut: {
        series1: '#ffe700',
        series2: '#00d4bd',
        series3: '#826bf8',
        series4: '#2b9bf4',
        series5: '#FFA1A1'
      },
      area: {
          series3: '#a4f8cd',
          series2: '#60f2ca',
          series1: '#2bdac7'
        }
    };




  // heat chart data generator
  function generateDataHeat(count, yrange) {
    var i = 0;
    var series = [];
    while (i < count) {
      var x = 'w' + (i + 1).toString();
      var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

      series.push({
        x: x,
        y: y
      });
      i++;
    }
    return series;
  }

  // Init flatpicker
  if (flatPicker.length) {
    var date = new Date();
    flatPicker.each(function () {
      $(this).flatpickr({
        mode: 'range',
        defaultDate: ['2019-05-01', '2019-05-10']
      });
    });
  }


  // Area Chart
  // --------------------------------------------------------------------


  var docs = {!! json_encode($c_docs) !!};
  var cuti = {!! json_encode($c_leave) !!};



  var bulan = [];
  var jumlah = [];
  var jumlah_doc = [];

  docs.forEach(element => {
      bulan.push(element.bulan);
      jumlah.push(element.jumlah);
  });

  cuti.forEach(element => {
    jumlah_doc.push(element.jumlah)
  })

  var areaChartEl = document.querySelector('#applicant-chart'),
    areaChartConfig = {
      chart: {
        height: 400,
        type: 'area',
        stacked:true,
        parentHeightOffset: 0,
        toolbar: {
          show: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        curve: 'straight'
      },
      markers: {
        size: [5, 7]
        },
      legend: {
        show: true,
        position: 'top',
        horizontalAlign: 'start'
      },
      grid: {
        xaxis: {
          lines: {
            show: true
          }
        }
      },
      colors: [chartColors.area.series3, chartColors.area.series2, chartColors.area.series1],
      series: [

        {
          name: 'Document',
          data: jumlah
        },
      ],
      xaxis: {

        categories: bulan
      },
      fill: {
        opacity:1,
        type:'solid'
      },
      tooltip: {
        shared: false
      },
      yaxis: {
        opposite: isRtl,
      }
    };
  if (typeof areaChartEl !== undefined && areaChartEl !== null) {
    var areaChart = new ApexCharts(areaChartEl, areaChartConfig);
    areaChart.render();
  }


  var areaChartEl = document.querySelector('#karyawan-chart'),
    areaChartConfig = {
      chart: {
        height: 400,
        type: 'area',
        stacked:true,
        parentHeightOffset: 0,
        toolbar: {
          show: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        curve: 'straight'
      },
      markers: {
        size: [5, 7]
        },
      legend: {
        show: true,
        position: 'top',
        horizontalAlign: 'start'
      },
      grid: {
        xaxis: {
          lines: {
            show: true
          }
        }
      },
      colors: [chartColors.area.series3, chartColors.area.series2, chartColors.area.series1],
      series: [

        {
          name: 'Document',
          data: jumlah
        },
        {
          name: 'Cuti',
          data: jumlah_doc
        },
      ],
      xaxis: {

        categories: bulan
      },
      fill: {
        opacity:1,
        type:'solid'
      },
      tooltip: {
        shared: false
      },
      yaxis: {
        opposite: isRtl,
      }
    };
  if (typeof areaChartEl !== undefined && areaChartEl !== null) {
    var areaChart = new ApexCharts(areaChartEl, areaChartConfig);
    areaChart.render();
  }
});




</script>

