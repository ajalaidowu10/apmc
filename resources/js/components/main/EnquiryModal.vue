<template>
  <v-row justify="center">
    <v-dialog
      v-model="show"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-card-title>
          <span class="headline font-weight-bolder">ENQUIRY</span>
        </v-card-title>
        <v-form ref="enquiryForm">
          <v-card-text>
            <v-container class="mb-n5">
              <v-row>
                <v-col
                  cols="12"
                >
                  <v-text-field
                    outlined
                    dense
                    label="Name*"
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
                     v-model="form.email"
                     :error-messages="emailErrors"
                    required
                    @input="$v.form.email.$touch()"
                    @blur="$v.form.email.$touch()"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    outlined
                    dense
                    label="Phone"
                     v-model="form.phone"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    outlined
                    dense
                    label="Subject*"
                    v-model="form.subject"
                    :error-messages="subjectErrors"
                    @input="$v.form.subject.$touch()"
                    @blur="$v.form.subject.$touch()"
                    required
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="12"
                >
                  <v-textarea
                    outlined
                    dense
                    label="Message*"
                    v-model="form.message"
                    :error-messages="messageErrors"
                    @input="$v.form.message.$touch()"
                    @blur="$v.form.message.$touch()"
                    required
                  ></v-textarea>
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
                    @click="show = false"
                  >
                    Close
                  </v-btn>
                </v-col>
                <v-col cols="6">
                  <v-btn
                    class="ma-2 float-right"
                    :loading="form.loading"
                    :disabled="form.loading"
                    color="blue darken-1"
                    @click="sendEnquiry"
                  >
                    Send
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
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
  import { validationMixin } from 'vuelidate'
  import { required, email } from 'vuelidate/lib/validators'

  export default {
    mixins: [validationMixin],

    validations: {
      form:{
        name:     {required },
        email:    {required, email },
        subject:  {required },
        message:   {required },
      }
    },
    data: () => ({
      show: false,
      form: {
                name: null,
                email: null,
                subject: null,
                message: null,
                phone: null,
                loading: false,
                allError: {},

      }
    }),
    computed: {
      nameErrors () {
        const errors = [];
        if (!this.$v.form.name.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'name') {
            errors.push(this.form.allError.name[0]);
            break;
          } 

        }  
        !this.$v.form.name.required && errors.push('Name is required')
        return errors;
      },
      emailErrors () {
        const errors = [];
        if (!this.$v.form.email.$dirty) return errors;
        for (let items in this.form.allError) {
          if (items == 'email') {

            errors.push(this.form.allError.email[0]);
            break;
          }
        }
        !this.$v.form.email.email && errors.push('Must be valid e-mail')
        !this.$v.form.email.required && errors.push('E-mail is required')
        return errors;
      },
      subjectErrors () {
        const errors = [];
        if (!this.$v.form.subject.$dirty) return errors;
        for (let items in this.form.allError) {
          if (items == 'subject') {

            errors.push(this.form.allError.subject[0]);
            break;
          }
        }
        !this.$v.form.subject.required && errors.push('Subject is required');
        return errors;
      },
      messageErrors () {
        const errors = [];
        if (!this.$v.form.message.$dirty) return errors
        for (let items in this.form.allError) {
          if (items == 'message') {

            errors.push(this.form.allError.message[0]);
            break;
          }
        }
        !this.$v.form.message.required && errors.push('Message is required')
        return errors;
      },
      
    },
    methods:{
      openModal(){
        this.show = true;
      },
      clear(){
        this.$v.$reset()
        this.form.name = this.form.email = this.form.phone = this.form.subject = this.form.message = null;
      },

      sendEnquiry(){
        this.$v.form.$touch();
        if (this.$v.form.$invalid) 
        {
          return;
        }
        this.form.loading = true;
        axios.post('send/enquiry', this.form)
        .then(resp => {
          this.show = this.form.loading = false;
          this.clear();
          swal('Notification', resp.data.message);
        })
        .catch(err => {
          this.form.loading = false;
          this.form.allError =  err.response.data.errors;
        })
        
      }
    }
  }
</script>
