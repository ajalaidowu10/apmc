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
                 Add Item Expense
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit Item Expense
              </div>
              
              
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewData"
                >
                  <span class="d-none d-md-flex">View Item Expense</span>
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
              cols="6"
              >
              <v-menu
                ref="menuDate"
                v-model="menuDate"
                :close-on-content-click="false"
                :return-value.sync="form.enterDate"
                transition="scale-transition"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    outlined
                    dense
                    v-model="form.enterDate"
                    label="Date"
                    append-icon="mdi-calendar"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="form.enterDate"
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
                    @click="$refs.menuDate.save(form.enterDate)"
                  >
                    OK
                  </v-btn>
                </v-date-picker>
              </v-menu>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                outlined
                dense
                label="Commission*"
                v-model="form.comm"
                type="number"
                :error-messages="commErrors"
                @input="$v.form.comm.$touch()"
                @blur="$v.form.comm.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                outlined
                dense
                label="P Hamali*"
                v-model="form.pHamali"
                type="number"
                :error-messages="pHamaliErrors"
                @input="$v.form.pHamali.$touch()"
                @blur="$v.form.pHamali.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                outlined
                dense
                label="B Hamali*"
                v-model="form.bHamali"
                type="number"
                :error-messages="bHamaliErrors"
                @input="$v.form.bHamali.$touch()"
                @blur="$v.form.bHamali.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                outlined
                dense
                label="P Levy*"
                v-model="form.pLevy"
                type="number"
                :error-messages="pLevyErrors"
                @input="$v.form.pLevy.$touch()"
                @blur="$v.form.pLevy.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                outlined
                dense
                label="B Levey*"
                v-model="form.bLevy"
                type="number"
                :error-messages="bLevyErrors"
                @input="$v.form.bLevy.$touch()"
                @blur="$v.form.bLevy.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                outlined
                dense
                label="APMC*"
                v-model="form.apmc"
                type="number"
                :error-messages="apmcErrors"
                @input="$v.form.apmc.$touch()"
                @blur="$v.form.apmc.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                outlined
                dense
                label="MAP Levy*"
                v-model="form.mapLevy"
                type="number"
                :error-messages="mapLevyErrors"
                @input="$v.form.mapLevy.$touch()"
                @blur="$v.form.mapLevy.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                outlined
                dense
                label="Tolai*"
                v-model="form.tolai"
                type="number"
                :error-messages="tolaiErrors"
                @input="$v.form.tolai.$touch()"
                @blur="$v.form.tolai.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
             >
              <v-text-field
                outlined
                dense
                label="Discount*"
                v-model="form.discount"
                type="number"
                :error-messages="discountErrors"
                @input="$v.form.discount.$touch()"
                @blur="$v.form.discount.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="6"
              >
              <v-combobox
                v-model="form.status"
                label="Status"
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
              cols="6"
              >
              <v-btn
               color="red"
               class="pa-10"
               dark
               min-width="300"
               x-large
               @click="deleteData"
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
              cols="6"
              >
              <v-btn
               color="primary"
               class="pa-10"
               dark
               min-width="300"
               x-large
               @click="saveItem"
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
           comm: {required},
           pHamali: {required},
           bHamali: {required},
           pLevy: {required},
           bLevy: {required},
           apmc: {required},
           mapLevy: {required},
           tolai: {required},
           discount: {required},
           item: {required },
           status: {required},
         }
     },
    data: () => ({
      menuDate: false,
      orderid: 0,
      permission: 'item',
      overlay: false,
      item: [],
      status: [{'id':1, 'name':'Active'}, {'id':2, 'name':'Inactive'}],
      form: {
              enterDate:  new Date().toISOString().substr(0, 10),
              item:null,
              itemId:null,
              comm: null,
              pHamali: null,
              bHamali: null,
              pLevy: null,
              bLevy: null,
              apmc: null,
              mapLevy: null,
              tolai: null,
              discount: null,
              status:null,
              statusId:null,
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
      if (this.$route.params.orderid) {
        this.orderid = this.$route.params.orderid;
        axios.get(`itemexp/${this.orderid}`)
             .then(resp => {
              let getItemOrder           = transformKeys.camelCase(resp.data.data);
              this.form.enterDate        = getItemOrder.enterDate;
              this.form.comm             = getItemOrder.comm;
              this.form.pHamali          = getItemOrder.pHamali;
              this.form.bHamali          = getItemOrder.bHamali;
              this.form.pLevy            = getItemOrder.pLevy;
              this.form.bLevy            = getItemOrder.bLevy;
              this.form.apmc             = getItemOrder.apmc;
              this.form.mapLevy          = getItemOrder.mapLevy;
              this.form.tolai            = getItemOrder.tolai;
              this.form.discount         = getItemOrder.discount;
              this.form.item             = getItemOrder.item;
              this.form.itemId           = getItemOrder.itemId;
              this.form.status           = getItemOrder.status;
              this.form.statusId         = getItemOrder.statusId;
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
      statusErrors () {
        const errors = [];
        if (!this.$v.form.status.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'statusId') {
            errors.push(this.form.allError.statusId[0]);
            break;
          } 

        } 
        !this.$v.form.status.required && errors.push('Status is required')
        return errors
      },
      commErrors () {
        const errors = []
        if (!this.$v.form.comm.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'comm') {
            errors.push(this.form.allError.comm[0]);
            break;
          } 

        } 
        !this.$v.form.comm.required && errors.push('Commission is required')
        return errors
      },
      pHamaliErrors () {
        const errors = []
        if (!this.$v.form.pHamali.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'pHamali') {
            errors.push(this.form.allError.pHamali[0]);
            break;
          } 

        } 
        !this.$v.form.pHamali.required && errors.push('P Hamali is required')
        return errors
      },
      bHamaliErrors () {
        const errors = []
        if (!this.$v.form.bHamali.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'bHamali') {
            errors.push(this.form.allError.bHamali[0]);
            break;
          } 

        } 
        !this.$v.form.bHamali.required && errors.push('B Hamali is required')
        return errors
      },
      pLevyErrors () {
        const errors = []
        if (!this.$v.form.pLevy.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'pLevy') {
            errors.push(this.form.allError.pLevy[0]);
            break;
          } 

        } 
        !this.$v.form.pLevy.required && errors.push('P Levy is required')
        return errors
      },
      bLevyErrors () {
        const errors = []
        if (!this.$v.form.bLevy.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'bLevy') {
            errors.push(this.form.allError.bLevy[0]);
            break;
          } 

        } 
        !this.$v.form.bLevy.required && errors.push('B Levy is required')
        return errors
      },
      ampcErrors () {
        const errors = []
        if (!this.$v.form.ampc.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'ampc') {
            errors.push(this.form.allError.ampc[0]);
            break;
          } 

        } 
        !this.$v.form.ampc.required && errors.push('Unit is required')
        return errors
      },
      unitErrors () {
        const errors = []
        if (!this.$v.form.unit.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'unit') {
            errors.push(this.form.allError.unit[0]);
            break;
          } 

        } 
        !this.$v.form.unit.required && errors.push('Unit is required')
        return errors
      },
      mapLevyErrors () {
        const errors = []
        if (!this.$v.form.mapLevy.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'mapLevy') {
            errors.push(this.form.allError.mapLevy[0]);
            break;
          } 

        } 
        !this.$v.form.mapLevy.required && errors.push('Unit is required')
        return errors
      },
      tolaiErrors () {
        const errors = []
        if (!this.$v.form.tolai.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'tolai') {
            errors.push(this.form.allError.tolai[0]);
            break;
          } 

        } 
        !this.$v.form.tolai.required && errors.push('Unit is required')
        return errors
      },
      apmcErrors () {
        const errors = []
        if (!this.$v.form.apmc.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'apmc') {
            errors.push(this.form.allError.apmc[0]);
            break;
          } 

        } 
        !this.$v.form.apmc.required && errors.push('Unit is required')
        return errors
      },
      discountErrors () {
        const errors = []
        if (!this.$v.form.discount.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'discount') {
            errors.push(this.form.allError.discount[0]);
            break;
          } 

        } 
        !this.$v.form.discount.required && errors.push('Unit is required')
        return errors
      },
      
    },
    methods: {
          setItem(data){
            this.form.itemId = data.id;
          },
          setStatus(data){
            this.form.statusId = data.id;
          },
          viewData(){
            this.$router.push({name:'view-itemexp'});
          },
          deleteData()
          {
            
            swal({
                  title: "Notification!",
                  text: 'Are you sure you want to Delete this Item',
                  buttons: ['No', 'Yes']
                })
            .then((yes) => {
              if (yes) {
                this.overlay = true;
                axios.delete(`itemexp/${this.orderid}`)
                     .then(resp => {
                      this.$router.push({name:'view-itemexp', params: { message: `Item Deleted Successfully` }});
                     })
                     .catch(err => Exception.handle(err, 'admin'));
                this.overlay = false;
              }
            })
          },
          saveItem(){
            this.$v.form.$touch();
            if (this.$v.form.$invalid) 
            {
              return;
            }
            this.overlay = true;
            if (this.orderid != 0) 
            {
              axios.patch(`itemexp/${this.orderid}`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-itemexp', params: { message: `Item Expense Updated Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      console.log(this.form.allError);
                    });
            }
            else
            {
              console.log(this.form);
              axios.post(`itemexp`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-itemexp', params: { message: `Item Expense Added Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      console.log(this.form.allError);
                    });
            }

          },
      },
  }
</script>
