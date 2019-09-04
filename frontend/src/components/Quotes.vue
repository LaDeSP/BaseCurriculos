<template>
    <div>
        <button class="btn btn-primary" @click="onGetQuotes">Get Quotes</button>
        <hr>
        <!-- salva as quotes em um array e depois loop -->
        <!--uso qt pra passar a quote pra iteração no caso seria p {{quote}}-->
        <!-- no entanto, qt nao é "bindable", nao determinei ele como parametro
        lá no componente de single quote, então tenho q ir lá colocar qt como props pra falar q 
        ele está esperando um parametro -->
        <single-quote 
            v-for="quote in quotes" :key="quote.id" :qt="quote" 
            @quoteDeleted="onQuoteDeleted($event)">
        </single-quote>
        <!-- sei q o evento quoteDeleted me passou um id pra verificar, pego ele por $event-->
    </div>
</template>

<script>
    import Quote from './Quote.vue';
    import axios from 'axios';

    export default {
        data(){
            return{
                quotes: []
            }
        },
        methods: {
            onGetQuotes(){
                
                axios.get('http://localhost:8000/api/quotes')
                    .then(
                        response => {
                            //console.log(response);
                            this.quotes = response.data.quotes;
                        }
                    )
                    .catch(
                        error => console.log(error)
                    );
            },
            onQuoteDeleted(value){
                //vou pegar index do elemento q foi deletado
                const position = this.quotes.findIndex((element) => {
                    //true or false, é esse o elemento q vc quer ou não? se for igual, manda ele
                    return element.id == id;
                });

                this.quotes.splice(position, 1);
            }
        },
        components:{
            'single-quote': Quote
        }
    }
</script>