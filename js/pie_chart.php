<script>
  var xValues = ["社長", "管理本部", "営業部", "総務部", "品質管理部"];
  var yValues = [<?=$arr["社長"]?>, <?=$arr["管理本部"]?>, <?=$arr["営業部"]?>, <?=$arr["総務部"]?>, <?=$arr["品質管理部"]?>];
  var barColors = [
    "#FECD56",
    "#FF9F40",
    "#FF6383",
    "#2FA0EE",
    "#4BC0C0"
  ];

  new Chart("pieChart", {
    type: "doughnut",
    data: {
      labels: xValues,
      datasets: [{
        backgroundColor: barColors,
        data: yValues
      }]
    },
    options: {
      title: {
        display: false,
      }
    }
  });
</script>