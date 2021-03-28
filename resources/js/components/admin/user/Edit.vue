<template>
  <v-container v-if="hasAccess">
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
              Edit User Permission
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewData"
                >
                  <span class="d-none d-md-flex">View User</span>
                  <v-icon >
                    mdi-book-search-outline
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
              <template v-slot:item.action="{ item }">
                <v-checkbox
                  v-model="form.userPermissions"
                  :value="item.slug"
                  hide-details
                ></v-checkbox>
              </template>
            </v-data-table>
          </v-card>
          <v-row>
            <v-col cols="6"></v-col>
            <v-col
              cols="6"
              >
              <v-btn
               color="primary"
               class="pa-10"
               dark
                
               x-large
               @click="saveData"
               >
               Save
               <v-icon
                 right
                 dark
                >
                 mdi-content-save-outline
               </v-icon>
             </v-btn>
            </v-col>
          </v-row>
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
      orderid: 0,
      search: '',
      headers: [
                { text: 'MENU', value: 'module' },
                { text: 'PERMISSION', value: 'name' },
                { text: 'ACTION', value: 'action' },
              ],
      itemOrders: [],
      form: {
              userPermissions: [],
      },
      overlay: false,
    }),
    created(){
       this.index();
    },
    methods: {
              index()
              {

                this.overlay = true;
                if (this.$route.params.orderid) {
                  this.orderid = this.$route.params.orderid;
                  axios.get(`permission/get/${this.orderid}`)
                       .then(resp => {
                        console.log(resp);
                        this.itemOrders = resp.data.all_permissions;
                        this.form.userPermissions = resp.data.user_permissions;
                       })
                       .catch(err => Exception.handle(err, 'admin'));
                }

                this.overlay = false;

              },
              viewData(){
                this.$router.push({name:'view-user'});
              },
              saveData()
              {
                swal({
                      title: "Notification!",
                      text: 'Are you sure you want to grant this User Permissions',
                      buttons: ['No', 'Yes']
                    })
                .then((yes) => {
                  if (yes) {
                    this.overlay = true;
                    axios.patch(`permission/refresh/${this.orderid}`, transformKeys.snakeCase(this.form))
                         .then(resp => {
                          this.$router.push({name:'view-user', params: { message: `User Permissions Granted Successfully` }});
                         })
                         .catch(err => Exception.handle(err, 'admin'));
                    this.overlay = false;
                  }
                })
              },
              
        }
  }
</script>
