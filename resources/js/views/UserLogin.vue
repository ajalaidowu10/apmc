<template>
  <v-app>
    <v-container>
      <div class="d-flex flex-column justify-space-between align-center">
        <v-img
          width="120"
          src="images/logo.png"
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
        <form>
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
              <v-row>
                <v-col cols="6">
                  <v-checkbox
                      value="1"
                      label="Remember me"
                      type="checkbox"
                      class="mt-n5"
                  >
                  </v-checkbox>
                </v-col>
                <v-col cols="6">
                  <v-btn
                    text
                    small
                    color="primary"
                    class="mt-n5 ma-2 float-right"
                  >
                    Forgot your password?
                  </v-btn>
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
              <v-row>
                <v-col cols="12" class="text-center">
                  No account? 
                  <v-btn
                    color="green darken-1"
                    text
                    to="/signup"
                  >
                    Create Account
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

  export default {
    mixins: [validationMixin],

    validations: {
      form:{
        email: { required, email },
        password: { required, minLength: minLength(8) },
      }
    },
    created(){
      if (User.loggedIn()) {
        this.$router.push({name: 'add-booking'});
      }
    },
    data: () => ({
      form: {
                email: null,
                password: null,
                showPassword: false,
                loading: false,

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
    },
    methods:{
      clear(){
        this.$v.$reset()
        this.form.email = this.form.password = null;
      },
      login()
      {
        this.$v.form.$touch();
        if (this.$v.form.$invalid) 
        {
          return;
        }
        this.form.loading = true;
        User.login(this.form)
        .then(resp => {
          this.form.loading = false;
          this.clear();
          User.responseAfterLogin(resp);
        })
        .catch(err => {
          this.form.loading = false;
          swal('Notification', "Email or Password does not match");
        });
        
      }
    }
  }
</script>
