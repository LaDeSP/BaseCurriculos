<template>
<v-dialog v-model="dialog" max-width="800px">
  <template v-slot:activator="{on: evento, attrs}">
    <v-btn
      color="default darken-1" 
      v-bind="attrs"
      v-on="evento"
    >
      Ver mais
    </v-btn>
  </template>
  <v-card>
      <v-card-title>
        <h3 class="text-center">Detalhes do Candidato</h3>
      </v-card-title>
        <v-card-text class=" text-justify">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, voluptates. Quasi repellendus adipisci molestias dicta, nobis nisi eveniet, officia, rem consequuntur facere eius recusandae aut! Non ut voluptatem fugiat quaerat!
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi totam et autem officia aliquid nulla ipsa deserunt cupiditate, est voluptatem nesciunt harum cum ipsam veniam quis reprehenderit quae distinctio ullam.
          <p> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repudiandae natus dolorum ipsum sapiente cupiditate! Earum eveniet ad minus labore eligendi vel, quasi non, commodi quos tenetur, iste dolorem vitae mollitia! </p>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn class="ml-1" color="red lighten-2 white--text"  @click="dialog = false">Recusar Candidato</v-btn>
          <v-btn class="ml-1" color="info white--text"  @click="dialog = false">Agendar Entrevista</v-btn>
        </v-card-actions>
  </v-card>
</v-dialog>
</template>

<script>
export default {
    components:{},
    data(){
        return{
            dialog: false
        }
    },
    created(){
        console.log('this.route', this.$route)
    },
    methods:{
      closeDialog(){
        this.dialog = false
      }
    }
}
</script>
