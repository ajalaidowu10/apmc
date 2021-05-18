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
              Report Purchase
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
                        v-model="dateFromComputed"
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
                      Round Off
                    </th>
                    <th class="text-left"> 
                      Final Amount
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <template v-for="(group, index) in purchase">
                    <tr
                      v-for="(item, innerIndex) in purchaseItem(group)"
                     >
                     <template v-if="innerIndex == 0">
                       <td>{{ item.sno }}</td>
                       <td>{{ item.enter_date }}</td>
                       <td>{{ item.acct_name }}</td>
                       <td>{{ item.item_name }}</td>
                       <td>{{ item.qty }}</td>
                       <td>{{ item.grwt }}</td>
                       <td>{{ item.rate }}</td>
                       <td>{{ item.amount }}</td>
                       <td colspan="6"></td>
                     </template>
                     <template v-else>
                       <td></td>
                       <td></td>
                       <td>{{ item.acct_name }}</td>
                       <td>{{ item.item_name }}</td>
                       <td>{{ item.qty }}</td>
                       <td>{{ item.grwt }}</td>
                       <td>{{ item.rate }}</td>
                       <td>{{ item.amount }}</td>
                       <td colspan="6"></td>
                     </template>
                    </tr>
                    <tr class="blue-grey lighten-5">
                      <td colspan="7"></td>
                      <td><strong>{{ totalPurchase(group).purchase_amount }} </strong></td>
                      <td><strong>{{ totalPurchase(group).t_levy }} </strong></td>
                      <td><strong>{{ totalPurchase(group).t_maplevy }} </strong></td>
                      <td><strong>{{ totalPurchase(group).t_apmc }} </strong></td>
                      <td><strong>{{ totalPurchase(group).t_comm }} </strong></td>
                      <td><strong>{{ totalPurchase(group).other_charges }} </strong></td>
                      <td><strong>{{ totalPurchase(group).total_amount }} </strong></td>
                    </tr>
                  </template>
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
      permission: 'purchase-report',
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
      purchase() {
              const purchase = new Set();
              this.itemOrders.forEach(item => purchase.add(item.sno));

              return Array.from(purchase); 
          },
    },
    created(){
       this.index();
    },
    methods: {
              purchaseItem(sno) 
              {
                return this.itemOrders.filter(item => item.sno === sno);
              },
              totalPurchase(sno) 
              {
                let result = this.itemOrders.filter(item => item.sno === sno);
                result = result.slice(0, 1);
                return result.shift();
              },
              index()
              {

                this.overlay = true;
                axios.get(`account/get/0/12`)
                      .then(resp=>{
                        this.acct = transformKeys.camelCase(resp.data.data);
                      })
                      .catch(err => Exception.handle(err, 'admin'));
                axios.get(`purchase/report/${this.dateFrom}/${this.dateTo}/${this.acctId}`)
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
                  axios.get(`purchase/report/${this.dateFrom}/${this.dateTo}/${this.acctId}`)
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
                  let routeData = this.$router.resolve({name: 'print-purchase-report',  params:{
                                                                                        dateFrom:this.dateFrom, 
                                                                                        dateTo:this.dateTo,
                                                                                        acctId:this.acctId,
                                                                                      }});
                  window.open(routeData.href, '_blank');
              },
        }
  }
</script>
