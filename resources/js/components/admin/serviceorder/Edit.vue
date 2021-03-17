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
              Edit Service Order
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewData"
                >
                  <span class="d-none d-md-flex">View Service Order</span>
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
               min-width="300"
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
               min-width="300"
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
       permission: 'service-order',
      orderid: 0,
      alert: false,
      search: '',
      headers: [
                { text: 'S/No', value: 'id' },
                { text: 'Service', value: 'service' },
                { text: 'QUANTITY', value: 'qty' },
                { text: 'PRICE', value: 'item_price' },
                { text: 'AMOUNT', value: 'amount' },
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
                  axios.get(`serviceorder/${this.orderid}`)
                       .then(resp => {
                        let getData = resp.data.data;
                        this.itemOrders = getData.service_order_items.filter(data => data.del_record == 0);
                        this.orderid = getData.id;
                       })
                       .catch(err => Exception.handle(err, 'admin'));
                }

                this.overlay = false;

              },
              viewData(){
                this.$router.push({name:'view-serviceorder'});
              },
              editData(){
                this.$router.push({name:'add-serviceorder', params:{orderid:this.orderid}});
              },
              printData(id)
              {
                let routeData = this.$router.resolve({name: 'print-serviceorder',  params:{id:id}});
                window.open(routeData.href, '_blank');
              },
              deleteData()
              {
                swal({
                      title: "Notification!",
                      text: 'Are you sure you want to Delete this Service Order',
                      buttons: ['No', 'Yes']
                    })
                .then((yes) => {
                  if (yes) {
                    this.overlay = true;
                    axios.delete(`serviceorder/${this.orderid}`)
                         .then(resp => {
                          this.$router.push({name:'view-serviceorder', params: { message: `Service Order Deleted Successfully` }});
                         })
                         .catch(err => Exception.handle(err, 'admin'));
                    this.overlay = false;
                  }
                })
              },
              
        }
  }
</script>
