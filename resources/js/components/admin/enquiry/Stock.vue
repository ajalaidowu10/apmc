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
              Stock Report
            </v-banner>
          </v-col>
        </v-row>
        <v-container>
          <v-card>
            <v-card-title>
              <v-row>
                <v-col
                  cols="3"
                  >
                  <v-combobox
                    label="Item"
                    :items="item"
                    item-text="name"
                    item-value="id"
                    dense
                    @change="setItem($event)"
                    outlined
                  ></v-combobox>
                </v-col>
                <v-col
                  cols="2"
                  >
                  <v-menu
                    ref="menuTo"
                    v-model="menuTo"
                    :close-on-content-click="false"
                    :return-value.sync="dateTo"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        outlined
                        dense
                        v-model="dateToComputed"
                        label="Date To"
                        append-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="dateTo"
                      no-title
                      scrollable
                    >
                      <v-spacer></v-spacer>
                      <v-btn
                        text
                        color="primary"
                        @click="menuTo = false"
                      >
                        Cancel
                      </v-btn>
                      <v-btn
                        text
                        color="primary"
                        @click="$refs.menuTo.save(dateTo)"
                      >
                        OK
                      </v-btn>
                    </v-date-picker>
                  </v-menu>
                </v-col>
                <v-col
                  cols="3"
                 >
                   <v-btn
                    class="px-10"
                    color="primary"
                    @click="searchData"
                    >
                    Search
                  </v-btn>
                </v-col>
              </v-row>
            </v-card-title>
            <v-simple-table
              fixed-header
              >
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">
                      ITEM
                    </th>
                    <th class="text-left">
                      INWARD QTY
                    </th>
                    <th class="text-left">
                      OUTWARD QTY
                    </th>
                    <th class="text-left">
                      BALANCE QTY
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(item, index) in itemOrders"
                    :key="index"
                   >
                    <td>{{ item.item_name }}</td>
                    <td>{{ item.inward_qty }}</td>
                    <td>{{ item.outward_qty }}</td>
                    <td>{{ item.inward_qty - item.outward_qty }}</td>
                  </tr>
                  <tr class="blue-grey lighten-5">
                    <td colspan="1"><strong>TOTAL</strong></td>
                    <td><strong>{{ totalInward }}</strong></td>
                    <td><strong>{{ totalOutward }}</strong></td>
                    <td><strong>{{ totalInward - totalOutward }}</strong></td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-card>
          <br>
          <div class="text-center">
            <v-btn
              color="red"
              dark
              large
              @click="printReport"
             >
             PRINT REPORT
               <v-icon right>
                  mdi-file-pdf-outline
               </v-icon>
            </v-btn>
          </div>
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
      permission: 'stock-report',
      open_bal: 0,
      search: '',
      itemId: 0,
      item: [],
      dateTo: new Date().toISOString().substr(0, 10),
      itemOrders: [],
      menuTo: false,
      overlay: false,
    }),
    computed:{
      totalInward(){
        if (this.itemOrders.length > 0) {
          let result = this.itemOrders.reduce((prev, cur) => ({inward_qty: Number(prev.inward_qty) + Number(cur.inward_qty)})).inward_qty

          return Number(result).toFixed(2);
        }
        
        return 0;
      },
      totalOutward(){
        if (this.itemOrders.length > 0) {
          let result = this.itemOrders.reduce((prev, cur) => ({outward_qty: Number(prev.outward_qty) + Number(cur.outward_qty)})).outward_qty

          return Number(result).toFixed(2);
        }
        
        return 0;
      },
    },
    created(){
      this.overlay = true;
        axios.get(`item`)
              .then(resp=>{
                this.item = transformKeys.camelCase(resp.data.data);
                this.item.push({id:0, name:'All Item'});
              })
              .catch(err => Exception.handle(err, 'admin'));
        axios.get(`report/get/stock/${this.dateTo}/${this.itemId}`)
           .then(resp => {
            this.itemOrders = resp.data
          })
           .catch(err => {
            Exception.handle(err, 'admin');
          }); 
      this.overlay = false;
    },
    methods: {
              
              setItem(data){
                this.itemId = data.id;
              },
              searchData(){
                this.overlay = true;
                  axios.get(`report/get/stock/${this.dateTo}/${this.itemId}`)
                     .then(resp => {
                      this.itemOrders = resp.data
                    })
                     .catch(err => {
                      Exception.handle(err, 'admin');
                    });
                this.overlay = false;
              },
              printReport()
              {
                  let routeData = this.$router.resolve({name: 'print-stock-report',  params:{
                                                                                        dateTo:this.dateTo,
                                                                                        itemId:this.itemId, 
                                                                                      }});
                  window.open(routeData.href, '_blank');
              },
        }
  }
</script>
