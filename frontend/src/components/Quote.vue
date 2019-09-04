<template>
    <div class="panel panel-default">
        <div class="panel-body">
            <!-- esse qt é o q ta vindo lá de fora -->
            {{qt.content}}
        </div>
        <div class="panel-footer">
            <!-- only show if edit button, editing is true-->
            <div v-if="editing">
                <input type="text" v-model="editValue">
                <a @click="onUpdate">Save</a>
                <a @click="onCancel">Cancel</a>
            </div>
            <!-- -->
            <div v-if="!editing">
                <a @click="onEdit">Edit</a>
                <a @click="onDelete">Delete</a>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default{
        props: ['qt'],
        data() {
            return {
                //por default, n estamos em modo de edit
                editing: false,
                //inicialmente, terá o conteúdo da quote q escolhi editar
                editValue: this.qt.content
            }
        },
        methods: {
            onEdit(){
                this.editing = true;
                //quando edito, terá o conteúdo q escolhe editar no input
                this.editValue = this.qt.content;
            },
            onCancel(){
                //pra ele sair do modo de edição
                this.editing = false;
            },
            onDelete(){
                const token = localStorage.getItem('token');
                //deletar a quote q eu deletei da tela
                //emit method to emit my own event, é tipo uma verificaçao
                this.$emit('quoteDeleted', this.qt.id); //esse vento será colocado lá no loop do for
                //esse qt é o vetor q to recebendo lá do quotes
                axios.delete('http://localhost:8000/api/quote/' + this.qt.id + '?token=' + token)
                    .then(
                        response => console.log(response)
                    )
                    .catch(
                        error => console.log(error)
                    )
            },
            onUpdate(){
                const token = localStorage.getItem('token');
                //já editei, ou seja, volta ao normal
                //agora quero fazer update da view, troca antigo pelo novo
                this.editing = false;
                //override o antigo pelo novo
                this.qt.content = this.editValue;
                axios.put('http://localhost:8000/api/quote/' + this.qt.id + '?token=' + token, 
                {content: this.editValue})
                    .then(
                        response => console.log(response)
                    )
                    .catch(
                        error => console.log(error)
                    )
            }
        }
    }
</script>

<style scoped>
    a{
        cursor: pointer;
    }
</style>