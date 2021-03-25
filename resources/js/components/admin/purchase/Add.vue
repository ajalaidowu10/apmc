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
                 Add Purchase 
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit Purchase
              </div>
              
              
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewData"
                >
                  <span class="d-none d-md-flex">View Purchase</span>
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
                cols="6"
                >
                <v-combobox
                  v-model="form.acct"
                  label="Account"
                  :items="acct"
                  item-text="name"
                  item-value="id"
                  :error-messages="acctErrors"
                  @input="$v.form.acct.$touch()"
                  @blur="$v.form.acct.$touch()"
                  dense
                  @change="setAcct($event)"
                  outlined
                >
                </v-combobox>
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
              <v-col
                cols="4"
               >
                <v-text-field
                  outlined
                  dense
                  label="Invoice No."
                  v-model="form.invoiceNo"
                ></v-text-field>
              </v-col>
              <v-col
                cols="4"
               >
                <v-text-field
                  outlined
                  dense
                  label="Motor No."
                  v-model="form.motorNo"
                  :error-messages="motorNoErrors"
                  @input="$v.form.motorNo.$touch()"
                  @blur="$v.form.motorNo.$touch()"
                  required
                ></v-text-field>
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
                  v-model="form.item"
                  label="Item"
                  :items="item"
                  item-text="item"
                  item-value="item_id"
                  :error-messages="itemErrors"
                  @input="$v.form.item.$touch()"
                  @blur="$v.form.item.$touch()"
                  dense
                  @change="setItem($event)"
                  outlined
                ></v-combobox>
              </v-col>
              <v-col
                cols="2"
               >
                <v-text-field
                  outlined
                  dense
                  label="Quantity"
                  v-model="form.qty"
                  type="number"
                  :error-messages="qtyErrors"
                  @input="$v.form.qty.$touch()"
                  @blur="$v.form.qty.$touch()"
                  required
                ></v-text-field>
              </v-col>
              <v-col
                cols="2"
               >
                <v-text-field
                  outlined
                  dense
                  label="GRWT"
                  v-model="form.grwt"
                  type="number"
                  :error-messages="grwtErrors"
                  @input="$v.form.grwt.$touch()"
                  @blur="$v.form.grwt.$touch()"
                  required
                ></v-text-field>
              </v-col>
              <v-col
                cols="2"
               >
                <v-text-field
                  outlined
                  dense
                  label="Rate"
                  v-model="form.rate"
                  type="number"
                  :error-messages="rateErrors"
                  @input="$v.form.rate.$touch()"
                  @blur="$v.form.rate.$touch()"
                  required
                ></v-text-field>
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
                          ITEM
                        </th>
                        <th class="text-left">
                          QUANTITY
                        </th>
                        <th class="text-left">
                          GRWT
                        </th>
                        <th class="text-left">
                          RATE
                        </th>
                        <th class="text-left">
                          AMOUNT
                        </th>
                        <th class="text-left">
                          Expense
                        </th>
                        <th class="text-left">
                         Final AMOUNT
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
                        v-for="(item, index) in purchaseOrderItems"
                        :key="index"
                        :class="[index==cartEdit ? 'success lighten-5' : '', item.delRecord ? 'red lighten-5' : '']"
                       >
                        <td>{{ index }}</td>
                        <td>{{ item.item }}</td>
                        <td>{{ item.qty }}</td>
                        <td>{{ item.grwt }}</td>
                        <td>{{ item.rate }}</td>
                        <td>{{ item.amount }}</td>
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
                      <tr v-if="getTotalPurchaseCartAmount()">
                        <td colspan="2"><strong>TOTAL AMOUNT</strong></td>
                        <td><strong>{{ getTotalPurchaseCartQty() }}</strong></td>
                        <td colspan="2"><strong>{{ getTotalPurchaseCartGrwt() }}</strong></td>
                        <td><strong>{{ getTotalPurchaseCartAmount() }}</strong></td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
              </v-col>
            </v-row>
            <v-row>
              <v-col
                cols="2"
               >
                <v-text-field
                  outlined
                  dense
                  disabled
                  label="LEVY"
                  type="number"
                  :value="levy"
                ></v-text-field>
              </v-col>
              <v-col
                cols="2"
               >
                <v-text-field
                  outlined
                  dense
                  disabled
                  label="APMC"
                  type="number"
                  :value="apmc"
                ></v-text-field>
              </v-col>
              <v-col
                cols="2"
               >
                <v-text-field
                  outlined
                  dense
                  disabled
                  label="MAP LEVY"
                  type="number"
                  :value="mapLevy"
                ></v-text-field>
              </v-col>
              <v-col
                cols="2"
               >
                <v-text-field
                  outlined
                  dense
                  disabled
                  label="COMM"
                  type="number"
                  :value="comm"
                ></v-text-field>
              </v-col>
                <v-col
                cols="2"
               >
                <v-text-field
                  outlined
                  dense
                  disabled
                  label="TDS"
                  type="number"
                  :value="tds"
                ></v-text-field>
              </v-col>
              <v-col
                cols="2"
               >
                <v-text-field
                  outlined
                  dense
                  disabled
                  label="FINAL AMOUNT"
                  type="number"
                  :value="finalAmount"
                ></v-text-field>
              </v-col>
              <v-col
                cols="2"
               >
                <v-text-field
                  outlined
                  dense
                  label="Other Charges"
                  v-model="form.otherCharges"
                  type="number"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="2">
                <v-text-field
                  outlined
                  color="success"
                  dense
                  disabled
                  label="Total Amount"
                  :value="getTotalPurchaseAmount"
                  type="number"
                ></v-text-field>
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
               min-width="300"
               x-large
               @click="clearData"
               >
               New Sales
             </v-btn>
            </v-col>
            <v-col
              cols="6"
              >
              <v-btn
               color="primary"
               class="pa-10"
               dark
               min-width="300"
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
  import { required, numeric } from 'vuelidate/lib/validators';
  import transformKeys from '../../../utils/transformKeys';
  export default {
     mixins: [validationMixin],
     validations: {
         form:{
           qty:         {required},
           grwt:         {required},
           rate:         {required},
           item:        {required},
           acct:     {required},
           motorNo:       {required},
         }
     },
    data: () => ({
      permission: 'purchase-entry',
      orderid: 0,
      overlay: false,
      enterDate: new Date().toISOString().substr(0, 10),
      menuDate: false,
      cartEdit: -1,
      purchaseOrderItems: [],
      item: [],
      acct: [],
      form: {
              id: 0,
              qty: null,
              otherCharges: 0,
              grwt: null,
              motorNo: null,
              rate: null, 
              totalQty: null,
              item:null,
              itemId:null,
              itemObject: {},
              acct:null,
              acctId:null,
              overlay: false,
              allError: {},

      }
    }),
    created(){
      this.overlay = true;
      axios.get(`get/itemexp/${this.enterDate}`)
            .then(resp=>{
              console.log(resp.data.data);
              this.item = transformKeys.camelCase(resp.data.data);
            })
            .catch(err => Exception.handle(err, 'admin'));
      axios.get(`account/get/0/12`)
            .then(resp=>{
              this.acct = transformKeys.camelCase(resp.data.data);
            })
            .catch(err => Exception.handle(err, 'admin'));
      if (this.$route.params.orderid) {
        this.orderid = this.$route.params.orderid;
        axios.get(`purchaseorder/${this.orderid}`)
             .then(resp => {
              let getSalesOrder         = transformKeys.camelCase(resp.data.data);
              this.form.acct            = getSalesOrder.acct;
              this.form.otherCharges    = getSalesOrder.otherCharges;
              this.form.acctId          = getSalesOrder.acctId;
              this.form.invoiceNo       = getSalesOrder.invoiceNo;
              this.form.motorNo         = getSalesOrder.motorNo;
              this.enterDate            = getSalesOrder.enterDate;
              this.purchaseOrderItems   = getSalesOrder.purchaseOrderItems;
              this.orderid              = getSalesOrder.id;
             })
             .catch(err => Exception.handle(err, 'admin'));
      }
      this.overlay = false;
      
    },
    computed: {
      levy(){
        let dataArray = this.purchaseOrderItems.filter(data => data.delRecord == 0);
        if (dataArray.length > 0) {
          return dataArray.reduce((prev, cur) => ({newLevy: Number(prev.newLevy) + Number(cur.newLevy)})).newLevy.toFixed(2);
        }
        return 0;
        
      },
      apmc(){
        let dataArray = this.purchaseOrderItems.filter(data => data.delRecord == 0);
        if (dataArray.length > 0) {
          return dataArray.reduce((prev, cur) => ({newApmc: Number(prev.newApmc) + Number(cur.newApmc)})).newApmc.toFixed(2);
        }
        return 0;
        
      },
      mapLevy(){
        let dataArray = this.purchaseOrderItems.filter(data => data.delRecord == 0);
        if (dataArray.length > 0) {
          return dataArray.reduce((prev, cur) => ({newMapLevy: Number(prev.newMapLevy) + Number(cur.newMapLevy)})).newMapLevy.toFixed(2);
        }
        return 0;
        
      },
      comm(){
        let dataArray = this.purchaseOrderItems.filter(data => data.delRecord == 0);
        if (dataArray.length > 0) {
          return dataArray.reduce((prev, cur) => ({newComm: Number(prev.newComm) + Number(cur.newComm)})).newComm.toFixed(2);
        }
        return 0;
        
      },
      tds(){
        let dataArray = this.purchaseOrderItems.filter(data => data.delRecord == 0);
        if (dataArray.length > 0) {
          return dataArray.reduce((prev, cur) => ({newTds: Number(prev.newTds) + Number(cur.newTds)})).newTds.toFixed(2);
        }
        return 0;
        
      },
      finalAmount(){
        let dataArray = this.purchaseOrderItems.filter(data => data.delRecord == 0);
        if (dataArray.length > 0) {
          return dataArray.reduce((prev, cur) => ({finalAmount: Number(prev.finalAmount) + Number(cur.finalAmount)})).finalAmount.toFixed(2);
        }
        return 0;
        
      },
      itemErrors () {
        const errors = [];
        if (!this.$v.form.item.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'itemId') {
            errors.push(this.form.allError.itemId[0]);
            break;
          } 

        } 
        !this.$v.form.item.required && errors.push('Item is required')
        return errors
      },
      acctErrors () {
        const errors = [];
        if (!this.$v.form.acct.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'acctId') {
            errors.push(this.form.allError.acctId[0]);
            break;
          } 

        } 
        !this.$v.form.acct.required && errors.push('Account is required')
        return errors
      },
      qtyErrors () {
        const errors = []
        if (!this.$v.form.qty.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'qty') {
            errors.push(this.form.allError.qty[0]);
            break;
          } 

        } 
        !this.$v.form.qty.required && errors.push('Quantity is required')
        return errors
      },
      grwtErrors () {
        const errors = []
        if (!this.$v.form.grwt.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'grwt') {
            errors.push(this.form.allError.grwt[0]);
            break;
          } 

        } 
        !this.$v.form.grwt.required && errors.push('Growth Weight is required')
        return errors
      },
      rateErrors () {
        const errors = []
        if (!this.$v.form.rate.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'rate') {
            errors.push(this.form.allError.rate[0]);
            break;
          } 

        } 
        !this.$v.form.rate.required && errors.push('Rate is required')
        return errors
      },
      motorNoErrors () {
        const errors = []
        if (!this.$v.form.motorNo.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'motorNo') {
            errors.push(this.form.allError.motorNo[0]);
            break;
          } 

        } 
        !this.$v.form.motorNo.required && errors.push('Motor No. is required')
        return errors
      },
      getTotalPurchaseAmount()
        {
          return Number(this.finalAmount) +  Number(this.form.otherCharges);
        },
      
    },
    methods: {
          setItem(data){
            this.form.itemId = data.itemId;
            this.form.item = data.item;
            this.form.itemObject = data;
          },
          setAcct(data){
            this.form.acctId = data.id;
            this.form.acct = data.name;
          },
          viewData(){
            this.$router.push({name:'view-purchase'});
          },
          async createPurchase(id, item, itemId, rate, grwt, itemObject, qty, delRecord)
          {
            let cartItem = {};
            cartItem.id = id;
            cartItem.itemId = itemId;
            cartItem.item = item;
            cartItem.rate = rate;
            cartItem.grwt = grwt;
            cartItem.qty = qty;
            cartItem.itemObject = itemObject;
            cartItem.unit = itemObject.unit;
            cartItem.weightPb = itemObject.weightPb;
            cartItem.tolai = itemObject.tolai;
            cartItem.tds = itemObject.tds;
            cartItem.pLevy = itemObject.pLevy;
            cartItem.bLevy = itemObject.bLevy;
            cartItem.pHamali = itemObject.pHamali;
            cartItem.bHamali = itemObject.bHamali;
            cartItem.mapLevy = itemObject.mapLevy;
            cartItem.apmc = itemObject.apmc;
            cartItem.comm = itemObject.comm;
            cartItem.discount = itemObject.discount;

            cartItem.amount = (cartItem.grwt * cartItem.rate) / cartItem.unit;
            cartItem.unitGrwt = cartItem.grwt/ cartItem.qty;
            cartItem.levy =  (cartItem.unitGrwt >= cartItem.weightPb) ? cartItem.bLevy : cartItem.pLevy;

            cartItem.newLevy = cartItem.levy * cartItem.qty;
            cartItem.newApmc = cartItem.apmc/100 * cartItem.amount;
            cartItem.newMapLevy = cartItem.mapLevy * cartItem.grwt;
            cartItem.newComm = cartItem.comm/100 *cartItem.amount;
            cartItem.newTds = cartItem.tds/100 * cartItem.newComm;
            cartItem.exp = cartItem.newLevy + cartItem.newApmc + cartItem.newMapLevy + cartItem.newComm;
            cartItem.finalAmount = cartItem.exp + cartItem.amount;
            cartItem.delRecord= delRecord;

            console.log(cartItem);

            return cartItem;
          },
          addPurchaseCart(cartItem)
          {
            this.purchaseOrderItems.push(cartItem);
          },
          setEditCart(cartItem, index)
          {
            this.form.id = cartItem.id;
            this.form.item = cartItem.item;
            this.form.itemId = cartItem.itemId;
            this.form.rate = cartItem.rate;
            this.form.qty = cartItem.qty;
            this.form.grwt = cartItem.grwt;
            this.form.itemObject = cartItem.itemObject;
            this.cartEdit = index;
          },
          setDeleteCart(cartItem, index)
          {
            if (this.orderid) {
             this.deletePurchaseCart(cartItem, index);
            }else{
              this.removePurchaseCart(index);
            }
            
          },
          editPurchaseCart(cartItem, index)
          {
            this.purchaseOrderItems = this.purchaseOrderItems.map((item, i) => { 
                if (index == i) 
                { 
                  item = cartItem;
                } 
              return item; 
            });
          },
          deletePurchaseCart(cartItem, index)
          {
            cartItem.delRecord = 1;
            this.editPurchaseCart(cartItem, index);
          },
          removePurchaseCart(index)
          {
           this.purchaseOrderItems.splice(index, 1);
          },
          clearPurchaseCart(index)
          {
            this.purchaseOrderItems = [];
          },
          getTotalPurchaseCartAmount()
          {
            let dataArray = this.purchaseOrderItems.filter(data => data.delRecord == 0);
            if (dataArray.length > 0) {
              return dataArray.reduce((prev, cur) => ({amount: Number(prev.amount) + Number(cur.amount)})).amount
            }
            return 0;
          },
          getTotalPurchaseCartQty()
          { 
            let dataArray = this.purchaseOrderItems.filter(data => data.delRecord == 0);
            if (dataArray.length > 0) {
              return dataArray.reduce((prev, cur) => ({qty: Number(prev.qty) + Number(cur.qty)})).qty
            }
            return 0;
          },
          getTotalPurchaseCartGrwt()
          { 
            let dataArray = this.purchaseOrderItems.filter(data => data.delRecord == 0);
            if (dataArray.length > 0) {
              return dataArray.reduce((prev, cur) => ({grwt: Number(prev.grwt) + Number(cur.grwt)})).grwt
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

            this.createPurchase(
              this.form.id, this.form.item, this.form.itemId, 
              this.form.rate, this.form.grwt, this.form.itemObject, this.form.qty, 0
              )
                .then(resp => {

                  if (this.cartEdit >= 0) 
                  {
                    this.editPurchaseCart(resp, this.cartEdit);
                    this.cartEdit = -1;
                  }else {
                    this.addPurchaseCart(resp);
                  }
                    
                  this.form.item = this.form.qty = this.form.rate = this.form.grwt = this.form.unit = null;
                  this.$v.form.$reset();
                })
                .catch(err => console.log(err));
          },
          clearData(){
            this.clearPurchaseCart();
            this.form =    {
                              id: 0,
                              qty: null,
                              rate:null,
                              grwt:null,
                              unit:null,
                              item:null,
                              itemId:null,
                              acct:null,
                              acctId:null,
                              overlay: false,
                              allError: {},
                            }
            this.$v.form.$reset();
          },
          saveData(){
            if (this.purchaseOrderItems.length === 0) {
               swal('Notification', 'Tranjection is empty');
               return;
            }
            
            let data = {};
            data['acctId']              = this.form.acctId;
            data['motorNo']             = this.form.motorNo;
            data['invoiceNo']           = this.form.invoiceNo;
            data['comm']                = this.form.comm;
            data['apmc']                = this.form.apmc;
            data['otherCharges']        = this.form.otherCharges;
            data['totalAmount']         = this.getTotalPurchaseAmount;
            data['totalQty']            = this.getTotalPurchaseCartQty();
            data['purchaseOrderItems']  = this.purchaseOrderItems;
            data['enterDate']           = this.enterDate;

            console.log(transformKeys.snakeCase(data));
            this.overlay = true;
            if (this.orderid != 0) 
            {
              axios.patch(`purchaseorder/${this.orderid}`, transformKeys.snakeCase(data))
                    .then(resp =>{
                      this.$router.push({name:'view-purchase', params: { message: `Purchase ${resp.data.orderid} Updated Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      console.log(this.form.allError);
                    });
            }
            else
            {
              axios.post(`purchaseorder`, transformKeys.snakeCase(data))
                    .then(resp =>{
                      this.$router.push({name:'view-purchase', params: { message: `Purchase with ID ${resp.data.orderid} Added Successfully` }});
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
