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
                      <template v-for="(group, index) in liabilityHead">
                        <tr class="blue-grey lighten-5">
                          <td><strong>{{ sliceData(group, 1) }}</strong></td>
                          <td width="100" class="text-right"><strong>{{ totalAmount(liabilityItem(sliceData(group))) }}</strong></td>
                        </tr>
                        <tr
                          v-for="(item, innerIndex) in liabilityItem(sliceData(group))"
                         >
                          <td>{{ item.acct_name }}</td>
                          <td width="100" class="text-right">{{ item.amount }}</td>
                        </tr>
                      </template>
                      <tr class="blue-grey lighten-3">
                        <td><strong>TOTAL</strong></td>
                        <td width="100" class="text-right"><strong>{{ totalLiabilityAmount }}</strong></td>
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
                      <template v-for="(group, index) in assetHead">
                        <tr class="blue-grey lighten-5">
                          <td><strong>{{ sliceData(group, 1) }}</strong></td>
                          <td width="100" class="text-right"><strong>{{ totalAmount(assetItem(sliceData(group))) }}</strong></td>
                        </tr>
                        <tr
                          v-for="(item, innerIndex) in assetItem(sliceData(group))"
                         >
                          <td>{{ item.acct_name }}</td>
                          <td width="100" class="text-right">{{ item.amount }}</td>
                        </tr>
                      </template>
                      <tr class="blue-grey lighten-3">
                        <td><strong>TOTAL</strong></td>
                        <td width="100" class="text-right"><strong>{{ totalAssetAmount }}</strong></td>
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
      permission: 'balsheet-report',
      search: '',
      dateTo: new Date().toISOString().substr(0, 10),
      asset: [],
      liability: [],
      menuTo: false,
      overlay: false,
    }),
    computed:{
      assetHead() {
              const data = new Set();
              this.asset.forEach(item => data.add(item.groupcode_id+','+item.groupcode_name));
              
              return Array.from(data); 
          },
      liabilityHead() {
              const data = new Set();
              this.liability.forEach(item => data.add(item.groupcode_id+','+item.groupcode_name));
              
              return Array.from(data); 
          },

      totalAssetAmount(){
        if (this.asset.length > 0) {
          let result = this.asset.reduce((prev, cur) => ({amount: Number(prev.amount) + Number(cur.amount)})).amount

          result = Number(result).toFixed(2);
          return this.numberWithCommas(result);
        }
        
        return 0;
      },

      liabilityHead() {
              const data = new Set();
              this.liability.forEach(item => data.add(item.groupcode_id+','+item.groupcode_name));

              return Array.from(data); 
          },
      
      totalLiabilityAmount(){ 
        if (this.liability.length > 0) {
          let result = this.liability.reduce((prev, cur) => ({amount: Number(prev.amount) + Number(cur.amount)})).amount
         
          result = Number(result).toFixed(2);
          return this.numberWithCommas(result);
        }
        return 0;
      },
      
    },
    created(){
       this.index();
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
                return this.asset.filter(item => item.groupcode_id == groupcode_id);
              },
              liabilityItem(groupcode_id) 
              {
                return this.liability.filter(item => item.groupcode_id == groupcode_id);
              },
              
              totalAmount(itemArray){
                if (itemArray.length > 0) 
                {
                  let result = itemArray.reduce((prev, cur) => ({amount: Number(prev.amount) + Number(cur.amount)})).amount

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
                     this.asset = resp.data.asset;
                     this.liability = resp.data.liability;
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
                     this.asset = resp.data.asset;
                     this.liability = resp.data.liability;
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
