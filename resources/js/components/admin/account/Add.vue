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
              <div v-if="orderid == 0">
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-plus-outline
                </v-icon>
                 Add Account
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit Account
              </div>
              
              
              <template v-slot:actions v-if="$route.name == 'add-account'">
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewAccount"
                >
                  <span class="d-none d-md-flex">View Account</span>
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
          <v-row>
            <v-col
              cols="6"
              >
              <v-combobox
                v-model="form.accountType"
                label="Account Type"
                :items="accountType"
                item-text="name"
                item-value="id"
                :error-messages="accountTypeErrors"
                @input="$v.form.accountType.$touch()"
                @blur="$v.form.accountType.$touch()"
                dense
                @change="setAccountType($event)"
                outlined
              ></v-combobox>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                outlined
                dense
                label="Account Name*"
                v-model="form.name"
                :error-messages="nameErrors"
                @input="$v.form.name.$touch()"
                @blur="$v.form.name.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                outlined
                dense
                label="Open Balance*"
                type="number"
                v-model="form.openingBal"
                :error-messages="openingBalErrors"
                @input="$v.form.openingBal.$touch()"
                @blur="$v.form.openingBal.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
              >
              <v-combobox
                v-model="form.crdr"
                label="CR/DR"
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
              cols="6"
              >
              <v-combobox
                v-model="form.groupcode"
                label="Account Group"
                :items="groupcode"
                item-text="name"
                item-value="id"
                :error-messages="groupcodeErrors"
                @input="$v.form.groupcode.$touch()"
                @blur="$v.form.groupcode.$touch()"
                dense
                @change="setGroupcode($event)"
                outlined
              ></v-combobox>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                v-model="form.phone"
                outlined
                dense
                label="Phone"
                type="text"
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                v-model="form.email"
                outlined
                dense
                label="Email"
                type="text"
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                v-model="form.addressOne"
                outlined
                dense
                label="Address One "
                type="text"
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
             <v-combobox
               v-model="form.area"
               label="Area"
               :items="area"
               item-text="name"
               item-value="id"
               @change="setArea($event)"
               dense
               outlined
             ></v-combobox>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                v-model="form.state"
                outlined
                dense
                label="State"
                type="text"
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                v-model="form.zip"
                outlined
                dense
                label="ZIP"
                type="text"
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                v-model="form.bankName"
                outlined
                dense
                label="Bank Name"
                type="text"
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                v-model="form.ifscCode"
                outlined
                dense
                label="IFSC Code"
                type="text"
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                v-model="form.creditDays"
                outlined
                dense
                label="Credit Days"
                type="text"
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                v-model="form.creditLimit"
                outlined
                dense
                label="Credit Limit"
                type="text"
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
              >
              <v-combobox
                v-model="form.status"
                label="Account Status"
                :items="status"
                item-text="name"
                item-value="id"
                :error-messages="statusErrors"
                @input="$v.form.status.$touch()"
                @blur="$v.form.status.$touch()"
                @change="setStatus($event)"
                dense
                outlined
              ></v-combobox>
            </v-col>
          </v-row>
          
          <v-row>
            <v-col
              v-if="orderid != 0"
              cols="12"
              md="12" 
              lg="6"
              >
              <v-btn
               color="red"
               class="pa-10"
               dark
                
               x-large
               @click="deleteAccount"
               >
               Delete
               <v-icon
                 right
                 dark
                >
                 mdi-close-outline
               </v-icon>
             </v-btn>
            </v-col>
            <v-col
              cols="12"
              md="12" 
              lg="6"
              >
              <v-btn
               color="primary"
               class="pa-10"
               dark
                
               x-large
               @click="saveAccount"
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

            <v-col cols="12" md="12" lg="6" v-if="orderid == 0">
              <v-dialog
                transition="dialog-top-transition"
                max-width="600"
               >
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    class="pa-10"
                    x-large
                    color="primary"
                    v-bind="attrs"
                    v-on="on"
                  >
                  Import Account
                  <v-icon
                    right
                    dark
                   >
                    mdi-google-spreadsheet
                  </v-icon>
                </v-btn>
                </template>
                <template v-slot:default="dialog">
                  <v-card>
                    <v-toolbar
                      color="primary"
                      dark
                    >Import Account Csv</v-toolbar>
                    <v-card-text>
                      <v-col cols="6">
                          Sample Csv
                          <img src="/images/csv.png"  title="Sample Csv" />
                      </v-col>
                      <v-file-input accept="text/csv" 
                        outlined
                        dense
                        label="Upload Account CSV"
                        chips
                        v-model="form.csvfile"
                        @change="addFiles">
                      </v-file-input>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                      <v-btn
                        text
                        @click="dialog.value = false"
                      >Close</v-btn>
                    </v-card-actions>
                  </v-card>
                </template>
              </v-dialog>
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
           name:          {required},
           openingBal:    {required},
           accountType:   {required},
           crdr:          {required},
           groupcode:     {required},
           status:        {required},
         }
     },
    data: () => ({
      alert: false,
      permission: "account",
      orderid: 0,
      overlay: false,
      area: [],
      accountType: [
                {                                                                                                
                  id:1,                                                                                                 
                  name: "Standard Code",                                                                                  
                },                                                                                                                    
                {                                                                                                
                  id:2,                                                                                                 
                  name: "Customer Account",                                                                               
                },                                                                                                                    
                {                                                                                                
                  id:3,                                                                                                 
                  name: "Consignor Account",                                                                               
                },                                                                                                                    
                {                                                                                                
                  id:4,                                                                                                 
                  name: "Bank Account",                                                                                   
                },                                                                                                                    
                {                                                                                                
                  id:5,                                                                                                 
                  name: "Cash in hand",                                                                                   
                },                                                                                                                    
                {                                                                                                
                  id:6,                                                                                                 
                  name: "General Account",                                                                                
                },                                                                                                                    
                {                                                                                                
                  id:7,                                                                                                 
                  name: "Income Account",                                                                                 
                },                                                                                                                    
                {                                                                                                
                  id:8,                                                                                                 
                  name: "Expenses Account",                                                                               
                },                                                                                                                    
                {                                                                                                
                  id:9,                                                                                                 
                  name: "Loan Account",                                                                                   
                },                                                                                                                    
                {                                                                                                
                  id:10,                                                                                         
                  name: "Capital Account",                                                                              
                }, 
                {                                                                                                
                  id:11,                                                                                         
                  name: "Transporter Account",                                                                              
                },
                {                                                                                                
                  id:12,                                                                                         
                  name: "Supplier Account",                                                                              
                },
                {                                                                                                
                  id:13,                                                                                         
                  name: "Agent Account",                                                                              
                }, 
      ],
      status: [{'id':1, 'name':'Active'}, {'id':2, 'name':'Inactive'}],
      crdr: [{'id':1, 'name': 'Cr'}, {'id':2, 'name': 'Dr'}],
      groupcode: [],
      form: {
              name: null,
              accountType:null,
              accountTypeId:null,
              openingBal: 0,
              status:'Active',
              statusId:1,
              crdr:'Cr',
              crdrId:1,
              groupcode:null,
              groupcodeId:null,
              phone: null,
              email: null,
              bankName: null,
              addressOne: null,
              addressTwo: null,
              ifscCode: null,
              area: null,
              state: null,
              zip: null,
              csvfile: null,
              creditDays: null,
              creditLimit: null,
              overlay: false,
              allError: {},

      }
    }),
    created(){
      this.overlay = true;
      axios.get(`groupcode`)
            .then(resp=>{
              this.groupcode = transformKeys.camelCase(resp.data.data);
            })
            .catch(err => Exception.handle(err, 'admin'));
      axios.get(`area`)
            .then(resp=>{
              this.area = transformKeys.camelCase(resp.data.data);
            })
            .catch(err => Exception.handle(err, 'admin'));
      if (this.$route.params.orderid) {
        this.orderid = this.$route.params.orderid;
        axios.get(`account/${this.orderid}`)
             .then(resp => {
              let getAccountOrder         = transformKeys.camelCase(resp.data.data);
              this.form.name              = getAccountOrder.name;
              this.form.openingBal        = getAccountOrder.openingBal;
              this.form.accountType       = getAccountOrder.accountType;
              this.form.accountTypeId     = getAccountOrder.accountTypeId;
              this.form.crdr              = getAccountOrder.crdr;
              this.form.crdrId            = getAccountOrder.crdrId;
              this.form.groupcode         = getAccountOrder.groupcode;
              this.form.groupcodeId       = getAccountOrder.groupcodeId;
              this.form.status            = getAccountOrder.status;
              this.form.statusId          = getAccountOrder.statusId;
              this.form.phone             = getAccountOrder.phone;
              this.form.email             = getAccountOrder.email;
              this.form.bankName          = getAccountOrder.bankName;
              this.form.addressOne        = getAccountOrder.addressOne;
              this.form.addressTwo        = getAccountOrder.addressTwo;
              this.form.ifscCode          = getAccountOrder.ifscCode;
              this.form.area              = getAccountOrder.area;
              this.form.state             = getAccountOrder.state;
              this.form.zip               = getAccountOrder.zip;
              this.form.creditDays        = getAccountOrder.creditDays;
              this.form.creditLimit       = getAccountOrder.creditLimit;

             })
             .catch(err => Exception.handle(err, 'admin'));
      }
      this.overlay = false;
      
    },
    computed: {
      accountTypeErrors () {
        const errors = [];
        if (!this.$v.form.accountType.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'accountTypeId') {
            errors.push(this.form.allError.accountTypeId[0]);
            break;
          } 

        } 
        !this.$v.form.accountType.required && errors.push('Account Type is required')
        return errors
      },
      groupcodeErrors () {
        const errors = [];
        if (!this.$v.form.groupcode.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'groupcodeId') {
            errors.push(this.form.allError.groupcodeId[0]);
            break;
          } 

        } 
        !this.$v.form.groupcode.required && errors.push('Account Group is required')
        return errors
      },
      statusErrors () {
        const errors = [];
        if (!this.$v.form.status.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'statusId') {
            errors.push(this.form.allError.statusId[0]);
            break;
          } 

        } 
        !this.$v.form.status.required && errors.push('Account Status is required')
        return errors
      },
      crdrErrors () {
        const errors = [];
        if (!this.$v.form.crdr.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'crdrId') {
            errors.push(this.form.allError.crdrId[0]);
            break;
          } 

        } 
        !this.$v.form.crdr.required && errors.push('CR/DR is required')
        return errors
      },
      nameErrors () {
        const errors = []
        if (!this.$v.form.name.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'name') {
            errors.push(this.form.allError.name[0]);
            break;
          } 

        } 
        !this.$v.form.name.required && errors.push('Account Name is required')
        return errors
      },
      openingBalErrors () {
        const errors = []
        if (!this.$v.form.openingBal.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'openingBal') {
            errors.push(this.form.allError.openingBal[0]);
            break;
          } 

        } 
        !this.$v.form.openingBal.required && errors.push('Open Balance is required')
        return errors
      },
      
    },
    methods: {

          addFiles(){
                          const data = new FormData();
                          data.append('file', this.form.csvfile);
                          this.overlay = true;
                          axios.post(`account/import/csv`, data)
                               .then(resp => {
                                  this.form.csvfile = null;
                                  this.$router.push({name:'view-account', params: { message: `${resp.data.message}` }});
                               })
                               .catch(err => swal('Notification', 'An error occured.Kindly check the uploaded csv file'));
                          this.overlay = false;

          },
          setAccountType(data){
            this.form.accountTypeId = data.id;
            if (this.form.accountTypeId == 2) {
                this.form.crdr = 'Dr';
                this.form.crdrId = 2;
                this.form.groupcode = "Sundry Debtor";
                this.form.groupcodeId = 10;
            }
            else if (this.form.accountTypeId == 3) {
              this.form.crdr = 'Cr';
              this.form.crdrId = 1;
              this.form.groupcode = "Sundry Creditors";
              this.form.groupcodeId = 19;
            }
             else if (this.form.accountTypeId == 4) {
              this.form.crdr = 'Dr';
              this.form.crdrId = 2;
              this.form.groupcode = "Bank Account";
              this.form.groupcodeId = 9;
            }
            else if (this.form.accountTypeId == 5) {
              this.form.crdr = 'Dr';
              this.form.crdrId = 2;
              this.form.groupcode = "Cash In Hand";
              this.form.groupcodeId = 8;
            }
            else if (this.form.accountTypeId == 7) {
              this.form.crdr = 'Cr';
              this.form.crdrId = 1;
              this.form.groupcode = "Direct Incomes";
              this.form.groupcodeId = 13;
            }
            else if (this.form.accountTypeId == 8) {
              this.form.crdr = 'Dr';
              this.form.crdrId = 2;
              this.form.groupcode = "Direct Expense";
              this.form.groupcodeId = 15;
            }
            else if (this.form.accountTypeId == 10) {
              this.form.crdr = 'Cr';
              this.form.crdrId = 1;
              this.form.groupcode = "Capital Account";
              this.form.groupcodeId = 24;
            }
            else if (this.form.accountTypeId == 11) {
              this.form.crdr = 'Cr';
              this.form.crdrId = 1;
              this.form.groupcode = "Sundry Creditors";
              this.form.groupcodeId = 19;
            }
            else if (this.form.accountTypeId == 12) {
              this.form.crdr = 'Cr';
              this.form.crdrId = 1;
              this.form.groupcode = "Sundry Creditors";
              this.form.groupcodeId = 19;
            }
            else {
              this.form.crdr = 'Cr';
              this.form.crdrId = 1;
              this.form.groupcode = null;
              this.form.groupcodeId = null;
            }
          },
          setStatus(data){
            this.form.statusId = data.id;
          },
          setArea(data){
            this.form.area = data.name;
          },
          setCrdr(data){
            this.form.crdrId = data.id;
          },
          setGroupcode(data){
            this.form.groupcodeId = data.id;
          },
          viewAccount(){
            this.$router.push({name:'view-account'});
          },
          deleteAccount()
          {
            
            swal({
                  title: "Notification!",
                  text: 'Are you sure you want to Delete this Account',
                  buttons: ['No', 'Yes']
                })
            .then((yes) => {
              if (yes) {
                this.overlay = true;
                axios.delete(`account/${this.orderid}`)
                     .then(resp => {
                      this.$router.push({name:'view-account', params: { message: `Account Deleted Successfully` }});
                     })
                     .catch(err => Exception.handle(err, 'admin'));
                this.overlay = false;
              }
            })
          },
          saveAccount(){
            this.$v.form.$touch();
            if (this.$v.form.$invalid) 
            {
              return;
            }
            this.overlay = true;
            if (this.orderid != 0) 
            {
              axios.patch(`account/${this.orderid}`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-account', params: { message: `Account ${resp.data.name} Updated Successfully` }});
                    })
                    .catch(err => {
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      if (!this.form.allError) Exception.handle(err, 'admin');
                    });
            }
            else
            {
              axios.post('account', transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      if (this.$route.name == 'add-account') {
                        this.$router.push({name:'view-account', params: { message: `Account ${resp.data.name} Added Successfully` }});
                      }else{
                        this.$router.go();
                      }
                      
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
