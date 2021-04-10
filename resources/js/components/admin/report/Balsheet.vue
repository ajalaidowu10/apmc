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
              Report Balance Sheet
            </v-banner>
          </v-col>
        </v-row>
        <v-container>
          <v-card>
            <v-card-title>
              <v-row>
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
            <v-row class="pa-2">
              <v-col cols="6">
                <v-alert
                  dense
                  outlined
                  type="error"
                  >
                  <strong>LIABILITY</strong>
                </v-alert>
                <v-simple-table
                  fixed-header
                  >
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left">
                          ACCOUNT
                        </th>
                        <th class="text-right">
                          AMOUNT &#8377
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <template v-for="(group, index) in liability">
                        <tr class="blue-grey lighten-5">
                          <td><strong>{{ sliceData(group, 1) }}</strong></td>
                          <td width="100" class="text-right"><strong>{{ totalLiabilityAmount(liabilityItem(sliceData(group))) }}</strong></td>
                        </tr>
                        <tr
                          v-for="(item, innerIndex) in liabilityItem(sliceData(group))"
                         >
                          <td>{{ item.acct_name }}</td>
                          <td width="100" class="text-right">{{ numberWithCommas(item.result1) }}</td>
                        </tr>
                      </template>
                      <tr class="blue-grey lighten-3">
                        <td><strong>TOTAL</strong></td>
                        <td width="100" class="text-right"><strong>{{ allLiabilityAmount }}</strong></td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
              </v-col>
              <v-col cols="6">
                <v-alert
                  dense
                  outlined
                  type="success"
                  >
                  <strong>ASSET</strong>
                </v-alert>
                <v-simple-table
                  fixed-header
                  >
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left">
                          ACCOUNT
                        </th>
                        <th class="text-right">
                          AMOUNT &#8377
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <template v-for="(group, index) in asset">
                        <tr class="blue-grey lighten-5">
                          <td><strong>{{ sliceData(group, 1) }}</strong></td>
                          <td width="100" class="text-right"><strong>{{ totalAssetAmount(assetItem(sliceData(group))) }}</strong></td>
                        </tr>
                        <tr
                          v-for="(item, innerIndex) in assetItem(sliceData(group))"
                         >
                          <td>{{ item.acct_name }}</td>
                          <td width="100" class="text-right">{{ numberWithCommas(item.result) }}</td>
                        </tr>
                      </template>
                      <tr class="blue-grey lighten-3">
                        <td><strong>TOTAL</strong></td>
                        <td width="100" class="text-right"><strong>{{ allAssetAmount }}</strong></td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
              </v-col>
            </v-row>
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
      permission: 'trailbal-report',
      search: '',
      dateTo: new Date().toISOString().substr(0, 10),
      itemOrders: [],
      profitLoss: 0,
      prevProfitLoss: 0,
      openbalDiff: 0,
      stockValue: 0,
      menuTo: false,
      overlay: false,
    }),
    computed:{
      getAsset(){
        return this.itemOrders.filter(item => Number(item.result) > 0);
      },
      getAsset(){
        return this.itemOrders.filter(item => Number(item.result) > 0);
      },
      asset() {
              const asset = new Set();
              this.getAsset.forEach(item => asset.add(item.groupcode_id+','+item.groupcode_name));
              asset.add("0, Stock Value");
              if (this.openbalDiff < 0) 
              {
                asset.add("-1, Diff. in Opening Balances");
              }
              return Array.from(asset); 
          },
      allAssetAmount(){
        if (this.getAsset.length > 0) {
          let result = this.getAsset.reduce((prev, cur) => ({result: Number(prev.result) + Number(cur.result)})).result

          result = Number(result) + Number(this.stockValue);

          if (this.openbalDiff < 0) 
          {
            result = result + (Number(this.openbalDiff) * -1) ;
          }

          result = Number(result).toFixed(2);
          return this.numberWithCommas(result);
        }
        return 0;
      },

      getLiability(){
        return this.itemOrders.filter(item => Number(item.result) < 0);
      },
      liability() {
              const liability = new Set();
              this.getLiability.forEach(item => liability.add(item.groupcode_id+','+item.groupcode_name));
              liability.add("0, Profit & Loss");
              if (this.openbalDiff > 0) 
              {
                liability.add("-1, Diff. in Opening Balances");
              }
              

              return Array.from(liability); 
          },
      allLiabilityAmount(){ 
        if (this.getLiability.length > 0) {
          let result = this.getLiability.reduce((prev, cur) => ({result1: Number(prev.result1) + Number(cur.result1)})).result1
         
          result = Number(result) + Number(this.prevProfitLoss) + Number(this.profitLoss);

          if (this.openbalDiff > 0) 
          {
            result = result + Number(this.openbalDiff);
          }

          result = Number(result).toFixed(2);
          return this.numberWithCommas(result);
        }
        return 0;
      },
      
    },
    created(){
       this.index();
       axios.get(`report/get/balsheet/${this.dateTo}`)
         .then(resp => {
          console.log(resp.data);
        })
    },
    methods: {
              numberWithCommas(x) {
                  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
              },
              sliceData(value, end = 0){
                let result = value.split(',');
                
                return end == 0 ? Number(result[0]) : result[1];
              },
              assetItem(groupcode_id) 
              {
                if (groupcode_id == 0) 
                {
                  return [{acct_name:'Stock Value', result: this.stockValue}];

                }

                if (groupcode_id == -1) 
                {
                  return [
                            {acct_name:'Diff. in Opening Balances', result: this.openbalDiff * -1}
                        ];

                }

                return this.getAsset.filter(item => item.groupcode_id == groupcode_id);
              },
              liabilityItem(groupcode_id) 
              {
                if (groupcode_id == 0) 
                {
                  return [
                            {acct_name:'Opening Balance', result1: this.prevProfitLoss},
                            {acct_name:'Current Period', result1: this.profitLoss},
                        ];

                }

                if (groupcode_id == -1) 
                {
                  return [
                            {acct_name:'Diff. in Opening Balances', result1: this.openbalDiff}
                        ];

                }
                  
                return this.getLiability.filter(item => item.groupcode_id == groupcode_id);
              },
              totalAssetAmount(itemArray){
                if (itemArray.length > 0) {
                  let result = itemArray.reduce((prev, cur) => ({result: Number(prev.result) + Number(cur.result)})).result

                  result = Number(result).toFixed(2);
          return this.numberWithCommas(result);
                }
                return 0;
              },

              totalLiabilityAmount(itemArray){
                if (itemArray.length > 0) {
                  let result = itemArray.reduce((prev, cur) => ({result1: Number(prev.result1) + Number(cur.result1)})).result1

                  result = Number(result).toFixed(2);
          return this.numberWithCommas(result);
                }
                return 0;
              },

              index()
              {

                this.overlay = true;
                  axios.get(`report/get/balsheet/${this.dateTo}`)
                    .then(resp => {
                     this.itemOrders = resp.data.asset_liability;
                     this.profitLoss = resp.data.profit_loss;
                     this.prevProfitLoss = resp.data.prev_profit_loss;
                     this.stockValue = resp.data.stock_value;
                     this.openbalDiff = resp.data.openbal_diff;
                   })
                   .catch(err => {
                    Exception.handle(err, 'admin');
                  });

                this.overlay = false;
              },
              searchData(){
                this.overlay = true;
                  axios.get(`report/get/balsheet/${this.dateTo}`)
                    .then(resp => {
                     this.itemOrders = resp.data.asset_liability;
                     this.profitLoss = resp.data.profit_loss;
                     this.prevProfitLoss = resp.data.prev_profit_loss;
                     this.stockValue = resp.data.stock_value;
                     this.openbalDiff = resp.data.openbal_diff;
                   })
                   .catch(err => {
                    Exception.handle(err, 'admin');
                  });
                this.overlay = false;
              },
              printReport()
              {
                  let routeData = this.$router.resolve({name: 'print-balsheet-report',  params:{
                                                                                        dateTo:this.dateTo
                                                                                      }});
                  window.open(routeData.href, '_blank');
              },
        }
  }
</script>
