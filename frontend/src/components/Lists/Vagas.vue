<template>
<span v-if="isFetching">
 <center><h1>
    Carregando...  <span class="fas fa-spinner fa-pulse"></span>
 </h1></center>
</span>
<span v-else>
<div class="row justify-content-center">
    <div class="col-md-9">
      <div class="row">
        <template v-if="permissaoDoUsuario === 'JURIDICA'">
            <div class="col-4">
              <div class=" bd-highlight">
                  <router-link
                    v-bind:to="'/dashboard/'"
                    tag="button"
                    class="btn btn-md btn-outline-secondary">
                    <i class="fas fa-home fa-sm"></i> Home
                  </router-link>
              </div>
            </div>
            <div class="col-4">
              <div class=" bd-highlight">
                <h2>Minhas Vagas</h2>
              </div>
            </div>
        </template>
      </div>
      <br />
      <template v-if="permissaoDoUsuario === 'JURIDICA'">
        <div class="d-flex flex-row bd-highlight mb-3">
          <div class="p-2 flex-fill bd-highlight">
            <div class="btn-group btn-group-sm" role="group">
              <button
                @click="changeActiveButton('ativa')"
                type="button"
                class="active btn btn-outline-success">
                Vagas Ativas
              </button>
              <button
                @click="changeActiveButton"
                type="button"
                class="btn btn-outline-secondary"
              >Vagas Inativas</button>
            </div>
          </div>
          <div class="p-2 bd-highlight">
             <div class="btn-group btn-group-sm" role="group">
              <button @click="onCreate" type="button" class="btn btn-primary">
                  Criar Vaga
                  <span>
                    <i class="fa fa-plus"></i>
                  </span>
              </button>
            </div>
           </div>
        </div>
      </template>
      <br />
      <br />

        <span v-if="filterState == true && pageOfItems.length == 0">
        <h3>Não há nenhuma vaga ativa. </h3>
        </span>
        <span v-else-if="filterState == false && pageOfItems.length == 0">
          <h3>Não há nenhuma vaga inativa. </h3>
        </span>
        <div class="card-deck">
          <div class="col-lg-12">
          <div class="row">
            <div v-for="vaga in pageOfItems" :key="vaga.id" :id="vaga.id">
              <template v-if="permissaoDoUsuario === 'JURIDICA'">
                <Card class="col-sm-5 mb-2 ml-2" >
                  <template v-slot:card-header>
                    <h3 class="card-title" style="color: #4E73DF;">
                      {{vaga.titulo}}
                    </h3>
                  </template>
                  <template v-slot:card-body>
                      <strong>Descrição:</strong>
                      {{vaga.descricao}} <br><br>
                      <strong>Cargo:</strong>
                      {{vaga.cargo}}<br><br>
                      <strong>Quantidade:</strong>
                      {{vaga.quantidade}}<br><br>
                      <strong>Área de Atuação:</strong>
                      {{vaga.area.tipo}}<br><br>
                      <strong>Salário:</strong>
                      {{vaga.salario}}<br><br>
                      <strong>Jornada de Trabalho:</strong>
                      {{vaga.jornada}}<br><br>
                      <strong>Benefícios:</strong>
                      {{vaga.beneficio}}<br><br>
                      <strong>Requisitos:</strong>
                      {{vaga.requisito}}<br><br>
                  </template>
                  <template v-slot:card-footer>
                    <div>
                      <button @click="onEdit(vaga.id)" class="btn btn-sm btn-warning">
                        <h6 class="card-text">Editar</h6>
                      </button>
                      <span v-if="filterState">
                        <button
                          @click="changeStatus(vaga.id, 'INATIVA')"
                          class="btn btn-sm btn-outline-secondary"
                        >
                          <h6 class="card-text">Desativar</h6>
                        </button>
                      </span>
                      <span v-else>
                        <button
                          @click="changeStatus(vaga.id, 'ATIVA')"
                          class="btn btn-sm btn-outline-success"
                        >
                          <h6 class="card-text">Ativar</h6>
                        </button>
                      </span>
                      <button @click="showModal('warning', vaga.id)" class="btn btn-sm btn-danger">
                        <h6 class="card-text">Deletar</h6>
                      </button>
                      <Modal v-show="isModalWarning" @close="closeModal">
                        <template v-slot:header>
                          <h3>Deletar Vaga</h3>
                        </template>
                        <template v-slot:body>
                          <h2 class="text-center">
                            Tem certeza de que deseja
                            <span style="color: #ff0000">
                              <strong>deletar</strong>
                            </span>
                            essa vaga?
                          </h2>
                        </template>
                        <template v-slot:footer>
                          <div>
                            <button @click="onDelete" class="btn btn-lg btn-danger">Sim</button>
                            <button @click="closeModal" class="btn btn-lg btn-success">Não</button>
                          </div>
                        </template>
                      </Modal>
                    </div>
                  </template>
                </Card>
              </template>
            </div>
          </div>
        </div>
      </div>
      <br />
      <br />
      <div class="row no-gutters align-items-center">
        <div class="col-11" v-if="isActive.length > 4">
          <center>
            <jw-pagination
              :items="isActive"
              @changePage="onChangePage"
              :pageSize="4"
              :labels="customLabels"
              v-if="permissaoDoUsuario === 'JURIDICA'"
            ></jw-pagination>
          </center>
        </div>
        <div class="col-11 display-none" v-else>
          <center>
            <jw-pagination
              :items="isActive"
              @changePage="onChangePage"
              :pageSize="4"
              :labels="customLabels"
              v-if="permissaoDoUsuario === 'JURIDICA'"
            ></jw-pagination>
          </center>
        </div>
      </div>
      <br />
      <br />
      <template v-if="permissaoDoUsuario === 'FISICA'">
        <div
          v-for="vaga in pageOfItems"
          :key="vaga.id"
          :id="vaga.id"
          @vagaDeleted="onVagaDeleted($event)"
        >
          <List>
            <template v-slot:list-header>
              <h3 class="mb-1" style="color: #4E73DF;">{{vaga.titulo}}</h3>
            </template>
            <template v-slot:list-body>
              <p class="mb-1">
                <strong>Cargo:</strong>
                {{vaga.cargo}}
              </p>
              <p class="mb-1">
                <strong>Área de Atuação:</strong>
                {{vaga.area.tipo}}
              </p>
              <p class="mb-1">
                <strong>Jornada de Trabalho:</strong>
                {{vaga.jornada}}
              </p>
            </template>
            <template v-slot:list-footer>
              <button @click="showModal('else', vaga.id)" class="btn btn-sm btn-default">Ver mais</button>
              <template v-if="dataCompleted">
                <button @click="onRequest(vaga.id)" class="btn btn-sm btn-success">Se Candidatar</button>
              </template>
              <template v-else>
                <router-link
                  to="/new-curriculo"
                  class="btn btn-sm btn-info"
                >Preencha seu currículo para se candidatar!</router-link>
              </template>
              <Modal v-if="isModalShowMore" @close="closeModal">
                <template v-slot:header>
                  <h3>Detalhes da Vaga</h3>
                </template>
                <template v-slot:body>
                  <h3 class="mb-1" style="color: #4E73DF;">{{vagaById[0].titulo}}</h3>
                  <strong>Descrição:</strong>
                  {{vagaById[0].descricao}}
                  <strong>Cargo:</strong>
                  {{vagaById[0].cargo}}
                  <strong>Área de Atuação:</strong>
                  {{vagaById[0].area.tipo}}
                  <strong>Jornada de Trabalho:</strong>
                  {{vagaById[0].jornada}}
                  <strong>Salário:</strong>
                  {{vagaById[0].salario}}
                  <strong>Benefícios:</strong>
                  {{vagaById[0].beneficio}}
                  <strong>Requisitos:</strong>
                  {{vagaById[0].requisito}}
                </template>
                <template v-slot:footer>
                  <button @click="closeModal" class="btn btn-sm btn-outline-default">Voltar</button>
                  <div v-if="dataCompleted">
                    <button @click="onRequest(vaga.id)" class="btn btn-sm btn-success">Se Candidatar</button>
                  </div>
                  <div v-else>
                    <router-link
                      to="/new-curriculo"
                      class="btn btn-sm btn-info"
                    >Preencha seu currículo para se candidatar!</router-link>
                  </div>
                </template>
              </Modal>
            </template>
          </List>
          <br />
        </div>
        <br />
        <br />
        <div class="row">
          <div class="col-11" v-if="isActive.length > 4">
            <center>
              <jw-pagination
                :items="isActive"
                @changePage="onChangePage"
                :pageSize="4"
                :labels="customLabels"
              ></jw-pagination>
            </center>
          </div>
          <div class="col-11 display-none" v-else>
            <center>
              <jw-pagination
                :items="isActive"
                @changePage="onChangePage"
                :pageSize="4"
                :labels="customLabels"
              ></jw-pagination>
            </center>
          </div>
        </div>
        <br />
        <br />
      </template>
    </div>
  </div>
