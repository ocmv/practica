<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <highcharts :options="chartOptions"></highcharts>
        </div>
    </div>
</div>
</template>

<script>
import {
    Chart
} from 'highcharts-vue'
import Highcharts from 'highcharts'
import exportingInit from 'highcharts/modules/exporting'
exportingInit(Highcharts)
export default {
    components: {
        highcharts: Chart
    },
    data() {
        return {
            chartOptions: {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Performance'
                },
                tooltip: {
                    formatter: function () {
                        return 'R$ ' + Highcharts.numberFormat(this.y, 2, ',', '.');
                    }
                },
                xAxis: {
                    categories: []
                },
                yAxis: {
                    plotLines: [{
                        color: 'red',
                        dashStyle: 'longdashdot',
                        value: '',
                        width: 2,
                        label: {
                            text: '', // Content of the label.
                            align: 'right',
                        }
                    }],
                    title: {
                        text: 'Receita'
                    },
                    labels: {
                        formatter: function () {
                            return 'R$ ' + Highcharts.numberFormat(this.value, 2, ',', '.');
                        }
                    },
                },
                series: []
            }
        }
    },
    props: {
        rdata: {
            type: Array
        },
       
    },
    mounted() {
        this.fetchData();
    },
    /**
     * Mostar datos en gráfica
     */
    methods: {
        fetchData() {
            this.chartOptions.xAxis.categories = this.rdata[0].ejeX;
            this.chartOptions.yAxis.plotLines[0].value = this.rdata[0].prom;
            const text = 'R$ ' + new Intl.NumberFormat("de-DE", {
                maximumFractionDigits: 2
            }).format(this.rdata[0].prom);
            this.chartOptions.yAxis.plotLines[0].label.text = text;
            let data = this.rdata[0].columna;
            for (let prop in data) {
                var receita = [];
                let items = data[prop];
                for (let key in items) {
                    receita[key] = items[key].receita;
                }
                //console.log(receita)
                this.chartOptions.series.push({
                    name: prop,
                    data: receita
                });
            }
        }
    },
    watch: {
        rdata: function () {
            this.chartOptions.series = [];
            this.fetchData();
        }
    },
}
</script>
