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
              Report Trial Balance
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
                      ACCOUNT
                    </th>
                    <th class="text-right">
                      DEBIT &#8377
                    </th>
                    <th class="text-right"> 
                      CREDIT &#8377
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <template v-for="(group, index) in trialbal">
                    <tr class="blue-grey lighten-5">
                      <td><strong>{{ sliceData(group, 1) }}</strong></td>
                      <td width="100"><strong>{{ totalDebit(trialbalItem(sliceData(group))) }}</strong></td>
                      <td width="100"><strong>{{ totalCredit(trialbalItem(sliceData(group))) }}</strong></td>
                    </tr>
                    <tr
                      v-for="(item, innerIndex) in trialbalItem(sliceData(group))"
                     >
                      <td>{{ item.acct_name }}</td>
                      <td width="100">{{ item.debit == 0 ? '' : item.debit}}</td>
                      <td width="100">{{ item.credit == 0 ? '' : item.credit }}</td>
                    </tr>
                  </template>
                  <tr class="blue-grey lighten-3">
                    <td><strong>TOTAL</strong></td>
                    <td width="100"><strong>{{ allDebit }}</strong></td>
                    <td width="100"><strong>{{ allCredit }}</strong></td>
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
      permission: 'trailbal-report',
      search: '',
      dateFrom: new Date().toISOString().substr(0, 10),
      dateTo: new Date().toISOString().substr(0, 10),
      itemOrders: [],
      menuFrom: false,
      menuTo: false,
      overlay: false,
    }),
    computed:{
      trialbal() {
              const trialbal = new Set();
              this.itemOrders.forEach(item => trialbal.add(item.groupcode_id+','+item.groupcode_name));

              return Array.from(trialbal); 
          },
      allDebit(){
        if (this.itemOrders.length > 0) {
          let result = this.itemOrders.reduce((prev, cur) => ({debit: Number(prev.debit) + Number(cur.debit)})).debit

          return Number(result).toFixed(2);
        }
        return 0;
      },

      allCredit(){
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
              sliceData(value, end = 0){
                let result = value.split(',');
                
                return end == 0 ? Number(result[0]) : result[1];
              },
              trialbalItem(groupcode_id) 
              {
                return this.itemOrders.filter(function(item){
                  if (item.groupcode_id !== groupcode_id) return false;
                  if (item.credit == 0 && item.debit == 0) return false;

                  return true;
                }) 
              },
              totalDebit(itemArray){
                if (itemArray.length > 0) {
                  let result = itemArray.reduce((prev, cur) => ({debit: Number(prev.debit) + Number(cur.debit)})).debit

                  return Number(result).toFixed(2);
                }
                return 0;
              },

              totalCredit(itemArray){
                if (itemArray.length > 0) {
                  let result = itemArray.reduce((prev, cur) => ({credit: Number(prev.credit) + Number(cur.credit)})).credit

                  return Number(result).toFixed(2);
                }
                return 0;
              },
              index()
              {

                this.overlay = true;
                axios.get(`report/get/trialbal/${this.dateFrom}/${this.dateTo}`)
                     .then(resp => {
                      this.itemOrders = resp.data;
                    })
                     .catch(err => {
                      Exception.handle(err, 'admin');
                    });
                this.overlay = false;
              },
              searchData(){
                this.overlay = true;
                  axios.get(`report/get/trialbal/${this.dateFrom}/${this.dateTo}`)
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
                  let routeData = this.$router.resolve({name: 'print-trialbal-report',  params:{
                                                                                        dateFrom:this.dateFrom, 
                                                                                        dateTo:this.dateTo
                                                                                      }});
                  window.open(routeData.href, '_blank');
              },
        }
  }
</script>
