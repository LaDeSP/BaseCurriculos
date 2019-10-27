<template>
  <card>
    <template v-slot:card-header>
      <div class="row justify-content-center">
        <div div class="col-12">
          <div class="btn-group">
            <router-link to="/DashFIS" class="btn btn-primary btn-lg btn-block"><i class="fas fa-arrow-left"></i>Voltar</router-link>
          </div>
        </div>
      </div>
      <center><h2>Currículo</h2></center>
    </template>
    <template v-slot:card-body>
        <hr>
        <h4>Objetivos</h4>
        <p>{{displayCurriculo.objetivos}}</p>
        <hr>
        <h4>Área de Atuação</h4>
        <p>{{displayCurriculo.area}}</p>
        <hr>
        <h4>Pretensão Salarial</h4>
        <p>{{displayCurriculo.pretensao}}</p>
        <hr>
        <h4>Formação Acadêmica</h4>
        <p>{{displayCurriculo.escolaridade}}</p>
        <hr>
        <h4>Histórico Profissional</h4>
        <p>{{displayCurriculo.historicoProfissional}}</p>
        <hr>
        <h4>Qualificações</h4>
        <p>{{displayCurriculo.qualificacoes}}</p>
        <hr>
      </template>
  </card>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import painel from '../Utils/Painel';
    import card from '../Utils/Card';
    export default {
        components:{
          painel,card
        },
        methods: {
            ...mapActions([
                'loadOnlyCurriculo'
            ]),
        },
        computed: {
            ...mapGetters([
                'displayCurriculo'
            ]),
        },

    }

</script>
