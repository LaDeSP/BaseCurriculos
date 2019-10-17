<template>
 <div class="row justify-content-center">
    <div class="col-7">
        <ValidationObserver v-slot="{ invalid }">
            <form >
                <div v-if="notificacoes">
                    <span v-for="notificacao in notificacoes" :key="notificacao[0]" class="badge badge-danger badge-pill">
                        {{notificacao[0]}}
                    </span>
                </div>
                <card class="form-row justify-content-center">
                  <template v-slot:card-header >
                    <h1 v-if="!editing">Agendar Entrevista</h1>
                    <h1 v-else>Editar Entrevista</h1>
                  </template>
                  <template v-slot:card-body class="justify-content-center">
                    <div class="col-8">
                      <div class="form-group">
                          <label for="data">* Dia</label>
                          <ValidationProvider name="data" rules="required">
                              <div slot-scope="{ errors }">
                                  <input type="date" class="form-control" name="data" v-model="data">
                                  <p>{{ errors[0] }}</p>
                              </div>
                          </ValidationProvider>
                      </div>
                      <div class="form-group">
                          <label for="hora">* Hora</label>
                          <ValidationProvider name="hora" rules="required">
                              <div slot-scope="{ errors }">
                                  <input type="time" name="hora"
                                  class="form-control" v-model="hora">
                                  <p>{{ errors[0] }}</p>
                              </div>
                          </ValidationProvider>
                      </div>
                      <div class="form-group">
                          <label for="observacao">Observação:</label>
                          <ValidationProvider name="observacao" rules="max:500">
                              <div slot-scope="{ errors }">
                                  <textarea class="md-textarea form-control" rows="5" name="observacao" v-model="observacao" maxlength="500"></textarea>
                                  <p>{{ errors[0] }}</p>
                              </div>
                          </ValidationProvider>
                      </div>
                    </div>
                   </template>
                   <template v-slot:card-footer class="justify-content-center">
                    <div v-if="editing === false">
                        <button :disabled="invalid" @click.prevent="register" type="submit" class="btn btn-primary">Cadastrar</button>
                        <router-link class="btn btn-default" to="/dashboard-fisica">Voltar</router-link>
                    </div>
                    <div v-else>
                        <button :disabled="invalid" @click.prevent="edit" type="submit" class="btn btn-primary">Enviar</button>
                        <router-link class="btn btn-default" to="/dashboard-fisica">Voltar</router-link>
                    </div>
                  </template>
                </card>
            </form>
        </ValidationObserver>
    </div>
</div>
</template>

<script>
  import card from '../Utils/Card';

  export default{
    components:{
      card
    },
    data(){
      return{
        data: '',
        hora: '',
        observacao: '',
        candidatura_id: 0,
        editing: false,
        uri: 'http://localhost:8000/api/agenda',
        token: this.$session.get('jwt'),
        notificacoes: [],
      }
    },
    methods: {
      register(){
        this.axios.post(this.uri + '?token=' + this.token, {
                data: this.data,
                hora: this.hora,
                observacao: this.observacao,
                candidatura_id: this.$route.params.candidaturaId
        },
        {headers: {'X-Requested-With': 'XMLHttpRequest'}})
        .then(response => {
            if(response.data.error  != undefined){
                this.notificacoes = response.data.error;
                return;
            }
            console.log(response);
        })
        .catch(
            (error) => console.log(error)
        );
      },
    }
  }
</script>
