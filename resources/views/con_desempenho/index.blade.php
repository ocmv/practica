@extends('layout.layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <desempenho-component inline-template>
                <div class="card">
                    <div class="card-body">
                        <div v-cloak v-if="e500" class="alert alert-danger" role="alert">
                          Error en realizar la consulta.
                          </div>
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <b>Período</b>
                            </div>
                            <div class="form-row col-12 col-md-9">
                                <div class="form-group col-12 col-md-6">
                                    <label>Desde</label>
                                    <div class="col-12 col-md-10 d-flex pl-0">
                                        <select v-model="fmonth" class="form-control mr-1" id="month1">
                                            <option value="01">Jan</option>
                                            <option value="02">Fev </option>
                                            <option value="03">Mar </option>
                                            <option value="04">Abr </option>
                                            <option value="05">Mai </option>
                                            <option value="06">Jun</option>
                                            <option value="07">Jul</option>
                                            <option value="08">Ago</option>
                                            <option value="09">Set</option>
                                            <option value="10">Out</option>
                                            <option value="11">Nov</option>
                                            <option value="12">Dez</option>
                                        </select>
                                        <select v-model="fyear" class="form-control m-l" id="year1">
                                            <option value="2003">2003</option>
                                            <option value="2004">2004</option>
                                            <option value="2005">2005</option>
                                            <option value="2006">2006</option>
                                            <option value="2007">2007</option>
                                        </select>
                                    </div>
                                    <div v-cloak v-if="errors.fecha" class="text-danger">
                                        @{{errors.fecha}}
                                    </div>
                                </div>
                                <div class="form-group col-12 col-md-6">
                                    <label>Hasta</label>
                                    <div class="col-12 col-md-10 d-flex pl-0">
                                        <select v-model="tmonth" class="form-control mr-l1" id="month2">
                                            <option value="01">Jan</option>
                                            <option value="02">Fev </option>
                                            <option value="03">Mar </option>
                                            <option value="04">Abr </option>
                                            <option value="05">Mai </option>
                                            <option value="06">Jun</option>
                                            <option value="07">Jul</option>
                                            <option value="08">Ago</option>
                                            <option value="09">Set</option>
                                            <option value="10">Out</option>
                                            <option value="11">Nov</option>
                                            <option value="12">Dez</option>
                                        </select>
                                        <select v-model="tyear" class="form-control ml-1" id="year2">
                                            <option value="2003">2003</option>
                                            <option value="2004">2004</option>
                                            <option value="2005">2005</option>
                                            <option value="2006">2006</option>
                                            <option value="2007">2007</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <b>Consultores</b>
                            </div>
                            <div class=" col-12 col-md-9">
                                <div class="row m-auto">
                                    <div class="col-12 col-md-5 pl-0">
                                        <select v-model="lista" multiple class="form-control" id="consutores">
                                            @foreach($consultores as $consultor)
                                            <option v-bind:value='{!!json_encode(['id'=>$consultor->co_usuario,'text'=>$consultor->no_usuario])!!}'>{{$consultor->no_usuario}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="cButton" class="col-12 col-md-1 mt-auto mb-auto">

                                        <button title="Agregar" v-on:click="agregaConsultor()"
                                            class="btn btn-sm btn-secondary mb-1"><i
                                                class="fas fa-angle-right"></i></button>
                                        <br>
                                        <button title="Eliminar" v-on:click="eliminarConsultor()"
                                            class="btn btn-sm btn-secondary mt-1"><i
                                                class="fas fa-angle-left"></i></button>
                                        <br>

                                    </div>
                                    <div class="col-12 col-md-5 pl-0">
                                        <select v-model="selected" multiple class="form-control" id="agregados">
                                            <option v-cloak v-for="item in agregados" :value="item.id">@{{item.text}}
                                            </option>
                                        </select>
                                    </div>
                                    <div v-cloak v-if="errors.data" class="text-danger">
                                        @{{errors.data[0]}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-md-2">
                                <b>Obtener</b>
                            </div>
                            <div class="col-12 col-md-8 m-auto">
                                <div class="row m-auto text-center">
                                    <div class="col-4">
                                        <button v-on:click="relatorio()" title="Relatório" class="btn btn-info w-100"><i
                                                class="fas fa-table"></i> <span
                                                class="text-button">Relatório</span></button>
                                    </div>
                                    <div v-on:click="columns()" class="col-4">
                                        <button title="Gráfico" class="btn btn-info w-100"> <i
                                                class="fas fa-chart-bar"></i> <span class="text-button">
                                                Gráfico</span></button>
                                    </div>
                                    <div class="col-4">
                                        <button v-on:click="pizza()" title="Pizza" class="btn btn-info w-100"><i
                                                class="fas fa-chart-pie "></i> <span class="text-button">
                                                Pizza</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="bpizza">
                            <pizza-component class="mt-3" :dpizza="[dPizza]"></pizza-component>
                        </div>
                        <div v-if="bcolumn">
                            <columnas-component class="mt-3" :rdata="[dataColumn]"></columnas-component>
                        </div>
                        <div v-if="brelatorio">
                            <relatorio-component class="mt-3" :lista="[listRelatorio]"></relatorio-component>
                        </div>
            </desempenho-component>
        </div>
    </div>
</div>

@endsection
@push('styles')
<style>
    @media (max-width:767px) {
        #cButton {
            margin-top: 5px !important;
            margin-bottom: 5px !important;
            text-align: center;
        }

        .text-button{
            display:none !important;
        }
    }
    @media (min-Width:768px) and (max-width:990px) {
        #cButton {
            padding: 0 !important;
        }

    }

    [v-cloak] {
        display: none !important;
    }
</style>
@endpush
