<template>

</template>

<script>

    export default {
        methods:{
        onLogout(){       
            this.$store.dispatch('logout')
            .then(() => {
            this.$router.push('/login')
            })
        }  
        },
        mounted () {
            this.onLogout();
        }
    }
</script>