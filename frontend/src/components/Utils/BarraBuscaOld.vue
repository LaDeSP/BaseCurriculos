<template>
  <div class="input-group col-md-11" v-if="permissaoDoUsuario === 'JURIDICA'">
    <input class="form-control py-2" type="search" placeholder="Busque aqui por qualificações necessárias" v-model="keywords">
    <span class="input-group-append">
      <button class="btn btn-outline-secondary" type="button" @click="redirectSimpleCurriculo" :disabled="keywords.length<1">
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
          <label for="area">Área de Atuação</label>
          <select class="custom-select" name="area" v-model="area">
              <option value="">Selecione uma área</option>
              <option v-for="area in areas" :key="area.id" :value="area.id">
                  {{area.tipo}}
              </option>
          </select>           
        </div>
        <div class="form-group">
          <label for="escolaridade">Nível de Escolaridade</label>
          <select class="custom-select" name="escolaridade" v-model="escolaridade">
              <option value="" selected>Selecione seu nível</option>
              <option value="Ensino Fundamental(Incompleto)">Ensino Fundamental(Incompleto)</option>
              <option value="Ensino Fundamental(Cursando)">Ensino Fundamental(Cursando)</option>
              <option value="Ensino Fundamental(Completo)">Ensino Fundamental(Completo)</option>
              <option value="Ensino Médio(Incompleto)">Ensino Médio(Incompleto)</option>
              <option value="Ensino Médio(Cursando)">Ensino Médio(Cursando)</option>
              <option value="Ensino Médio(Completo)">Ensino Médio(Completo)</option>
              <option value="Ensino Superior(Incompleto)">Ensino Superior(Incompleto)</option>
              <option value="Ensino Superior(Cursando)">Ensino Superior(Cursando)</option>
              <option value="Ensino Superior(Completo)">Ensino Superior(Completo)</option>
              <option value="Pós-Graduação(Especialização)">Pós-Graduação(Especialização)</option>
              <option value="Pós-Graduação(Mestrado)">Pós-Graduação(Mestrado)</option>
              <option value="Pós-Graduação(Doutorado)">Pós-Graduação(Doutorado)</option>
          </select>
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
        <p class="color-red" v-if="aviso">{{aviso}}</p>
        <button class="btn btn-primary" type="button" @click="redirectAdvancedCurriculo"
        :disabled="keywords.length<1 && escolaridade.length<1 && objetivos.length<1 && historicoProfissional.length<1 && cidade.length<1 && nome.length<1 && area.length<1">
          Busca Avançada
        </button>
        

      </template>
    </Modal>

  </div>
  <div class="input-group col-md-11" v-else>
    <input class="form-control py-2" type="search" placeholder="Busque aqui pelo título ou descrição da vaga que você quer" v-model="keywords">
    <span class="input-group-append">
      <button class="btn btn-outline-secondary" type="button" @click="redirectSimple" v-on:keyup.enter="redirectSimple" :disabled="keywords.length<1">
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
          <label for="area">Área de Atuação</label>
          <select class="custom-select" name="area" v-model="area">
              <option value="">Selecione uma área</option>
              <option v-for="area in areas" :key="area.id" :value="area.id">
                  {{area.tipo}}
              </option>
          </select>           
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
        <p class="color-red" v-if="aviso">{{aviso}}</p>
        <button class="btn btn-primary" type="button" @click="redirectAdvanced"
        :disabled="keywords.length<1 && cargo.length<1 && beneficio.length<1 && jornada.length<1 && requisitos.length<1 && area.length<1">
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
        areas: [],
        area: '',
        aviso: '',
      }
    },
    methods: {
      redirectSimple(){
        if (this.keywords=='' || this.keywords==undefined){
          return;
        }

        if (this.$router.currentRoute.name == "buscas"){
          //this.$parent.$parent.$children[1].resultado = [];
      
          this.$store.dispatch('searchVagas', this.keywords)
          .then(response => {
              //this.$parent.$parent.$children[1].resultado = response;
          })
          .catch(error => console.log(error))
        }
        else {
          this.$router.push({ name: 'buscas', query: { keywords: this.keywords} })
        }
      },
      redirectAdvanced(){
         if ((this.keywords=='' || this.keywords==undefined)==true && (this.cargo=='' || this.cargo==undefined)
            && (this.beneficio=='' || this.beneficio==undefined) && (this.jornada=='' || this.jornada==undefined)
            && (this.requisitos=='' || this.requisitos==undefined) && (this.area=='' || this.area==undefined)){
              this.aviso="Preencha pelo menos um campo para realizar a busca.";
          return;
        }

        if (this.$router.currentRoute.name == "buscas"){
          let pesquisa = {
            keywords : this.keywords,
            cargo : this.cargo, 
            beneficio : this.beneficio, 
            jornada : this.jornada,
            requisitos : this.requisitos,
            area: this.area
          }

            this.$store.dispatch('searchVagasAvancadas', pesquisa)
            .then(response => {
                this.isModalPesquisaAvancada = false;
                this.aviso = '';

            })
            .catch(error => console.log(error))
        }
        else{
          this.$router.push({ name: 'buscas', query: { keywords: this.keywords, cargo: this.cargo, beneficio: this.beneficio, jornada: this.jornada, requisitos: this.requisitos, area: this.area} })
          this.isModalPesquisaAvancada = false;
          this.aviso = '';
        }
      },
      showModalPesquisaAvancada(){
        this.isModalPesquisaAvancada = true;
      },
      closeModalPesquisaAvancada(){
        this.isModalPesquisaAvancada = false;
        this.aviso='';
      },
      redirectSimpleCurriculo(){
        if (this.keywords=='' || this.keywords==undefined){
          return;
        }
        
        if (this.$router.currentRoute.name == "buscas"){
          //this.$parent.$parent.$children[1].resultado = [];
      
          this.$store.dispatch('searchCurriculos', this.keywords)
          .then(response => {
              //this.$parent.$parent.$children[1].resultado = response;
          })
          .catch(error => console.log(error))
        }
        else {
          this.$router.push({ name: 'buscas', query: { keywords: this.keywords} })
        }
      },
      redirectAdvancedCurriculo(){
        if ((this.keywords=='' || this.keywords==undefined)==true && (this.escolaridade=='' || this.escolaridade==undefined)
            && (this.objetivos=='' || this.objetivos==undefined) && (this.historicoProfissional=='' || this.historicoProfissional==undefined)
            && (this.cidade=='' || this.cidade==undefined) && (this.nome=='' || this.nome==undefined) && (this.area=='' || this.area==undefined)){
              this.aviso="Preencha pelo menos um campo para realizar a busca.";
          return;
        }

        if (this.$router.currentRoute.name == "buscas"){
          
          let pesquisa = {
            keywords : this.keywords,
            escolaridade : this.escolaridade, 
            objetivos : this.objetivos, 
            historicoProfissional : this.historicoProfissional,
            cidade : this.cidade,
            nome: this.nome,
            area: this.area
          }

            this.$store.dispatch('searchCurriculosAvancadas', pesquisa)
            .then(response => {
                this.isModalPesquisaAvancada = false;
                this.aviso = '';

            })
            .catch(error => console.log(error))
        }
        else{
          this.$router.push({ name: 'buscas', query: { keywords: this.keywords, escolaridade: this.escolaridade, objetivos: this.objetivos, historicoProfissional: this.historicoProfissional, cidade: this.cidade, nome: this.nome, area: this.area} })
          this.isModalPesquisaAvancada = false;
          this.aviso = '';
        }
      },

      loadArea(){
        this.$store.dispatch('loadArea')
        .then(response => {
            this.areas = response.areas;
        }).catch(error => console.log(error))
      },

    },
    computed: {
      ...mapGetters([
        'permissaoDoUsuario'
      ]),
    },

    created() {
      this.loadArea();
    }

  }

</script>
