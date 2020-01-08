<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link
      href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css"
      rel="stylesheet"
    />
    <title>CRUD Vuetify + PHP</title>
  </head>
  <body>
    <div id="app">
      <v-app>
        <v-content>
          <v-container py-10>
            <!-- DataTable -->
            <v-data-table
              :headers="headers"
              :items="products"
              :search="search"
              sort-by="id"
              class="elevation-1 pb-3 px-5"
            >
              <template v-slot:top>
                <v-toolbar flat color="white">
                  <v-toolbar-title>Listado de productos</v-toolbar-title>
                  <v-divider
                  class="mx-4"
                  inset
                  vertical
                ></v-divider>
                <v-spacer></v-spacer>
                  <v-btn color="primary" @click="openDialog"
                    >Crear producto</v-btn
                  >
                </v-toolbar>

                <!-- Search box -->
                <v-col cols="12" sm="12" class="mb-4">
                  <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="¿Desea buscar un producto?"
                    single-line
                    hide-details
                  ></v-text-field>
                </v-col>
              </template>

              <!-- Status column -->
              <template v-slot:item.status="{ item }">
                <v-chip :color="getColor(item.status)" dark
                  >{{ getStatusText(item.status) }}</v-chip
                >
              </template>

              <!-- Actions column -->
              <template v-slot:item.action="{ item }">
                <v-icon small class="mr-2" @click="update(item)"
                  >mdi-pencil</v-icon
                >
                <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
              </template>
            </v-data-table>

            <!-- Dialog -->
            <v-dialog v-model="dialog" max-width="600" persistent>
              <v-card>
                <v-card-title>
                  <span class="headline">Crear nuevo producto</span>
                </v-card-title>
                <v-form ref="formdialog" v-model="valid" lazy-validation class="py-4 px-6">
                  <v-row>
                    <v-col cols="12" sm="12">
                      <v-text-field
                        v-model="name"
                        :rules="[rules.required, rules.name]"
                        label="Nombre del producto"
                      />
                    </v-col>
                  </v-row>
                  <v-row>
                    <v-col cols="12" sm="4" md="2">
                      <v-text-field
                        v-model="quantity"
                        label="Cantidad"
                        type="number"
                        min="0"
                      />
                    </v-col>

                    <v-col cols="12" sm="8"  md="5">
                      <v-select
                        v-model = "status"
                        :items="statuses"
                        item-text="description"
                        item-value="value"
                        return-object
                        :rules="[rules.required]"
                        label="Estado"
                      />
                    </v-col>

                    <v-col cols="12" sm="12" md="5">
                      <v-select
                        v-model = "warehouse"
                        :items="warehouses"
                        item-text= "name"
                        item-value= "id"
                        return-object
                        :rules="[rules.required]"
                        label="Bodega"
                      />
                    </v-col>
                  </v-row>

                  <v-row>
                    <v-col cols="12" sm="12">
                      <v-textarea
                        v-model="remarks"
                        label="Observaciones y/o comentarios"
                        no-resize
                        rows="3"
                      />
                    </v-col>
                  </v-row>

                  <v-row>
                    <v-col
                      cols="12"
                      sm="12"
                      class="d-flex justify-space-between"
                    >
                      <div>
                        <v-btn small text color="error" @click="closeDialog"
                          >Cancelar</v-btn
                        >
                      </div>

                      <div>
                        <v-btn small text @click="clearDialog">Limpiar</v-btn>
                        <v-btn small @click="createProduct" color="primary"
                          >Crear</v-btn
                        >
                      </div>
                    </v-col>
                  </v-row>
                </v-form>
              </v-card>
            </v-dialog>

            <v-snackbar
              v-model="snackbar"
              :timeout="snackbarTimeout"
              :color="snackbarColor"
            >
              {{ snackbarText }}
              <v-btn dark text @click="snackbar = false">Cerrar</v-btn>
            </v-snackbar>
          </v-container>
        </v-content>
      </v-app>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.2/axios.js"></script>   
    <script src="vue.js"></script>
  </body>
</html>
