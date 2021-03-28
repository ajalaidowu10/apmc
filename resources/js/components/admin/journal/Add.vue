<template>
  <v-container class="mt-n10" v-if="hasAccess">
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
              <div v-if="orderid == 0">
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-plus-outline
                </v-icon>
                 Add Journal
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit Journal
              </div>
              
              
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewData"
                >
                  <span class="d-none d-md-flex">View Journal</span>
                  <v-icon >
                    mdi-book-search-outline
                  </v-icon>
                </v-btn>
              </template>
            </v-banner>
            <br>
          </v-col>
        </v-row>
        <v-container>
          <v-card
            class="pa-5"
            elevation="2"
            >
            <v-row>
              <v-col
                cols="4"
                >
                <v-menu
                  ref="menuDate"
                  v-model="menuDate"
                  :close-on-content-click="false"
                  :return-value.sync="enterDate"
                  transition="scale-transition"
                  offset-y
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      outlined
                      dense
                      v-model="enterDate"
                      label="Date"
                      append-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="enterDate"
                    no-title
                    scrollable
                  >
                    <v-spacer></v-spacer>
                    <v-btn
                      text
                      color="primary"
                      @click="menuDate = false"
                    >
                      Cancel
                    </v-btn>
                    <v-btn
                      text
                      color="primary"
                      @click="$refs.menuDate.save(enterDate)"
                    >
                      OK
                    </v-btn>
                  </v-date-picker>
                </v-menu>
              </v-col>
            </v-row>
          </v-card>
          <v-card
            class="pa-5 mt-5"
            elevation="2"
            >
            <v-row>
              <v-col
                cols="3"
                >
                <v-combobox
                  v-model="form.acctOne"
                  label="Account"
                  :items="acctOne"
                  item-text="name"
                  item-value="id"
                  :error-messages="acctOneErrors"
                  @input="$v.form.acctOne.$touch()"
                  @blur="$v.form.acctOne.$touch()"
                  dense
                  @change="setAccountOne($event)"
                  outlined
                ></v-combobox>
              </v-col>
              <v-col
                cols="2"
               >
                <v-text-field
                  outlined
                  dense
                  label="Amount"
                  v-model="form.amount"
                  type="number"
                  :error-messages="amountErrors"
                  @input="$v.form.amount.$touch()"
                  @blur="$v.form.amount.$touch()"
                  required
                ></v-text-field>
              </v-col>
              <v-col
                cols="2"
                >
                <v-combobox
                  v-model="form.crdr"
                  label="CREDIT/DEBIT"
                  :items="crdr"
                  item-text="name"
                  item-value="id"
                  :error-messages="crdrErrors"
                  @input="$v.form.crdr.$touch()"
                  @blur="$v.form.crdr.$touch()"
                  dense
                  @change="setCrdr($event)"
                  outlined
                ></v-combobox>
              </v-col>
              <v-col
                cols="3"
                >
                <v-combobox
                  v-model="form.descp"
                  label="Narration"
                  :items="narration"
                  item-text="name"
                  item-value="name"
                  :error-messages="descpErrors"
                  @input="$v.form.descp.$touch()"
                  @blur="$v.form.descp.$touch()"
                  dense
                  @change="setNarration($event)"
                  outlined
                ></v-combobox>
              </v-col>
              <v-col
                cols="2"
               >
                 <v-btn
                  class="px-10"
                  color="primary"
                  @click="addTran"
                  >
                  Add
                </v-btn>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12">
                <v-simple-table
                  fixed-header
                  >
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left">
                          S/No
                        </th>
                        <th class="text-left">
                          ACCOUNT
                        </th>
                        <th class="text-left">
                          AMOUNT
                        </th>
                        <th class="text-left">
                          CREDIT/DEBIT
                        </th>
                        <th class="text-left">
                          NARRATION
                        </th>
                        <th class="text-left">
                          EDIT
                        </th>
                        <th class="text-left"> 
                          DELETE
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(item, index) in journalOrderItems"
                        :key="index"
                        :class="[index==cartEdit ? 'success lighten-5' : '', item.delRecord ? 'red lighten-5' : '']"
                       >
                        <td>{{ index }}</td>
                        <td>{{ item.acctOne }}</td>
                        <td>{{ item.amount }}</td>
                        <td>{{ item.crdr }}</td>
                        <td>{{ item.descp }}</td>
                        <td v-if="item.delRecord">
                          <v-btn text color="deep-purple accent-4">
                            <v-icon>>mdi-trash-can-outline </v-icon>
                          </v-btn> 
                        </td>
                        <td v-else>
                          <v-btn text color="deep-purple accent-4" @click="setEditCart(item, index)">
                            <v-icon>mdi-square-edit-outline </v-icon>
                          </v-btn> 
                        </td>
                        <td v-if="item.delRecord">
                          <v-btn text color="deep-purple accent-4"> 
                            <v-icon>mdi-trash-can-outline</v-icon>
                          </v-btn> 
                        </td>
                        <td v-else>
                          <v-btn text color="deep-purple accent-4" @click="setDeleteCart(item, index)"> 
                            <v-icon>mdi-trash-can-outline</v-icon>
                          </v-btn> 
                        </td>
                      </tr>
                      <tr v-if="getTotalJournalCartCrAmount()">
                        <td colspan="2"><strong>TOTAL CREDIT AMOUNT</strong></td>
                        <td colspan="5"><strong>{{ getTotalJournalCartCrAmount() }}</strong></td>
                      </tr>
                      <tr v-if="getTotalJournalCartDrAmount()">
                        <td colspan="2"><strong>TOTAL DEBIT AMOUNT</strong></td>
                        <td colspan="5"><strong>{{ getTotalJournalCartDrAmount() }}</strong></td>
                      </tr>

                    </tbody>
                  </template>
                </v-simple-table>
              </v-col>
            </v-row>
          </v-card>
          <v-row>
            <v-col
              cols="6"
              >
              <v-btn
               color="blue"
               class="pa-10"
               dark
                
               x-large
               @click="clearData"
               >
               New Journal
             </v-btn>
            </v-col>
            <v-col
              cols="6"
              >
              <v-btn
               color="primary"
               class="pa-10"
               dark
                
               x-large
               @click="saveData"
               >
               Save
               <v-icon
                 right
                 dark
                >
                 mdi-content-save-outline
               </v-icon>
             </v-btn>
            </v-col>

          </v-row>
        </v-container>
      </v-card>
    </v-card>
    <v-overlay :value="overlay">
      <v-progress-circular
        indeterminate
        size="64"
      ></v-progress-circular>
    </v-overlay>
  </v-container>
