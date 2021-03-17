<template>
  <v-card 
    >
    <form>
      <v-container class="pa-5">
        <v-row>
          <v-col
            cols="12"
          >
            <v-text-field
              outlined
              dense
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
              dense
              label="Last Name*"
              v-model="form.lastName"
              :error-messages="lastNameErrors"
              @input="$v.form.lastName.$touch()"
              @blur="$v.form.lastName.$touch()"
              required
            ></v-text-field>
            <v-text-field
              outlined
              dense
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
              dense
              label="Email*"
               v-model="form.email"
               :error-messages="emailErrors"
              required
              @input="$v.form.email.$touch()"
              @blur="$v.form.email.$touch()"
            ></v-text-field>
          </v-col>
          <v-col cols="12" class="text-center">
            <v-btn
              tile
              x-large
              color="success"
              @click="signup"
            >
              <v-icon left>
                mdi-credit-card-check-outline
              </v-icon>
              Proceed to Payment
            </v-btn>
          </v-col>
        </v-row>
      </v-container>
    </form>
  </v-card>
</template>
<script>
  import { validationMixin } from 'vuelidate'
  import { required,  minLength, email, numeric } from 'vuelidate/lib/validators'
  import transformKeys from '../../utils/transformKeys';

  export default {
    mixins: [validationMixin],

    validations: {
      form:{
        firstName:  {required },
        lastName:   {required },
        phone:      {required, numeric},
        email:      {required, email },
      }
    },
    data: () => ({
      form: {
                firstName: null,
                lastName: null,
                phone: null,
                email: null,
                loading: false,
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
      
    },
    methods:{
      clear(){
        this.$v.$reset()
        this.form.firstName = this.form.email = this.form.phone = this.form.lastName  = null;
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
