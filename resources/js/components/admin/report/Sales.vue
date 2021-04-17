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
              Report Sales
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
                    label="Account"
                    :items="acct"
                    item-text="name"
                    item-value="id"
                    dense
                    @change="setAccountOne($event)"
                    outlined
                  ></v-combobox>
                </v-col>
                <v-col
                  cols="2"
                  >
                  <v-menu
                    ref="menuFrom"
                    v-model="menuFrom"
                    :close-on-content-click="false"
                    :return-value.sync="dateFrom"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        outlined
                        dense
                        v-model="dateFrom"
                        label="Date From"
                        append-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="dateFrom"
                      no-title
                      scrollable
                    >
                      <v-spacer></v-spacer>
                      <v-btn
                        text
                        color="primary"
                        @click="menuFrom = false"
                      >
                        Cancel
                      </v-btn>
                      <v-btn
                        text
                        color="primary"
                        @click="$refs.menuFrom.save(dateFrom)"
                      >
                        OK
                      </v-btn>
                    </v-date-picker>
                  </v-menu>
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
                        v-model="dateTo"
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
                      S/No.
                    </th>
                    <th class="text-left">
                      Date
                    </th>
                    <th class="text-left">
                      Account
                    </th>
                    <th class="text-left">
                      Item
                    </th>
                    <th class="text-left">
                      Qty
                    </th>
                    <th class="text-left">
                      Grwt
                    </th>
                    <th class="text-left">
                      Rate
                    </th>
                    <th class="text-left">
                      Amount
                    </th>
                    <th class="text-left">
                      Levy
                    </th>
                    <th class="text-left">
                      Map Levy
                    </th>
                    <th class="text-left">
                      Apmc
                    </th>
                    <th class="text-left"> 
                      Comm
                    </th>
                    <th class="text-left"> 
                      Tds
                    </th>
                    <th class="text-left"> 
                      Final Amount
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(item, index) in itemOrders"
                    :key="index"
                   >
                    <td>{{ item.sno }}</td>
                    <td>{{ item.enter_date }}</td>
                    <td>{{ item.acct_name }}</td>
                    <td>{{ item.item_name }}</td>
                    <td>{{ item.qty }}</td>
                    <td>{{ item.grwt }}</td>
                    <td>{{ item.rate }}</td>
                    <td>{{ item.amount }}</td>
                    <td>{{ item.levy }}</td>
                    <td>{{ item.map_levy }}</td>
                    <td>{{ item.apmc }}</td>
                    <td>{{ item.comm }}</td>
                    <td>{{ item.tds }}</td>
                    <td>{{ item.final_amount }}</td>
                  </tr>
                  <tr class="blue-grey lighten-5">
                    <td colspan="4"><strong>TOTAL</strong></td>
                    <td><strong>{{ totalQty }}</strong></td>
                    <td><strong>{{ totalGrwt }}</strong></td>
                    <td><strong>{{ totalRate }}</strong></td>
                    <td><strong>{{ totalAmount }}</strong></td>
                    <td><strong>{{ totalLevy }}</strong></td>
                    <td><strong>{{ totalMapLevy }}</strong></td>
                    <td><strong>{{ totalApmc }}</strong></td>
                    <td><strong>{{ totalComm }}</strong></td>
                    <td><strong>{{ totalTds}}</strong></td>
                    <td><strong>{{ totalFinalAmount }}</strong></td>
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
      permission: 'sales-report',
      acctId: 0,
      acct: [],
      dateFrom: new Date().toISOString().substr(0, 10),
      dateTo: new Date().toISOString().substr(0, 10),
      itemOrders: [],
      menuFrom: false,
      menuTo: false,
      overlay: false,
    }),
    computed:{
      totalQty(){
        if (this.itemOrders.length > 0) {
          let result = this.itemOrders.reduce((prev, cur) => ({qty: Number(prev.qty) + Number(cur.qty)})).qty

          return Number(result).toFixed(2);
        }
        
        return 0;
      },

      totalGrwt(){
        if (this.itemOrders.length > 0) {
          let result = this.itemOrders.reduce((prev, cur) => ({grwt: Number(prev.grwt) + Number(cur.grwt)})).grwt

          return Number(result).toFixed(2);
        }
        
        return 0;
      },

      totalRate(){
        if (this.itemOrders.length > 0) {
          let result = this.itemOrders.reduce((prev, cur) => ({rate: Number(prev.rate) + Number(cur.rate)})).rate

          return Number(result).toFixed(2);
        }
        
        return 0;
      },

      totalAmount(){
        if (this.itemOrders.length > 0) {
          let result = this.itemOrders.reduce((prev, cur) => ({amount: Number(prev.amount) + Number(cur.amount)})).amount

          return Number(result).toFixed(2);
        }
        
        return 0;
      },

      totalLevy(){
        if (this.itemOrders.length > 0) {
          let result = this.itemOrders.reduce((prev, cur) => ({levy: Number(prev.levy) + Number(cur.levy)})).levy

          return Number(result).toFixed(2);
        }
        
        return 0;
      },

      totalMapLevy(){
        if (this.itemOrders.length > 0) {
          let result = this.itemOrders.reduce((prev, cur) => ({map_levy: Number(prev.map_levy) + Number(cur.map_levy)})).map_levy

          return Number(result).toFixed(2);
        }
        
        return 0;
      },

      totalApmc(){
        if (this.itemOrders.length > 0) {
          let result = this.itemOrders.reduce((prev, cur) => ({apmc: Number(prev.apmc) + Number(cur.apmc)})).apmc

          return Number(result).toFixed(2);
        }
        
        return 0;
      },

      totalComm(){
        if (this.itemOrders.length > 0) {
          let result = this.itemOrders.reduce((prev, cur) => ({comm: Number(prev.comm) + Number(cur.comm)})).comm

          return Number(result).toFixed(2);
        }
        
        return 0;
      },

      totalTds(){
        if (this.itemOrders.length > 0) {
          let result = this.itemOrders.reduce((prev, cur) => ({tds: Number(prev.tds) + Number(cur.tds)})).tds

          return Number(result).toFixed(2);
        }
        
        return 0;
      },

      totalFinalAmount(){
        if (this.itemOrders.length > 0) {
          let result = this.itemOrders.reduce((prev, cur) => ({final_amount: Number(prev.final_amount) + Number(cur.final_amount)})).final_amount

          return Number(result).toFixed(2);
        }
        
        return 0;
      },








      
    },
    created(){
       this.index();
    },
    methods: {
              index()
              {

                this.overlay = true;
                axios.get(`account/get/0/2`)
                      .then(resp=>{
                        this.acct = transformKeys.camelCase(resp.data.data);
                      })
                      .catch(err => Exception.handle(err, 'admin'));
                axios.get(`sales/report/${this.dateFrom}/${this.dateTo}/${this.acctId}`)
                     .then(resp => {
                      this.itemOrders = resp.data;
                    })
                     .catch(err => {
                      Exception.handle(err, 'admin');
                    });
                this.overlay = false;
              },
              setAccountOne(data){
                this.acctId = data.id;
              },
              searchData(){
                this.overlay = true;
                  axios.get(`sales/report/${this.dateFrom}/${this.dateTo}/${this.acctId}`)
                       .then(resp => {
                        this.itemOrders = resp.data;
                      })
                       .catch(err => {
                        Exception.handle(err, 'admin');
                      });
                this.overlay = false;
              },
              printReport()
              {
                  let routeData = this.$router.resolve({name: 'print-sales-report',  params:{
                                                                                        dateFrom:this.dateFrom, 
                                                                                        dateTo:this.dateTo,
                                                                                        acctId:this.acctId,
                                                                                      }});
                  window.open(routeData.href, '_blank');
              },
        }
  }
</script>
