var url = "connection/crud.php";

new Vue({
  el: "#app",
  vuetify: new Vuetify(),

  data: () => ({
    dialog: false,
    snackbar: false,
    valid: false,
    search: "",
    headers: [
      {
        text: "#",
        value: "id",
        filterable: false
      },
      {
        text: "Producto",
        value: "name"
      },
      {
        text: "Bodega",
        value: "warehouse",
        filterable: false
      },
      {
        text: "Cantidad",
        value: "quantity",
        align: "right",
        filterable: false,
        align: "center"
      },
      {
        text: "Estado",
        value: "status",
        filterable: false,
        align: "center"
      },
      {
        text: "Gestión",
        value: "action",
        sortable: false,
        filterable: false,
        align: "center"
      }
    ],

    id: "",
    name: "",
    quantity: "0",
    warehouse: null,
    status: null,
    remarks: "",
    products: [],
    warehouses: [],
    statuses: [],

    rules: {
      required: value => !!value || "Este campo es requerido",
      name: value =>
        (value && value.length > 4) ||
        "El nombre debe contener al menos 5 carácteres"
    },

    snackbarText: "",
    snackbarTimeout: 2500,
    snackbarColor: ""
  }),

  methods: {
    getColor(status) {
      if (status == 1) return "green";
      else return "red";
    },

    getStatusText(status) {
      if (status == 1) return "Activo";
      else return "Inactivo";
    },

    changeDialogValue() {
      this.dialog = !this.dialog;
    },

    openDialog() {
      this.getStatuses();
      this.getWarehouses();
      this.changeDialogValue();
    },

    clearDialog() {
      this.valid = false;
      this.name = "";
      this.quantity = 0;
      this.statuses = [];
      this.status = null;
      this.warehouses = [];
      this.warehouse = null;
      this.remarks = "";
    },

    closeDialog() {
      this.$refs.formdialog.reset();
      this.changeDialogValue();
    },

    getProducts() {
      axios.post(url, { operation: 4 }).then(response => {
        this.products = response.data;
      });
    },

    getWarehouses() {
      axios.post(url, { operation: 5 }).then(response => {
        this.warehouses = response.data;
      });
    },

    getStatuses() {
      axios.post(url, { operation: 6 }).then(response => {
        this.statuses = response.data;
      });
    },

    createProduct() {
      if (this.valid) {
        axios
          .post(url, {
            operation: 1,
            name: this.name,
            warehouse: this.warehouse.id,
            status: this.status.value,
            quantity: this.quantity,
            remarks: this.remarks
          })
          .then(response => {
            this.getProducts();
            this.closeDialog();
            this.showSnackbar("Producto creado con éxito", "success");
          });
      }
    },

    updateProduct(id, status) {
      axios
        .post(url, {
          operation: 2,
          id: id,
          status: status
        })
        .then(response => {
          this.getProducts();
          this.showSnackbar("Estado del producto actualizado", "success");
        });
    },

    deleteProduct(id) {
      console.log(id);
      axios
        .post(url, {
          operation: 3,
          id: id
        })
        .then(response => {
          this.getProducts();
          this.showSnackbar("Producto eliminado", "error");
        });
    },

    update(item) {
      const index = this.products.indexOf(item);
      var isOk = confirm(
        "El estado del producto será cambiado ¿desea continuar?"
      );

      if (isOk) {
        var newStatus = this.products[index].status == 1 ? 0 : 1;
        this.updateProduct(this.products[index].id, newStatus);
      }
    },

    deleteItem(item) {
      const index = this.products.indexOf(item);
      var isOk = confirm("¿Está seguro de eliminar el producto?");

      if (isOk) {
        this.deleteProduct(this.products[index].id);
      }
    },

    showSnackbar(text, color) {
      this.snackbar = true;
      this.snackbarText = text;
      this.snackbarColor = color;
    }
  },

  created() {
    this.getProducts();
  }
});
