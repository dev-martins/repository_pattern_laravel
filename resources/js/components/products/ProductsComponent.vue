<template>
  <div>
    <div class="d-flex justify-content-end">
      <!-- button modal -->
      <button
        id="modal_open"
        class="btn btn-primary mb-3"
        data-toggle="modal"
        data-target="#myModal"
        @click="cadastro = true"
      >
        <i class="fas fa-plus"></i>
      </button>
    </div>
    <!-- table users -->
    <table
      id="data_table"
      class="table table-striped table-bordered"
      style="width: 100%"
    >
      <thead>
        <tr>
          <th>Nome</th>
          <th>Preço</th>
          <th>Imagem</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.name }}</td>
          <td>{{ money(product.price, 1) }}</td>
          <td style="padding: 0">
            <p class="text-center" style="margin-bottom: 0">
              <img
                src="/vendor/adminlte/dist/img/AdminLTELogo.png"
                alt=""
                width="55px"
              />
            </p>
          </td>
          <td class="btn-group d-flex flex-row justify-content-center">
            <button
              class="btn btn-primary"
              @click="
                editarDados(
                  product.name,
                  product.url,
                  product.description,
                  product.id,
                  money(product.price, 1),
                  product.image
                )
              "
            >
              <i class="far fa-edit"></i>
            </button>
            <button
              class="btn btn-success"
              @click="
                editarDados(
                  product.name,
                  product.url,
                  product.description,
                  product.id,
                  money(product.price, 1),
                  product.image
                )
              "
            >
              <i class="far fa-eye" style="color: white"></i>
            </button>
            <button class="btn btn-danger" @click="deletar(product.id)">
              <i class="far fa-trash-alt"></i>
            </button>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <th>Nome</th>
          <th>Preço</th>
          <th>Imagem</th>
          <th>Ações</th>
        </tr>
      </tfoot>
    </table>
    <!-- The Modal -->
    <div class="modal" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              @click="limparModal()"
            >
              &times;
            </button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <form>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="title" class="col-form-label">Nome:</label>
                    <input
                      type="text"
                      class="form-control"
                      id="title"
                      v-model="name"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="url" class="col-form-label">URL:</label>
                    <input
                      type="text"
                      class="form-control"
                      id="url"
                      v-model="url"
                    />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="description" class="col-form-label"
                      >Categorias:</label
                    >
                    <select class="form-control" v-model="category_selected">
                      <option disabled selected>Escolha uma categoria</option>
                      <option v-for="product in products" :key="product.id" v-bind:value="product.category.id">
                        {{ product.category.title }}
                      </option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="price" class="col-form-label">Preço:</label>
                    <input
                      type="text"
                      class="form-control"
                      id="price"
                      v-model="price"
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="description" class="col-form-label"
                      >Descrição:</label
                    >
                    <textarea
                      v-model="description"
                      class="form-control"
                      id="description"
                      rows="3"
                    ></textarea>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-danger btn-sm"
              data-dismiss="modal"
              @click="limparModal()"
            >
              Cancelar
            </button>
            <button
              v-if="cadastro == true"
              type="button"
              class="btn btn-primary btn-sm"
              @click="createCategory()"
            >
              Salvar
            </button>
            <button
              v-else
              type="button"
              class="btn btn-success btn-sm"
              @click="atualizar()"
            >
              Salvar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueToast from "vue-toast-notification";

