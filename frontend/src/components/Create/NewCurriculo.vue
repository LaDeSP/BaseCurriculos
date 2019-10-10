<template>
    <form-wizard>
  <tab-content title="Personal details">
    My first tab content
  </tab-content>
  <tab-content title="Additional Info">
      My second tab content
   </tab-content>
   <tab-content title="Last step">
     Yuhuuu! This seems pretty damn simple
   </tab-content>
</form-wizard>
</template>

<script>
export default {
  name: 'demo',
  data(){
    return {
      steps: [
        {
          label: 'Informações Pessoais',
          slot: 'page1',
        },
        {
          label: 'Contato',
          slot: 'page2',
        },
        {
          label: 'Endereço',
          slot: 'page3',
        },
        {
          label: 'Dados Empregadícios',
          slot: 'page4',
        },
      ],
        voltar: 'Voltar',
        prosseguir: 'Prosseguir',
        salvar: 'Salvar',

        nome: '',
        nascimento: '',
        genero: '',
        rua: '',
        numero: '', 
        complemento: '',
        bairro: '',
        cidade: '',
        cep: '',
        celular: '',
        fixo: '',
        facebook: '',
        twitter: '',
        linkedin:'',
        site: '',
        outraRede: '',
        objetivos: '',
        area: '',
        pretensao: '',
        qualificacoes: '',
        historicoProfissional: '',
        emailAlt: '',
        estadoCivil: '',
        pais: '',
        estado: '',
        escolaridade: '',
        uri: 'http://localhost:8000/api/curriculos',
        token: this.$session.get('jwt'),
        editing: false,
        areas: [],
        notificacoes: []
    };
  },
  methods: {
    nextClicked(currentPage) {
      console.log('next clicked', currentPage)
      return true; //return false if you want to prevent moving to next page
    },
    backClicked(currentPage) {
      console.log('back clicked', currentPage);
      return true; //return false if you want to prevent moving to previous page
    },
    register(){

        this.axios.post(this.uri + '?token=' + this.token,

        {
            nome: this.nome,
            nascimento: this.nascimento,
            genero: this.genero,
            rua: this.rua,
            bairro: this.bairro,
            cidade: this.cidade,
            numero: this.numero,
            complemento: this.complemento,
            cep: this.cep,
            celular: this.celular,
            fixo: this.fixo,
            facebook: this.facebook,
            twitter: this.twitter,
            site: this.site,
            outraRede: this.outraRede,
            objetivos: this.objetivos,
            area: this.area,
            pretensao: this.pretensao,
            qualificacoes: this.qualificacoes,
            historicoProfissional: this.historicoProfissional,
            estadoCivil: this.estadoCivil,
            pais: this.pais,
            estado: this.estado,
            escolaridade: this.escolaridade,
            emailAlt: this.emailAlt,
            linkedin: this.linkedin,
            user_id: this.$session.get('user_id')
        },
        {headers: {'X-Requested-With': 'XMLHttpRequest'}})
        .then(response => {
            if(response.data.error  != undefined){
                this.notificacoes = response.data.error;
                return;
            }
        })
        .catch(
            (error) => console.log(error)
        );
    },
    verifyEdit(){

        if(this.$route.params.editing === true){
            this.editing = true;
            this.loadDataEdit();
        }
        console.log('verifyedit:', this.editing);
    },

    edit(){

        const user_id = this.$session.get('user_id');
        this.axios.put(this.uri + '/' + user_id + '?token=' + this.token,

            {
                nome: this.nome,
                nascimento: this.nascimento,
                genero: this.genero,
                rua: this.rua,
                bairro: this.bairro,
                cidade: this.cidade,
                cep: this.cep,
                celular: this.celular,
                fixo: this.fixo,
                facebook: this.facebook,
                twitter: this.twitter,
                site: this.site,
                outraRede: this.outraRede,
                objetivos: this.objetivos,
                area: this.area,
                pretensao: this.pretensao,
                qualificacoes: this.qualificacoes,
                historicoProfissional: this.historicoProfissional,
                estadoCivil: this.estadoCivil,
                pais: this.pais,
                estado: this.estado,
                escolaridade: this.escolaridade,
                emailAlt: this.emailAlt,
                linkedin: this.linkedin
            },
            {headers: {'X-Requested-With': 'XMLHttpRequest'}})
            .then(response => {
                if(response.data.error  != undefined){
                    this.notificacoes = response.data.error;
                    return;
                }
            })
            .catch(
                (error) => console.log(error)
            );
    },

    loadArea(){

        this.axios.get('http://localhost:8000/api/areas?token=' + this.token)

            .then(response => {
                this.areas = response.data.areas
                this.nome = this.$session.get('name');
            })
            .catch(
                error => console.log(error)
            );
    },
    loadDataEdit(){

        const user_id = this.$session.get('user_id');
        const curriculo_id = this.$route.params.curriculo_id;

        this.axios.get(this.uri + '/' + user_id + '?token=' + this.token)
            .then(response=>{

                console.log('TESTE', response.data.fisica[0].user.name);
                this.nome = response.data.fisica[0].user.name;
                this.pretensao = response.data.curriculo[0].pretensao;
                this.rua = response.data.fisica[0].endereco.rua;
                this.bairro = response.data.fisica[0].endereco.bairro;
                this.cidade = response.data.fisica[0].endereco.cidade;
                this.cep = response.data.fisica[0].endereco.cep;
                this.celular = response.data.fisica[0].contato.celular;
                this.fixo = response.data.fisica[0].contato.fixo;
                this.facebook = response.data.fisica[0].contato.facebook;
                this.twitter = response.data.fisica[0].contato.twitter;
                this.site = response.data.fisica[0].contato.site;
                this.outraRede = response.data.fisica[0].contato.outraRede;
                this.emailAlt = response.data.fisica[0].contato.emailAlt;
                this.linkedin = response.data.fisica[0].contato.linkedin;
                this.objetivos = response.data.curriculo[0].objetivos;
                this.qualificacoes = response.data.curriculo[0].qualificacoes;
                this.historicoProfissional = response.data.curriculo[0].historicoProfissional;
                this.estadoCivil = response.data.fisica[0].estadoCivil;
                this.pais = response.data.curriculo[0].pais;
                this.estado = response.data.curriculo[0].estado;
                this.escolaridade = response.data.curriculo[0].escolaridade;
                this.genero = response.data.curriculo[0].fisica.genero;
            })
            .catch(
                error => console.log(error)
            );
    }

        },
        created() {
            this.verifyEdit();
            this.loadArea();
        }
};
</script>