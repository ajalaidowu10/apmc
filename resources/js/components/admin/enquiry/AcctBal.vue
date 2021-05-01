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
              Enquiry Account Balance
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
                      DATE
                    </th>
                    <th class="text-left">
                      ACCOUNT
                    </th>
                    <th class="text-left">
                      BALANCE
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="success lighten-5">
                    <td>{{ formatDate(searchDateTo) }}</td>
                    <td>{{ searchAcctName }}</td>
                    <td v-if="open_bal < 0"><strong>{{ open_bal * -1 }} DR</strong></td>
                    <td v-else-if="open_bal > 0"><strong>{{ open_bal  }} CR</strong></td>
                    <td v-else><strong>00.00</strong></td>
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
              @click="printEnquiry"
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
      permission: 'account-bal',
      open_bal: 0,
      search: '',
      acctId: null,
      acctName: null,
      searchAcctName: null,
      searchDateTo: null,
      acct: [],
      dateTo: new Date().toISOString().substr(0, 10),
      menuFrom: false,
      menuTo: false,
      overlay: false,
    }),
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
                      .catch(err => Exception.handle(err, 'admin'));
                this.overlay = false;
              },
              setAccountOne(data){
                this.acctId = data.id;
                this.acctName = data.name;
              },
              searchData(){
                this.overlay = true;
                  axios.get(`acctbal/${this.acctId}/${this.dateTo}/2/1`)
                     .then(resp => {
                      console.log(resp);
                      this.open_bal = resp.data;
                      this.searchAcctName = this.acctName;
                      this.searchDateTo = this.dateTo;
                    })
                     .catch(err => {
                      Exception.handle(err, 'admin');
                    });
                this.overlay = false;
              },
              printEnquiry()
              {
                  let routeData = this.$router.resolve({name: 'print-acctbal-report',  params:{
                                                                                        acctId:this.acctId,
                                                                                        dateTo:this.dateTo, 
                                                                                      }});
                  window.open(routeData.href, '_blank');
              },
        }
  }
</script>
