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
                 Add User
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit User
              </div>
              
              
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewUser"
                >
                  <span class="d-none d-md-flex">View User</span>
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
                label="User Name*"
                :disabled="orderid == 0 ? false : true"
                v-model="form.name"
                :error-messages="nameErrors"
                @input="$v.form.name.$touch()"
                @blur="$v.form.name.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                outlined
                dense
                label="Email*"
                :disabled="orderid == 0 ? false : true"
                 v-model="form.email"
                 :error-messages="emailErrors"
                required
                @input="$v.form.email.$touch()"
                @blur="$v.form.email.$touch()"
              ></v-text-field>
            </v-col>
            <v-col cols="12">
              <v-text-field
                v-model="form.password"
                :append-icon="form.showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                :error-messages="passwordErrors"
                :type="form.showPassword ? 'text' : 'password'"
                outlined
                label="Password"
                hint="At least 8 characters"
                required
                @input="$v.form.password.$touch()"
                @blur="$v.form.password.$touch()"
                @click:append="form.showPassword = !form.showPassword"
              ></v-text-field>
            </v-col>
            <v-col
              cols="12"
              >
              <v-combobox
                v-model="form.status"
                label="User Status"
                :items="itemStatus"
                item-text="name"
                item-value="id"
                :error-messages="itemStatusErrors"
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
                
               x-large
               @click="deleteUser"
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
               @click="saveUser"
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
           email: { required, email },
           password: { required, minLength: minLength(8) },
           status: {required},
         }
     },
    data: () => ({
      orderid: 0,
      permission: 'user',
      overlay: false,
      roomGroup: [],
      itemStatus: [{'id':1, 'name':'Active'}, {'id':2, 'name':'Inactive'}],
      form: {
              name: null,
              password: null,
              showPassword: false,                                                   
              status:null,
              statusId:null,
              overlay: false,
              allError: {},

      }
    }),
    created(){
      if (this.$route.params.orderid) {
        this.orderid = this.$route.params.orderid;
        this.overlay = true;
        axios.get(`admin/${this.orderid}`)
             .then(resp => {
              let getUserOrder            = transformKeys.camelCase(resp.data.data);
              this.form.name              = getUserOrder.name;
              this.form.email             = getUserOrder.email;
              this.form.status            = getUserOrder.status;
              this.form.statusId          = getUserOrder.statusId;
             })
             .catch(err => Exception.handle(err, 'admin'));
        this.overlay = false;
      }
      
    },
    computed: {
      itemStatusErrors () {
        const errors = [];
        if (!this.$v.form.status.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'statusId') {
            errors.push(this.form.allError.statusId[0]);
            break;
          } 

        } 
        !this.$v.form.status.required && errors.push('User Status is required')
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
        !this.$v.form.name.required && errors.push('User Name is required')
        return errors
      },
      emailErrors () {
        const errors = []
        if (!this.$v.form.email.$dirty) return errors
        !this.$v.form.email.email && errors.push('Must be valid e-mail')
        !this.$v.form.email.required && errors.push('E-mail is required')
        return errors
      },
      passwordErrors () {
        const errors = []
        if (!this.$v.form.password.$dirty) return errors
        !this.$v.form.password.minLength && errors.push('Password must be more 8 characters long')
        !this.$v.form.password.required && errors.push('Password is required.')
        return errors
      },
      
    },
    methods: {
          setStatus(data){
            this.form.statusId = data.id;
          },
          viewUser(){
            this.$router.push({name:'view-user'});
          },
          deleteUser()
          {
            
            swal({
                  title: "Notification!",
                  text: 'Are you sure you want to Delete this User',
                  buttons: ['No', 'Yes']
                })
            .then((yes) => {
              if (yes) {
                this.overlay = true;
                axios.delete(`admin/${this.orderid}`)
                     .then(resp => {
                      this.$router.push({name:'view-user', params: { message: `User Deleted Successfully` }});
                     })
                     .catch(err => Exception.handle(err, 'admin'));
                this.overlay = false;
              }
            })
          },
          saveUser(){
            this.$v.form.$touch();
            if (this.$v.form.$invalid) 
            {
              return;
            }
            this.overlay = true;
            if (this.orderid != 0) 
            {
              axios.patch(`admin/${this.orderid}`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-user', params: { message: `User ${resp.data.name} Updated Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      if (!this.form.allError) Exception.handle(err, 'admin');
                    });
            }
            else
            {
              axios.post(`admin`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-user', params: { message: `User ${resp.data.name} Added Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      if (!this.form.allError) Exception.handle(err, 'admin');
                    });
            }

          },
      },
  }
</script>
