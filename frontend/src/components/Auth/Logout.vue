<template>
    <button @click.prevent="onLogout" class="dropdown-item">
        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
        Sair
    </button>
</template>

<script>

    export default {
        methods:{
        onLogout(){       
            this.$store.dispatch('logout')
            .then(() => {
                this.$router.push('/')
            })
        }  
        },
    }
</script>