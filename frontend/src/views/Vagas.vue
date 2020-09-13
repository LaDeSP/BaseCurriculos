<template>
 <v-row align="center" justify="center">
    <v-col cols="12" lg="12" md="12" sm="12" v-if="isLoaded">
      <span v-if="notificacao">
        <v-alert type="success">
          {{notificacao}}
        </v-alert>
      </span>
      <router-link to="/dashboard">
        <v-btn>
          <v-icon class="pr-1">fas fa-home fa-lg</v-icon> Home
        </v-btn>
      </router-link>
      <v-card align="center">
          <v-card-title class="text-center justify-center py-6">
            <h1>Minhas Vagas</h1> 
          </v-card-title>
          <v-tabs 
            v-model="tab"
            centered 
            grow
            color="black"
            show-arrows
          >
          <v-tabs-slider></v-tabs-slider>
          <v-tab href="#tab-1" class="green lighten-1" @click="changeButton('ATIVAS')">
            Vagas Ativas
          </v-tab>
          <v-tab href="#tab-2" class="grey lighten-1" @click="changeButton('INATIVAS')">
            Vagas Inativas
          </v-tab>
          <v-tabs-items v-model="tab">
            <v-tab-item
              v-for="i in 2"
              :key="i"
              :value="'tab-' + i"
            >
            <v-card flat align="center">
              <v-card-text>
                <router-link to="/vagas/create">
                  <v-btn class="ml-3" outlined color="primary darken-1">
                    Criar Nova Vaga 
                    <v-icon class="pl-1">fa fa-plus</v-icon>
                  </v-btn>
                </router-link>
                <v-row align="center" justify="center">
                  <template v-if="getVagas.length == 0">
                      <span style="font-size: 20px" class="my-10">Não há nenhuma vaga com esse status.</span>
                  </template>
                  <template v-else>
                    <v-col class="d-flex flex-column" cols="12" lg="6" md="6" sm="10" v-for="vaga in pageOfItems" :key="vaga.id">
                      <v-card class="py-5 flex d-flex flex-column" align="center">
                        <v-card-title class="primary--text text-center justify-center">
                          <h3>{{vaga.titulo}}</h3>
                        </v-card-title>
                        <v-card-text align="left" class="black--text">
                          <strong>Descrição:</strong> {{vaga.descricao}} <br/>
                          <strong>Cargo:</strong> {{vaga.cargo}} <br/>
                          <strong>Quantidade:</strong> {{vaga.quantidade}} <br/>
                          <strong>Área de Atuação:</strong> {{vaga.area.tipo}} <br/>
                          <strong>Salário:</strong> {{vaga.salario}} <br/>
                          <strong>Jornada de Trabalho:</strong> {{vaga.jornada}} <br/>
                          <strong>Benefícios:</strong> {{vaga.beneficio}} <br/>
                          <strong>Requisitos:</strong> {{vaga.requisito}} <br/>
                        </v-card-text>
                        <v-card-actions class="text-center justify-center">
                          <router-link :to="`/vagas/edit/${vaga.id}`">
                            <v-btn class="mr-2" outlined color="yellow darken-3">
                              Editar
                            </v-btn>
                          </router-link>
                          <v-btn class="mr-1" outlined :color="getButtonColor(vaga.status)" @click="updateStatus(vaga.id, vaga.status)">
                            {{statusButton}}
                          </v-btn>
                          <ModalAlert :payload="deletarVaga" :vagaId="vaga.id">
                            <slot>
                              <h1 class="text-center">Tem certeza de que deseja <span style="color: #ff0000"><strong>deletar</strong></span> essa vaga?</h1>
                            </slot>
                          </ModalAlert>
                        </v-card-actions>
                      </v-card>
                    </v-col>
                  </template>
                </v-row>
              </v-card-text>
            </v-card>
            <v-row align="center" justify="center">
              <v-col>
                <template v-if="getVagas.length > 4">
                  <jw-pagination 
                    :items="getVagas"
                    @changePage="onChangePage"
                    :pageSize="4"
                    :labels="customLabels"
                  ></jw-pagination>
                </template>
                <template v-else>
                  <span style="display: none" >
                    <jw-pagination 
                      :items="getVagas" 
                      @changePage="onChangePage"
                      :pageSize="4" 
                      :labels="customLabels"
                    ></jw-pagination>
                  </span>
                </template>
              </v-col>
            </v-row>
            </v-tab-item>
          </v-tabs-items>
          </v-tabs>
        </v-card>
    </v-col>
 </v-row>
</template>

<script>
import FormCreateVaga from '@/components/Forms/FormCreateVaga'
import ModalAlert from '@/components/Utils/ModalAlert'
import {actionTypes} from '@/core/constants'
import {mapState, mapGetters} from 'vuex'

const customLabels = {
  next: '>',
  previous: '<'
}

export default {
  components: {FormCreateVaga, ModalAlert},
  data(){ 
    return{
      tab: null, 
      notificacao: '',
      status: 'ATIVAS',
      isLoaded: false,
      edicao: false,
      pageOfItems: [],
      vagasJuridica: [],
      customLabels,
      deletarVaga: {
        title: 'Deletar Vaga',
        action: 'deletar vaga'
      }
    }
  },
  async created(){
    this.setNotificacoes()
    await this.$store.dispatch(actionTypes.GET_VAGAS_JURIDICAS)
    this.vagasJuridica = this.getVagasAtivas
    this.isLoaded = true
  },
  computed: {
    ...mapState(['vagas']),
    ...mapGetters(['getVagasAtivas', 'getVagasInativas']),
    getVagas(){
      console.log('shitorjtor', this.status)
      if(this.status == 'ATIVAS') return this.getVagasAtivas 
      else if(this.status == 'INATIVAS') return this.getVagasInativas
    }
  },
  methods: {
    onChangePage(pageOfItems) {
      this.pageOfItems = pageOfItems;
    },
    setNotificacoes(){
      if(this.$route.params.cadastroVagaSucesso){
        this.notificacao = 'Vaga cadastrada com sucesso!'
      }else if(this.$route.params.updateVagaSucesso){
        this.notificacao = 'Vaga atualizada com sucesso!'
      }
    },
    async updateStatus(id, status) {
      status == 'ATIVA' ? status = 'INATIVA' : status = 'ATIVA'
      let newStatus = {
        vaga_id: id,
        status: status
      };
      await this.$store.dispatch(actionTypes.UPDATE_VAGA_STATUS, newStatus)
        .then(response => {
          this.notificacao =  response.notificacao
      })
    },
    changeButton(value){
      value == 'ATIVAS' ? this.status = 'ATIVAS' : this.status = 'INATIVAS'
    },
    getButtonColor(status){
      if(status == 'ATIVA'){
        this.statusButton = 'Desativar'
        return 'default darken-3'
      }else{
        this.statusButton = 'Ativar'
        return 'success'
      }
    }
  }
}
</script>

<style lang="stylus" scoped>
  .dados 
    font-size 15px
</style>