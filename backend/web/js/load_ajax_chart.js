$(function () {
  "use strict";
  let bulan = $('#aktivitasharian-bulan').find(":selected").val();

  let data = [];
  $.ajax({
    method: "POST",
    url: "/ajax-load/data-chart?bulan="+bulan,
  }).done(function (data) {
    /** PIE CHART **/
    if (data == "0,0,0") {
      var datapie = {
        labels: [""],
        datasets: [
          {
            data: [1],
            backgroundColor: ["#E0E0E0"],
            borderWidth: 0,
          },
        ],
      };
      var optionpie = {
        events: [],
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: false,
        },
        animation: {
          animateScale: true,
          animateRotate: true,
        },
      };
    } else {
      var datapie = {
        labels: ["Ditolak", "Diterima", "Belum Diverifikasi"],
        datasets: [
          {
            data: data,
            backgroundColor: ["#BD2130", "#0C8842", "#00B8D4"],
            borderWidth: 0,
          },
        ],
      };

      var optionpie = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
          display: false,
        },
        animation: {
          animateScale: true,
          animateRotate: true,
        },
      };
    }

    // For a pie chart
    var ctx2 = document.getElementById("chartDonut");
    var myDonutChart = new Chart(ctx2, {
      type: "doughnut",
      data: datapie,
      options: optionpie,
    });
  });

  // chart absensi
  // $.ajax({
  //   method: "GET",
  //   url: "/ajax-load/chart-absensi",
  // })
  //   .done(function (data) {
  //     var getDaysArray = function () {
  //       let year = new Date().getFullYear(); //CURRENT YEAR
  //       let month = new Date().getMonth() + 1; //CURRENT MONTH
  //       var monthIndex = month - 1; // 0..11 instead of 1..12
  //       var date = new Date(year, monthIndex, 1);
  //       var result = [];
  //       while (date.getMonth() == monthIndex) {
  //         result.push(date.getDate());
  //         date.setDate(date.getDate() + 1);
  //       }
  //       return result;
  //     };
  //     var getValues = function () {
  //       var result = [];
  //       let i = 1;
  //       while (i <= getDaysArray().length) {
  //         result.push(Math.floor(Math.random() * (100 - 1)) + 1);
  //         i++;
  //       }
  //       return { data: result, backgroundColor: "#66a4fb" };
  //     };
  //     console.log(getDaysArray());
  //     console.log(getValues().data);

  //     // cart bar
  //     var chartBar = document.getElementById("chartBar1").getContext("2d");
  //     new Chart(chartBar, {
  //       type: "bar",
  //       data: {
  //         labels: getDaysArray(),
  //         datasets: [
  //           {
  //             label: "Acquisitions by sdsd",
  //             data: getValues().data,
  //             backgroundColor: getValues().backgroundColor,
  //           },
  //         ],
  //       },
  //       options: {
  //         responsive: true,
  //         maintainAspectRatio: false,
  //         legend: {
  //           display: false,
  //           labels: {
  //             display: false,
  //           },
  //         },

  //         scales: {
  //           xAxes: [
  //             {
  //               gridLines: {
  //                 display: false,
  //               },
  //               display: true,
  //               barPercentage: 0.4,
  //             },
  //           ],
  //           yAxes: [
  //             {
  //               gridLines: {
  //                 display: false,
  //               },
  //               display: false,
  //               ticks: {
  //                 fontColor: "#8392a5",
  //                 fontSize: 10,
  //                 min: 0,
  //                 max: 100,
  //               },
  //             },
  //           ],
  //         },
  //       },
  //     });
  //   })
  //   .fail(function (jqXHR, textStatus, errorThrown) {
  //     $(".chart").html(
  //       "<div class='alert alert-danger'>Gagal mengambil data, Error:" +
  //         jqXHR +
  //         "</div>"
  //     );
  //   });
  // chart absensi
});
