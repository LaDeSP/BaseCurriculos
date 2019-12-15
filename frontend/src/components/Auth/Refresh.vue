<template>
    <div>  
        <h1>INFERNO</h1>
    </div>
</template>
<script>
   
    export default {
        methods:{
            teste(){
                  console.log('state token dentro da funçao teste', this.$store.state.auth.token)
                 this.$store.dispatch("refreshToken")
                    .then(response => {
                      
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        },
        mounted(){
            this.teste();
        }
    }

</script>

