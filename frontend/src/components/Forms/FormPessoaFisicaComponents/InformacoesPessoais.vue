<template>
<v-stepper-content :rules="[() => !errors.has('name') && !erros.has('nascimento')]" step="1">
<v-card flat color="white darken-1">
  <v-card-text>
      <v-icon size="45" class="mb-4">far fa-address-card</v-icon>
      <vue-dropzone ref="myVueDropzone" id="dropzone" name="dropzone" :options="dropzoneOptions"
          @vdropzone-success="getActualPic"
          @vdropzone-removed-file="deleteUserPic"
          :destroyDropzone="false"
      ></vue-dropzone>
      <ValidationProvider v-slot="{ errors }" name="name" rules="required|max:250">
        <v-text-field 
          v-model="name"
          :error-messages="errors"
          label="Nome Completo *"
          required
        ></v-text-field>
      </ValidationProvider>
      <ValidationProvider name="nascimento" rules="required" v-slot="{errors}">
        <v-menu
          ref="menu"
          v-model="menu"
          :close-on-content-click="false"
          transition="scale-transition"
          offset-y
          max-width="290px"
          min-width="290px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
              v-model="dateFormated"
              label="Data de Nascimento *"
              persistent-hint
              :rules="rulesPeriodo"
              readonly
              required
              :error-messages="errors"
              append-outer-icon="fa-calendar"
              v-bind="attrs"
             
              v-on="on"
            ></v-text-field>
          </template>
          <v-date-picker scrollable locale="pt-br" v-model="date" no-title @input="menu = false"></v-date-picker>
        </v-menu>
      </ValidationProvider>
      <ValidationProvider v-slot="{ errors }" name="select" rules="required">
        <v-select
          v-model="genero"
          :items="itemsGeneros"
          :error-messages="errors" 
          label="Gênero *"
          required
        ></v-select>
      </ValidationProvider>
      <ValidationProvider v-slot="{ errors }" name="select" rules="required">
        <v-select
          v-model="estadoCivil"
          :items="itemsEstadoCivil"
          :error-messages="errors"
          label="Estado Civil *"
          required
        ></v-select>
      </ValidationProvider>
      <ValidationProvider v-slot="{ errors }" name="select" rules="required">
        <v-select
          v-model="paisNacionalidade"
          :items="itemsPaisNacionalidade"
          :error-messages="errors"
          label="País de Nacionalidade *"
          required
        ></v-select>
      </ValidationProvider>
  </v-card-text>
  <v-card-actions><small class="red--text">* Campo obrigatório</small></v-card-actions>
   <v-btn color="primary" @click="sendStep(2)">Próximo</v-btn>
</v-card>
</v-stepper-content>
</template>

<script>
import moment from 'moment'
import {mapState} from 'vuex'
import UploadPhoto from '@/components/Utils/UploadPhoto'
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import {mutationTypes, actionTypes} from '@/core/constants'

