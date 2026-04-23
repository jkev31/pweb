<canvas id="jual" style="width:100%; margin-bottom:20px; margin-top: 20px;"></canvas>
<canvas id="beli" style="width:100%; margin-bottom:20px; margin-top: 20px;"></canvas>

<script>
const xJual = ["jan", "feb", "mar", "april", "mei","jun"];
const yJual = [20, 48, 44, 24, 15,30];
const barColorsJual = ["green", "green","green","green","green"];
const xBeli = ["jan", "feb", "mar", "april", "mei","jun"];
const yBeli = [55, 49, 44, 24, 15,25];
const barColorsBeli = ["red", "red","red","red","red"];




new Chart("jual", {
  type: "bar",
  data: {
    labels: xJual,
    datasets: [{
      backgroundColor: barColorsJual,
      data: yJual
    }]
  },
  options: {
    plugins: {
      legend: {display: false},
      title: {
        display: true,
        text: "Penjualan",
        font: {size: 16}
      }
    }
  }
});


new Chart("beli", {
  type: "bar",
  data: {
    labels: xBeli,
    datasets: [{
      backgroundColor: barColorsBeli,
      data: yBeli
    }]
  },
  options: {
    plugins: {
      legend: {display: false},
      title: {
        display: true,
        text: "Pembelian",
        font: {size: 16}
      }
    }
  }
});
</script>