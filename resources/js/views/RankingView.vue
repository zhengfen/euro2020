<template>
  <div class="container-fluid bg-light">
    <div
      class="row"
    >
      <div class="col-md-8">
        <p class="pageTitle">Classification</p>
        <div
          class="chart-container"
          style="position: relative; "
        >
          <canvas id="line-chart"></canvas>
        </div>
      </div>
      <div class="col-md-4">
        <table class="table-vsm">
          <tr>
            <th>Nom</th>
            <th>Point Premier tour</th>
            <th>Point</th>
          </tr>
          
          <tr v-for="(record, index) in dataset" :key="index">
            <td>{{ record.label }}</td>
            <td>{{ record.data.length > 35 ? record.data[36] : record.data[record.data.length-1]}}</td>
            <td>{{ record.data[record.data.length-1] }}</td>
          </tr>

        </table>
      </div>
    </div>
  </div>
</template>

<script>
import Chart from 'chart.js'
export default {
  data() {
    return {
      dataset: []
    }
  },
  created() {
    this.fetch();
  },
  methods: {
    fetch() {
      console.log('fetching in ranking view');
      axios.get('/api/dataset').then(({ data }) => {
        this.dataset = data;
        // set label
        let labels = [];
        for (let i = 1; i <= data[0]['data'].length; i++) {
          labels.push(i);
        }

        const ctx = document.getElementById('line-chart');
        new Chart(ctx, {
          type: "line",
          data: {
            labels: labels,
            datasets: data
          },
          options: {
            animation: {
              duration: 0, // general animation time
            },
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true
                }
              }]
            },
            elements: {
              line: {
                tension: 0, // disables bezier curves
              }
            }
          }
        });
      });
    }
  }
}
</script>

<style>
</style>