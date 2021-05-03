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
              Edit Sales
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewData"
                >
                  <span class="d-none d-md-flex">View Sales</span>
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
              <template v-slot:item.id="{ item }">
                {{itemOrders.map(function(x) {return x.id; }).indexOf(item.id)}}
              </template>
              <template v-slot:item.isCharged="{ item }">
                <v-icon v-if="item.isCharged
                ">mdi-check</v-icon>
                <v-icon v-else>mdi-cancel</v-icon>
              </template>
            </v-data-table>
          </v-card>
          <v-row>
            <v-col
              cols="6"
              >
              <v-btn
               color="primary"
               class="pa-10"
               dark
                
               x-large
               @click="editData"
               >
               Edit
               <v-icon
                 right
                 dark
                >
                 mdi-square-edit-outline
               </v-icon>
             </v-btn>
            </v-col>
            <v-col
              v-if="orderid != 0"
              cols="6"
              >
              <v-btn
               color="red"
               class="pa-10"
               dark
                
               x-large
               @click="deleteData"
               >
               Delete
               <v-icon
                 right
                 dark
                >
                 mdi-close-outline
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
       permission: 'sales-entry',
      orderid: 0,
      alert: false,
      search: '',
      headers: [
                { text: 'S/No', value: 'id' },
                { text: 'Item', value: 'item' },
                { text: 'QUANTITY', value: 'qty' },
                { text: 'GRWT', value: 'grwt' },
                { text: 'RATE', value: 'rate' },
                { text: 'AMOUNT', value: 'amount' },
                { text: 'Charged', value: 'isCharged' },
              ],
      itemOrders: [],
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
                  axios.get(`salesorder/${this.orderid}`)
                       .then(resp => {
                        let getData = resp.data.data;
                        this.itemOrders = transformKeys.camelCase(getData.sales_order_items.filter(data => data.del_record == 0));
                        this.orderid = getData.id;
                        console.log(this.itemOrders);
                       })
                       .catch(err => Exception.handle(err, 'admin'));
                }

                this.overlay = false;

              },
              viewData(){
                this.$router.push({name:'view-sales'});
              },
              editData(){
                this.$router.push({name:'add-sales', params:{orderid:this.orderid}});
              },
              deleteData()
              {
                swal({
                      title: "Notification!",
                      text: 'Are you sure you want to Delete this Sales',
                      buttons: ['No', 'Yes']
                    })
                .then((yes) => {
                  if (yes) {
                    this.overlay = true;
                    axios.delete(`salesorder/${this.orderid}`)
                         .then(resp => {
                          this.$router.push({name:'view-sales', params: { message: `Sales Deleted Successfully` }});
                         })
                         .catch(err => Exception.handle(err, 'admin'));
                    this.overlay = false;
                  }
                })
              },
              
        }
  }
</script>
