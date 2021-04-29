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
    <v-row>
      <v-col cols="3">
        <v-card color="lime lighten-5" class="pa-5">
          <div class="d-flex flex-no-wrap justify-space-between">
             <v-icon size="50" color="lime">mdi-dots-grid</v-icon>
             <div>
                <v-card-title
                  class="headline1"
                >{{ totalCashBankBalance }}</v-card-title>

                <v-card-subtitle>Cash &amp; Bank Balance</v-card-subtitle>

                <v-card-actions>
                  <v-btn
                    outlined
                    rounded
                    small
                    @click="viewCashBankBalance"
                  >
                    View Details
                  </v-btn>
                </v-card-actions>
              </div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="3">
        <v-card color="pink lighten-5" class="pa-5">
          <div class="d-flex flex-no-wrap justify-space-between">
             <v-icon size="50" color="pink">mdi-home-variant-outline</v-icon>
             <div>
                <v-card-title
                  class="headline1"
                >{{ totalPayable }}</v-card-title>

                <v-card-subtitle>Payables</v-card-subtitle>

                <v-card-actions>
                  <v-btn
                    outlined
                    rounded
                    small
                    @click="viewPayable"
                  >
                    View Details
                  </v-btn>
                </v-card-actions>
             </div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="3">
        <v-card color="blue-grey lighten-5" class="pa-5">
          <div class="d-flex flex-no-wrap justify-space-between">
             <v-icon size="50" color="blue-grey">mdi-ship-wheel</v-icon>
             <div>
                <v-card-title
                  class="headline1"
                >{{ totalReceivable }}</v-card-title>

                <v-card-subtitle>Receivable</v-card-subtitle>

                <v-card-actions>
                  <v-btn
                    outlined
                    rounded
                    small
                    @click="viewReceivable"
                  >
                    View Details
                  </v-btn>
                </v-card-actions>
             </div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="3">
        <v-card color="amber lighten-5" class="pa-5">
          <div class="d-flex flex-no-wrap justify-space-between">
             <v-icon size="50" color="amber">mdi-bank-check</v-icon>
             <div>
                <v-card-title
                  class="headline1"
                >{{totalItem}}</v-card-title>

                <v-card-subtitle>Stock Quantity</v-card-subtitle>

                <v-card-actions>
                  <v-btn
                    outlined
                    rounded
                    small
                    @click="viewItem"
                  >
                    View Details
                  </v-btn>
                </v-card-actions>
             </div>
          </div>
        </v-card>
      </v-col>
    </v-row>
    <v-row v-if="cashbankBalance">
      <v-col cols="12">
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
            :headers="cashbankBalanceHeaders"
            :items="cashBankBalance"
            :search="search"
            >
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
    <v-row v-if="item">
      <v-col cols="12">
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
            :headers="itemHeaders"
            :items="itemOrders"
            :search="search"
            >
            <template v-slot:item.balance="{ item }">
              {{ item.inward_qty - item.outward_qty }}
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
    <v-row v-if="receivable">
      <v-col cols="12">
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
            :headers="receivableHeaders"
            :items="getNewReceivable"
            :search="search"
            >
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
    <v-row v-if="payable">
      <v-col cols="12">
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
            :headers="payableHeaders"
            :items="getNewPayable"
            :search="search"
            >
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
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
  import transformKeys from '../../utils/transformKeys';
  export default {
    data: () => ({
      alert: false,
      permission: 'dashboard',
      cashbankBalance: true,
      dateTo: new Date().toISOString().substr(0, 10),
      item: false,
      receivable: false,
      payable: false,
      orderid: null,
      alert: false,
      search: '',
      payableHeaders: [
                {
                  text: 'Accounts',
                  align: 'start',
                  sortable: true,
                  value: 'acct_name',
                },
                { text: 'Payables', value: 'balance' },
              ],
      cashbankBalanceHeaders: [
                {
                  text: 'Accounts',
                  align: 'start',
                  sortable: true,
                  value: 'acct_name',
                },
                { text: 'Balances', value: 'balance' },
              ],
      itemHeaders: [
                {
                  text: 'Item',
                  align: 'start',
                  sortable: true,
                  value: 'item_name',
                },
                { text: 'Inward Qty', value: 'inward_qty' },
                { text: 'Outward Qty', value: 'outward_qty' },
                { text: 'Balance Qty', value: 'balance' },
              ],
      receivableHeaders: [
                {
                  text: 'Accounts',
                  align: 'start',
                  sortable: true,
                  value: 'acct_name',
                },
                { text: 'Receivables', value: 'balance' },
              ],
      cashBankBalance: [],
      itemOrders: [],
      payableOrders: [],
      receivableOrders: [],
      overlay: false,
    }),
    computed: {
      getNewPayable(){
        return this.payableOrders.filter(item => item.balance > 0);
      },
      getNewReceivable(){
          return this.receivableOrders.filter(item => item.balance > 0);
      },
      totalCashBankBalance(){
        if (this.cashBankBalance.length > 0) {
          let result = this.cashBankBalance.reduce((prev, cur) => ({balance: Number(prev.balance) + Number(cur.balance)})).balance
          result = Number(result).toFixed(2);
          return this.numberWithCommas(result);
        }
        
        return 0;
      },
      totalItem(){
        let result = Number(this.totalInward) - Number(this.totalOutward)
        return this.numberWithCommas(result);
      },
      totalReceivable(){
          if (this.getNewReceivable.length > 0) {
            let result = this.getNewReceivable.reduce((prev, cur) => ({balance: Number(prev.balance) + Number(cur.balance)})).balance
            result = Number(result).toFixed(2);
            return this.numberWithCommas(result);
          }
          
          return 0; 
      },
      totalPayable(){
          if (this.getNewPayable.length > 0) {
            let result = this.getNewPayable.reduce((prev, cur) => ({balance: Number(prev.balance) + Number(cur.balance)})).balance
            result = Number(result).toFixed(2);
            return this.numberWithCommas(result);
          }
          
          return 0;
      },

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
       this.getReceivable();
       this.getCashBankBalance();
       this.getItem();
       this.getPayable();
    },
    methods: {
              numberWithCommas(x) {
                  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
              },
              getPayable()
              {
                this.overlay = true;
                axios.get('report/get/payable')
                     .then(resp => {
                      this.overlay = false;
                      this.payableOrders = resp.data;
                    })
                     .catch(err => {
                      Exception.handle(err, 'admin');
                      this.overlay = false;
                    });
                this.overlay = false;
              },
              getCashBankBalance()
              {
                this.overlay = true;
                axios.get('report/get/cashbankbalance')
                     .then(resp => {
                      this.cashBankBalance = resp.data;
                    })
                     .catch(err => {
                      Exception.handle(err, 'admin');
                    });
                this.overlay = false;
              },
              getItem()
              {
                this.overlay = true;
                axios.get(`report/get/stock/${this.dateTo}/0`)
                     .then(resp => {
                      this.itemOrders = resp.data;
                    })
                     .catch(err => {
                      Exception.handle(err, 'admin');
                    });
               this.overlay = false;
              },
              getReceivable()
              {
                this.overlay = true;
                axios.get(`report/get/receivable`)
                     .then(resp => {
                      this.receivableOrders = resp.data;
                    })
                     .catch(err => {
                      Exception.handle(err, 'admin');
                    });
               this.overlay = false;
              },
              disableAll(){
                this.cashbankBalance = false;
                this.item = false;
                this.payable = false;
                this.receivable = false;
                this.$route.params.message = null;
              },
              viewCashBankBalance(){
                this.disableAll();
                this.cashbankBalance = true;
                this.getCashBankBalance();
              },
              viewReceivable(){
                this.disableAll();
                this.receivable = true;
                this.getReceivable();
              },
              viewItem(){
                this.disableAll();
                this.item = true;
                this.getItem();
              },
              viewPayable(){
                this.disableAll();
                this.payable = true;
                this.getPayable();
              },
        }
  }
</script>


