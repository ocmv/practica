<template>
    <div>
        <h4 class="text-center">Relatório</h4>
        <div :key="key" v-for="(items,key) in lista[0]">
            <div class="table-responsive">
                <table class="table table-sm table-bordered mt-2">
                    <thead>
                        <tr>
                            <th colspan="5" scope="col">{{key}}</th>
                        </tr>
                        <tr>
                            <th scope="col">Período</th>
                            <th scope="col">Receita Líquida (R$)</th>
                            <th scope="col">Cuxto Fixo (R$)</th>
                            <th scope="col">Comissão (R$)</th>
                            <th scope="col">lucro (R$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr :key="key" v-for="(item,key) in items">
                            <template v-if="key != 'saldo'">
                        <td> {{item.fecha}}</td>
                        <td>{{item.receital}}</td>
                        <td>{{item.custo_fixo}}</td>
                        <td>{{item.comissao}}</td>
                        <td>{{item.lucro}}</td>
</template>
                    </tr>
                    <tr class="table-info">
                    <td >SALDO</td>
                    <td>{{items.saldo.receital_total}}</td>
                    <td>{{items.saldo.custo_fixo_total}}</td>
                    <td>{{items.saldo.comissao_total}}</td>
                    <td>{{items.saldo.lucro_total}}</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {},
        props: {
            lista: {
                type: Array
            }
        },
    }
</script>
