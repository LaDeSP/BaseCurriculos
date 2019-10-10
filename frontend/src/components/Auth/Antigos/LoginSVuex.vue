<template>
<div class="container">
<div class="row justify-content-center" >
    <div class="col-sm-8">
            <div class="form-group input-group margin-bottom-sm">
                <span class="input-group-text"><i class="fas fa-envelope fa-fw"></i></span>
                <input placeholder="Email" type="email"  name="email" class="form-control" required = "autofocus" v-model="email">
            </div>

            <div class="form-group input-group">
                <span class="input-group-text"><i class="fa fa-key fa-fw"></i></span>
                <input placeholder="Senha" type="password" name="password"
                class="form-control" v-model="password" required = "autofocus">
            </div>

    </div>
            <div class="col-sm-3 text-right" style="padding-left: 35px;">
              <slot name="icone">
                <i class="far fa-user fa-5x login-icon"></i>
              </slot>
            </div>
            <div class="modal-footer text-center">
              <button @click.prevent="login" type="submit" class="btn btn-lg btn-primary">Entrar</button>
            </div>


</div>
</div>
</template>

<script>

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
                
                    {email: this.email, password: this.password},
                    {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                    .then(
                        (response) => {
                         
                            this.$session.start(),
                            this.$session.set('jwt', response.data.token),
                            this.$session.set('name', response.data.name),
                            this.$session.set('role', response.data.role),
                            this.$session.set('user_id', response.data.user_id),
                            localStorage.setItem('auth_success', true);
                            console.log(response);
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



