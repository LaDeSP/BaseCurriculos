<template>

    <div>
        <div v-if="!dataCompleted">
            <h3>Cadastrar Informações</h3>
        </div>
        <div v-else>
            <h3>Editar Informações</h3>
        </div>
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
  <tab-content title="Informações Pessoais" icon="far fa-address-card">
    <UploadPhoto></UploadPhoto>
    <div class="form-group">
        <label for="nome">* Nome Completo</label>
        <ValidationProvider name="nome" rules="required|max:50">
            <div slot-scope="{ errors }">
                <input type="text" name="nome" class="form-control" v-model="nome"  maxlength="50">
                <p>{{ errors[0] }}</p>
            </div>
        </ValidationProvider>
    </div>

    <div class="form-group">
        <label for="nascimento">* Data de Nascimento</label>
        <ValidationProvider name="nascimento" rules="required">
            <div slot-scope="{ errors }">
                <input type="date" class="form-control" name="nascimento" v-model="nascimento">
                <p>{{ errors[0] }}</p>
            </div>
        </ValidationProvider>
    </div>

    <div class="form-group">
        <label for="genero">* Gênero</label>
            <select class="custom-select" name="genero" v-model="genero">
                <option disabled value="">Selecione seu gênero</option>
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
                <option value="Outro">Outro</option>
            </select>
    </div>

    <div class="form-group">
        <label for="estadoCivil">* Estado Civil</label>
            <select class="custom-select" name="estadoCivil" v-model="estadoCivil">
                <option disabled value="">Selecione seu estado civil</option>
                <option value="Solteiro(a)">Solteiro(a)</option>
                <option value="Casado(a)">Casado(a)</option>
                <option value="Separado(a)">Separado(a)</option>
                <option value="Viúvo(a)">Viúvo(a)</option>
            </select>
    </div>

     <div class="form-group">
        <label for="pais">* País de Nacionalidade</label>
            <select class="custom-select" name="pais" v-model="pais">
                <option value="" disabled selected>Selecione seu país de nacionalidade</option>
                <option value="África do Sul">África do Sul</option>
                <option value="Albânia">Albânia</option>
                <option value="Alemanha">Alemanha</option>
                <option value="Andorra">Andorra</option>
                <option value="Angola">Angola</option>
                <option value="Anguilla">Anguilla</option>
                <option value="Antigua">Antigua</option>
                <option value="Arábia Saudita">Arábia Saudita</option>
                <option value="Argentina">Argentina</option>
                <option value="Armênia">Armênia</option>
                <option value="Aruba">Aruba</option>
                <option value="Austrália">Austrália</option>
                <option value="Áustria">Áustria</option>
                <option value="Azerbaijão">Azerbaijão</option>
                <option value="Bahamas">Bahamas</option>
                <option value="Bahrein">Bahrein</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Barbados">Barbados</option>
                <option value="Bélgica">Bélgica</option>
                <option value="Benin">Benin</option>
                <option value="Bermudas">Bermudas</option>
                <option value="Botsuana">Botsuana</option>
                <option value="Brasil">Brasil</option>
                <option value="Brunei">Brunei</option>
                <option value="Bulgária">Bulgária</option>
                <option value="Burkina Fasso">Burkina Fasso</option>
                <option value="botão">botão</option>
                <option value="Cabo Verde">Cabo Verde</option>
                <option value="Camarões">Camarões</option>
                <option value="Camboja">Camboja</option>
                <option value="Canadá">Canadá</option>
                <option value="Cazaquistão">Cazaquistão</option>
                <option value="Chade">Chade</option>
                <option value="Chile">Chile</option>
                <option value="China">China</option>
                <option value="Cidade do Vaticano">Cidade do Vaticano</option>
                <option value="Colômbia">Colômbia</option>
                <option value="Congo">Congo</option>
                <option value="Coréia do Sul">Coréia do Sul</option>
                <option value="Costa do Marfim">Costa do Marfim</option>
                <option value="Costa Rica">Costa Rica</option>
                <option value="Croácia">Croácia</option>
                <option value="Dinamarca">Dinamarca</option>
                <option value="Djibuti">Djibuti</option>
                <option value="Dominica">Dominica</option>
                <option value="EUA">EUA</option>
                <option value="Egito">Egito</option>
                <option value="El Salvador">El Salvador</option>
                <option value="Emirados Árabes">Emirados Árabes</option>
                <option value="Equador">Equador</option>
                <option value="Eritréia">Eritréia</option>
                <option value="Escócia">Escócia</option>
                <option value="Eslováquia">Eslováquia</option>
                <option value="Eslovênia">Eslovênia</option>
                <option value="Espanha">Espanha</option>
                <option value="Estônia">Estônia</option>
                <option value="Etiópia">Etiópia</option>
                <option value="Fiji">Fiji</option>
                <option value="Filipinas">Filipinas</option>
                <option value="Finlândia">Finlândia</option>
                <option value="França">França</option>
                <option value="Gabão">Gabão</option>
                <option value="Gâmbia">Gâmbia</option>
                <option value="Gana">Gana</option>
                <option value="Geórgia">Geórgia</option>
                <option value="Gibraltar">Gibraltar</option>
                <option value="Granada">Granada</option>
                <option value="Grécia">Grécia</option>
                <option value="Guadalupe">Guadalupe</option>
                <option value="Guam">Guam</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Guiana">Guiana</option>
                <option value="Guiana Francesa">Guiana Francesa</option>
                <option value="Guiné-bissau">Guiné-bissau</option>
                <option value="Haiti">Haiti</option>
                <option value="Holanda">Holanda</option>
                <option value="Honduras">Honduras</option>
                <option value="Hong Kong">Hong Kong</option>
                <option value="Hungria">Hungria</option>
                <option value="Iêmen">Iêmen</option>
                <option value="Ilhas Cayman">Ilhas Cayman</option>
                <option value="Ilhas Cook">Ilhas Cook</option>
                <option value="Ilhas Curaçao">Ilhas Curaçao</option>
                <option value="Ilhas Marshall">Ilhas Marshall</option>
                <option value="Ilhas Turks & Caicos">Ilhas Turks & Caicos</option>
                <option value="Ilhas Virgens (brit.)">Ilhas Virgens (brit.)</option>
                <option value="Ilhas Virgens(amer.)">Ilhas Virgens(amer.)</option>
                <option value="Ilhas Wallis e Futuna">Ilhas Wallis e Futuna</option>
                <option value="Índia">Índia</option>
                <option value="Indonésia">Indonésia</option>
                <option value="Inglaterra">Inglaterra</option>
                <option value="Irlanda">Irlanda</option>
                <option value="Islândia">Islândia</option>
                <option value="Israel">Israel</option>
                <option value="Itália">Itália</option>
                <option value="Jamaica">Jamaica</option>
                <option value="Japão">Japão</option>
                <option value="Jordânia">Jordânia</option>
                <option value="Kuwait">Kuwait</option>
                <option value="Latvia">Latvia</option>
                <option value="Líbano">Líbano</option>
                <option value="Liechtenstein">Liechtenstein</option>
                <option value="Lituânia">Lituânia</option>
                <option value="Luxemburgo">Luxemburgo</option>
                <option value="Macau">Macau</option>
                <option value="Macedônia">Macedônia</option>
                <option value="Madagascar">Madagascar</option>
                <option value="Malásia">Malásia</option>
                <option value="Malaui">Malaui</option>
                <option value="Mali">Mali</option>
                <option value="Malta">Malta</option>
                <option value="Marrocos">Marrocos</option>
                <option value="Martinica">Martinica</option>
                <option value="Mauritânia">Mauritânia</option>
                <option value="Mauritius">Mauritius</option>
                <option value="México">México</option>
                <option value="Moldova">Moldova</option>
                <option value="Mônaco">Mônaco</option>
                <option value="Montserrat">Montserrat</option>
                <option value="Nepal">Nepal</option>
                <option value="Nicarágua">Nicarágua</option>
                <option value="Niger">Niger</option>
                <option value="Nigéria">Nigéria</option>
                <option value="Noruega">Noruega</option>
                <option value="Nova Caledônia">Nova Caledônia</option>
                <option value="Nova Zelândia">Nova Zelândia</option>
                <option value="Omã">Omã</option>
                <option value="Palau">Palau</option>
                <option value="Panamá">Panamá</option>
                <option value="Papua-nova Guiné">Papua-nova Guiné</option>
                <option value="Paquistão">Paquistão</option>
                <option value="Peru">Peru</option>
                <option value="Polinésia Francesa">Polinésia Francesa</option>
                <option value="Polônia">Polônia</option>
                <option value="Porto Rico">Porto Rico</option>
                <option value="Portugal">Portugal</option>
                <option value="Qatar">Qatar</option>
                <option value="Quênia">Quênia</option>
                <option value="Rep. Dominicana">Rep. Dominicana</option>
                <option value="Rep. Tcheca">Rep. Tcheca</option>
                <option value="Reunion">Reunion</option>
                <option value="Romênia">Romênia</option>
                <option value="Ruanda">Ruanda</option>
                <option value="Rússia">Rússia</option>
                <option value="Saipan">Saipan</option>
                <option value="Samoa Americana">Samoa Americana</option>
                <option value="Senegal">Senegal</option>
                <option value="Serra Leone">Serra Leone</option>
                <option value="Seychelles">Seychelles</option>
                <option value="Singapura">Singapura</option>
                <option value="Síria">Síria</option>
                <option value="Sri Lanka">Sri Lanka</option>
                <option value="St. Kitts & Nevis">St. Kitts & Nevis</option>
                <option value="St. Lúcia">St. Lúcia</option>
                <option value="St. Vincent">St. Vincent</option>
                <option value="Sudão">Sudão</option>
                <option value="Suécia">Suécia</option>
                <option value="Suiça">Suiça</option>
                <option value="Suriname">Suriname</option>
                <option value="Tailândia">Tailândia</option>
                <option value="Taiwan">Taiwan</option>
                <option value="Tanzânia">Tanzânia</option>
                <option value="Togo">Togo</option>
                <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                <option value="Tunísia">Tunísia</option>
                <option value="Turquia">Turquia</option>
                <option value="Ucrânia">Ucrânia</option>
                <option value="Uganda">Uganda</option>
                <option value="Uruguai">Uruguai</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Vietnã">Vietnã</option>
                <option value="Zaire">Zaire</option>
                <option value="Zâmbia">Zâmbia</option>
                <option value="Zimbábue">Zimbábue</option>
            </select>
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

          <ValidationProvider name="numero" rules="required|max:50">
              <div slot-scope="{ errors }">
                  <input type="text" class="form-control" name="numero" placeholder="Número" v-model="numero" maxlength="50">
                  <p>{{ errors[0] }}</p>
              </div>
          </ValidationProvider>

          <ValidationProvider name="complemento" rules="required|max:50">
              <div slot-scope="{ errors }">
                  <input type="text" class="form-control" name="complemento" placeholder="Complemento" v-model="complemento" maxlength="50">
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

   <tab-content title="Informações Profissionais" icon="fas fa-file-alt">
     <div class="form-group">
          <label for="objetivos">* Objetivos Profissionais</label>
          <ValidationProvider name="objetivos" rules="required|max:500">
              <div slot-scope="{ errors }">
                  <textarea id="objetivos" class="md-textarea form-control" rows="5" name="objetivos" v-model="objetivos" maxlength="500"></textarea>
                  <p>{{ errors[0] }}</p>
              </div>
          </ValidationProvider>
      </div>

      <div class="form-group">
          <label for="area">* Área de Atuação</label>
              <select class="custom-select" name="area" v-model="area">
                   <option disabled value="">Selecione uma área</option>
                  <option v-for="area in areas" :key="area.id" :value="area.id">
                      {{area.tipo}}
                  </option>
              </select>
      </div>

      <div class="form-group">
          <label for="pretensao">* Pretensão Salarial</label>
          <ValidationProvider name="pretensao" rules="required|numeric|min_value:1">
              <div slot-scope="{ errors }">
                  <input type="number" id="pretensao" name="pretensao"
                  class="form-control" v-model="pretensao" step="any">

                  <p>{{ errors[0] }}</p>
              </div>
          </ValidationProvider>
      </div>

      <div class="form-group">
          <label for="escolaridade">* Nível de Escolaridade</label>
              <select class="custom-select" name="escolaridade" v-model="escolaridade">
                  <option value="" disabled selected>Selecione seu nível</option>
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
          <label for="qualificacoes">* Qualificações</label>
          <ValidationProvider name="qualificacoes" rules="required|max:500">
              <div slot-scope="{ errors }">
                  <textarea id="qualificacoes" class="md-textarea form-control" rows="5" name="qualificacoes" v-model="qualificacoes" maxlength="500"></textarea>
                  <p>{{ errors[0] }}</p>
              </div>
          </ValidationProvider>
      </div>

      <div class="form-group">
          <label for="historicoProfissional">* Histórico Profissional</label>
          <ValidationProvider name="historicoProfissional" rules="required|max:500">
              <div slot-scope="{ errors }">
                  <textarea id="historicoProfissional" class="md-textarea form-control" rows="5" name="historicoProfissional" v-model="historicoProfissional" maxlength="500"></textarea>
                  <p>{{ errors[0] }}</p>
              </div>
          </ValidationProvider>
      </div>

   </tab-content>
