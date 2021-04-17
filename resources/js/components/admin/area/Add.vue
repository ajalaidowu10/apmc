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
                 Add Area
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit Area
              </div>
              
              
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewData"
                >
                  <span class="d-none d-md-flex">View Area</span>
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
                label="Area Name*"
                v-model="form.name"
                :error-messages="nameErrors"
                @input="$v.form.name.$touch()"
                @blur="$v.form.name.$touch()"
                required
              ></v-text-field>
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
                
               x-large
               @click="saveData"
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
         }
     },
    data: () => ({
      orderid: 0,
      permission: 'area',
      overlay: false,
      form: {
              name: null,
              overlay: false,
              allError: {},

      }
    }),
    created(){
      this.overlay = true;
      if (this.$route.params.orderid) {
        this.orderid = this.$route.params.orderid;
        axios.get(`area/${this.orderid}`)
             .then(resp => {
              let getAccountOrder            = transformKeys.camelCase(resp.data.data);
              this.form.name              = getAccountOrder.name;
             })
             .catch(err => Exception.handle(err, 'admin'));
      }
      this.overlay = false;
      
    },
    computed: {
      nameErrors () {
        const errors = []
        if (!this.$v.form.name.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'name') {
            errors.push(this.form.allError.name[0]);
            break;
          } 

        } 
        !this.$v.form.name.required && errors.push('Area Name is required')
        return errors
      },
    },
    methods: {
          viewData(){
            this.$router.push({name:'view-area'});
          },
          deleteData()
          {
            
            swal({
                  title: "Notification!",
                  text: 'Are you sure you want to Delete this Area',
                  buttons: ['No', 'Yes']
                })
            .then((yes) => {
              if (yes) {
                this.overlay = true;
                axios.delete(`area/${this.orderid}`)
                     .then(resp => {
                      this.$router.push({name:'view-area', params: { message: `Area Deleted Successfully` }});
                     })
                     .catch(err => Exception.handle(err, 'admin'));
                this.overlay = false;
              }
            })
          },
          saveData(){
            this.$v.form.$touch();
            if (this.$v.form.$invalid) 
            {
              return;
            }
            this.overlay = true;
            if (this.orderid != 0) 
            {
              axios.patch(`area/${this.orderid}`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-area', params: { message: `Area ${resp.data.name} Updated Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      if (!this.form.allError) Exception.handle(err, 'admin');
                    });
            }
            else
            {
              axios.post(`area`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-area', params: { message: `Area ${resp.data.name} Added Successfully` }});
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