</template>
<script>
  import { validationMixin } from 'vuelidate';
  import { required} from 'vuelidate/lib/validators';
  import transformKeys from '../../../utils/transformKeys';
  export default {
     mixins: [validationMixin],
     validations: {
         form:{
           crdr:  {required},
           amount:          {required},
           acctOne:     {required},
           descp:     {required},
         }
     },
    data: () => ({
      permission: 'journal',
      orderid: 0,
      overlay: false,
      enterDate: new Date().toISOString().substr(0, 10),
      menuDate: false,
      cartEdit: -1,
      journalOrderItems: [],
      narration: [],
      crdr: [
                      {                                                                                                
                        id:1,                                                                                                 
                        name: "Cr",                                                                                  
                      }, 
                      {                                                                                                
                        id:2,                                                                                                 
                        name: "Dr",                                                                                  
                      }, 
                ],
      acctOne: [],
      form: {
              id: 0,
              amount: null,
              crdr:null,
              crdrId:null,
              acctOne:null,
              descp: null,
              acctOneId:null,
              overlay: false,
              allError: {},

      }
    }),
    created(){
      this.overlay = true;
      axios.get(`account`)
            .then(resp=>{
              this.acctOne = transformKeys.camelCase(resp.data.data);
            })
            .catch(err => Exception.handle(err, 'admin'));
      axios.get(`narration`)
            .then(resp=>{
              this.narration = transformKeys.camelCase(resp.data.data);
            })
            .catch(err => Exception.handle(err, 'admin'));
      if (this.$route.params.orderid) {
        this.orderid = this.$route.params.orderid;
        axios.get(`journal/${this.orderid}`)
             .then(resp => {
              let getJournalOrder          = transformKeys.camelCase(resp.data.data);
              this.enterDate               = getJournalOrder.enterDate;
              this.journalOrderItems       = getJournalOrder.journalOrderItems;
              this.orderid                 = getJournalOrder.id;
             })
             .catch(err => Exception.handle(err, 'admin'));
      }
      this.overlay = false;
      
    },
    computed: {
      crdrErrors () {
        const errors = [];
        if (!this.$v.form.crdr.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'crdrId') {
            errors.push(this.form.allError.crdrId[0]);
            break;
          } 

        } 
        !this.$v.form.crdr.required && errors.push('Credit/Debit is required')
        return errors
      },
      acctOneErrors () {
        const errors = [];
        if (!this.$v.form.acctOne.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'acctOneId') {
            errors.push(this.form.allError.acctOneId[0]);
            break;
          } 

        } 
        !this.$v.form.acctOne.required && errors.push('Cash/Bank Account is required')
        return errors
      },
      amountErrors () {
        const errors = []
        if (!this.$v.form.amount.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'amount') {
            errors.push(this.form.allError.amount[0]);
            break;
          } 

        } 
        !this.$v.form.amount.required && errors.push('Amount is required')
        return errors
      },
      descpErrors () {
        const errors = []
        if (!this.$v.form.descp.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'descp') {
            errors.push(this.form.allError.descp[0]);
            break;
          } 

        } 
        !this.$v.form.descp.required && errors.push('Narration is required')
        return errors
      },
      
    },
    methods: {
          setCrdr(data){
            this.form.crdrId = data.id;
            this.form.crdr = data.name;
          },
          setNarration(data){
            this.form.descp = data.name;
          },
          setAccountOne(data){
            this.form.acctOneId = data.id;
            this.form.acctOne = data.name;
          },
          viewData(){
            this.$router.push({name:'view-journal'});
          },
          async createCashBank(id, acctOne, acctOneId, crdr, crdrId, amount, descp, delRecord)
          {
            let cartItem = {};
            cartItem.id = id;
            cartItem.acctOneId = acctOneId;
            cartItem.acctOne = acctOne;
            cartItem.crdrId = crdrId;
            cartItem.crdr = crdr;
            cartItem.amount = amount;
            cartItem.descp = descp;
            cartItem.delRecord= delRecord;

            return cartItem;

          },
          addJournalCart(cartItem)
          {
            this.journalOrderItems.push(cartItem);
          },
          setEditCart(cartItem, index)
          {
            this.form.id = cartItem.id;
            this.form.acctOne = cartItem.acctOne;
            this.form.acctOneId = cartItem.acctOneId;
            this.form.crdr = cartItem.crdr;
            this.form.crdrId = cartItem.crdrId;
            this.form.amount = cartItem.amount;
            this.form.descp = cartItem.descp;
            this.cartEdit = index;
          },
          setDeleteCart(cartItem, index)
          {
            if (this.orderid) {
             this.deleteJournalCart(cartItem, index);
            }else{
              this.removeJournalCart(index);
            }
            
          },
          editJournalCart(cartItem, index)
          {
            this.journalOrderItems = this.journalOrderItems.map((item, i) => { 
                if (index == i) 
                { 
                  item = cartItem;
                } 
              return item; 
            });
          },
          deleteJournalCart(cartItem, index)
          {
            cartItem.delRecord = 1;
            this.editJournalCart(cartItem, index);
          },
          removeJournalCart(index)
          {
           this.journalOrderItems.splice(index, 1);
          },
          clearJournalCart(index)
          {
            this.journalOrderItems = [];
          },
          getTotalJournalCartCrAmount()
          {
            let dataArray = this.journalOrderItems.filter(data => (data.delRecord == 0 && data.crdrId == 1));
            if (dataArray.length > 0) {
              return dataArray.reduce((prev, cur) => ({amount: Number(prev.amount) + Number(cur.amount)})).amount
            }
            return 0;
          },
          getTotalJournalCartDrAmount()
          {
            let dataArray = this.journalOrderItems.filter(data => (data.delRecord == 0 && data.crdrId == 2));
            if (dataArray.length > 0) {
              return dataArray.reduce((prev, cur) => ({amount: Number(prev.amount) + Number(cur.amount)})).amount
            }
            return 0;
          },
          addTran()
          {
            this.$v.form.$touch();
            if (this.$v.form.$invalid) 
            {
              return;
            }

            this.createCashBank(this.form.id, this.form.acctOne, this.form.acctOneId, this.form.crdr, this.form.crdrId, this.form.amount, this.form.descp, 0)
                .then(resp => {

                  if (this.cartEdit >= 0) 
                  {
                    this.editJournalCart(resp, this.cartEdit);
                    this.cartEdit = -1;
                  }else {
                    this.addJournalCart(resp);
                  }
                    
                  this.form.acctOne = this.form.crdr = this.form.amount = this.form.descp = null;
                  this.$v.form.$reset();
                })
                .catch(err => console.log(err));
          },
          clearData(){
            this.clearJournalCart();
            this.form =    {
                              id: 0,
                              amount: null,
                              crdr:null,
                              crdrId:null,
                              acctOne:null,
                              acctOneId:null,
                              overlay: false,
                              allError: {},
                            }
            this.$v.form.$reset();
          },
          saveData(){
            if (this.journalOrderItems.length === 0) {
               swal('Notification', 'Tranjection is empty');
               return;
            }
            if (this.getTotalJournalCartCrAmount() != this.getTotalJournalCartDrAmount()) 
            {
              swal('Notification', 'Invalid Journal Transactions');
              return;
            }
            let data = {};
            data['totalCrAmount']         = this.getTotalJournalCartCrAmount();
            data['totalDrAmount']         = this.getTotalJournalCartDrAmount();
            data['enterDate']             = this.enterDate;
            data['journalOrderItems']     = this.journalOrderItems;


            this.overlay = true;
            if (this.orderid != 0) 
            {
              axios.patch(`journal/${this.orderid}`, transformKeys.snakeCase(data))
                    .then(resp =>{
                      this.$router.push({name:'view-journal', params: { message: `Journal ${resp.data.orderid} Updated Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      console.log(this.form.allError);
                    });
            }
            else
            {
              axios.post(`journal`, transformKeys.snakeCase(data))
                    .then(resp =>{
                      this.$router.push({name:'view-journal', params: { message: `Journal with ID ${resp.data.orderid} Added Successfully` }});
                    })
                    .catch(err => {
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      console.log(this.form.allError);
                    });
            }
            this.overlay = false;
          },
      },
  }
</script>
