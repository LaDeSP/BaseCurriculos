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
      rulesPeriodo: [value => !!value || 'Esse campo é obrigatório.']
    }
  },
  async created(){
    console.log('no info juridica, edicao?', this.edicao)
    this.name = this.$store.state.auth.user.name
    if(this.edicao){
      await this.loadDataToEdit()
    }
  },
  computed: {
    ...mapState(['pessoaJuridicaInfo'])
  },
  methods: {
    sendStep(value){
      let payload = {
        nome: this.name
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