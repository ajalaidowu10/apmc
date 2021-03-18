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
                 Add Sales
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit Sales
              </div>
              
              
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewData"
                >
                  <span class="d-none d-md-flex">View Sales</span>
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
                  v-model="form.cusAcct"
                  label="Account"
                  :items="cusAcct"
                  item-text="name"
                  item-value="id"
                  :error-messages="cusAcctErrors"
                  @input="$v.form.cusAcct.$touch()"
                  @blur="$v.form.cusAcct.$touch()"
                  dense
                  @change="setCusAcct($event)"
                  outlined
                >
                </v-combobox>
              </v-col>
              <v-col
                cols="3"
                >
                <v-combobox
                  label="Booking ID"
                  :items="booking"
                  item-text="bookingOrderId"
                  item-value="bookingOrderId"
                  dense
                  @change="setBookingId($event)"
                  outlined
                ></v-combobox>
              </v-col>
              <v-col
                cols="3"
               >
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
                cols="8"
               >
                <v-text-field
                  outlined
                  dense
                  label="Narration"
                  v-model="form.descp"
                  :error-messages="descpErrors"
                  @input="$v.form.descp.$touch()"
                  @blur="$v.form.descp.$touch()"
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
                cols="6"
                >
                <v-combobox
                  v-model="form.item"
                  label="Item"
                  :items="item"
                  item-text="name"
                  item-value="id"
                  :error-messages="itemErrors"
                  @input="$v.form.item.$touch()"
                  @blur="$v.form.item.$touch()"
                  dense
                  @change="setItem($event)"
                  outlined
                ></v-combobox>
              </v-col>
              <v-col
                cols="3"
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
                          PRICE
                        </th>
                        <th class="text-left">
                          AMOUNT
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
                        v-for="(item, index) in salesOrderItems"
                        :key="index"
                        :class="[index==cartEdit ? 'success lighten-5' : '', item.delRecord ? 'red lighten-5' : '']"
                       >
                        <td>{{ index }}</td>
                        <td>{{ item.item }}</td>
                        <td>{{ item.qty }}</td>
                        <td>{{ item.itemPrice }}</td>
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
                      <tr v-if="getTotalSalesCartAmount()">
                        <td colspan="2"><strong>TOTAL AMOUNT</strong></td>
                        <td colspan="2"><strong>{{ getTotalSalesCartQty() }}</strong></td>
                        <td><strong>{{ getTotalSalesCartAmount() }}</strong></td>
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
           item:        {required},
           cusAcct:     {required},
           descp:       {required},
         }
     },
    data: () => ({
      permission: 'restuarant-sales',
      orderid: 0,
      overlay: false,
      enterDate: new Date().toISOString().substr(0, 10),
      menuDate: false,
      cartEdit: -1,
      salesOrderItems: [],
      item: [],
      booking: [],
      cusAcct: [],
      form: {
              id: 0,
              qty: null,
              totalQty: null,
              item:null,
              itemId:null,
              itemPrice:null,
              cusAcct:null,
              cusAcctId:null,
              overlay: false,
              allError: {},

      }
    }),
    created(){
      this.overlay = true;
      axios.get(`item`)
            .then(resp=>{
              this.item = transformKeys.camelCase(resp.data.data);
            })
            .catch(err => Exception.handle(err, 'admin'));
      axios.get(`account/get/0/2`)
            .then(resp=>{
              this.cusAcct = transformKeys.camelCase(resp.data.data);
            })
            .catch(err => Exception.handle(err, 'admin'));
      axios.get(`booking/get/checkout`)
            .then(resp=>{
              this.booking = transformKeys.camelCase(resp.data.data);
            })
            .catch(err => Exception.handle(err, 'admin'));
      if (this.$route.params.orderid) {
        this.orderid = this.$route.params.orderid;
        axios.get(`sales/${this.orderid}`)
             .then(resp => {
              let getSalesOrder         = transformKeys.camelCase(resp.data.data);
              this.form.cusAcct         = getSalesOrder.cusAcct;
              this.form.cusAcctId       = getSalesOrder.cusAcctId;
              this.form.totalQty        = getSalesOrder.totalQty;
              this.form.descp           = getSalesOrder.descp;
              this.enterDate            = getSalesOrder.enterDate;
              this.salesOrderItems      = getSalesOrder.salesOrderItems;
              this.orderid              = getSalesOrder.id;
             })
             .catch(err => Exception.handle(err, 'admin'));
      }
      this.overlay = false;
      
    },
    computed: {
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
      cusAcctErrors () {
        const errors = [];
        if (!this.$v.form.cusAcct.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'cusAcctId') {
            errors.push(this.form.allError.cusAcctId[0]);
            break;
          } 

        } 
        !this.$v.form.cusAcct.required && errors.push('Account is required')
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
          setBookingId(data){
            this.form.cusAcct = data.bookingOrder.accountName;
            this.form.cusAcctId = data.bookingOrder.accountId;
          },
          setItem(data){
            this.form.itemId = data.id;
            this.form.itemPrice = data.price;
            this.form.item = data.name;
          },
          setCusAcct(data){
            this.form.cusAcctId = data.id;
            this.form.cusAcct = data.name;
          },
          viewData(){
            this.$router.push({name:'view-sales'});
          },
          async createSales(id, item, itemId, itemPrice, qty, delRecord)
          {
            let cartItem = {};
            cartItem.id = id;
            cartItem.itemId = itemId;
            cartItem.item = item;
            cartItem.itemPrice = itemPrice;
            cartItem.qty = qty;
            cartItem.amount = cartItem.itemPrice * cartItem.qty;
            cartItem.delRecord= delRecord;

            return cartItem;
          },
          addSalesCart(cartItem)
          {
            this.salesOrderItems.push(cartItem);
          },
          setEditCart(cartItem, index)
          {
            this.form.id = cartItem.id;
            this.form.item = cartItem.item;
            this.form.itemId = cartItem.itemId;
            this.form.itemPrice = cartItem.itemPrice;
            this.form.qty = cartItem.qty;
            this.cartEdit = index;
          },
          setDeleteCart(cartItem, index)
          {
            if (this.orderid) {
             this.deleteSalesCart(cartItem, index);
            }else{
              this.removeSalesCart(index);
            }
            
          },
          editSalesCart(cartItem, index)
          {
            this.salesOrderItems = this.salesOrderItems.map((item, i) => { 
                if (index == i) 
                { 
                  item = cartItem;
                } 
              return item; 
            });
          },
          deleteSalesCart(cartItem, index)
          {
            cartItem.delRecord = 1;
            this.editSalesCart(cartItem, index);
          },
          removeSalesCart(index)
          {
           this.salesOrderItems.splice(index, 1);
          },
          clearSalesCart(index)
          {
            this.salesOrderItems = [];
          },
          getTotalSalesCartAmount()
          {
            if (this.salesOrderItems.length > 0) {
              return this.salesOrderItems.filter(data => data.delRecord == 0).reduce((prev, cur) => ({amount: Number(prev.amount) + Number(cur.amount)})).amount
            }
            return 0;
          },
          getTotalSalesCartQty()
          {
            if (this.salesOrderItems.length > 0) {
              return this.salesOrderItems.filter(data => data.delRecord == 0).reduce((prev, cur) => ({qty: Number(prev.qty) + Number(cur.qty)})).qty
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

            this.createSales(this.form.id, this.form.item, this.form.itemId, this.form.itemPrice, this.form.qty, 0)
                .then(resp => {

                  if (this.cartEdit >= 0) 
                  {
                    this.editSalesCart(resp, this.cartEdit);
                    this.cartEdit = -1;
                  }else {
                    this.addSalesCart(resp);
                  }
                    
                  this.form.item = this.form.qty = this.form.itemPrice = null;
                  this.$v.form.$reset();
                })
                .catch(err => console.log(err));
          },
          clearData(){
            this.clearSalesCart();
            this.form =    {
                              id: 0,
                              qty: null,
                              itemPrice:null,
                              item:null,
                              itemId:null,
                              cusAcct:null,
                              cusAcctId:null,
                              overlay: false,
                              allError: {},
                            }
            this.$v.form.$reset();
          },
          saveData(){
            if (this.salesOrderItems.length === 0) {
               swal('Notification', 'Tranjection is empty');
               return;
            }
            
            let data = {};
            data['cusAcctId']           = this.form.cusAcctId;
            data['totalAmount']         = this.getTotalSalesCartAmount();
            data['totalQty']            = this.getTotalSalesCartQty();
            data['descp']               = this.form.descp;
            data['salesOrderItems']     = this.salesOrderItems;
            data['enterDate']           = this.enterDate;


            this.overlay = true;
            if (this.orderid != 0) 
            {
              axios.patch(`sales/${this.orderid}`, transformKeys.snakeCase(data))
                    .then(resp =>{
                      this.$router.push({name:'view-sales', params: { message: `Sales ${resp.data.orderid} Updated Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      console.log(this.form.allError);
                    });
            }
            else
            {
              axios.post(`sales`, transformKeys.snakeCase(data))
                    .then(resp =>{
                      this.$router.push({name:'view-sales', params: { message: `Sales with ID ${resp.data.orderid} Added Successfully` }});
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
