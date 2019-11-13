<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div v-if="!this.dataCompleted">
                <h3>Cadastrar Informações</h3>
            </div>
            <div v-else>
                <h3>Editar Informações</h3>
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
                        <ValidationProvider name="razao" rules="required|max:50">
                            <div slot-scope="{ errors }">
                                <input type="text" name="razao" class="form-control" v-model="razao"  maxlength="50">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>
                </tab-content>

                <tab-content title="Contato" icon="fas fa-phone">
                    <div class="form-group">
                        <label for="telefone">Telefone e Celular <a class="color-red">*</a></label>
                        <div class="form-row">
                            <div class="col-6">
                                <ValidationProvider name="fixo" rules="required|numeric|digits:10">
                                    <div slot-scope="{ errors }">
                                        <input type="text" class="form-control" name="fixo" placeholder="Fixo" v-model="fixo" minlength="10" maxlength="10">
                                        <p class="color-red">{{ errors[0] }}</p>
                                    </div>
                                </ValidationProvider>
                            </div>
                            <div class="col">
                                <ValidationProvider name="celular" rules="required|numeric|digits:11">
                                    <div slot-scope="{ errors }">
                                        <input type="text" class="form-control" name="celular" placeholder="Celular" v-model="celular" minlength="11" maxlength="11">
                                        <p class="color-red">{{ errors[0] }}</p>
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
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="form-group">
                        <label for="facebook">Facebook</label>
                        <ValidationProvider name="facebook" rules="max:50">
                            <div slot-scope="{ errors }">
                                <input type="facebook" id="facebook" name="facebook"
                                class="form-control" v-model="facebook" maxlength="50">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="form-group">
                        <label for="twitter">Twitter</label>
                        <ValidationProvider name="twitter" rules="max:50">
                            <div slot-scope="{ errors }">
                                <input type="twitter" id="twitter" name="twitter"
                                class="form-control" v-model="twitter" maxlength="50">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>
                    <div class="form-group">
                        <label for="site">Site</label>
                        <ValidationProvider name="site" rules="max:50">
                            <div slot-scope="{ errors }">
                                <input type="site" id="facebook" name="site"
                                class="form-control" v-model="site" maxlength="50">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>
                </tab-content>

                <tab-content title="Endereço" icon="fas fa-map-marker-alt">

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
                        <label for="endereco">Endereço <a class="color-red">*</a></label>
                        <ValidationProvider name="rua" rules="required|max:50">
                            <div slot-scope="{ errors }">
                                <input type="text" class="form-control" name="rua" placeholder="Rua" v-model="rua" maxlength="50" id="rua">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>


                        <ValidationProvider name="bairro" rules="required|max:50">
                            <div slot-scope="{ errors }">
                                <input type="text" class="form-control" name="bairro" placeholder="Bairro" v-model="bairro" maxlength="50" id="bairro">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>

                        <ValidationProvider name="numero" rules="required|numeric|max:7|max_value:1000000">
                            <div slot-scope="{ errors }">
                                <input type="number" class="form-control" name="numero" id="numero" placeholder="Número" v-model="numero" maxlength="7" max="1000000">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>

                        <ValidationProvider name="complemento" rules="required|max:50">
                            <div slot-scope="{ errors }">
                                <input type="text" class="form-control" name="complemento" id="complemento" placeholder="Complemento" v-model="complemento" maxlength="50">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>

                        <ValidationProvider name="cidade" rules="required|max:50">
                            <div slot-scope="{ errors }">
                                <input type="text" class="form-control" name="cidade" id="cidade" placeholder="Cidade" v-model="cidade" maxlength="50">
                                <p class="color-red">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>


                        <ValidationProvider name="cep" rules="required|numeric|digits:8">
                            <div slot-scope="{ errors }">
                                <input type="text" class="form-control" name="cep" id="cep" v-on:keyup="buscar" placeholder="CEP" v-model="cep" minlength="8" maxlength="8">
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
</template>

<script>
import UploadPhoto from '../Utils/UploadPhoto';
import { mapActions, mapGetters } from 'vuex';
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

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
        methods: {
            register(){

                if(!this.token){
                    console.log('loga ai seu corno');
                }else{
                        this.axios.post('http://localhost:8000/api/data/pjuridicas?token=' + this.token,

                    {
                      
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
                            this.$router.push({ name: 'profile-juridica'});
                        }
                    })
                    .catch(error => console.log(error))

                }else{
                    this.$store.dispatch('updateJuridica', completeJuridica)
                    .then(response => {
                            if(response.error  != undefined){
                                this.notificacoes = response.error;
                            }else{
                                this.$router.push({ name: 'profile-juridica'});
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
                console.log('inferno', this.displayPessoaJuridica)
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
                console.log(endereco);
                self.rua = endereco.logradouro;
                self.bairro = endereco.bairro;
                self.cidade = endereco.localidade;
                self.estado = endereco.uf;
                self.complemento = endereco.complemento;


                $("#numero").focus();

                });
            }
            },

        },
            computed: {
                ...mapGetters([
                    'displayPessoaJuridica', 'dataCompleted'
                ]),
            
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

