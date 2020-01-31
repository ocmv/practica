<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                         <b-alert show>Default Alert</b-alert>
                         <highcharts :options="chartOptions"></highcharts>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {Chart} from 'highcharts-vue'
import Highcharts from 'highcharts'
import exportingInit from 'highcharts/modules/exporting'
exportingInit(Highcharts)

    export default {
         components: {
    highcharts: Chart 
  },data() {
    return {
      chartOptions: {
        series: [{
          data: [1,2,3] // sample data
        }]
      }
    }
  },
        mounted() {
            console.log('Component .')
        }
    }
</script>
