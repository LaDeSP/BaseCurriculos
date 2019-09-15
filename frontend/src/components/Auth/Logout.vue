<template>

</template>

<script>

    export default {
        methods:{
            onDelete(){
                    const token = this.$session.get('jwt');
                    this.axios.post('http://localhost:8000/api/logout?token=' + token)
                    .then(response => {
                        this.$session.remove('jwt');
                        this.$session.destroy();
                        console.log(response);
                        this.$router.push({ name: 'login' })
                    }, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .catch(
                        error => console.log(error)
                    );
            
            }
        },
        mounted () {
            this.onDelete();
        }
    }
</script>