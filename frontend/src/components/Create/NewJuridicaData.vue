<template>
<span v-if="isFetching">
  <br>
  <br>
  <br>
  <div class="container">
    <center><h1>
        Carregando...  <span class="fas fa-spinner fa-pulse"></span>
    </h1></center>
  </div>
</span>
<span v-else>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div v-if="!this.dataCompleted">
              <h3>Cadastrar Informações</h3>
            </div>
            <div v-else>
              <div class="row">
                 <div class="col-4">
                  <div class=" bd-highlight flex-left">
                      <router-link to="/profile" class="btn btn-md btn-outline-secondary">
                        <i class="fas fa-long-arrow-alt-left"></i> Voltar
                      </router-link>
                  </div>
                </div>
                    <div class="col-5">
                  <h3> <center>Editar Informações</center></h3>
                </div>
              </div>
            </div>
            <ValidationObserver v-slot="{ invalid }">
             <form-wizard @on-complete="onComplete"
                    title="" subtitle=" "
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
                    <div class="form-group">
                        <label for="dropzone">Foto de Perfil</label>
                        <vue-dropzone ref="myVueDropzone" id="dropzone" name="dropzone" :options="dropzoneOptions"
                            @vdropzone-success="getActualPhoto"
                            @vdropzone-removed-file="deleteUserPhoto"
                            :destroyDropzone="false"
                        ></vue-dropzone>
                    </div>
                    <div class="form-group">
                        <label for="razao">Nome da Empresa <a class="color-red">*</a></label>
                        <ValidationProvider name="razao" rules="required|max:250">
                            <div slot-scope="{ errors }">
                                <input type="text" name="razao" class="form-control" v-model="razao"  maxlength="250">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>
                </tab-content>

                <tab-content title="Contato" icon="fas fa-phone">
                    <div class="form-group">
                        <label for="telefone">Telefone Fixo</label>
                        <div class="form-group">
                          <ValidationProvider name="fixo" rules="regex:^\([0-9]{2}\)[0-9]{4}\-[0-9]{4}$">
                              <div slot-scope="{ errors }">
                                  <input type="text" class="form-control" name="fixo" v-model="fixo" v-mask="'(##)####-####'" maxlength="13">
                                  <p class="color-red">{{ errors[0] }}</p>
                              </div>
                          </ValidationProvider>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="celular">Telefone Celular<a class="color-red">*</a></label>
                      <ValidationProvider name="celular" rules="required|regex:^\([0-9]{2}\)[0-9]{5}\-[0-9]{4}$">
                          <div slot-scope="{ errors }">
                              <input type="text" class="form-control" name="celular" v-model="celular" v-mask="'(##)#####-####'" maxlength="14">
                              <p class="color-red">{{ errors[0] }}</p>
                          </div>
                      </ValidationProvider>
                    </div>
                    <div class="form-group">
                        <label for="linkedin">Linkedin</label>
                        <ValidationProvider name="linkedin" rules="max:250">
                            <div slot-scope="{ errors }">
                                <input type="linkedin" id="linkedin" name="linkedin"
                                class="form-control" v-model="linkedin" maxlength="250">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="form-group">
                        <label for="facebook">Facebook</label>
                        <ValidationProvider name="facebook" rules="max:250">
                            <div slot-scope="{ errors }">
                                <input type="facebook" id="facebook" name="facebook"
                                class="form-control" v-model="facebook" maxlength="250">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="form-group">
                        <label for="twitter">Twitter</label>
                        <ValidationProvider name="twitter" rules="max:250">
                            <div slot-scope="{ errors }">
                                <input type="twitter" id="twitter" name="twitter"
                                class="form-control" v-model="twitter" maxlength="250">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="form-group">
                        <label for="site">Site</label>
                        <ValidationProvider name="site" rules="max:250">
                            <div slot-scope="{ errors }">
                                <input type="site" id="facebook" name="site"
                                class="form-control" v-model="site" maxlength="250">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>
                </tab-content>

                <tab-content title="Endereço" icon="fas fa-map-marker-alt">
                    <div class="form-group">
                      <label for="cep">CEP <a class="color-red">*</a></label>
                      <ValidationProvider name="cep" rules="required|numeric|digits:8">
                          <div slot-scope="{ errors }">
                              <input type="text" class="form-control" name="cep" id="cep" placeholder="CEP" v-on:keyup="buscar" v-model="cep" minlength="8" maxlength="8" />
                              <p class="color-red">{{ errors[0] }}</p>
                          </div>
                      </ValidationProvider>
                     </div>

                    <div class="form-group">
                        <label for="estado">Estado <a class="color-red">*</a></label>
                        <ValidationProvider name="estadio" rules="required">
                            <div slot-scope="{ errors }">
                                <select class="custom-select" name="estado" v-model="estado" id="estado">
                                    <option disabled value="">Selecione seu estado</option>
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
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>

                    <div class="form-group">
                      <label for="cidade">Cidade <a class="color-red">*</a></label>
                      <ValidationProvider name="cidade" rules="required|max:250">
                            <div slot-scope="{ errors }">
                                <input type="text" class="form-control" name="cidade" id="cidade" placeholder="Cidade" v-model="cidade" maxlength="250">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                      </ValidationProvider>
                    </div>

                     <div class="form-group">
                      <label for="bairro">Bairro <a class="color-red">*</a></label>
                      <ValidationProvider name="bairro" rules="required|max:250">
                            <div slot-scope="{ errors }">
                                <input type="text" class="form-control" name="bairro" placeholder="Bairro" v-model="bairro" id="bairro" maxlength="250">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                     </div>

                    <div class="form-group">
                        <label for="endereco">Rua <a class="color-red">*</a></label>
                        <ValidationProvider name="rua" rules="required|max:250">
                            <div slot-scope="{ errors }">
                                <input type="text" class="form-control" name="rua" placeholder="Rua" v-model="rua" id="rua" maxlength="250">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>


                    <div class="form-group">
                      <label for="numero">Número</label>
                      <ValidationProvider name="numero" rules="max:250">
                            <div slot-scope="{ errors }">
                                <input type="text" class="form-control" name="numero" placeholder="Número" v-model="numero" id="numero" maxlength="250">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                     </div>

                    <div class="form-group">
                      <label for="complemento">Complemento</label>
                      <ValidationProvider name="complemento" rules="max:250">
                          <div slot-scope="{ errors }">
                              <input type="text" class="form-control" name="complemento" placeholder="Complemento" id="complemento" v-model="complemento" maxlength="250">
                              <p class="color-red">{{ errors[0] }}</p>
                          </div>
                      </ValidationProvider>
                    </div>


                </tab-content>
                <div slot="footer" slot-scope="props">
                    <div class="wizard-footer-left">
                        <wizard-button  v-if="props.activeTabIndex > 0" @click.native="props.prevTab()" :style="props.fillButtonStyle">Voltar</wizard-button>
                    </div>
                    <div class="wizard-footer-right">
                        <wizard-button v-if="!props.isLastStep" @click.native="props.nextTab()" class="wizard-footer-right" :style="props.fillButtonStyle">Próximo</wizard-button>
                        <wizard-button v-else :disabled="invalid" @click.native="onComplete" class="wizard-footer-right finish-button" :style="props.fillButtonStyle">  {{props.isLastStep ? 'Salvar' : 'Próximo'}}</wizard-button>
                    </div>
                </div>
            </form-wizard>
            </ValidationObserver>
        </div>

    </div>
