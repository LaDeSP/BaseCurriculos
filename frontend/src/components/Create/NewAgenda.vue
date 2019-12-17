<template>
<span v-if="isFetching && editing">
  <div class="container"></div>
  <div class="container">
    <center><h1>
        Carregando...  <span class="fas fa-spinner fa-pulse"></span>
    </h1></center>
  </div>
</span>
<span v-else>
  <div class="row justify-content-center">
    <div class="col-6">
        <ValidationObserver v-slot="{ invalid }">
          <form >
              <div v-if="notificacoes">
                  <span v-for="notificacao in notificacoes" :key="notificacao[0]" class="badge badge-danger badge-pill">
                      {{notificacao[0]}}
                  </span>
              </div>
              <card class="form-row justify-content-center">
                <template v-slot:card-header >
                  <div cclass="d-flex justify-content-center">
                    <center><h1 v-if="!editing">Agendar Entrevista</h1>
                    <h1 v-else>Reagendar Entrevista</h1></center>
                  </div>
                </template>
                <template v-slot:card-body>
                  <div class="col-12">
                    <div class="form-group">
                        <label for="data">Dia <a class="color-red">*</a></label>
                        <ValidationProvider name="data" rules="required">
                            <div class="color-red" slot-scope="{ errors }">
                                <input type="date" class="form-control" name="data" v-model="data">
                                <p>{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="form-group">
                        <label for="hora">Hora <a class="color-red">*</a></label>
                        <ValidationProvider name="hora" rules="required">
                            <div class="color-red" slot-scope="{ errors }">
                                <input type="time" name="hora"
                                class="form-control" v-model="hora">
                                <p>{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="form-group">
                        <label for="observacao">Observação:</label>
                        <ValidationProvider name="observacao" rules="max:5000">
                            <div slot-scope="{ errors }">
                                <textarea class="md-textarea form-control" rows="5" name="observacao" v-model="observacao" maxlength="5000"></textarea>
                                <small>Use esse campo para falar dados de contato e de localização, bem como qualquer outra informação importante.</small>
                                <p>{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>

                  </div>
                  </template>
                  <template v-slot:card-footer class="justify-content-center">
                    <div v-if="editing === false">
                      <div class="row">
                        <div class="col-md-10 float-left" >
                          <router-link class="btn btn-outline-secondary" to="/candidaturas">Voltar</router-link>
                        </div>
                        <div class="col-md-2 float-right" >
                          <button :disabled="invalid" @click.prevent="register" type="submit" class="btn btn-primary">Agendar</button>
                        </div>
                      </div>
                    </div>
                    <div v-else>
                      <div class="row">
                        <div class="col-md-10 float-left" >
                          <span v-if="permissaoDoUsuario == 'FISICA'">
                              <router-link class="btn btn-outline-secondary" to="/candidaturas">Voltar</router-link>
                          </span>
                          <span v-else>
                              <router-link class="btn btn-outline-secondary" to="/agenda">Voltar</router-link>
                          </span>
                        </div>
                        <div class="col-md-2 float-right" >
                          <button :disabled="invalid" @click.prevent="register" type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                      </div>
                    </div>
                </template>
              </card>
          </form>
      </ValidationObserver>
    </div>
  </div>
  </span>
</template>

<script>
  import card from '../Utils/Card';
  import {mapState, mapActions, mapGetters} from 'vuex';

  export default{
    components:{
      card
    },
    data(){
      return{
        data: '',
        hora: '',
        observacao: '',
        contraproposta: '',
        candidatura_id: 0,
        editing: false,
        notificacoes: [],
      }
    },
    methods: {

      ...mapActions(['loadAgenda']),

      register(){

        if(this.editing){
          if(this.permissaoDoUsuario === 'FISICA'){
            this.contraproposta = 'FISICA';
          }else{
            this.contraproposta = 'JURIDICA';
          }
        }

        let newAgendaData = {
          data: this.data,
          hora: this.hora,
          observacao: this.observacao,
          contraproposta: this.contraproposta,
          candidatura_id: this.$session.get('candidato_id'),
          update_id: this.$route.params.id
        }

        if(!this.editing){
          this.$store.dispatch('newAgenda', newAgendaData)
          .then( response => {
            if(response.error  != undefined){
              this.notificacoes = response.error;
            }
            else{
              this.$router.push({ name: 'agenda',  params:{agendou: true} });
            }

          })
          .catch(error => console.log(error))
        }else{
          this.$store.dispatch('updateAgenda', newAgendaData)
          .then( response => {
            if(response.error  != undefined){
              this.notificacoes = response.error;
            }
            else{
              if(this.permissaoDoUsuario == 'FISICA'){
                this.$router.push({ name: 'candidaturas', params:{editouEntrevista: true} })
              }else{
                this.$router.push({ name: 'agenda', params:{agendou: true} })
              }
            }
          })
          .catch(error => console.log(error))
        }
      },

      displayDataEdit(){
        this.data = this.agendaById[0].data;
        this.hora = this.agendaById[0].hora;
      },

    },

    computed:{
      ...mapState([
        'agenda', 'isFetching'
      ]),
      ...mapGetters([
        'displayAgendaById', 'permissaoDoUsuario'
      ]),
      agendaById() {
          return this.displayAgendaById(this.$route.params.id)
      },
    },

    async created(){
      if(this.$route.params.id){
              this.editing = true;
              await this.loadAgenda();
              this.displayDataEdit();
            }

    },

    /*async beforeRouteEnter(to, from, next) {
        next(vm => {
            if(this.$route.params.id){
              vm.editing = true;
              vm.loadAgenda();
              vm.displayDataEdit();
            }
        });
    } */

  }
</script>
