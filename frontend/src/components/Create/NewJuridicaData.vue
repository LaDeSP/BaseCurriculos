<template>

    <form-wizard @on-complete="onComplete"
      title="Cadastro de Currículo" subtitle=" "
      back-button-text="Voltar"
      next-button-text="Próximo"
      finish-button-text="Salvar"
      color="#2E59D9"
    >
    <div v-if="notificacoes">
        <span v-for="notificacao in notificacoes" :key="notificacao[0]" class="badge badge-danger badge-pill">
            {{notificacao[0]}}
        </span>
    </div>
  <tab-content title="Informações da Empresa" icon="fas fa-clipboard-list">
    <UploadPhoto></UploadPhoto>
    <div class="form-group">
        <label for="nome">* Nome da Empresa</label>
        <ValidationProvider name="nome" rules="required|max:50">
            <div slot-scope="{ errors }">
                <input type="text" name="nome" class="form-control" v-model="nome"  maxlength="50">
                <p>{{ errors[0] }}</p>
            </div>
        </ValidationProvider>
    </div>
    <div class="form-group">
      <label for="nome">* Ramo</label>
      <ValidationProvider name="ramo" rules="required|max:50">
          <div slot-scope="{ errors }">
              <input type="text" name="ramo" class="form-control" v-model="ramo"  maxlength="50">
              <p>{{ errors[0] }}</p>
          </div>
      </ValidationProvider>
    </div>
  </tab-content>

  <tab-content title="Contato" icon="fas fa-phone">
      <div class="form-group">
          <label for="telefone">* Telefone</label>
          <div class="form-row">
              <div class="col-6">
                  <ValidationProvider name="fixo" rules="required|numeric|digits:10">
                      <div slot-scope="{ errors }">
                          <input type="text" class="form-control" name="fixo" placeholder="Fixo" v-model="fixo" minlength="10" maxlength="10">
                          <p>{{ errors[0] }}</p>
                      </div>
                  </ValidationProvider>
              </div>
              <div class="col">
                  <ValidationProvider name="celular" rules="required|numeric|digits:11">
                      <div slot-scope="{ errors }">
                          <input type="text" class="form-control" name="celular" placeholder="Celular" v-model="celular" minlength="11" maxlength="11">
                          <p>{{ errors[0] }}</p>
                      </div>
                  </ValidationProvider>
              </div>
          </div>
      </div>
      <div class="form-group">
          <label for="linkedin">Linkedin</label>
          <ValidationProvider name="linkedin" rules="max:50">
              <div slot-scope="{ errors }">
                  <input type="linkedin" id="linkedin" name="linkedin"
                  class="form-control" v-model="linkedin" maxlength="50">
                  <p>{{ errors[0] }}</p>
              </div>
          </ValidationProvider>
      </div>
      <div class="form-group">
          <label for="facebook">Facebook</label>
          <ValidationProvider name="facebook" rules="max:50">
              <div slot-scope="{ errors }">
                  <input type="facebook" id="facebook" name="facebook"
                  class="form-control" v-model="facebook" maxlength="50">
                  <p>{{ errors[0] }}</p>
              </div>
          </ValidationProvider>
      </div>
      <div class="form-group">
          <label for="twitter">Twitter</label>
          <ValidationProvider name="twitter" rules="max:50">
              <div slot-scope="{ errors }">
                  <input type="twitter" id="twitter" name="twitter"
                  class="form-control" v-model="twitter" maxlength="50">
                  <p>{{ errors[0] }}</p>
              </div>
          </ValidationProvider>
      </div>
      <div class="form-group">
          <label for="site">Site</label>
          <ValidationProvider name="site" rules="max:50">
              <div slot-scope="{ errors }">
                  <input type="site" id="facebook" name="site"
                  class="form-control" v-model="site" maxlength="50">
                  <p>{{ errors[0] }}</p>
              </div>
          </ValidationProvider>
      </div>
   </tab-content>

   <tab-content title="Endereço" icon="fas fa-map-marker-alt">

     <div class="form-group">
      <label for="estado">* Estado</label>
        <select class="custom-select" name="estado" v-model="estado">
          <option selected>Selecione a opção</option>
          <option value="AC">Acre</option>
          <option value="AL">Alagoas</option>
          <option value="AP">Amapá</option>
          <option value="AM">Amazonas</option>
          <option value="BA">Bahia</option>
          <option value="CE">Ceará</option>
          <option value="DF">Distrito Federal</option>
          <option value="ES">Espírito Santo</option>
          <option value="GO">Goiás</option>
          <option value="MA">Maranhão</option>
          <option value="MT">Mato Grosso</option>
          <option value="MS">Mato Grosso do Sul</option>
          <option value="MG">Minas Gerais</option>
          <option value="PA">Pará</option>
          <option value="PB">Paraíba</option>
          <option value="PR">Paraná</option>
          <option value="PE">Pernambuco</option>
          <option value="PI">Piauí</option>
          <option value="RJ">Rio de Janeiro</option>
          <option value="RN">Rio Grande do Norte</option>
          <option value="RS">Rio Grande do Sul</option>
          <option value="RO">Rondônia</option>
          <option value="RR">Roraima</option>
          <option value="SC">Santa Catarina</option>
          <option value="SP">São Paulo</option>
          <option value="SE">Sergipe</option>
          <option value="TO">Tocantins</option>
        </select>
      </div>

     <div class="form-group">
        <label for="endereco">* Endereço</label>
          <ValidationProvider name="rua" rules="required|max:50">
              <div slot-scope="{ errors }">
                  <input type="text" class="form-control" name="rua" placeholder="Rua" v-model="rua" maxlength="50">
                  <p>{{ errors[0] }}</p>
              </div>
          </ValidationProvider>


          <ValidationProvider name="bairro" rules="required|max:50">
              <div slot-scope="{ errors }">
                  <input type="text" class="form-control" name="bairro" placeholder="Bairro" v-model="bairro" maxlength="50">
                  <p>{{ errors[0] }}</p>
              </div>
          </ValidationProvider>

          <ValidationProvider name="cidade" rules="required|max:50">
              <div slot-scope="{ errors }">
                  <input type="text" class="form-control" name="cidade" placeholder="Cidade" v-model="cidade" maxlength="50">
                  <p>{{ errors[0] }}</p>
              </div>
          </ValidationProvider>


          <ValidationProvider name="cep" rules="required|numeric|digits:8">
              <div slot-scope="{ errors }">
                  <input type="text" class="form-control" name="cep" placeholder="CEP" v-model="cep" minlength="8" maxlength="8">
                  <p>{{ errors[0] }}</p>
              </div>
          </ValidationProvider>

      </div>
   </tab-content>
