<script>
import Relatorio from './tablas/relatorioComponent.vue';
import Column from './graficas/columnasComponent.vue';
import Pizza from './graficas/pizzaComponent.vue';
export default {
    components: {
        Relatorio,
        Column,
        Pizza
    },
    mounted() {

    },
    data() {
        return {
            lista: [],
            agregados: [],
            value: '',
            selected: [],
            brelatorio: false,
            listRelatorio: [],
            bcolumn: false,
            dataColumn: [],
            bpizza: false,
            dPizza: [],
            fmonth: '09',
            fyear: '2007',
            tmonth: '09',
            tyear: '2007',
            errors: [],
            e500:''

        }
    },
    methods: {
        agregaConsultor() {
            var lista = this.lista;
            for (var prop in lista) {
                const found = this.agregados.some(el => el.id === lista[prop].id);
                if (!found) {
                    this.agregados.push({
                        'id': lista[prop].id,
                        'text': lista[prop].text
                    });
                }
            }
            this.lista = [];
        },
        eliminarConsultor() {
            var selected = this.selected;
            for (var prop in selected) {
                const index = this.agregados.findIndex(el => el.id === selected[prop]);
                this.agregados.splice(index, 1);
            }
        },
        /**
         * Mostrar Tabla
         */
        relatorio() {
            this.errors = [];
            this.bpizza = false;
            this.bcolumn = false;

            axios.post('/relatorio', {
                data: this.agregados,
                fecha: this.datestf
            }).then((response) => {

                this.brelatorio = true;
                this.listRelatorio = response.data.relatorio;
            }).catch((errors) => {

                if (errors.response.status == 422) {
                    this.errors = errors.response.data.errors;
                }
                this.e500=errors.response.msg;
            });
        },
        /**
         * Mostrar Grafico de columnas
         */
        columns() {
            this.errors = [];
            this.brelatorio = false
            this.bpizza = false;
            this.dataColumn = [];
            axios.post('/columnas', {
                data: this.agregados,
                fecha: this.datestf
            }).then((response) => {
                this.dataColumn = response.data;
                this.bcolumn = true;
            }).catch((errors) => {
                if (errors.response.status == 422) {
                    this.errors = errors.response.data.errors;
                }
                this.e500=errors.response.msg;
            });
        },
        pizza() {
            this.errors = [];
            this.brelatorio = false
            this.bcolumn = false;
            this.dPizza = [];
            axios.post('/pizza', {
                data: this.agregados,
                fecha: this.datestf
            }).then((response) => {
                this.dPizza = response.data;
                this.bpizza = true;
            }).catch((errors) => {
                if (errors.response.status == 422) {
                    this.errors = errors.response.data.errors;
                }
                this.e500=errors.response.msg;
            });
        }
    },
    computed: {
        datestf: function () {

            return [this.fyear + '-' + this.fmonth,
                this.tyear + '-' + this.tmonth
            ];
        }
    },
}
</script>
