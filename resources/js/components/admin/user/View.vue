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
              View User
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="addUser"
                >
                  <span class="d-none d-md-flex">Add User</span>
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
              :items="roomOrders"
              :search="search"
              >
              <template v-slot:item.permit="{ item }">
                <v-btn
                  color="primary"
                  text
                  small
                   @click="permitUser(item.id)"
                >
                  <v-icon>
                     mdi-eye
                  </v-icon>
                </v-btn>
              </template>
              <template v-slot:item.edit="{ item }">
                <v-btn
                  color="primary"
                  text
                  small
                  @click="editUser(item.id)"
                >
                  <v-icon>
                    mdi-square-edit-outline
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
      permission: 'user',
      alert: false,
      search: '',
      headers: [
                { text: 'User Name', value: 'name' },
                { text: 'User Permissions', value: 'permit' },
                { text: 'User Email', value: 'email' },
                { text: 'Edit', value: 'edit' },
                { text: 'Status', value: 'status' },
              ],
      roomOrders: [],
      overlay: false,
    }),
    created(){
       this.index();
    },
    methods: {
              addUser(){
                this.$router.push({name:'add-user'});
              },
              index()
              {

                this.overlay = true;
                axios.get(`admin`)
                     .then(resp => {
                      this.overlay = false;
                      this.roomOrders = resp.data.data;
                      if (this.$route.params.message) {
                        this.alert = true;
                      }
                    })
                     .catch(err => {
                      Exception.handle(err, 'admin');
                      this.overlay = false;
                    });

              },
              
              editUser(id){
                this.$router.push({name:'add-user', params:{orderid:id}});
              },
              permitUser(id){
                this.$router.push({name:'edit-user', params:{orderid:id}});
              },
              
        }
  }
</script>