export default {
  components: {UploadPhoto, vueDropzone: vue2Dropzone},
  props: {
    edicao: Boolean
  },
  data(){
    return {
      step: 1,
      date: '',
      menu: false,
      name: '',
      genero: '',
      estadoCivil: '',
      paisNacionalidade: '',
      itemsGeneros: [
        'Feminino',
        'Masculino',
        'Não-binário'
      ],
      itemsEstadoCivil: [
        'Solteiro',
        'Casado',
        'Separado',
        'Viúvo'
      ],
      itemsPaisNacionalidade: [
        "Brasil",
        "África do Sul",
        "Albânia",
        "Alemanha",
        "Andorra",
        "Angola",
        "Anguilla",
        "Antigua",
        "Arábia Saudita",
        "Argentina",
        "Armênia",
        "Aruba",
        "Austrália",
        "Áustria",
        "Azerbaijão",
        "Bahamas",
        "Bahrein",
        "Bangladesh",
        "Barbados",
        "Bélgica",
        "Benin",
        "Bermudas",
        "Botsuana",
        "Brasil",
        "Brunei",
        "Bulgária",
        "Burkina Fasso",
        "Botão",
        "Cabo Verde",
        "Camarões",
        "Camboja",
        "Canadá",
        "Cazaquistão",
        "Chade",
        "Chile",
        "China",
        "Cidade do Vaticano",
        "Colômbia",
        "Congo",
        "Coréia do Sul",
        "Costa do Marfim",
        "Costa Rica",
        "Croácia",
        "Dinamarca",
        "Djibuti",
        "Dominica",
        "EUA",
        "Egito",
        "El Salvador",
        "Emirados Árabes",
        "Equador",
        "Eritréia",
        "Escócia",
        "Eslováquia",
        "Eslovênia",
        "Espanha",
        "Estônia",
        "Etiópia",
        "Fiji",
        "Filipinas",
        "Finlândia",
        "França",
        "Gabão",
        "Gâmbia",
        "Gana",
        "Geórgia",
        "Gibraltar",
        "Granada",
        "Grécia",
        "Guadalupe",
        "Guam",
        "Guatemala",
        "Guiana",
        "Guiana Francesa" ,
        "Guiné-bissau",
        "Haiti",
        "Holanda",
        "Honduras",
        "Hong Kong" ,
        "Hungria",
        "Iêmen",
        "Ilhas Cayman" ,
        "Ilhas Cook" ,
        "Ilhas Curaçao" ,
        "Ilhas Marshall" ,
        "Ilhas Turks & Caicos",
        "Ilhas Virgens (brit.)",
        "Ilhas Virgens(amer.)",
        "Ilhas Wallis e Futuna",
        "Índia",
        "Indonésia",
        "Inglaterra",
        "Irlanda",
        "Islândia",
        "Israel",
        "Itália",
        "Jamaica",
        "Japão",
        "Jordânia",
        "Kuwait",
        "Latvia",
        "Líbano",
        "Liechtenstein",
        "Lituânia",
        "Luxemburgo",
        "Macau",
        "Macedônia",
        "Madagascar",
        "Malásia",
        "Malaui",
        "Mali",
        "Malta",
        "Marrocos",
        "Martinica",
        "Mauritânia",
        "Mauritius",
        "México",
        "Moldova",
        "Mônaco",
        "Montserrat",
        "Nepal",
        "Nicarágua",
        "Niger",
        "Nigéria",
        "Noruega",
        "Nova Caledônia" ,
        "Nova Zelândia" ,
        "Omã",
        "Palau",
        "Panamá",
        "Papua-nova Guiné",
        "Paquistão",
        "Peru",
        "Polinésia Francesa",
        "Polônia",
        "Porto Rico",
        "Portugal",
        "Qatar",
        "Quênia",
        "Rep. Dominicana",
        "Rep. Tcheca",
        "Reunion",
        "Romênia",
        "Ruanda",
        "Rússia",
        "Saipan",
        "Samoa Americana",
        "Senegal",
        "Serra Leone",
        "Seychelles",
        "Singapura",
        "Síria",
        "Sri Lanka",
        "St. Kitts & Nevis",
        "St. Lúcia",
        "St. Vincent",
        "Sudão",
        "Suécia",
        "Suiça",
        "Suriname",
        "Tailândia",
        "Taiwan",
        "Tanzânia",
        "Togo",
        "Trinidad & Tobago",
        "Tunísia",
        "Turquia",
        "Ucrânia",
        "Uganda",
        "Uruguai",
        "Venezuela",
        "Vietnã",
        "Zaire",
        "Zâmbia",
        "Zimbábue",
      ],
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
      naoLocalizado: false,
      rulesPeriodo: [value => !!value || 'Esse campo é obrigatório.']
    }
  },
  async created(){
    console.log('no info fisica', this.edicao)
    this.name = this.$store.state.auth.user.name
    if(this.edicao){
      await this.loadDataToEdit()
    }
  },
  computed: {
    ...mapState(['pessoaFisicaInfo']),
    dateFormated(){
      if(this.date != '' && this.date != undefined){
        return moment(this.date).format('DD/MM/YYYY')
      }else{
        return this.date
      }
    }
  },
  methods: {
    async loadDataToEdit(){
      this.date = this.pessoaFisicaInfo.data_nascimento
      this.genero = this.pessoaFisicaInfo.genero
      this.estadoCivil = this.pessoaFisicaInfo.estado_civil
      this.paisNacionalidade = this.pessoaFisicaInfo.endereco.pais
    },
    sendStep(value){
      let payload = {
        name: this.name,
        nascimento: this.date,
        genero: this.genero,
        estadoCivil: this.estadoCivil,
        paisNacionalidade: this.paisNacionalidade
      }
      this.$emit('handlePayload', payload)
      this.$emit('handleStep', value)
    },
    getActualPic(){
      this.$store.dispatch(actionTypes.UPDATE_USER_PIC)
    },
    deleteUserPic(file){
      if(file.status!='error'){
        this.$store.dispatch(actionTypes.DELETE_USER_PIC)
      }
    }
  }
}
</script>