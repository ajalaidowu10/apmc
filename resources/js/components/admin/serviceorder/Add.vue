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
                 Add Service Order 
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit Service Order
              </div>
              
              
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewData"
                >
                  <span class="d-none d-md-flex">View Service Order</span>
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
                  v-model="form.service"
                  label="Service"
                  :items="service"
                  item-text="name"
                  item-value="id"
                  :error-messages="serviceErrors"
                  @input="$v.form.service.$touch()"
                  @blur="$v.form.service.$touch()"
                  dense
                  @change="setService($event)"
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
                          SERVICE
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
                        v-for="(item, index) in serviceOrderItems"
                        :key="index"
                        :class="[index==cartEdit ? 'success lighten-5' : '', item.delRecord ? 'red lighten-5' : '']"
                       >
                        <td>{{ index }}</td>
                        <td>{{ item.service }}</td>
                        <td>{{ item.qty }}</td>
                        <td>{{ item.servicePrice }}</td>
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
                      <tr v-if="getTotalServiceCartAmount()">
                        <td colspan="2"><strong>TOTAL AMOUNT</strong></td>
                        <td colspan="2"><strong>{{ getTotalServiceCartQty() }}</strong></td>
                        <td><strong>{{ getTotalServiceCartAmount() }}</strong></td>
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
           service:        {required},
           cusAcct:     {required},
           descp:       {required},
         }
     },
    data: () => ({
      permission: 'service-order',
      orderid: 0,
      overlay: false,
      enterDate: new Date().toISOString().substr(0, 10),
      menuDate: false,
      cartEdit: -1,
      serviceOrderItems: [],
      service: [],
      booking: [],
      cusAcct: [],
      form: {
              id: 0,
              qty: null,
              totalQty: null,
              service:null,
              serviceId:null,
              servicePrice:null,
              cusAcct:null,
              cusAcctId:null,
              overlay: false,
              allError: {},

      }
    }),
    created(){
      this.overlay = true;
      axios.get(`service`)
            .then(resp=>{
              this.service = transformKeys.camelCase(resp.data.data);
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
        axios.get(`serviceorder/${this.orderid}`)
             .then(resp => {
              let getSalesOrder         = transformKeys.camelCase(resp.data.data);
              this.form.cusAcct         = getSalesOrder.cusAcct;
              this.form.cusAcctId       = getSalesOrder.cusAcctId;
              this.form.totalQty        = getSalesOrder.totalQty;
              this.form.descp            = getSalesOrder.descp;
              this.enterDate            = getSalesOrder.enterDate;
              this.serviceOrderItems      = getSalesOrder.serviceOrderItems;
              this.orderid              = getSalesOrder.id;
             })
             .catch(err => Exception.handle(err, 'admin'));
      }
      this.overlay = false;
      
    },
    computed: {
      serviceErrors () {
        const errors = [];
        if (!this.$v.form.service.$dirty) return errors; 
        for (let services in this.form.allError) {
          if (services == 'serviceId') {
            errors.push(this.form.allError.serviceId[0]);
            break;
          } 

        } 
        !this.$v.form.service.required && errors.push('Item is required')
        return errors
      },
      cusAcctErrors () {
        const errors = [];
        if (!this.$v.form.cusAcct.$dirty) return errors; 
        for (let services in this.form.allError) {
          if (services == 'cusAcctId') {
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
        for (let services in this.form.allError) {
          if (services == 'qty') {
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
        for (let services in this.form.allError) {
          if (services == 'descp') {
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
          setService(data){
            this.form.serviceId = data.id;
            this.form.servicePrice = data.price;
            this.form.service = data.name;
          },
          setCusAcct(data){
            this.form.cusAcctId = data.id;
            this.form.cusAcct = data.name;
          },
          viewData(){
            this.$router.push({name:'view-serviceorder'});
          },
          async createService(id, service, serviceId, servicePrice, qty, delRecord)
          {
            let cartItem = {};
            cartItem.id = id;
            cartItem.serviceId = serviceId;
            cartItem.service = service;
            cartItem.servicePrice = servicePrice;
            cartItem.qty = qty;
            cartItem.amount = cartItem.servicePrice * cartItem.qty;
            cartItem.delRecord= delRecord;

            return cartItem;
          },
          addServiceCart(cartItem)
          {
            this.serviceOrderItems.push(cartItem);
          },
          setEditCart(cartItem, index)
          {
            this.form.id = cartItem.id;
            this.form.service = cartItem.service;
            this.form.serviceId = cartItem.serviceId;
            this.form.servicePrice = cartItem.servicePrice;
            this.form.qty = cartItem.qty;
            this.cartEdit = index;
          },
          setDeleteCart(cartItem, index)
          {
            if (this.orderid) {
             this.deleteServiceCart(cartItem, index);
            }else{
              this.removeServiceCart(index);
            }
            
          },
          editServiceCart(cartItem, index)
          {
            this.serviceOrderItems = this.serviceOrderItems.map((item, i) => { 
                if (index == i) 
                { 
                  item = cartItem;
                } 
              return item; 
            });
          },
          deleteServiceCart(cartItem, index)
          {
            cartItem.delRecord = 1;
            this.editServiceCart(cartItem, index);
          },
          removeServiceCart(index)
          {
           this.serviceOrderItems.splice(index, 1);
          },
          clearServiceCart(index)
          {
            this.serviceOrderItems = [];
          },
          getTotalServiceCartAmount()
          {
            let dataArray = this.serviceOrderItems.filter(data => data.delRecord == 0);
            if (dataArray.length > 0) {
              return dataArray.reduce((prev, cur) => ({amount: Number(prev.amount) + Number(cur.amount)})).amount
            }
            return 0;
          },
          getTotalServiceCartQty()
          { 
            let dataArray = this.serviceOrderItems.filter(data => data.delRecord == 0);
            if (dataArray.length > 0) {
              return dataArray.reduce((prev, cur) => ({qty: Number(prev.qty) + Number(cur.qty)})).qty
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

            this.createService(this.form.id, this.form.service, this.form.serviceId, this.form.servicePrice, this.form.qty, 0)
                .then(resp => {

                  if (this.cartEdit >= 0) 
                  {
                    this.editServiceCart(resp, this.cartEdit);
                    this.cartEdit = -1;
                  }else {
                    this.addServiceCart(resp);
                  }
                    
                  this.form.service = this.form.qty = this.form.servicePrice = null;
                  this.$v.form.$reset();
                })
                .catch(err => console.log(err));
          },
          clearData(){
            this.clearServiceCart();
            this.form =    {
                              id: 0,
                              qty: null,
                              servicePrice:null,
                              service:null,
                              serviceId:null,
                              cusAcct:null,
                              cusAcctId:null,
                              overlay: false,
                              allError: {},
                            }
            this.$v.form.$reset();
          },
          saveData(){
            if (this.serviceOrderItems.length === 0) {
               swal('Notification', 'Tranjection is empty');
               return;
            }
            
            let data = {};
            data['cusAcctId']           = this.form.cusAcctId;
            data['totalAmount']         = this.getTotalServiceCartAmount();
            data['totalQty']            = this.getTotalServiceCartQty();
            data['descp']               = this.form.descp;
            data['serviceOrderItems']   = this.serviceOrderItems;
            data['enterDate']           = this.enterDate;


            this.overlay = true;
            if (this.orderid != 0) 
            {
              axios.patch(`serviceorder/${this.orderid}`, transformKeys.snakeCase(data))
                    .then(resp =>{
                      this.$router.push({name:'view-serviceorder', params: { message: `Service Order ${resp.data.orderid} Updated Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      console.log(this.form.allError);
                    });
            }
            else
            {
              axios.post(`serviceorder`, transformKeys.snakeCase(data))
                    .then(resp =>{
                      this.$router.push({name:'view-serviceorder', params: { message: `Service Order with ID ${resp.data.orderid} Added Successfully` }});
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
