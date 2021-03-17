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
                 Add Room Group
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit Room Group
              </div>
              
              
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewData"
                >
                  <span class="d-none d-md-flex">View Room Group</span>
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
                label="Room Group Name*"
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
              <v-textarea
                outlined
                dense
                label="Room Group Description*"
                v-model="form.descp"
                :error-messages="descpErrors"
                @input="$v.form.descp.$touch()"
                @blur="$v.form.descp.$touch()"
                required
              ></v-textarea>
            </v-col>
            <v-col
              cols="12"
             >
              <v-text-field
                outlined
                dense
                label="Room Group Price*"
                v-model="form.roomPrice"
                :error-messages="roomPriceErrors"
                @input="$v.form.roomPrice.$touch()"
                @blur="$v.form.roomPrice.$touch()"
                type="number"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="12"
             >
              <v-text-field
                outlined
                dense
                label="Room Group Extra Bed Price*"
                v-model="form.extraBedPrice"
                :error-messages="extraBedPriceErrors"
                @input="$v.form.extraBedPrice.$touch()"
                @blur="$v.form.extraBedPrice.$touch()"
                required
              ></v-text-field>
            </v-col>
            <v-col
              cols="12"
              >
              <v-combobox
                v-model="form.status"
                label="Room Status"
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
           descp:  {required },
           roomPrice: {required},
           extraBedPrice: {required },
           status: {required},
         }
     },
    data: () => ({
      permission: 'room-group',
      orderid: 0,
      overlay: false,
      itemStatus: [{'id':1, 'name':'Active'}, {'id':2, 'name':'Inactive'}],
      form: {
              name: null,
              descp: null,
              roomPrice: null,
              extraBedPrice: null,
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
        axios.get(`roomgroup/${this.orderid}`)
             .then(resp => {
              let getRoomOrder            = transformKeys.camelCase(resp.data.data);
              this.form.name              = getRoomOrder.name;
              this.form.descp             = getRoomOrder.descp;
              this.form.roomPrice         = getRoomOrder.roomPrice;
              this.form.extraBedPrice     = getRoomOrder.extraBedPrice;
              this.form.status            = getRoomOrder.status;
              this.form.statusId          = getRoomOrder.statusId;
             })
             .catch(err => Exception.handle(err, 'admin'));
        this.overlay = false;
      }
      
    },
    computed: {
      roomPriceErrors () {
        const errors = [];
        if (!this.$v.form.roomPrice.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'roomPrice') {
            errors.push(this.form.allError.roomPrice[0]);
            break;
          } 

        } 
        !this.$v.form.roomPrice.required && errors.push('Room Group Price is required')
        return errors
      },
      extraBedPriceErrors () {
        const errors = [];
        if (!this.$v.form.extraBedPrice.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'extraBedPrice') {
            errors.push(this.form.allError.extraBedPrice[0]);
            break;
          } 

        } 
        !this.$v.form.extraBedPrice.required && errors.push('Room Group Extra Bed Price is required')
        return errors
      },
      itemStatusErrors () {
        const errors = [];
        if (!this.$v.form.status.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'statusId') {
            errors.push(this.form.allError.statusId[0]);
            break;
          } 

        } 
        !this.$v.form.status.required && errors.push('Room Group Status is required')
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
        !this.$v.form.name.required && errors.push('Room Group Name is required')
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
        !this.$v.form.descp.required && errors.push('Room Group Description is required')
        return errors
      },
      
    },
    methods: {
          setStatus(data){
            this.form.statusId = data.id;
          },
          viewData(){
            this.$router.push({name:'view-roomgroup'});
          },
          deleteData()
          {
            
            swal({
                  title: "Notification!",
                  text: 'Are you sure you want to Delete this Room Group',
                  buttons: ['No', 'Yes']
                })
            .then((yes) => {
              if (yes) {
                this.overlay = true;
                axios.delete(`roomgroup/${this.orderid}`)
                     .then(resp => {
                      this.$router.push({name:'view-roomgroup', params: { message: `Room Group Deleted Successfully` }});
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
              axios.patch(`roomgroup/${this.orderid}`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-roomgroup', params: { message: `Room Group ${resp.data.name} Updated Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      console.log(this.form.allError);
                    });
            }
            else
            {
              axios.post(`roomgroup`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-roomgroup', params: { message: `Room Group ${resp.data.name} Added Successfully` }});
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
