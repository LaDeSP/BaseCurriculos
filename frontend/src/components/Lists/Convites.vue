<template>
    <div class="container" v-if="permissaoDoUsuario === 'FISICA'">
        <div v-if="displayConvites.length==0">
            <h1>Você ainda não tem convites.</h1> 
        </div>
        <div class="card-group" v-else>
            <div class="col-lg-12">
                <div class="row">
                    <Card class="col-sm-6" v-for="convite in pageOfItems" :key="convite.id" :id="convite.id">
                        <template v-slot:card-header>
                        <h3><span class="label label-info " style="color: #4E73DF;">{{convite.id}}</span></h3>
                        </template>
                        <template v-slot:card-body>
                        
                        </template>
                        <template v-slot:card-footer>
                            
                        </template>
                    </Card>
                    
                </div>
            </div>
        </div>
        <div v-if="displayConvites.length > 10">
             <jw-pagination :items="displayConvites" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
        </div>
        <div class="display-none" v-else>
            <jw-pagination :items="displayConvites" @changePage="onChangePage" :pageSize="10" :labels="customLabels"></jw-pagination>
        </div>
    </div>
</template>
<script>
import Card from '../Utils/Card';
import Modal from '../Utils/ModalOld';
import { mapActions, mapGetters } from 'vuex';
import JwPagination from 'jw-vue-pagination';
import { BAlert } from 'bootstrap-vue'

const customLabels = {
    first: 'Primeira',
    last: 'Última',
    previous: 'Anterior',
    next: 'Próxima'
};

export default {
    data(){
        return{
            pageOfItems: [],
            customLabels,
            isModalWarning: false,
            isModalShowMore: false,
            isModalSuccess: false,
            isModalError: false,
            isModalMultipleInvite: false,
        }
    },
    components: {Card, JwPagination, Modal, BAlert},

    computed:{
        ...mapGetters([
            'displayConvites', 'permissaoDoUsuario'
        ]),
    },

    methods: {
        ...mapActions([
            'getConvitesFisica'
        ]),

        onChangePage(pageOfItems) {
            // update page of items
            this.pageOfItems = pageOfItems;
        },
    },
    
    created(){
        this.getConvitesFisica();
    }
}

</script>