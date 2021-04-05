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
              Report Ledger
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
                      DATE
                    </th>
                    <th class="text-left">
                      ACCOUNT
                    </th>
                    <th class="text-left">
                      NARRATION
                    </th>
                    <th class="text-left">
                      DEBIT &#8377
                    </th>
                    <th class="text-left"> 
                      CREDIT &#8377
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="red lighten-5">
                    <td colspan="3"><strong>Opening Balance</strong></td>
                    <td v-if="open_bal < 0"><strong>{{ open_bal * -1 }}</strong></td>
                    <td v-else>&nbsp;</td>
                    <td v-if="open_bal > 0"><strong>{{ open_bal }}</strong></td>
                    <td v-else>&nbsp;</td>
                  </tr>
                  <tr
                    v-for="(item, index) in itemOrders"
                    :key="index"
                   >
                    <td>{{ item.enter_date }}</td>
                    <td>{{ item.acct_name }}</td>
                    <td>{{ item.descp }}</td>
                    <td>{{ item.debit == 0 ? '' : item.debit}}</td>
                    <td>{{ item.credit == 0 ? '' : item.credit }}</td>
                  </tr>
                  <tr class="blue-grey lighten-5">
                    <td colspan="3"><strong>TOTAL</strong></td>
                    <td><strong>{{ totalDebit }}</strong></td>
                    <td><strong>{{ totalCredit }}</strong></td>
                  </tr>
                  <tr class="success lighten-5">
                    <td colspan="3"><strong>Closing Balance</strong></td>
                    <td v-if="closingBal < 0"><strong>{{ closingBal * -1 }}</strong></td>
                    <td v-else>&nbsp;</td>
                    <td v-if="closingBal > 0"><strong>{{ closingBal }}</strong></td>
                    <td v-else>&nbsp;</td>
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
      permission: 'ledger-report',
      open_bal: 0,
      search: '',
      acctId: 4,
      acct: [],
      dateFrom: new Date().toISOString().substr(0, 10),
      dateTo: new Date().toISOString().substr(0, 10),
      itemOrders: [],
      menuFrom: false,
      menuTo: false,
      overlay: false,
    }),
    computed:{
      closingBal(){
        let result = Number(this.open_bal) - Number(this.total);

        return Number(result).toFixed(2);
      },
      total(){
        let result = Number(this.totalDebit) - Number(this.totalCredit);

        return Number(result).toFixed(2);
      },
      totalDebit(){
        if (this.itemOrders.length > 0) {
          let result = this.itemOrders.reduce((prev, cur) => ({debit: Number(prev.debit) + Number(cur.debit)})).debit

          return Number(result).toFixed(2);
        }
        return 0;
      },

      totalCredit(){
        if (this.itemOrders.length > 0) {
          let result = this.itemOrders.reduce((prev, cur) => ({credit: Number(prev.credit) + Number(cur.credit)})).credit

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
                axios.get(`account`)
                      .then(resp=>{
                        this.acct = transformKeys.camelCase(resp.data.data);
                      })
                      // .catch(err => Exception.handle(err, 'admin'));
                axios.get(`acctbal/${this.acctId}/${this.dateFrom}`)
                     .then(resp => {
                      this.open_bal = resp.data;
                    })
                     .catch(err => {
                      // Exception.handle(err, 'admin');
                    });
                axios.get(`ledger/report/${this.dateFrom}/${this.dateTo}/${this.acctId}`)
                     .then(resp => {
                      this.overlay = false;
                      this.itemOrders = resp.data;
                    })
                     .catch(err => {
                      // Exception.handle(err, 'admin');
                    });
                this.overlay = false;
              },
              setAccountOne(data){
                this.acctId = data.id;
              },
              searchData(){
                this.overlay = true;
                  axios.get(`acctbal/${this.acctId}/${this.dateFrom}`)
                     .then(resp => {
                      this.open_bal = resp.data;
                    })
                     .catch(err => {
                      // Exception.handle(err, 'admin');
                    });
                  axios.get(`ledger/report/${this.dateFrom}/${this.dateTo}/${this.acctId}`)
                       .then(resp => {
                        this.itemOrders = resp.data;
                      })
                       .catch(err => {
                        // Exception.handle(err, 'admin');
                      });

                this.overlay = false;
              },
              printReport()
              {
                  let routeData = this.$router.resolve({name: 'print-ledger-report',  params:{
                                                                                        dateFrom:this.dateFrom, 
                                                                                        dateTo:this.dateTo,
                                                                                        acctId:this.acctId,
                                                                                      }});
                  window.open(routeData.href, '_blank');
              },
        }
  }
</script>
