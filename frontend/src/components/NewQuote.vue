<template>
    
    <form @submit.prevent="onSubmitted">
        <div class="form-group">
            <!--content of the quote-->
            <label for="content">Content</label>
            <input type="text" id="content" class="form-control" v-model="quoteContent">
        </div>
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>

</template>

<script>
    import axios from 'axios';

    export default {
        
        data() {
           
           return {
               quoteContent: ''
            }
        },
        methods: {
            //submit prevent evita de ser o submit padrao e ao inves disso, faz esse metodo
            onSubmitted(){
                //vee-validate pra validações dps vejo isso
                //url do beck
            
                // vv pega o token que foi salvo na hora do login, pra poder enviar como parametro pras rotas protegidas
                const token = localStorage.getItem('token');
                //a variável, que é o name="" q chega no beck, recebe o metodo que pegou o submit do usuario
                axios.post('http://localhost:8000/api/quote?token=' + token, 
                // ^^^ manda o token como parametro q nem no postman
                    {content: this.quoteContent})
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