</span>

</template>


<script>
import Card from "../Utils/CardsVagas";
import Modal from "../Utils/ModalOld";
import List from "../Utils/List";
import painel from "../Utils/Painel";
import { mapActions, mapGetters, mapState } from "vuex";
import JwPagination from "jw-vue-pagination";
const customLabels = {
  first: "Primeira",
  last: "Última",
  previous: "Anterior",
  next: "Próxima"
};

export default {
  data() {
    return {
      vagas: [],
      vaga_id: 0,
      filterState: true,
      isModalWarning: false,
      isModalShowMore: false,
      pageOfItems: [],
      customLabels
    };
  },
  components: { Card, Modal, List, painel, JwPagination },
  methods: {
    ...mapActions(["loadVagasJuridica"]),

    onChangePage(pageOfItems) {
      // update page of items
      this.pageOfItems = pageOfItems;
    },

    showModal(modal, vaga_id) {
      if (modal === "warning") {
        this.isModalWarning = true;
        this.vaga_id = vaga_id;
      } else {
        this.isModalShowMore = true;
        this.vaga_id = vaga_id;
      }
    },

    closeModal() {
      this.isModalWarning = false;
      this.isModalShowMore = false;
    },

    onCreate() {
      this.$session.set("editing", false);
      this.$router.push({ name: "new-vaga" });
    },

    onEdit(vaga_id) {
      this.$session.set("editing", true);
      this.$session.set("vaga_id", vaga_id);
      this.$router.push({ name: "new-vaga" });
    },

    onRequest(id) {
      let vaga_id = 0;
      if (this.vaga_id != 0) {
        vaga_id = this.vaga_id;
      } else {
        vaga_id = id;
      }

      let requestVaga = {
        vaga_id: vaga_id,
        user_id: this.$store.state.auth.user.id
      };
      this.$store
        .dispatch("requestVaga", requestVaga)
        .then(response => {
          this.isModalShowMore = false;
        })
        .catch(error => console.log(error));
    },

    changeStatus(id, status) {
      let newStatus = {
        vaga_id: id,
        status: status
      };
      this.$store
        .dispatch("changeStatusVaga", newStatus)
        .then(response => {})
        .catch(error => console.log(error));
    },

    async onDelete() {
      await this.$store
        .dispatch("deleteVaga", this.vaga_id)
        .then(response => {
          this.isModalWarning = false;
        })
        .catch(error => console.log(error));
    },

    changeActiveButton(status) {
      $(".btn-group").on("click", ".btn", function() {
        $(this)
          .addClass("active")
          .siblings()
          .removeClass("active");
      });
      if (status === "ativa") {
        this.filterState = true;
      } else {
        this.filterState = false;
      }
    }
  },

  computed: {
    isActive() {
      if (this.permissaoDoUsuario === "FISICA") {
        return this.displayVagasJuridica.filter(vaga => {
          return vaga.status === "ATIVA";
        });
      } else {
        if (this.filterState === true) {
          return this.displayVagasAtivas
        } else {
          return this.displayVagasInativas
        }
      }
    },

    ...mapState([
      'isFetching'
    ]),

    ...mapGetters([
      "displayVagasJuridica",
      "displayVagaById",
      "permissaoDoUsuario",
      "displayVagasAtivas",
      "displayVagasInativas",
      "dataCompleted"
    ]),

    vagaById() {
      return this.displayVagaById(this.vaga_id);
    }
  },

  created() {
    this.loadVagasJuridica();
    console.log('vagas/statetoken', this.$store.state.auth.token)
    console.log('actio', this.displayVagasJuridica)
  }
};
</script>
