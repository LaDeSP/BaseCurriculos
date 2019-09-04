<template>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Solicitação de estágio</h2></div>
        <div class="panel-body">
              <div class="row justify-content-center">
                <div class="col-sm-6">
                    <form>
                        <p style="color: red;"><strong>Obs: Só faça a solicitação caso todos os termos tenham sido previamente acordados.</strong></p>
                    
                        <div class="form-group">
                            <label for="nome">Nome Completo</label>
                            <input type="nome" id="nome" name="nome" 
                            class="form-control" v-model="nome">
                        </div>
                    
                        <div class="form-group"> 
                            <label for="nascimento">Data de Nascimento</label>
                            <input type="date" class="form-control" name="nascimento" v-model="nascimento">
                        </div>
                        <div class="form-group"> 
                            <label for="cpf">CPF</label>
                            <input type="text" class="form-control" name="cpf" placeholder="Ex. 999.999.999-99" v-model="cpf">
                        </div>
                         <div class="form-group"> 
                            <label for="rg">RG</label>
                            <input type="text" class="form-control" name="rg" v-model="rg">
                        </div>
                        <div class="form-group">
                            <label for="rg">RGA</label>
                            <input type="text" class="form-control" name="rg" placeholder="RG" v-model="rga">
                        </div>
                        <div class="form-group"> 
                            <label for="telefone">Telefone</label>
                            <div class="form-row">
                                <div class="col-6">
                                    <input type="text" class="form-control" name="fixo" placeholder="Fixo" v-model="fixo">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" name="celular" placeholder="Celular" v-model="celular"> 
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group"> 
                            <label for="estagioInicio">Data de Início do Estágio</label>
                            <input type="date" class="form-control" name="estagioInicio" v-model="estagioInicio">
                        </div>
                        <div class="form-group"> 
                            <label for="estagioFinal">Data de Encerramento</label>
                            <input type="date" class="form-control" name="estagioFinal" v-model="estagioFinal">
                        </div>
                        <div class="form-group"> 
                            <label for="carga">Carga Horária</label>
                            <input type="text" class="form-control" name="carga" v-model="carga">
                        </div>
                        <div class="form-group">
                            <label for="tarefas">Planejamento de tarefas</label>
                            <textarea class="form-control" id="tarefas" rows="5" v-model="tarefas"></textarea>
                        </div>
                        <label for="termo">Termo de Compromisso</label>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file">
                                <label class="custom-file-label" for="customFile">Selecione seu documento</label>
                            </div>
                        </div>
                    
                        <button @click.prevent="register" type="submit" class="btn btn-warning">Enviar Solicitação</button>
                        <router-link to="/dashboard/aluno" class="btn btn-danger">Cancelar</router-link>
                    </form>
                </div>
            </div>
        </div>        
    </div>
</template>

<script>
    import axios from 'axios';
    import moment from 'moment'
    export default {
        data(){
            return{

                nome: '',
                nascimento: '',
                cpf: '',
                rga: '',
                rg: '',
                fixo: '',
                celular: '',
                estagioInicio: '',
                estagioFinal: '',
                tarefas: '',
                carga: '',
                status: 'PENDENTE'
            }
        },
        methods: {

            register(){
                const token = localStorage.getItem('token');
                const aluno_id = localStorage.getItem('aluno_id')
                const vaga_id = this.$route.params.id;
                const coor_id = localStorage.getItem('cord_id');
                const super_id = localStorage.getItem('sup_id');
                console.log(aluno_id)
                axios.post('http://localhost:8000/api/solicitacao/' + vaga_id + '?token=' + token, 
               
                    {
                       
                        nome: this.nome,
                        nascimento: this.nascimento,
                        cpf: this.cpf,
                        rg: this.rg,
                        celular: this.celular,
                        fixo: this.fixo,
                        rga: this.rga,
                        estagioInicio: this.estagioInicio, 
                        estagioFinal: this.estagioFinal,
                        tarefas: this.tarefas,
                        status: this.status,
                        coor_id: coor_id,
                        aluno_id: aluno_id,
                        super_id: super_id,
                        carga: this.carga
                    },
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => console.log(response),
                       
                       alert("Solicitação feita com sucesso"),
                    )
                    .catch(
                        (error) => console.log(error)
                    );

                    this.$router.push({ name: 'ALUDash' })
                   
                    
            }
        },
       
    }
</script>

