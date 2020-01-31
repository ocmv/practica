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
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Participacao na Receita'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                            }
                        }
                    },
                    series: [{
                        name: 'Receita',
                        colorByPoint: true,
                        data: []
                    }]
                }
            }
        },
        props: {
            dpizza: {
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
                let data = this.dpizza[0].receita;
                for (let prop in data) {
                    var por;
                    let items = data[prop];
                    for (let key in items) {
                        por = items[key].porcentaje;
                    }
                    this.chartOptions.series[0].data.push({
                        name: prop,
                        y: por
                    });
                }
            }
        },
        watch: {
            dpizza: function() {
                this.chartOptions.series[0].data = [];
                this.fetchData();
            }
        },
    }
</script>
