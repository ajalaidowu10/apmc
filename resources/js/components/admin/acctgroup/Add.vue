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
                 Add Item
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit Item
              </div>
              
              
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewItem"
                >
                  <span class="d-none d-md-flex">View Item</span>
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
              cols="12"
              >
              <v-combobox
                v-model="form.itemGroup"
                label="Item Group"
                :items="itemGroup"
                item-text="name"
                item-value="id"
                :error-messages="itemGroupErrors"
                @input="$v.form.itemGroup.$touch()"
                @blur="$v.form.itemGroup.$touch()"
                dense
                @change="setItemGroup($event)"
                outlined
              ></v-combobox>
            </v-col>
            <v-col
              cols="12"
             >
              <v-text-field
                outlined
                dense
                label="Item Name*"
                v-model="form.name"
                :error-messages="nameErrors"
                @input="$v.form.name.$touch()"
                @blur="$v.form.name.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="12"
             >
              <v-text-field
                outlined
                dense
                label="Item Price*"
                v-model="form.price"
                type="number"
                :error-messages="priceErrors"
                @input="$v.form.price.$touch()"
                @blur="$v.form.price.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="12"
              >
              <v-combobox
                v-model="form.status"
                label="Item Status"
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
               @click="deleteItem"
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
           name:  {required },
           price: {required},
           itemGroup: {required },
           status: {required},
         }
     },
    data: () => ({
      orderid: 0,
      permission: 'item',
      overlay: false,
      itemGroup: [],
      status: [{'id':1, 'name':'Active'}, {'id':2, 'name':'Inactive'}],
      form: {
              name: null,
              itemGroup:null,
              itemGroupId:null,
              price: null,
              status:null,
              statusId:null,
              overlay: false,
              allError: {},

      }
    }),
    created(){
      this.overlay = true;
      axios.get(`itemgroup`)
            .then(resp=>{
              this.itemGroup = transformKeys.camelCase(resp.data.data);
            })
            .catch(err => Exception.handle(err, 'admin'));
      if (this.$route.params.orderid) {
        this.orderid = this.$route.params.orderid;
        axios.get(`item/${this.orderid}`)
             .then(resp => {
              let getItemOrder            = transformKeys.camelCase(resp.data.data);
              this.form.name              = getItemOrder.name;
              this.form.price             = getItemOrder.price;
              this.form.itemGroup         = getItemOrder.itemGroup;
              this.form.itemGroupId       = getItemOrder.itemGroupId;
              this.form.status            = getItemOrder.status;
              this.form.statusId          = getItemOrder.statusId;
             })
             .catch(err => Exception.handle(err, 'admin'));
      }
      this.overlay = false;
      
    },
    computed: {
      itemGroupErrors () {
        const errors = [];
        if (!this.$v.form.itemGroup.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'itemGroupId') {
            errors.push(this.form.allError.itemGroupId[0]);
            break;
          } 

        } 
        !this.$v.form.itemGroup.required && errors.push('Item Group is required')
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
        !this.$v.form.status.required && errors.push('Item Status is required')
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
        !this.$v.form.name.required && errors.push('Item Name is required')
        return errors
      },
      priceErrors () {
        const errors = []
        if (!this.$v.form.price.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'price') {
            errors.push(this.form.allError.price[0]);
            break;
          } 

        } 
        !this.$v.form.price.required && errors.push('Item Price is required')
        return errors
      },
      
    },
    methods: {
          setItemGroup(data){
            this.form.itemGroupId = data.id;
          },
          setStatus(data){
            this.form.statusId = data.id;
          },
          viewItem(){
            this.$router.push({name:'view-item'});
          },
          deleteItem()
          {
            
            swal({
                  title: "Notification!",
                  text: 'Are you sure you want to Delete this Item',
                  buttons: ['No', 'Yes']
                })
            .then((yes) => {
              if (yes) {
                this.overlay = true;
                axios.delete(`item/${this.orderid}`)
                     .then(resp => {
                      this.$router.push({name:'view-item', params: { message: `Item Deleted Successfully` }});
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
              axios.patch(`item/${this.orderid}`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-item', params: { message: `Item ${resp.data.name} Updated Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      console.log(this.form.allError);
                    });
            }
            else
            {
              axios.post('item', transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-item', params: { message: `Item ${resp.data.name} Added Successfully` }});
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