</form-wizard>
</div>
</template>


<script>

import UploadPhoto from '../Utils/UploadPhoto';
import { mapActions, mapGetters } from 'vuex';

export default {
  components:{
          UploadPhoto,
  },
  data(){
    return {

        nome: '',
        nascimento: '',
        genero: '',
        rua: '',
        numero: '',
        complemento: '',
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
        objetivos: '',
        area: '',
        pretensao: '',
        qualificacoes: '',
        historicoProfissional: '',
        estadoCivil: '',
        pais: '',
        estado: '',
        escolaridade: '',
        areas: [],
        notificacoes: []
    };
  },
  methods: {
    ...mapActions([
        'loadFisica'
    ]),
    onComplete(){
     
        let curriculo = {

          nome: this.nome,
          nascimento: this.nascimento,
          genero: this.genero,
          rua: this.rua,
          numero: this.numero,
          complemento: this.complemento,
          bairro: this.bairro,
          cidade: this.cidade,
          cep: this.cep,
          celular: this.celular,
          fixo: this.fixo,
          facebook: this.facebook,
          twitter: this.twitter,
          linkedin:this.linkedin,
          site: this.site,
          outraRede: this.outraRede,
          objetivos: this.objetivos,
          area: this.area,
          pretensao: this.pretensao,
          qualificacoes: this.qualificacoes,
          historicoProfissional: this.historicoProfissional,
          estadoCivil: this.estadoCivil,
          pais: this.pais,
          estado: this.estado,
          escolaridade: this.escolaridade,
      }
     if(!this.editing){
        this.$store.dispatch('completeFisica', curriculo)
        .then(response => {

            if(response.error  != undefined){
                this.notificacoes = response.error;
            }
            console.log(this.notificacoes)
        })
        .catch(error => console.log(error))
     
     }else{
        this.$store.dispatch('updateFisica', curriculo)
        .then(response => {
                if(response.error  != undefined){
                    this.notificacoes = response.error;
                }
        }).catch(error => console.log(error))  
      }
    },
    verifyEdit(){

        //if(this.$route.params.editing === true){
       if(this.dataCompleted){
           this.displayDataEdit();
       }
    
      //  console.log('verifyedit:', this.dataCompleted);
    },

    displayDataEdit(){
        console.log('desgraça', this.displayPessoaFisica)
       
        /* this.nascimento = this.$store.getters.displayPessoaFisica.nascimento
        this.genero = this.$store.getters.displayPessoaFisica.genero
        this.estadoCivil = this.$store.getters.displayPessoaFisica.estadoCivil
        this.pais = this.$store.getters.displayPessoaFisica.pais
        this.fixo = this.$store.getters.displayPessoaFisica.fixo
        this.celular = this.$store.getters.displayPessoaFisica.celular
        this.linkedin = this.$store.getters.displayCurriculo.linkedin
        this.facebook = this.$store.getters.displayCurriculo.facebook
        this.twitter = this.$store.getters.displayCurriculo.twitter
        this.site = this.$store.getters.displayCurriculo.site
        this.estado = this.$store.getters.displayPessoaFisica.estado
        this.rua = this.$store.getters.displayPessoaFisica.rua
        this.bairro = this.$store.getters.displayPessoaFisica.bairro
        this.cidade = this.$store.getters.displayPessoaFisica.cidade
        this.cep = this.$store.getters.displayPessoaFisica.cep
        this.complemento = this.$store.getters.displayPessoaFisica.complemento
        this.numero = this.$store.getters.displayPessoaFisica.numero
        this.objetivos = this.$store.getters.displayCurriculo.objetivos
        this.area = this.$store.getters.displayCurriculo.area
        this.pretensao = parseFloat(this.$store.getters.displayCurriculo.pretensao)
        this.escolaridade = this.$store.getters.displayCurriculo.escolaridade
        this.qualificacoes = this.$store.getters.displayCurriculo.qualificacoes
        this.historicoProfissional = this.$store.getters.displayCurriculo.historicoProfissional
        console.log(this.pretensao) */
    },

    loadArea(){
        const token = this.$store.state.auth.token;
        this.axios.get('http://localhost:8000/api/areas?token=' + token)

            .then(response => {
                this.areas = response.data.areas
                this.nome = this.$store.state.auth.user.name
            })
            .catch(
                error => console.log(error)
            );
    },
   
  },
    computed: {
        ...mapGetters([
            'displayPessoaFisica', 'displayCurriculo', 'dataCompleted'
        ]),
        dataCompleted: {
            get(){ 
                return this.$store.getters.dataCompleted;
            }
        }
    },
    async created() {
        await this.loadFisica();
        this.loadArea();
        this.verifyEdit();
        console.log('inferno', this.displayPessoaFisica)
    },
  
};
</script>
