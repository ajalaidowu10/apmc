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
                 Add Service
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit Service
              </div>
              
              
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewService"
                >
                  <span class="d-none d-md-flex">View Service</span>
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
              <v-text-field
                outlined
                dense
                label="Service Name*"
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
                label="Service Price*"
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
                label="Service Status"
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
               @click="deleteService"
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
               @click="saveService"
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
           status: {required},
         }
     },
    data: () => ({
      permission: 'service',
      orderid: 0,
      overlay: false,
      status: [{'id':1, 'name':'Active'}, {'id':2, 'name':'Inactive'}],
      form: {
              name: null,
              price: null,
              status:null,
              statusId:null,
              overlay: false,
              allError: {},

      }
    }),
    created(){
      if (this.$route.params.orderid) {
        this.orderid = this.$route.params.orderid;
        axios.get(`service/${this.orderid}`)
             .then(resp => {
              let getServiceOrder            = transformKeys.camelCase(resp.data.data);
              this.form.name              = getServiceOrder.name;
              this.form.price             = getServiceOrder.price;
              this.form.status            = getServiceOrder.status;
              this.form.statusId          = getServiceOrder.statusId;
             })
             .catch(err => Exception.handle(err, 'admin'));
      }
      this.overlay = false;
      
    },
    computed: {
      statusErrors () {
        const errors = [];
        if (!this.$v.form.status.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'statusId') {
            errors.push(this.form.allError.statusId[0]);
            break;
          } 

        } 
        !this.$v.form.status.required && errors.push('Service Status is required')
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
        !this.$v.form.name.required && errors.push('Service Name is required')
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
        !this.$v.form.price.required && errors.push('Service Price is required')
        return errors
      },
      
    },
    methods: {
          setStatus(data){
            this.form.statusId = data.id;
          },
          viewService(){
            this.$router.push({name:'view-service'});
          },
          deleteService()
          {
            
            swal({
                  title: "Notification!",
                  text: 'Are you sure you want to Delete this Service',
                  buttons: ['No', 'Yes']
                })
            .then((yes) => {
              if (yes) {
                this.overlay = true;
                axios.delete(`service/${this.orderid}`)
                     .then(resp => {
                      this.$router.push({name:'view-service', params: { message: `Service Deleted Successfully` }});
                     })
                     .catch(err => Exception.handle(err, 'admin'));
                this.overlay = false;
              }
            })
          },
          saveService(){
            this.$v.form.$touch();
            if (this.$v.form.$invalid) 
            {
              return;
            }
            this.overlay = true;
            if (this.orderid != 0) 
            {
              axios.patch(`service/${this.orderid}`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-service', params: { message: `Service ${resp.data.name} Updated Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      console.log(this.form.allError);
                    });
            }
            else
            {
              axios.post(`service`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-service', params: { message: `Service ${resp.data.name} Added Successfully` }});
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