</span>
</template>

<script>
import UploadPhoto from '../Utils/UploadPhoto';
import { mapActions, mapGetters, mapState } from 'vuex';
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import {mask} from 'vue-the-mask'

    export default {
        components:{
            UploadPhoto, vueDropzone: vue2Dropzone,
        },
        data(){
            return{


                razao: this.$store.state.auth.user.name,
                ramo: '',
                rua: '',
                bairro: '',
                numero: '',
                complemento: '',
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
                notificacoes: [],
                dropzoneOptions: {
                    url: 'http://localhost:8000/api/store/foto/user_id/'+this.$store.state.auth.user.id+'?token='+this.$store.state.auth.token,
                    maxFilesize: 5,
                    dictDefaultMessage: "Insira sua foto!",
                    dictRemoveFile: "Remover",
                    dictFileTooBig: "Imagens devem ter até 5mb.",
                    dictInvalidFileType: "Formato inválido.",
                    dictCancelUpload: "Cancelar",
                    dictMaxFilesExceeded: "Você só pode inserir uma imagem.",
                    maxFiles: 1,
                    addRemoveLinks: true,
                    thumbnailWidth: 200, // px
                    thumbnailHeight: 200,
                    acceptedMimeTypes: ".png, .jpg, .jpeg, .gif"
                },
                naoLocalizado: false
            }
        },
        directives: {mask},
        methods: {

            ...mapActions([
                'loadJuridica'
            ]),

            onComplete(){

                let completeJuridica = {

                    nome: this.razao,
                    ramo: this.ramo,
                    rua: this.rua,
                    bairro: this.bairro,
                    numero: this.numero,
                    complemento: this.complemento,
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

                }

                if(!this.dataCompleted){
                    this.$store.dispatch('completeJuridica', completeJuridica)
                    .then(response => {

                        if(response.error  != undefined){
                            this.notificeacoes = response.error;
                        }else{
                            this.$router.push({ name: 'dashboard', params:{criou: true}});
                        }
                    })
                    .catch(error => console.log(error))

                }else{
                    this.$store.dispatch('updateJuridica', completeJuridica)
                    .then(response => {
                            if(response.error  != undefined){
                                this.notificacoes = response.error;
                            }else{
                                this.$router.push({ name: 'profile'});
                            }
                    }).catch(error => console.log(error))
                }
            },

            verifyEdit(){
                if(this.dataCompleted){
                    this.displayDataEdit();
                }
            },

            displayDataEdit(){
                this.razao = this.displayPessoaJuridica.razao
                this.fixo = this.displayPessoaJuridica.fixo
                this.celular = this.displayPessoaJuridica.celular
                this.linkedin = this.displayPessoaJuridica.linkedin
                this.facebook = this.displayPessoaJuridica.facebook
                this.twitter = this.displayPessoaJuridica.twitter
                this.site = this.displayPessoaJuridica.site
                this.estado = this.displayPessoaJuridica.estado
                this.rua = this.displayPessoaJuridica.rua
                this.bairro = this.displayPessoaJuridica.bairro
                this.cidade = this.displayPessoaJuridica.cidade
                this.cep = this.displayPessoaJuridica.cep
                this.complemento = this.displayPessoaJuridica.complemento
                this.numero = this.displayPessoaJuridica.numero
            },

            loadArea(){
                const token = this.$store.state.auth.token;
                this.axios.get('http://localhost:8000/api/areas?token=' + token)

                    .then(response => {
                        this.areas = response.data.areas
                    })
                    .catch(
                        error => console.log(error)
                    );
            },

             getActualPhoto(){
                this.$store.dispatch('updateFoto')
            },

            deleteUserPhoto(file){
                if(file.status!='error'){
                    this.$store.dispatch('deleteUserPhoto')
                }
            },
            buscar: function(){
                var self = this;
            self.naoLocalizado = false;

            if(/^[0-9]{5}[0-9]{3}$/.test(this.cep)){
                $.getJSON("https://viacep.com.br/ws/" + this.cep + "/json/", function(endereco){
                if(endereco.erro){
                    $("#rua").focus();
                    self.naoLocalizado = true;
                    return;
                }
                self.rua = endereco.logradouro;
                self.bairro = endereco.bairro;
                self.cidade = endereco.localidade;
                self.estado = endereco.uf;


                //$("#numero").focus();

                });
            }
            },

        },
            computed: {
                ...mapGetters([
                    'displayPessoaJuridica', 'dataCompleted'
                ]),

                ...mapState(['isFetching']),

            },

            async created() {
                if(this.dataCompleted){
                    await this.loadJuridica();
                }
                this.loadArea();
                this.verifyEdit();
            },

             mounted() {
                if (this.$store.state.upload.path != "http://localhost:8000/anon.jpg"){
                    var url = this.$store.state.upload.path;
                    var file = { dataURL: url };
                    this.$refs.myVueDropzone.manuallyAddFile(file, url);
                    this.$refs.myVueDropzone.dropzone.emit('thumbnail', file, file.dataURL)
                    this.$refs.myVueDropzone.dropzone.emit('complete', file)
                }

            },
    }

</script>

