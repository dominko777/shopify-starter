<script>
import { Line } from 'vue-chartjs'

export default {
	extends: Line,
	props: {
      data: {
        type: Object,
        default: false
      }
    },
	data() {
        return {
          options: {}
        }
    },
	methods: {
    createChart () {
      const labels = this.data.dates.map(el => {
            return el.date
          })
      const counts = this.data.dates.map(el => {
            return el.count
          })
      this.renderChart({
        labels: labels,
        datasets: [
          {
            label: 'Reviews',
            backgroundColor: '#4FB0C6',
            data: counts
          }
        ]
      }, {
        responsive: true, 
        maintainAspectRatio: false,
        scales: {
           yAxes: [{
               ticks: {
                   beginAtZero: true,
                   callback: function(value) {if (value % 1   === 0) {return value;}}
                }
            }]
       }
      })
	  }
	},
  watch: {
    data: function (val) {
      if (val && val != 'undefined') {
        this.createChart()
      }
    }
  }
}
</script>