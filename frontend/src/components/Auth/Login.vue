<template>

<div class="row justify-content-center" >
    <img src="/img/images.png" alt="Usuario" id="login-esp">
    <div class="col-sm-3" id="login-esp">
        <form>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" v-model="email">
            </div>

            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" 
                class="form-control" v-model="password">
            </div>
            <button @click.prevent="login" type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
            <router-link to="/new-fisica" class="btn btn-lg btn-primary btn-block btn-success">Cadastrar - Fisica</router-link>
            <router-link to="/new-juridica" class="btn btn-lg btn-primary btn-block btn-success">Cadastrar - Juridica</router-link>
        </form>
    </div>
</div>    
</template>

<script>

 // import store from './store';

    export default {
    
        data(){
            return{
                email: '',
                password: '',
                loginError: false,
            }
        },
        methods: {
            login(){
                this.loginError = false;
                this.axios.post('http://localhost:8000/api/login', 
                //pra autenticar, precisa de mais uma header
                //essa header só vai dizer pro beck q isso é uma chamada ajax
                    {email: this.email, password: this.password},
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => {
                            //muda o estado com vuex, loginUser() põe isLoggedIn como true
                         //   store.commit('loginUser')
                         // localStorage.setItem('user_id', response.data.user_id),
                            
                            this.$session.start(),
                            this.$session.set('jwt', response.data.token),
                            this.$session.set('name', response.data.name),
                            this.$session.set('role', response.data.role),
                            this.$session.set('user_id', response.data.user_id)

                             console.log(response);

                            /*if(role === 'ADMIN'){
                                //redireciona pra dash do admin
                                this.$router.push({ name: 'ADMDash' })
                            }else if(role === 'COORDENADOR'){
                                const coor_id = response.data.coor_id;
                                localStorage.setItem('coor_id', coor_id);
                                this.$router.push({ name: 'COORDash' })
                            }else if(role === 'SUPERVISOR'){
                                const super_id = response.data.super_id;
                                localStorage.setItem('super_id', super_id);
                                this.$router.push({ name: 'SUPERDash' })
                            }else if(role === 'ALUNO'){
                                const aluno_id = response.data.aluno_id;
                                localStorage.setItem('aluno_id', aluno_id);
                                this.$router.push({ name: 'ALUDash' })
                            } */
                        }
                    )
                    .catch(error => {
                        this.loginError = true
                        console.log(error)

                    }
                    );
            }
        }
    }

</script>
<style>
#login-esp{
    margin-top: 13%;
    margin-left: 40px;
    
}
</style>



