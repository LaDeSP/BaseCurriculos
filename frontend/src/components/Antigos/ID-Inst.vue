<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Perfil da Instituição</h2></div>
        <div class="panel-body">
            <h1>Perfil do Instituição</h1>
              <div v-for="inst in instituicao" :key="inst.id">
                <h1>Nome: {{inst.nome}}</h1>
                <hr>
                <p>CNPJ: {{inst.cnpj}}</p>
                <p>Telefone: {{inst.telefone}}</p>
                <p>Email: {{inst.email}}</p>
                <p>Site: {{inst.site}}</p>
                <p>Tipo: {{inst.tipo}}</p>
                <p>Campus: {{campus}}</p>
                <p>Endereço: Rua {{inst.endereco.rua}}, Bairro {{inst.endereco.bairro}}</p>
                <p>Cidade: {{inst.endereco.cidade}}</p>
                <p>CEP: {{inst.endereco.cep}}</p>
            </div>  
             <hr>
        </div>
        <div class="panel-footer">
                    <router-link to="/instituicoes" 
                        tag="button" class="btn btn-lg btn-danger">Voltar</router-link>
        </div>   
        <hr>
        <h1>Cursos</h1>
        <div v-if="cursos.length == 0" class="text-center">
            <h4> Ainda não há nenhum curso cadastrado para esta instituição :/ </h4>
        </div>
        <div v-else>
            <cursos :inst_id="inst_id"></cursos>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Cursos from './Cursos.vue';

    export default {
        data(){
            return{
                instituicao: [],
                campus: '',
                cursos: [],
                inst_id: this.$route.params.id
            }
        },
        components: {'cursos': Cursos},
        methods: {

            loadInstituicao(){
                const token = localStorage.getItem('token');
                axios
                    .get('http://localhost:8000/api/instituicao/' + this.$route.params.id + '?token=' + token)
                    .then(response => {
                        this.instituicao = response.data.instituicao,
                        this.campus = response.data.campus,
                        this.cursos = response.data.cursos
                        console.log(this.inst_id);
                    })
                    .catch(
                        error => console.log(error)
                    );
            }
        },
        created(){
            this.loadInstituicao();
        }
       
    }
</script>

