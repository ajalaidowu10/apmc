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
              View Account
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="addAccount"
                >
                  <span class="d-none d-md-flex">Add Account</span>
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
              <template v-slot:item.edit="{ item }">
                <v-btn
                  v-if="item.is_visible"
                  color="primary"
                  text
                  small
                  @click="editAccount(item.id)"
                >
                  <v-icon>
                    mdi-square-edit-outline
                  </v-icon>
                </v-btn>
                <v-btn
                  v-else
                  color="primary"
                  text
                  small
                >
                  <v-icon>
                    mdi-square
                  </v-icon>
                </v-btn>
              </template>
              <template v-slot:item.status="{ item }">
                <v-btn
                  v-if="item.status == 'Active'"
                  color="success"
                  text
                  small
                >
                  {{ item.status }}
                </v-btn>
                <v-btn
                  v-else
                  color="primary"
                  text
                  small
                >
                  {{ item.status }}
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
      permission: "account",
      alert: false,
      search: '',
      headers: [
                { text: 'Account Type', value: 'account_type' },
                { text: 'Account Name', value: 'name' },
                { text: 'Opening Balance', value: 'opening_bal' },
                { text: 'Account Group', value: 'groupcode' },
                { text: 'CR/DR', value: 'crdr' },
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
              addAccount(){
                this.$router.push({name:'add-account'});
              },
              index()
              {

                this.overlay = true;
                axios.get('account')
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
              
              editAccount(id){
                this.$router.push({name:'add-account', params:{orderid:id}});
              },
              
        }
  }
</script>