</form-wizard>
</template>

<script>
import UploadPhoto from '../Utils/UploadPhoto';

    export default {
        components:{
            UploadPhoto,
        },
        data(){
            return{


                razao: '',
                missao: '',
                rua: '',
                bairro: '',
                cidade: '',
                cep: '',
                celular: '',
                fixo: '',
                facebook: '',
                twitter: '',
                linkedin:'',
                site: '',
                outraRede: '',
                pais: '',
                estado: '',
                editing: false,
                uri: 'http://localhost:8000/api/pjuridicas',
                token: this.$session.get('jwt'),
                user_id: this.$session.get('user_id'),
                notificacoes: []


            }
        },
        methods: {
            register(){

                if(!this.token){
                    console.log('loga ai seu corno');
                }else{
                     this.axios.post('http://localhost:8000/api/data/pjuridicas?token=' + this.token,

                    {
                        razao: this.razao,
                        missao: this.missao,
                        rua: this.rua,
                        bairro: this.bairro,
                        cidade: this.cidade,
                        cep: this.cep,
                        celular: this.celular,
                        fixo: this.fixo,
                        facebook: this.facebook,
                        twitter: this.twitter,
                        site: this.site,
                        outraRede: this.outraRede,
                        pais: this.pais,
                        estado: this.estado,
                        linkedin: this.linkedin,
                        user_id: this.$session.get('user_id')
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => {
                            if(response.data.error  != undefined){
                                this.notificacoes = response.data.error;
                                return;
                            }
                        }
                    )
                    .catch(
                        (error) => console.log(error)
                    );
                }
            },
             verifyEdit(){

                if(this.$route.params.editing === true){
                    this.editing = true;
                    this.loadDataEdit();
                }
                console.log('verifyedit:', this.editing);
            },
            edit(){

                this.axios.put(this.uri + '/' + this.user_id + '?token=' + this.token,

                    {
                        razao: this.razao,
                        missao: this.missao,
                        rua: this.rua,
                        bairro: this.bairro,
                        cidade: this.cidade,
                        cep: this.cep,
                        celular: this.celular,
                        fixo: this.fixo,
                        facebook: this.facebook,
                        twitter: this.twitter,
                        site: this.site,
                        outraRede: this.outraRede,
                        pais: this.pais,
                        estado: this.estado,
                        linkedin: this.linkedin
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => {
                            if(response.data.error  != undefined){
                                this.notificacoes = response.data.error;
                                return;
                            }
                        }
                    )
                    .catch(
                        (error) => console.log(error)
                    );
            },
            loadDataEdit(){

                this.axios.get(this.uri + '/' + this.user_id + '?token=' + this.token)
                    .then(response=>{

                        console.log('TESTE', response.data);
                        this.razao = response.data.juridica[0].user.name;
                        this.missao = response.data.juridica[0].missao;
                        this.rua = response.data.juridica[0].endereco.rua;
                        this.bairro = response.data.juridica[0].endereco.bairro;
                        this.cidade = response.data.juridica[0].endereco.cidade;
                        this.cep = response.data.juridica[0].endereco.cep;
                        this.celular = response.data.juridica[0].contato.celular;
                        this.fixo = response.data.juridica[0].contato.fixo;
                        this.facebook = response.data.juridica[0].contato.facebook;
                        this.twitter = response.data.juridica[0].contato.twitter;
                        this.site = response.data.juridica[0].contato.site;
                        this.outraRede = response.data.juridica[0].contato.outraRede;
                        this.linkedin = response.data.juridica[0].contato.linkedin;
                        this.pais = response.data.juridica[0].endereco.pais;
                        this.estado = response.data.juridica[0].endereco.estado;

                    })
                    .catch(
                        error => console.log(error)
                    );
            }
        },
        created() {
            this.verifyEdit();
            console.log(this.$session.get('user_id'));
        }

    }
</script>

