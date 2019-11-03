<template>
  <div class="input-group col-md-11" v-if="permissaoDoUsuario === 'JURIDICA'">
    <input class="form-control py-2" type="search" placeholder="Digite aqui.." v-model="keywords">
    <span class="input-group-append">
      <button class="btn btn-outline-secondary" type="button" @click="redirectSimpleCurriculo">
          <i class="fa fa-search"></i>
      </button>
      <button class="btn primary" type="button" @click="showModalPesquisaAvancada">
          Busca Avançada
      </button>
    </span>

    <Modal v-show="isModalPesquisaAvancada" @close="closeModalPesquisaAvancada">
      <template v-slot:header><h3>Busca Avançada</h3></template>
      <template v-slot:body>
        <div class="form-group">
          <label for="keywords">Qualificações</label>
          <input type="text" name="keywords" class="form-control" v-model="keywords" maxlength="50">  
        </div>
        <div class="form-group">
          <label for="escolaridade">Escolaridade</label>
          <input type="text" name="escolaridade" class="form-control" v-model="escolaridade" maxlength="50">  
        </div>
        <div class="form-group">
          <label for="beneficio">Objetivos</label>
          <input type="text" name="objetivos" class="form-control" v-model="objetivos" maxlength="50">  
        </div>
        <div class="form-group">
          <label for="historicoProfissional">Histórico Profissional</label>
          <input type="text" name="historicoProfissional" class="form-control" v-model="historicoProfissional" maxlength="50">  
        </div>
        <div class="form-group">
          <label for="cidade">Cidade</label>
          <input type="text" name="cidade" class="form-control" v-model="cidade" maxlength="50">  
        </div>
        <div class="form-group">
          <label for="nome">Nome</label>
          <input type="text" name="nome" class="form-control" v-model="nome" maxlength="50">  
        </div>
        <button class="btn btn-primary" type="button" @click="redirectAdvancedCurriculo">
          Busca Avançada
        </button>
        

      </template>
    </Modal>

  </div>
  <div class="input-group col-md-11" v-else>
    <input class="form-control py-2" type="search" placeholder="Digite aqui.." v-model="keywords">
    <span class="input-group-append">
      <button class="btn btn-outline-secondary" type="button" @click="redirectSimple" v-on:keyup.enter="redirectSimple">
          <i class="fa fa-search"></i>
      </button>
       <button class="btn primary" type="button" @click="showModalPesquisaAvancada">
          Busca Avançada
      </button>
    </span>

    <Modal v-show="isModalPesquisaAvancada" @close="closeModalPesquisaAvancada">
      <template v-slot:header><h3>Busca Avançada</h3></template>
      <template v-slot:body>
        <div class="form-group">
          <label for="keywords">Titulo</label>
          <input type="text" name="keywords" class="form-control" v-model="keywords" maxlength="50">  
        </div>
        <div class="form-group">
          <label for="cargo">Cargo</label>
          <input type="text" name="cargo" class="form-control" v-model="cargo" maxlength="50">  
        </div>
        <div class="form-group">
          <label for="beneficio">Beneficio</label>
          <input type="text" name="beneficio" class="form-control" v-model="beneficio" maxlength="50">  
        </div>
        <div class="form-group">
          <label for="jornada">Jornada</label>
          <input type="text" name="jornada" class="form-control" v-model="jornada" maxlength="50">  
        </div>
        <div class="form-group">
          <label for="requisitos">Requisitos</label>
          <input type="text" name="requisitos" class="form-control" v-model="requisitos" maxlength="50">  
        </div>
        <button class="btn btn-primary" type="button" @click="redirectAdvanced">
          Busca Avançada
        </button>
        

      </template>
    </Modal>
  </div>
</template>

<script>
  import Modal from '../Utils/Modal.vue';
  import {mapGetters} from 'vuex';



  export default {
    name: 'BarraBusca',
    components:{
      Modal,
    },
    data(){
      return{
        keywords: '',
        isModalPesquisaAvancada: false,
        cargo: '',
        beneficio: '',
        jornada: '',
        requisitos: '',
        escolaridade: '',
        objetivos: '',
        historicoProfissional: '',
        cidade: '',
        nome: '',

      }
    },
    methods: {
      redirectSimple(){
        if (this.$router.currentRoute.name == "buscas"){
          console.log('if simple');
          //this.$parent.$parent.$children[1].resultado = [];
      
          this.$store.dispatch('searchVagas', this.keywords)
          .then(response => {
              console.log(response);
              //this.$parent.$parent.$children[1].resultado = response;
          })
          .catch(error => console.log(error))
        }
        else {
          console.log('else simple');
          this.$router.push({ name: 'buscas', query: { keywords: this.keywords} })
        }
      },
      redirectAdvanced(){
        if (this.$router.currentRoute.name == "buscas"){
          console.log('if advanced');
          
          let pesquisa = {
            keywords : this.keywords,
            cargo : this.cargo, 
            beneficio : this.beneficio, 
            jornada : this.jornada,
            requisitos : this.requisitos
          }

            this.$store.dispatch('searchVagasAvancadas', pesquisa)
            .then(response => {
                console.log('state', this.$store.state.resultado);
                this.isModalPesquisaAvancada = false;

            })
            .catch(error => console.log(error))
        }
        else{
          console.log('else advanced');
          this.$router.push({ name: 'buscas', query: { keywords: this.keywords, cargo: this.cargo, beneficio: this.beneficio, jornada: this.jornada, requisitos: this.requisitos} })
          this.isModalPesquisaAvancada = false;
        }
      },
      showModalPesquisaAvancada(){
        this.isModalPesquisaAvancada = true;
      },
      closeModalPesquisaAvancada(){
        this.isModalPesquisaAvancada = false;
      },
      redirectSimpleCurriculo(){
        if (this.$router.currentRoute.name == "buscas"){
          console.log('if simple curriculo');
          //this.$parent.$parent.$children[1].resultado = [];
      
          this.$store.dispatch('searchCurriculos', this.keywords)
          .then(response => {
              console.log(response);
              //this.$parent.$parent.$children[1].resultado = response;
          })
          .catch(error => console.log(error))
        }
        else {
          console.log('else simple');
          this.$router.push({ name: 'buscas', query: { keywords: this.keywords} })
        }
      },
      redirectAdvancedCurriculo(){
        if (this.$router.currentRoute.name == "buscas"){
          console.log('if advanced');
          
          let pesquisa = {
            keywords : this.keywords,
            escolaridade : this.escolaridade, 
            objetivos : this.objetivos, 
            historicoProfissional : this.historicoProfissional,
            cidade : this.cidade,
            nome: this.nome
          }

            this.$store.dispatch('searchCurriculosAvancadas', pesquisa)
            .then(response => {
                console.log('state', this.$store.state.resultado);
                this.isModalPesquisaAvancada = false;

            })
            .catch(error => console.log(error))
        }
        else{
          console.log('else advanced');
          this.$router.push({ name: 'buscas', query: { keywords: this.keywords, escolaridade: this.escolaridade, objetivos: this.objetivos, historicoProfissional: this.historicoProfissional, cidade: this.cidade, nome: this.nome} })
          this.isModalPesquisaAvancada = false;
        }
      },

    },
    computed: {
      ...mapGetters([
        'permissaoDoUsuario'
      ]),
    },

  }

</script>
