<template>
  <v-container v-if="hasAccess">
    <v-alert
      v-model="alert"
      border="left"
      close-text="Close Alert"
      color="success"
      dark
      dismissible
      >
      {{ $route.params.message }}
    </v-alert>
    <v-card>
      <v-card
        min-height="500"
        elevation="0"
        >
        <v-row>
          <v-col class="mt-n3">
            <v-banner
              single-line
              outlined

            >
              <v-icon
                slot="icon"
                color="warning"
              >
                mdi-book-search-outline
              </v-icon>
              View Item Expense
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="addData"
                >
                  <span class="d-none d-md-flex">Add Item Expense</span>
                  <v-icon >
                    mdi-notebook-plus-outline
                  </v-icon>
                </v-btn>
              </template>
            </v-banner>
          </v-col>
        </v-row>
        <v-container>
          <v-card>
            <v-card-title>
              <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
                >
              </v-text-field>
            </v-card-title>
            <v-data-table
              :headers="headers"
              :items="itemOrders"
              :search="search"
              >
              <template v-slot:item.enterdate="{ item }">
                {{ formatDate(item.enter_date) }}
              </template>
              <template v-slot:item.edit="{ item }">
                <v-btn
                  color="primary"
                  text
                  small
                  @click="editData(item.id)"
                >
                  <v-icon>
                    mdi-square-edit-outline
                  </v-icon>
                </v-btn>
              </template>
            </v-data-table>
          </v-card>
        </v-container>
      </v-card>
    </v-card>
    <v-overlay 
      :value="overlay"
      z-index="300"
      >
      <v-progress-circular
        indeterminate
        size="64"
      ></v-progress-circular>
    </v-overlay>
  </v-container>
</template>
<script>
  import transformKeys from '../../../utils/transformKeys';
  export default {
    data: () => ({
      permission: 'item',
      alert: false,
      search: '',
      headers: [
                { text: 'Item Name', value: 'item' },
                { text: 'Date', value: 'enterdate' },
                { text: 'Commission', value: 'comm' },
                { text: 'P Hamali', value: 'p_hamali' },
                { text: 'B Hamali', value: 'b_hamali' },
                { text: 'P Levy', value: 'p_levy' },
                { text: 'B Levy', value: 'b_levy' },
                { text: 'Apmc', value: 'apmc' },
                { text: 'TDS', value: 'tds' },
                { text: 'MAP Levy', value: 'map_levy' },
                { text: 'Discount', value: 'discount' },
                { text: 'Tolai', value: 'tolai' },
                { text: 'Edit', value: 'edit' },
                { text: 'Status', value: 'status' },
              ],
      itemOrders: [],
      overlay: false,
    }),
    created(){
       this.index();
    },
    methods: {
              addData(){
                this.$router.push({name:'add-itemexp'});
              },
              index()
              {

                this.overlay = true;
                axios.get(`itemexp`)
                     .then(resp => {
                      this.overlay = false;
                      this.itemOrders = resp.data.data;
                      if (this.$route.params.message) {
                        this.alert = true;
                      }
                    })
                     .catch(err => {
                      Exception.handle(err, 'admin');
                      this.overlay = false;
                    });

              },
              
              editData(id){
                this.$router.push({name:'add-itemexp', params:{orderid:id}});
              },
              
        }
  }
</script>
