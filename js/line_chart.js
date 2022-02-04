var xValues = ["11月", "12月", "1月", "2月", "3月", "4月"];
new Chart("lineChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [
      {
        label: "販売チーム01",
        data: [860, 1140, 1060, 1060, 1070, 1110],
        pointBackgroundColor: "#d95941",
        borderColor: "#d95941",
        fill: false,
        borderWidth: 1,
      },
      {
        label: "販売チーム02",
        data: [1600, 1700, 1700, 1900, 2000, 2700],
        pointBackgroundColor: "#ffc906",
        borderColor: "#ffc906",
        fill: false,
        borderWidth: 1,
      },
      {
        label: "販売チーム03",
        data: [300, 700, 2000, 5000, 5100, 4000],
        pointBackgroundColor: "#3fbca3",
        borderColor: "#3fbca3",
        fill: false,
        borderWidth: 1,
      },
    ],
  },
  options: {
    legend: { display: true },
  },
});
