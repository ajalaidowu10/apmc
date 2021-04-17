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
                 Add Financial Year
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit Financial Year
              </div>
              
              
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewData"
                >
                  <span class="d-none d-md-flex">View Financial Year</span>
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
              cols="4"
              >
              <v-menu
                ref="menuFrom"
                v-model="menuFrom"
                :close-on-content-click="false"
                :return-value.sync="form.fromDate"
                transition="scale-transition"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    outlined
                    dense
                    v-model="form.fromDate"
                    label="Year From"
                    append-icon="mdi-calendar"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="form.fromDate"
                  no-title
                  scrollable
                >
                  <v-spacer></v-spacer>
                  <v-btn
                    text
                    color="primary"
                    @click="menuFrom = false"
                  >
                    Cancel
                  </v-btn>
                  <v-btn
                    text
                    color="primary"
                    @click="$refs.menuFrom.save(form.fromDate)"
                  >
                    OK
                  </v-btn>
                </v-date-picker>
              </v-menu>
            </v-col>
            <v-col
              cols="4"
              >
              <v-menu
                ref="menuTo"
                v-model="menuTo"
                :close-on-content-click="false"
                :return-value.sync="form.toDate"
                transition="scale-transition"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    outlined
                    dense
                    v-model="form.toDate"
                    label="Year To"
                    append-icon="mdi-calendar"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="form.toDate"
                  no-title
                  scrollable
                >
                  <v-spacer></v-spacer>
                  <v-btn
                    text
                    color="primary"
                    @click="menuTo = false"
                  >
                    Cancel
                  </v-btn>
                  <v-btn
                    text
                    color="primary"
                    @click="$refs.menuTo.save(form.toDate)"
                  >
                    OK
                  </v-btn>
                </v-date-picker>
              </v-menu>
            </v-col>
            <v-col
              cols="12"
              >
              <v-combobox
                v-model="form.status"
                label="Status"
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
           company: {required },
           status: {required},
         }
     },
    data: () => ({
      orderid: 0,
      permission: 'fin-year',
      menuFrom: false,
      menuTo: false,
      overlay: false,
      company: [],
      status: [{'id':1, 'name':'Active'}, {'id':2, 'name':'Inactive'}],
      form: {
              company:null,
              companyId:null,
              fromDate: new Date().toISOString().substr(0, 10),
              toDate: new Date().toISOString().substr(0, 10),
              status:null,
              statusId:null,
              overlay: false,
              allError: {},

      }
    }),
    created(){
      this.overlay = true;
      axios.get(`company`)
      .then(resp=>{
        this.company = transformKeys.camelCase(resp.data.data);
      })
      .catch(err => Exception.handle(err, 'admin'));
      if (this.$route.params.orderid) {
        this.orderid = this.$route.params.orderid;
        axios.get(`finyear/${this.orderid}`)
             .then(resp => {
              let getAccountOrder         = transformKeys.camelCase(resp.data.data);
              this.form.company           = getAccountOrder.company;
              this.form.companyId         = getAccountOrder.companyId;
              this.form.fromDate          = getAccountOrder.fromDate;
              this.form.toDate            = getAccountOrder.toDate;
              this.form.status            = getAccountOrder.status;
              this.form.statusId          = getAccountOrder.statusId;
             })
             .catch(err => Exception.handle(err, 'admin'));
      }
      this.overlay = false;
      
    },
    computed: {
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
      statusErrors () {
        const errors = [];
        if (!this.$v.form.status.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'statusId') {
            errors.push(this.form.allError.statusId[0]);
            break;
          } 

        } 
        !this.$v.form.status.required && errors.push('Status is required')
        return errors
      },
    },
    methods: {
          setCompany(data){
            this.form.companyId = data.id;
          },
          setStatus(data){
            this.form.statusId = data.id;
          },
          viewData(){
            this.$router.push({name:'view-finyear'});
          },
          deleteData()
          {
            
            swal({
                  title: "Notification!",
                  text: 'Are you sure you want to Delete this Financial Year',
                  buttons: ['No', 'Yes']
                })
            .then((yes) => {
              if (yes) {
                this.overlay = true;
                axios.delete(`finyear/${this.orderid}`)
                     .then(resp => {
                      this.$router.push({name:'view-finyear', params: { message: `Financial Year Deleted Successfully` }});
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
              axios.patch(`finyear/${this.orderid}`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-finyear', params: { message: `Financial Year ${resp.data.name} Updated Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      if (!this.form.allError) Exception.handle(err, 'admin');
                    });
            }
            else
            {
              axios.post(`finyear`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-finyear', params: { message: `Financial Year ${resp.data.name} Added Successfully` }});
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
