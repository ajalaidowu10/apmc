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
                 Add Cashbank
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit Cashbank
              </div>
              
              
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewData"
                >
                  <span class="d-none d-md-flex">View Cashbank</span>
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
                <v-combobox
                  v-model="form.cashbankType"
                  label="Type"
                  :items="cashbankType"
                  item-text="name"
                  item-value="id"
                  :error-messages="cashbankTypeErrors"
                  @input="$v.form.cashbankType.$touch()"
                  @blur="$v.form.cashbankType.$touch()"
                  dense
                  @change="setCashbankType($event)"
                  outlined
                ></v-combobox>
              </v-col>
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
                      v-model="enterDateComputed"
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
              <v-col cols="4"></v-col>
              <v-col
                cols="4"
                >
                <v-combobox
                  v-model="form.paymentType"
                  label="Payment Type"
                  :items="paymentType"
                  item-text="name"
                  item-value="id"
                  :error-messages="paymentTypeErrors"
                  @input="$v.form.paymentType.$touch()"
                  @blur="$v.form.paymentType.$touch()"
                  dense
                  @change="setPaymentType($event)"
                  outlined
                ></v-combobox>
              </v-col>
              <v-col
                cols="4"
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
                  v-model="form.acctTwo"
                  label="Account"
                  :items="acctTwo"
                  item-text="name"
                  item-value="id"
                  :error-messages="acctTwoErrors"
                  @input="$v.form.acctTwo.$touch()"
                  @blur="$v.form.acctTwo.$touch()"
                  dense
                  @change="setAccountTwo($event)"
                  outlined
                ></v-combobox>
              </v-col>
              <v-col
                cols="3"
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
                cols="3"
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
                        v-for="(item, index) in cashbankOrderItems"
                        :key="index"
                        :class="[index==cartEdit ? 'success lighten-5' : '', item.delRecord ? 'red lighten-5' : '']"
                       >
                        <td>{{ index }}</td>
                        <td>{{ item.acctTwo }}</td>
                        <td>{{ item.amount }}</td>
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
                      <tr v-if="getTotalCashbankCartAmount()">
                        <td colspan="2"><strong>TOTAL AMOUNT</strong></td>
                        <td><strong>{{ getTotalCashbankCartAmount() }}</strong></td>
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
               New Cashbank
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
  import { required,  minLength, email, numeric } from 'vuelidate/lib/validators';
  import transformKeys from '../../../utils/transformKeys';
  export default {
     mixins: [validationMixin],
     validations: {
         form:{
           cashbankType:  {required},
           amount:          {required},
           paymentType:   {required},
           acctOne:     {required},
           acctTwo:     {required},
           descp:     {required},
         }
     },
    data: () => ({
      orderid: 0,
      permission: 'cash-bank',
      overlay: false,
      narration: [],
      enterDate: new Date().toISOString().substr(0, 10),
      menuDate: false,
      cartEdit: -1,
      cashbankOrderItems: [],
      cashbankType: [
                      {                                                                                                
                        id:1,                                                                                                 
                        name: "Receipt",                                                                                  
                      }, 
                      {                                                                                                
                        id:2,                                                                                                 
                        name: "Payment",                                                                                  
                      }, 
                ],
      paymentType: [
                      {                                                                                                
                        id:1,                                                                                                 
                        name: "Cash",                                                                                  
                      }, 
                      {                                                                                                
                        id:2,                                                                                                 
                        name: "Bank",                                                                                  
                      }, 
                ],
      acctOne: [],
      acctTwo: [],
      form: {
              id: 0,
              amount: null,
              cashbankType:null,
              cashbankTypeId:null,
              paymentType:null,
              paymentTypeId:null,
              acctOne:null,
              descp:null,
              acctOneId:null,
              acctTwo:null,
              acctTwoId:null,
              overlay: false,
              allError: {},

      }
    }),
    created(){
      this.overlay = true;
      axios.get(`account`)
            .then(resp=>{
              this.acctTwo = transformKeys.camelCase(resp.data.data);
            })
            .catch(err => Exception.handle(err, 'admin'));
      axios.get(`narration`)
            .then(resp=>{
              this.narration = transformKeys.camelCase(resp.data.data);
            })
            .catch(err => Exception.handle(err, 'admin'));
      if (this.$route.params.orderid) {
        this.orderid = this.$route.params.orderid;
        axios.get(`cashbank/${this.orderid}`)
             .then(resp => {
              let getCashbankOrder         = transformKeys.camelCase(resp.data.data);
              this.form.cashbankType       = getCashbankOrder.cashbankType;
              this.form.cashbankTypeId     = getCashbankOrder.cashbankTypeId;
              this.form.paymentType        = getCashbankOrder.paymentType;
              this.form.paymentTypeId      = getCashbankOrder.paymentTypeId;
              this.form.acctOne            = getCashbankOrder.acctOne;
              this.form.acctOneId          = getCashbankOrder.acctOneId;
              this.enterDate               = getCashbankOrder.enterDate;
              this.cashbankOrderItems      = getCashbankOrder.cashbankOrderItems;
              this.orderid                 = getCashbankOrder.id;
             })
             .catch(err => Exception.handle(err, 'admin'));
      }
      this.overlay = false;
      
    },
    computed: {
      paymentTypeErrors () {
        const errors = [];
        if (!this.$v.form.paymentType.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'paymentTypeId') {
            errors.push(this.form.allError.paymentTypeId[0]);
            break;
          } 

        } 
        !this.$v.form.paymentType.required && errors.push('Payment  Type is required')
        return errors
      },
      cashbankTypeErrors () {
        const errors = [];
        if (!this.$v.form.cashbankType.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'cashbankTypeId') {
            errors.push(this.form.allError.cashbankTypeId[0]);
            break;
          } 

        } 
        !this.$v.form.cashbankType.required && errors.push('Cashbank Type is required')
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
      acctTwoErrors () {
        const errors = [];
        if (!this.$v.form.acctTwo.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'acctTwoId') {
            errors.push(this.form.allError.acctTwoId[0]);
            break;
          } 

        } 
        !this.$v.form.acctTwo.required && errors.push('Account is required')
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
          setCashbankType(data){
            this.form.cashbankTypeId = data.id;
          },
          setAccountOne(data){
            this.form.acctOneId = data.id;
          },
          setAccountTwo(data){
            this.form.acctTwoId = data.id;
            this.form.acctTwo = data.name;
          },
          setNarration(data){
            this.form.descp = data.name;
          },
          setPaymentType(data){
            this.form.paymentTypeId = data.id;
            this.overlay = true;
            axios.get(`account/get/${this.form.paymentTypeId}`)
                  .then(resp=>{
                    this.acctOne = transformKeys.camelCase(resp.data.data);
                  })
                  .catch(err => Exception.handle(err, 'admin'));
           this.overlay = false;
          },
          viewData(){
            this.$router.push({name:'view-cashbank'});
          },
          async createCashBank(id, acctTwo, acctTwoId, amount, descp, delRecord)
          {
            let cartItem = {};
            cartItem.id = id;
            cartItem.acctTwoId = acctTwoId;
            cartItem.acctTwo = acctTwo;
            cartItem.amount = amount;
            cartItem.descp = descp;
            cartItem.delRecord= delRecord;

            return cartItem;

          },
          addCashbankCart(cartItem)
          {
            this.cashbankOrderItems.push(cartItem);
          },
          setEditCart(cartItem, index)
          {
            this.form.id = cartItem.id;
            this.form.acctTwo = cartItem.acctTwo;
            this.form.acctTwoId = cartItem.acctTwoId;
            this.form.amount = cartItem.amount;
            this.form.descp = cartItem.descp;
            this.cartEdit = index;
          },
          setDeleteCart(cartItem, index)
          {
            if (this.orderid) {
             this.deleteCashbankCart(cartItem, index);
            }else{
              this.removeCashbankCart(index);
            }
            
          },
          editCashbankCart(cartItem, index)
          {
            this.cashbankOrderItems = this.cashbankOrderItems.map((item, i) => { 
                if (index == i) 
                { 
                  item = cartItem;
                } 
              return item; 
            });
          },
          deleteCashbankCart(cartItem, index)
          {
            cartItem.delRecord = 1;
            this.editCashbankCart(cartItem, index);
          },
          removeCashbankCart(index)
          {
           this.cashbankOrderItems.splice(index, 1);
          },
          clearCashbankCart(index)
          {
            this.cashbankOrderItems = [];
          },
          getTotalCashbankCartAmount()
          {
            let dataArray = this.cashbankOrderItems.filter(data => data.delRecord == 0);
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

            this.createCashBank(this.form.id, this.form.acctTwo, this.form.acctTwoId, this.form.amount, this.form.descp, 0)
                .then(resp => {

                  if (this.cartEdit >= 0) 
                  {
                    this.editCashbankCart(resp, this.cartEdit);
                    this.cartEdit = -1;
                  }else {
                    this.addCashbankCart(resp);
                  }
                    
                  this.form.acctTwo = this.form.amount = this.form.descp = null;
                  this.$v.form.$reset();
                })
                .catch(err => console.log(err));
          },
          clearData(){
            this.clearCashbankCart();
            this.form =    {
                              id: 0,
                              amount: null,
                              cashbankType:null,
                              cashbankTypeId:null,
                              paymentType:null,
                              paymentTypeId:null,
                              acctOne:null,
                              acctOneId:null,
                              acctTwo:null,
                              acctTwoId:null,
                              overlay: false,
                              allError: {},
                            }
            this.$v.form.$reset();
          },
          saveData(){
            if (this.cashbankOrderItems.length === 0) {
               swal('Notification', 'Tranjection is empty');
               return;
            }
            let data = {};
            data['cashbankTypeId']      = this.form.cashbankTypeId;
            data['paymentTypeId']       = this.form.paymentTypeId;
            data['acctOneId']           = this.form.acctOneId;
            data['totalAmount']         = this.getTotalCashbankCartAmount();
            data['enterDate']           = this.enterDate;
            data['cashbankOrderItems']  = this.cashbankOrderItems;


            this.overlay = true;
            if (this.orderid != 0) 
            {
              axios.patch(`cashbank/${this.orderid}`, transformKeys.snakeCase(data))
                    .then(resp =>{
                      this.$router.push({name:'view-cashbank', params: { message: `Cashbank ${resp.data.orderid} Updated Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      if (!this.form.allError) Exception.handle(err, 'admin');
                    });
            }
            else
            {
              axios.post(`cashbank`, transformKeys.snakeCase(data))
                    .then(resp =>{
                      this.$router.push({name:'view-cashbank', params: { message: `Cashbank with ID ${resp.data.orderid} Added Successfully` }});
                    })
                    .catch(err => {
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      if (!this.form.allError) Exception.handle(err, 'admin');
                    });
            }
            this.overlay = false;
          },
      },
  }
</script>
