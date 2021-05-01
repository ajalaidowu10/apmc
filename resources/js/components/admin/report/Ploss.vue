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
              Report Profit &amp; Loss
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
            <v-row class="pa-2">
              <v-col cols="6">
                <v-alert
                  dense
                  outlined
                  type="error"
                  >
                  <strong>EXPENSE</strong>
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
                      <template v-for="(group, index) in expenseHead">
                        <tr class="blue-grey lighten-5">
                          <td><strong>{{ sliceData(group, 1) }}</strong></td>
                          <td width="100" class="text-right"><strong>{{ totalAmount(expenseItem(sliceData(group))) }}</strong></td>
                        </tr>
                        <tr
                          v-for="(item, innerIndex) in expenseItem(sliceData(group))"
                         >
                          <td>{{ item.acct_name }}</td>
                          <td width="100" class="text-right">{{ item.amount }}</td>
                        </tr>
                      </template>
                      <tr class="blue-grey lighten-3">
                        <td><strong>TOTAL</strong></td>
                        <td width="100" class="text-right"><strong>{{ totalExpenseAmount }}</strong></td>
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
                  <strong>INCOME</strong>
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
                      <template v-for="(group, index) in incomeHead">
                        <tr class="blue-grey lighten-5">
                          <td><strong>{{ sliceData(group, 1) }}</strong></td>
                          <td width="100" class="text-right"><strong>{{ totalAmount(incomeItem(sliceData(group))) }}</strong></td>
                        </tr>
                        <tr
                          v-for="(item, innerIndex) in incomeItem(sliceData(group))"
                         >
                          <td>{{ item.acct_name }}</td>
                          <td width="100" class="text-right">{{ item.amount }}</td>
                        </tr>
                      </template>
                      <tr class="blue-grey lighten-3">
                        <td><strong>TOTAL</strong></td>
                        <td width="100" class="text-right"><strong>{{ totalIncomeAmount }}</strong></td>
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
      permission: 'ploss-report',
      search: '',
      dateFrom: new Date().toISOString().substr(0, 10),
      dateTo: new Date().toISOString().substr(0, 10),
      income: [],
      expense: [],
      menuTo: false,
      overlay: false,
    }),
    computed:{
      incomeHead() {
              const data = new Set();
              this.income.forEach(item => data.add(item.groupcode_id+','+item.groupcode_name));
              
              return Array.from(data); 
          },
      expenseHead() {
              const data = new Set();
              this.expense.forEach(item => data.add(item.groupcode_id+','+item.groupcode_name));
              
              return Array.from(data); 
          },

      totalIncomeAmount(){
        if (this.income.length > 0) {
          let result = this.income.reduce((prev, cur) => ({amount: Number(prev.amount) + Number(cur.amount)})).amount

          result = Number(result).toFixed(2);
          return this.numberWithCommas(result);
        }
        
        return 0;
      },

      expenseHead() {
              const data = new Set();
              this.expense.forEach(item => data.add(item.groupcode_id+','+item.groupcode_name));

              return Array.from(data); 
          },
      
      totalExpenseAmount(){ 
        if (this.expense.length > 0) {
          let result = this.expense.reduce((prev, cur) => ({amount: Number(prev.amount) + Number(cur.amount)})).amount
         
          result = Number(result).toFixed(2);
          return this.numberWithCommas(result);
        }
        return 0;
      },
      
    },
    created(){
       this.index();
       axios.get(`report/get/ploss/${this.dateFrom}/${this.dateTo}`)
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
              incomeItem(groupcode_id) 
              {
                return this.income.filter(item => item.groupcode_id == groupcode_id);
              },
              expenseItem(groupcode_id) 
              {
                return this.expense.filter(item => item.groupcode_id == groupcode_id);
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
                  axios.get(`report/get/ploss/${this.dateFrom}/${this.dateTo}`)
                    .then(resp => {
                     this.income   = resp.data.income;
                     this.expense  = resp.data.expense;
                     this.dateTo   = resp.data.date_to;
                     this.dateFrom = resp.data.date_from;
                   })
                   .catch(err => {
                    Exception.handle(err, 'admin');
                  });

                this.overlay = false;
              },
              searchData(){
                this.overlay = true;
                  axios.get(`report/get/ploss/${this.dateFrom}/${this.dateTo}`)
                    .then(resp => {
                     this.income   = resp.data.income;
                     this.expense  = resp.data.expense;
                     this.dateTo   = resp.data.date_to;
                     this.dateFrom = resp.data.date_from;
                   })
                   .catch(err => {
                    Exception.handle(err, 'admin');
                  });
                this.overlay = false;
              },
              printReport()
              {
                  let routeData = this.$router.resolve({name: 'print-ploss-report',  params:{
                                                                                        dateFrom:this.dateFrom,
                                                                                        dateTo:this.dateTo
                                                                                      }});
                  window.open(routeData.href, '_blank');
              },
        }
  }
</script>
