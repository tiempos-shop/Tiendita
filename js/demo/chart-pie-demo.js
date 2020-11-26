Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart
function ChartPie(titulo,etiquetas,datos,colores,fondos){
  var ctx = document.getElementById(idPieChart);
  var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: etiquetas,
    datasets: [{
      label:titulo,
      data: datos,
      backgroundColor: colores,
      hoverBackgroundColor: fondos,
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
})
};
