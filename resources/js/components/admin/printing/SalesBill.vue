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
              Sales Bill
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
                    label="Customer Account"
                    :items="acct"
                    item-text="name"
                    item-value="id"
                    dense
                    @change="setAcct($event)"
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
                      CUSTOMER NAME
                    </th>
                    <th class="text-left">
                      TOTAL QTY
                    </th>
                    <th class="text-left">
                      TOTAL PRICE
                    </th>
                    <th class="text-left">
                      TOTAL CHARGES
                    </th>
                    <th class="text-left">
                      TOTAL COMMISSION
                    </th>
                    <th class="text-left">
                      TOTAL AMOUNT
                    </th>
                    <th class="text-left">
                      PRINT
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(item, index) in itemOrders"
                    :key="index"
                   >
                    <td>{{ item.enterdate }}</td>
                    <td>{{ item.acct_name }}</td>
                    <td>{{ item.total_qty }}</td>
                    <td>{{ item.total_price }}</td>
                    <td>{{ item.total_charges }}</td>
                    <td>{{ item.total_comm }}</td>
                    <td>{{ item.total_amount }}</td>
                    <td>
                      <v-btn
                        color="red"
                        text
                        small
                        @click="printBill(item.acct_id, item.enter_date)"
                      >
                        <v-icon>
                          mdi-file-pdf-outline
                        </v-icon>
                      </v-btn>
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-card>
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
      permission: 'sales-printing',
      search: '',
      dateFrom: new Date().toISOString().substr(0, 10),
      dateTo: new Date().toISOString().substr(0, 10),
      itemOrders: [],
      acct: [],
      acctId: 0,
      showGroup: 0,
      menuFrom: false,
      menuTo: false,
      overlay: false,
    }),
    created(){
       this.index();
    },
    methods: {
              setAcct(data){
                this.acctId = data.id;
              },
              index()
              {

                this.overlay = true;
                axios.get(`account/get/0/2`)
                      .then(resp=>{
                        this.acct = transformKeys.camelCase(resp.data.data);
                      })
                      // .catch(err => Exception.handle(err, 'admin'));
                axios.get(`report/salesbill/${this.dateFrom}/${this.dateTo}/${this.acctId}`)
                     .then(resp => {
                      this.itemOrders = resp.data;
                    })
                     .catch(err => {
                      // Exception.handle(err, 'admin');
                    });
                this.overlay = false;
              },
              searchData(){
                this.overlay = true;
                  axios.get(`report/salesbill/${this.dateFrom}/${this.dateTo}/${this.acctId}`)
                       .then(resp => {
                        this.itemOrders = resp.data;
                      })
                       .catch(err => {
                        // Exception.handle(err, 'admin');
                      });
                this.overlay = false;
              },
              printBill(acct_id, date)
              {
                  let routeData = this.$router.resolve({name: 'print-sales-bill',  params:{
                                                                                        acctId:acct_id,
                                                                                        date:date, 
                                                                                      }});
                  window.open(routeData.href, '_blank');
              },
        }
  }
</script>
