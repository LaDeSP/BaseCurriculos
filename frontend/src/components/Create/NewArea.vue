<template>
 <div class="row justify-content-center">
    <div class="col-sm-6">
        <form>
            <h1>Cadastro de Area</h1>
            <div class="form-group">
                <label for="area">Area</label>
                <textarea class="form-control" rows="3" v-model="area"></textarea>
            </div>
           
            <button @click.prevent="register" type="submit" class="btn btn-primary">Cadastrar</button>
            <router-link to="/dashboard" class="btn btn-danger">Cancelar</router-link>
        </form>
    </div>
</div>
</template>

<script>

    export default {
    
        data(){
            return{area: ''}
        },
        methods: {
            register(){
                
                    let uri = 'http://localhost:8000/api/areas'
                    this.axios.post(uri, {
                        area: this.area
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response)
                    )
                    .catch(
                        (error) => console.log(error)
                    );
                }
          
        }
        
    }
</script>

