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
                 Add Company
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit Company
              </div>
              
              
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewCompany"
                >
                  <span class="d-none d-md-flex">View Company</span>
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
                label="Company Name*"
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
                label="Company Email*"
                v-model="form.email"
                type="email"
                :error-messages="emailErrors"
                @input="$v.form.email.$touch()"
                @blur="$v.form.email.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="12"
             >
              <v-text-field
                outlined
                dense
                label="Company Phone*"
                v-model="form.phone"
                :error-messages="phoneErrors"
                @input="$v.form.phone.$touch()"
                @blur="$v.form.phone.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="12"
             >
              <v-text-field
                outlined
                dense
                label="Company Address*"
                v-model="form.address"
                :error-messages="addressErrors"
                @input="$v.form.address.$touch()"
                @blur="$v.form.address.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="12"
              >
              <v-combobox
                v-model="form.status"
                label="Company Status"
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
          <v-row v-if="orderid">
            <v-col
              cols="12"
             >
              <v-file-input accept="image/*" 
                outlined
                dense
                label="Upload Invoice Header"
                chips
                v-model="form.invheader"
                @change="addFiles('invheader')">
              </v-file-input>
            </v-col>
            <v-col cols="6">
                Invoice Header
                <img :ref="'invheader'" :src="form.invheaderPath" class="img-fluid" title="Invoice Header" />
            </v-col>
            <v-col
              cols="12"
             >
              <v-file-input accept="image/*" 
                outlined
                dense
                label="Upload Invoice Footer"
                chips
                v-model="form.invfooter"
                @change="addFiles('invfooter')">
              </v-file-input>
            </v-col>
            <v-col cols="6">
                Invoice Footer
                <img :ref="'invfooter'" :src="form.invfooterPath" class="img-fluid" title="Invoice Footer" />
            </v-col>

            <v-col
              cols="12"
             >
              <v-file-input accept="image/*" 
                outlined
                dense
                label="Upload Receipt Header"
                chips
                v-model="form.recheader"
                @change="addFiles('recheader')">
              </v-file-input>
            </v-col>
            <v-col cols="6">
                Receipt Header
                <img :ref="'recheader'" :src="form.recheaderPath" class="img-fluid" title="Receipt Header" />
            </v-col>
            <v-col
              cols="12"
             >
              <v-file-input accept="image/*" 
                outlined
                dense
                label="Upload Receipt Footer"
                chips
                v-model="form.recfooter"
                @change="addFiles('recfooter')">
              </v-file-input>
            </v-col>
            <v-col cols="6">
                Receipt Footer
                <img :ref="'recfooter'" :src="form.recfooterPath" class="img-fluid" title="Receipt Footer" />
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
                
               x-large
               @click="deleteCompany"
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
                
               x-large
               @click="saveCompany"
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
           email: {required, email},
           phone: {required},
           address: {required},
           status: {required},
         }
     },
    data: () => ({
      orderid: 0,
      permission: 'company',
      overlay: false,
      status: [{'id':1, 'name':'Active'}, {'id':2, 'name':'Inactive'}],
      form: {
              name: null,
              email: null,
              phone: null,
              address:null,
              invheaderFile: null,
              invfooter: null,
              recheader: null,
              recfooter: null,
              invheaderPath: null,
              invfooterPath: null,
              recheaderPath: null,
              recfooterPath: null,
              status:null,
              statusId:null,
              overlay: false,
              allError: {},

      }
    }),
    created(){
      this.overlay = true;
      if (this.$route.params.orderid) {
        this.orderid = this.$route.params.orderid;
        axios.get(`company/${this.orderid}`)
             .then(resp => {
              let getCompanyOrder         = transformKeys.camelCase(resp.data.data);
              this.form.name              = getCompanyOrder.name;
              this.form.email             = getCompanyOrder.email;
              this.form.phone             = getCompanyOrder.phone;
              this.form.address           = getCompanyOrder.address;
              this.form.status            = getCompanyOrder.status;
              this.form.statusId          = getCompanyOrder.statusId;
              this.form.invheaderPath     = getCompanyOrder.invheaderPath;
              this.form.invfooterPath     = getCompanyOrder.invfooterPath;
              this.form.recheaderPath     = getCompanyOrder.recheaderPath;
              this.form.recfooterPath     = getCompanyOrder.recfooterPath;
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
        !this.$v.form.status.required && errors.push('Company Status is required')
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
        !this.$v.form.name.required && errors.push('Company Name is required')
        return errors
      },
      emailErrors () {
        const errors = []
        if (!this.$v.form.email.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'email') {
            errors.push(this.form.allError.email[0]);
            break;
          } 

        } 
        !this.$v.form.email.required && errors.push('Company Email is required')
        return errors
      },
      phoneErrors () {
        const errors = []
        if (!this.$v.form.phone.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'phone') {
            errors.push(this.form.allError.phone[0]);
            break;
          } 

        } 
        !this.$v.form.phone.required && errors.push('Company Phone is required')
        return errors
      },
      addressErrors () {
        const errors = []
        if (!this.$v.form.address.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'address') {
            errors.push(this.form.allError.address[0]);
            break;
          } 

        } 
        !this.$v.form.address.required && errors.push('Company Address is required')
        return errors
      },
      
    },
    methods: {
          addFiles(type){
                          var reader = new FileReader();
                          reader.onloadend = (e) => {
                              let fileData = reader.result
                              let imgRef = this.$refs[type]
                              imgRef.src = fileData

                              const data = new FormData();
                              data.append(type, this.form[type]);

                              this.overlay = true;
                              axios.post(`company/upload/${this.orderid}/${type}`, data)
                                   .then(resp => {
                                     console.log('upload successful');
                                   })
                                   .catch(err => Exception.handle(err, 'admin'));
                              this.overlay = false;
                          }
                          reader.readAsDataURL(this.form.[type]);
          },
          setStatus(data){
            this.form.statusId = data.id;
          },
          viewCompany(){
            this.$router.push({name:'view-company'});
          },
          deleteCompany()
          {
            
            swal({
                  title: "Notification!",
                  text: 'Are you sure you want to Delete this Company',
                  buttons: ['No', 'Yes']
                })
            .then((yes) => {
              if (yes) {
                this.overlay = true;
                axios.delete(`company/${this.orderid}`)
                     .then(resp => {
                      this.$router.push({name:'view-company', params: { message: `Company Deleted Successfully` }});
                     })
                     .catch(err => Exception.handle(err, 'admin'));
                this.overlay = false;
              }
            })
          },
          saveCompany(){
            this.$v.form.$touch();
            if (this.$v.form.$invalid) 
            {
              return;
            }
            this.overlay = true;
              delete this.form.invheader;
              delete this.form.invfooter;
              delete this.form.recheader;
              delete this.form.recfooter;
            if (this.orderid != 0) 
            {
              axios.patch(`company/${this.orderid}`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-company', params: { message: `Company ${resp.data.name} Updated Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      console.log(this.form.allError);
                    });
            }
            else
            {
              axios.post(`company`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-company', params: { message: `Company ${resp.data.name} Added Successfully` }});
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
