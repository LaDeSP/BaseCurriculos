<template>
  <card>
    <template v-slot:card-header>
      <div class="row justify-content-center">
        <div div class="col-md-12">
          <div class="btn-group">
            <router-link to="/dashboard" class="btn btn-outline-secondary btn-md btn-block"><i class="fas fa-home"></i> Home</router-link>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-center">
        <img class="quadrado icon-profile" :src=path>
      </div>
    </template>
    <template v-slot:card-body>
      <div class="row justify-content-center">
        <div class="col-md-12">
          <h4>Objetivos</h4>
            {{displayCurriculo.objetivos}}
          <hr>
          <h4>Área de Atuação</h4>
            {{displayCurriculo.area}}
          <hr>
          <h4>Pretensão Salarial</h4>
            {{displayCurriculo.pretensao}}
          <hr>
          <h4>Formação Acadêmica</h4>
            {{displayCurriculo.escolaridade}}
          <hr>
          <h4>Histórico Profissional</h4>
            {{displayCurriculo.historicoProfissional}}
          <hr>
          <h4>Qualificações</h4>
            {{displayCurriculo.qualificacoes}}
        </div>
      </div>
    </template>
  </card>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import painel from '../Utils/Painel';
    import card from '../Utils/Card';
    export default {
       data() {
            return {
                path:this.$store.state.upload.path,
            }
        },
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
