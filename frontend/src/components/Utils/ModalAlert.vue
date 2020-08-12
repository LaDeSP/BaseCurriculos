<template>
<v-dialog v-model="dialog" max-width="700px">
  <template v-slot:activator="{on: evento, attrs}">
    <v-btn
      color="red lighten-1 white--text" 
      v-bind="attrs"
      v-on="evento"
    >
      {{payload.title}}
    </v-btn>
  </template>
  <v-card>
      <v-card-title class="red lighten-1 white--text">
        <h3 class="text-center">{{payload.title}}</h3>
      </v-card-title>
        <v-card-text class="text-justify my-5 justify-center text-center">
            <slot>
              Texto do Modal Alert
            </slot>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn class="ml-1" color="red lighten-1 white--text"  @click="dialog = false">{{payload.title}}</v-btn>
          <v-btn class="ml-1" color="grey white--text"  @click="dialog = false">Voltar</v-btn>
        </v-card-actions>
  </v-card>
</v-dialog>
</template>

<script>
export default {
    props:{
      payload: Object
    },
    data(){
        return{
          dialog: false
        }
    },
    created(){
      //console.log('this ', this.payload)
    },
    methods:{
      closeDialog(){
        this.dialog = false
      }
    }
}
</script>
