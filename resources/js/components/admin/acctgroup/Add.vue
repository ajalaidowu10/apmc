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
                 Add Account Group
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit Account Group
              </div>
              
              
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewData"
                >
                  <span class="d-none d-md-flex">View Account Group</span>
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
                v-model="form.parentGroupcode"
                label="Account Group type"
                :items="parentGroupcode"
                item-text="name"
                item-value="id"
                :error-messages="parentGroupcodeErrors"
                @input="$v.form.parentGroupcode.$touch()"
                @blur="$v.form.parentGroupcode.$touch()"
                dense
                @change="setParentGroupcode($event)"
                outlined
              ></v-combobox>
            </v-col>
            <v-col
              cols="12"
             >
              <v-text-field
                outlined
                dense
                label="Account Group Name*"
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
                label="Account Group Description*"
                v-model="form.descp"
                type="text"
                :error-messages="descpErrors"
                @input="$v.form.descp.$touch()"
                @blur="$v.form.descp.$touch()"
                required
              ></v-text-field>
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
               min-width="300"
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
               min-width="300"
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
           descp: {required},
           parentGroupcode: {required },
           status: {required},
         }
     },
    data: () => ({
      orderid: 0,
      permission: 'item',
      overlay: false,
      parentGroupcode: [
                          {'id':1, 'name':'Assets'}, 
                          {'id':2, 'name':'Profit and Loss'},
                          {'id':3, 'name':'Liabilities'},
      ],
      status: [{'id':1, 'name':'Active'}, {'id':2, 'name':'Inactive'}],
      form: {
              name: null,
              parentGroupcode:null,
              parentGroupcodeId:null,
              descp: null,
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
        axios.get(`groupcode/${this.orderid}`)
             .then(resp => {
              let getAccountOrder            = transformKeys.camelCase(resp.data.data);
              this.form.name              = getAccountOrder.name;
              this.form.descp             = getAccountOrder.descp;
              this.form.parentGroupcode         = getAccountOrder.parentGroupcode;
              this.form.parentGroupcodeId       = getAccountOrder.parentGroupcodeId;
              this.form.status            = getAccountOrder.status;
              this.form.statusId          = getAccountOrder.statusId;
             })
             .catch(err => Exception.handle(err, 'admin'));
      }
      this.overlay = false;
      
    },
    computed: {
      parentGroupcodeErrors () {
        const errors = [];
        if (!this.$v.form.parentGroupcode.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'parentGroupcodeId') {
            errors.push(this.form.allError.parentGroupcodeId[0]);
            break;
          } 

        } 
        !this.$v.form.parentGroupcode.required && errors.push('Account Group Type is required')
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
      nameErrors () {
        const errors = []
        if (!this.$v.form.name.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'name') {
            errors.push(this.form.allError.name[0]);
            break;
          } 

        } 
        !this.$v.form.name.required && errors.push('Account Group Name is required')
        return errors
      },
      descpErrors () {
        const errors = []
        if (!this.$v.form.descp.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'descp') {
            errors.push(this.form.allError.descp[0]);
            break;
          } 

        } 
        !this.$v.form.descp.required && errors.push('Description is required')
        return errors
      },
      
    },
    methods: {
          setParentGroupcode(data){
            this.form.parentGroupcodeId = data.id;
          },
          setStatus(data){
            this.form.statusId = data.id;
          },
          viewData(){
            this.$router.push({name:'view-acctgroup'});
          },
          deleteData()
          {
            
            swal({
                  title: "Notification!",
                  text: 'Are you sure you want to Delete this Account Group',
                  buttons: ['No', 'Yes']
                })
            .then((yes) => {
              if (yes) {
                this.overlay = true;
                axios.delete(`groupcode/${this.orderid}`)
                     .then(resp => {
                      this.$router.push({name:'view-acctgroup', params: { message: `Account Group Deleted Successfully` }});
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
              axios.patch(`groupcode/${this.orderid}`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-acctgroup', params: { message: `Account Group ${resp.data.name} Updated Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      console.log(this.form.allError);
                    });
            }
            else
            {
              axios.post(`groupcode`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-acctgroup', params: { message: `Account Group ${resp.data.name} Added Successfully` }});
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
