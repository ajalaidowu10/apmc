<template>
  <v-app>
    <v-container>
      <div class="d-flex flex-column justify-space-between align-center">
        <v-img
          width="120"
          src="images/favicon.png"
          @click="$router.push('/')"
        ></v-img>
      </div>
      <v-card 
        max-width="600"
        class="mx-auto my-5"
        >
        <v-card-title>
          <span class="headline font-weight-bolder">CREATE ACCOUNT</span>
        </v-card-title>
        <form>
          <v-card-text>
            <v-container class="mb-n5">
              <v-row>
                <v-col
                  cols="12"
                >
                  <v-text-field
                    outlined
                    label="First Name*"
                    v-model="form.firstName"
                    :error-messages="firstNameErrors"
                    @input="$v.form.firstName.$touch()"
                    @blur="$v.form.firstName.$touch()"
                    required
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="12"
                >
                  <v-text-field
                    outlined
                    label="Last Name*"
                    v-model="form.lastName"
                    :error-messages="lastNameErrors"
                    @input="$v.form.lastName.$touch()"
                    @blur="$v.form.lastName.$touch()"
                    required
                  ></v-text-field>
                  <v-text-field
                    outlined
                    label="Phone*"
                    v-model="form.phone"
                    :error-messages="phoneErrors"
                    @input="$v.form.phone.$touch()"
                    @blur="$v.form.phone.$touch()"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    outlined
                    label="Email*"
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
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-container class="mt-n5">
              <v-row>
                <v-col cols="6">
                  <v-btn
                    color="blue darken-1"
                    text
                    to="/"
                  >
                    Back
                  </v-btn>
                </v-col>
                <v-col cols="6">
                  <v-btn
                    class="ma-2 float-right"
                    :loading="form.loading"
                    :disabled="form.loading"
                    color="blue darken-1"
                    @click="signup"
                  >
                    Create
                    <template v-slot:loader>
                      <span class="custom-loader ">
                        <v-icon light >mdi-cached</v-icon>
                      </span>
                    </template>
                  </v-btn>
                </v-col>
              </v-row>
            </v-container>
          </v-card-actions>
        </form>
      </v-card>
    </v-container>
  </v-app>
</template>
<script>
  import { validationMixin } from 'vuelidate'
  import { required,  minLength, email, numeric } from 'vuelidate/lib/validators'
  import transformKeys from '../utils/transformKeys';

  export default {
    mixins: [validationMixin],

    validations: {
      form:{
        firstName:  {required },
        lastName:   {required },
        phone:      {required, numeric},
        email:      {required, email },
        password:   { required, minLength: minLength(8) },
      }
    },
    data: () => ({
      form: {
                firstName: null,
                lastName: null,
                phone: null,
                email: null,
                password: null,
                loading: false,
                showPassword: true,
                allError: {},

      }
    }),
    computed: {
      firstNameErrors () {
        const errors = []
        if (!this.$v.form.firstName.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'firstName') {
            errors.push(this.form.allError.firstName[0]);
            break;
          } 

        } 
        !this.$v.form.firstName.required && errors.push('First Name is required')
        return errors
      },
      lastNameErrors () {
        const errors = []
        if (!this.$v.form.lastName.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'lastName') {
            errors.push(this.form.allError.lastName[0]);
            break;
          } 

        } 
        !this.$v.form.lastName.required && errors.push('Last Name is required')
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
        !this.$v.form.phone.required && errors.push('Phone Number is required');
        !this.$v.form.phone.numeric && errors.push('Invalid Phone Number');

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
        !this.$v.form.email.email && errors.push('Must be valid e-mail')
        !this.$v.form.email.required && errors.push('E-mail is required')
        return errors
      },
      passwordErrors () {
        const errors = []
        if (!this.$v.form.password.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'password') {
            errors.push(this.form.allError.password[0]);
            break;
          } 

        } 
        !this.$v.form.password.required && errors.push('Password is required.')
        !this.$v.form.password.minLength && errors.push('Password must be more 8 characters long')
        return errors
      },
      
    },
    methods:{
      clear(){
        this.$v.$reset()
        this.form.firstName = this.form.email = this.form.phone = this.form.lastName = this.form.password = null;
      },

       signup(){
        this.$v.form.$touch();
        if (this.$v.form.$invalid) 
        {
          return;
        }
        this.form.loading = true;
        axios.post('auth/signup', transformKeys.snakeCase(this.form))
        .then(resp => {
          this.form.loading = false;
          this.clear();
         swal('Notification', resp.data.message)
         .then(()=>this.$router.push({name: 'login'}));
        })
        .catch(err => {
          this.form.loading = false;
          this.form.allError =  transformKeys.camelCase(err.response.data.errors);

        });
        
        
      }
    }
  }
</script>
