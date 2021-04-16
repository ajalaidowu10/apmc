<template>
  <v-app>
    <v-container class="py-15">
      <div class="d-flex flex-column justify-space-between align-center">
        <v-img
          width="120"
          src="../images/logo.png"
          @click="$router.push('/')"
        ></v-img>
      </div>
      <v-card 
        max-width="600"
        class="mx-auto my-5Mene"
        >
        <v-card-title>
          <span class="headline font-weight-bolder site-font">LOGIN</span>
        </v-card-title>
        <form  v-if="showFinyear">
          <v-card-text>
            <v-container class="mb-n5">
              <v-row>
                <v-col
                  cols="12"
                  >
                  <v-combobox
                    v-model="form.company"
                    label="Company"
                    :items="company"
                    item-text="name"
                    item-value="id"
                    :error-messages="companyErrors"
                    @input="$v.form.company.$touch()"
                    @blur="$v.form.company.$touch()"
                    dense
                    @change="setCompany($event)"
                    outlined
                  ></v-combobox>
                </v-col>
                <v-col
                  cols="12"
                  >
                  <v-combobox
                    v-model="form.finyear"
                    label="Financial Year"
                    :items="finyear"
                    item-text="name"
                    item-value="id"
                    :error-messages="finyearErrors"
                    @input="$v.form.finyear.$touch()"
                    @blur="$v.form.finyear.$touch()"
                    dense
                    @change="setFinyear($event)"
                    outlined
                  ></v-combobox>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-container class="mt-n5">
              <v-row>
                <v-col cols="6">
                </v-col>
                <v-col cols="6">
                  <v-btn
                    class="ma-2 float-right"
                    :loading="form.loading"
                    :disabled="form.loading"
                    color="blue darken-1"
                    @click="loginFinal"
                  >
                    Login
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
        <form v-else>
          <v-card-text>
            <v-container class="mb-n5">
              <v-row>
                <v-col
                  cols="12"
                >
                  <v-text-field
                    v-model="form.email"
                    :error-messages="emailErrors"
                    outlined
                    label="E-mail"
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
                </v-col>
                <v-col cols="6">
                  <v-btn
                    class="ma-2 float-right"
                    :loading="form.loading"
                    :disabled="form.loading"
                    color="blue darken-1"
                    @click="login"
                  >
                    Login
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
  import { validationMixin } from 'vuelidate';
  import { required, minLength, email } from 'vuelidate/lib/validators';
  import transformKeys from '../utils/transformKeys';

  export default {
    mixins: [validationMixin],

    validations: {
      form:{
        email: { required, email },
        password: { required, minLength: minLength(8) },
        company: {required},
        finyear: {required},
      }
    },
    created(){
      if (Admin.loggedIn()) {
        this.$router.push({name: 'web-admin'});
      }
    },
    data: () => ({
      showFinyear: false,
      company: [],
      finyear: [],
      form: {
                email: null,
                password: null,
                showPassword: false,
                loading: false,
                company:null,
                companyId:null,
                finyear:null,
                finyearId:null,

      }
    }),
    computed: {
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
      companyErrors () {
        const errors = [];
        if (!this.$v.form.company.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'companyId') {
            errors.push(this.form.allError.companyId[0]);
            break;
          } 

        } 
        !this.$v.form.company.required && errors.push('Company is required')
        return errors
      },
      finyearErrors () {
        const errors = [];
        if (!this.$v.form.finyear.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'finyearId') {
            errors.push(this.form.allError.finyearId[0]);
            break;
          } 

        } 
        !this.$v.form.finyear.required && errors.push('Financial Year is required')
        return errors
      },
    },
    methods:{
      clear(){
        this.$v.$reset()
        this.form.email = this.form.password =  this.form.company = this.form.finyear = null;
      },
      setCompany(data){
        this.form.companyId = data.id;
        this.finyear = data.finyear;
      },
      setFinyear(data){
        this.form.finyearId = data.id;
      },
      login()
      {
        this.$v.form.$touch();
        if (this.$v.form.email.$invalid) 
        {
          return;
        }
        if (this.$v.form.password.$invalid) 
        {
          return;
        }
        this.form.loading = true;
        axios.get(`company`)
        .then(resp=>{
          this.company = resp.data.data;
          this.showFinyear = true;
        })
        this.$v.$reset();
        this.form.loading = false;
        
      },
      loginFinal()
      {
        this.$v.form.$touch();
        if (this.$v.form.company.$invalid) 
        {
          return;
        }
        if (this.$v.form.finyear.$invalid) 
        {
          return;
        }
        this.form.loading = true;
        Admin.login(transformKeys.snakeCase(this.form))
        .then(resp => {
          this.form.loading = false;
          this.clear();
          Admin.responseAfterLogin(resp);
        })
        .catch(err => {
          this.form.loading = false;
          this.showFinyear = false;
          swal('Notification', "Email or Password does not match");
        });
        
      }

    }
  }
</script>
