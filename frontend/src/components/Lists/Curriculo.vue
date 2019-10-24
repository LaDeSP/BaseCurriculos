<template>
<painel class="panel panel-default">
  <template v-slot:panel-head>
    <div class="panel-heading"><h2>Currículo</h2></div>
  </template>
  <template v-slot:panel-body>
      <h4>Redes Sociais</h4>
      <hr>
      <ul>
          <li v-if="typeof displayCurriculo.facebook !== 'undefined' || null">Facebook: {{displayCurriculo.facebook}}</li>
          <li v-if="typeof displayCurriculo.twitter !== 'undefined' || null">Twitter: {{displayCurriculo.twitter}}</li>
          <li v-if="typeof displayCurriculo.linkedin !== 'undefined' || null">Linkedin: {{displayCurriculo.linkedin}}</li>
          <li v-if="typeof displayCurriculo.site !== 'undefined' || null">Site: {{displayCurriculo.site}}</li>
      </ul>
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
</painel>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import painel from '../Utils/Painel';
    export default {
        components:{
          painel
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