Vue.use(VueToast);
var localHost = "http://127.0.0.1:8000";
export default {
  data() {
    return {
      products: [],
      cadastro: true,
      category_selected:"",
      name: "",
      url: "",
      id: "",
      price: "",
      description: "",
      options: {
        year: "numeric",
        month: "numeric",
        day: "numeric",
        hour: "numeric",
        minute: "numeric",
        second: "numeric",
        hour12: false,
        timeZone: "America/Sao_Paulo",
      },
    };
  },
  mounted() {
    this.listCategories();
  },
  methods: {
    loadTable() {
      $("#data_table").DataTable({
        language: {
          lengthMenu: "Exibindo &nbsp _MENU_ &nbsp registros por página",
          zeroRecords: "Nada encontrado - desculpe",
          info: "Mostrando página _PAGE_ de _PAGES_",
          infoEmpty: "Nenhum registro disponível",
          infoFiltered: "(filtrado de _MAX_ registros totais)",
        },
        retrieve: true,
      });
    },
    listCategories: function () {
      window.axios
        .get(`${localHost}/api/v1/products`)
        .then((res) => {
          this.products = res.data;
          setTimeout(() => {
            this.loadTable();
          }, 100);
        })
        .catch((erro) => {
          Vue.$toast.open({
            message: "Ocorreu um erro!",
            type: "error",
            position: "top-right",
            // all of other options may go here
          });
        });
    },
    createCategory() {
      this.sendData = new FormData();
      this.name == "" ? "" : this.sendData.append("name", this.name);
      this.price == "" ? "" : this.sendData.append("price", this.price);
      this.image == "" ? "" : this.sendData.append("image", this.image);
      this.url == "" ? "" : this.sendData.append("url", this.url);
      this.category_selected == ""
        ? ""
        : this.sendData.append("category_id", this.category_selected);
      this.description == ""
        ? ""
        : this.sendData.append("description", this.description);

      window.axios
        .post(`${localHost}/api/v1/products`, this.sendData)
        .then((res) => {
          Vue.$toast.open({
            message: res.data.msg,
            type: "success",
            position: "top-right",
            // all of other options may go here
          });

          this.listCategories();
          this.fecharModal();
        })
        .catch((erro) => {
          Vue.$toast.open({
            message: erro.response.data,
            type: "error",
            position: "top-right",
            // all of other options may go here
          });
        });
    },
    deletar(id) {
      window.axios
        .delete(`${localHost}/api/v1/products/${id}`, this.sendData)
        .then((res) => {
          Vue.$toast.open({
            message: "Categoria removida!",
            type: "success",
            position: "top-right",
            // all of other options may go here
          });
          this.listCategories();
        })
        .catch((erro) => {
          Vue.$toast.open({
            message: "Ocorreu um erro!",
            type: "error",
            position: "top-right",
            // all of other options may go here
          });
        });
    },
    atualizar() {
      window.axios
        .put(`${localHost}/api/v1/products/${this.id}`, {
          name: this.name,
          url: this.url,
          description: this.description,
          price: this.price,
          image: this.image,
        })
        .then((res) => {
          Vue.$toast.open({
            message: "Categoria atualizada!",
            type: "success",
            position: "top-right",
            // all of other options may go here
          });
          this.listCategories();
          this.fecharModal();
        })
        .catch((erro) => {
          Vue.$toast.open({
            message: "Ocorreu um erro!",
            type: "error",
            position: "top-right",
            // all of other options may go here
          });
        });
    },
    fecharModal() {
      $(".close").trigger("click");
    },
    limparModal() {
      this.name = "";
      this.url = "";
      this.description = "";
      this.price = "";
    },
    titleModal(name) {
      $(".modal-title").text(name);
    },
    editarDados(name, url, description, id, price) {
      this.name = name;
      this.url = url;
      this.description = description;
      this.id = id;
      this.price = price;
      this.cadastro = false;
      this.titleModal("Editar dados");
      $("#myModal").modal();
    },
    convertDateTime(date) {
      date = date
        .replace(" ", "-")
        .replace(":", "-")
        .replace(":", "-")
        .replace("T", "-");
      var arr = date.split("-");

      date = new Intl.DateTimeFormat("default", this.options).format(
        new Date(arr[0], arr[1] - 1, arr[2], arr[3], arr[4], arr[5])
      );
      return date;
    },
    loadJs(url, callback) {
      jQuery.ajax({
        url: url,
        dataType: "script",
        success: callback,
        async: true,
      });
    },
    money: function (value, a = 0) {
      if (a == 0) {
        var str = value;
        str = str.replace(",", "");
        var res = str.length - 2;
        res = str.substr(1, 2);
        res =
          str.substr(0, str.length - 2) + "." + str.substr(str.length - 2, 2);
      } else {
        var res = value.toLocaleString("pt-BR", {
          style: "currency",
          currency: "BRL",
        });
      }
      return res;
    },
  },
};
</script>