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
                 Add Room
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit Room
              </div>
              
              
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewRoom"
                >
                  <span class="d-none d-md-flex">View Room</span>
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
                v-model="form.roomGroup"
                label="Room Group"
                :items="roomGroup"
                item-text="name"
                item-value="id"
                :error-messages="roomGroupErrors"
                @input="$v.form.roomGroup.$touch()"
                @blur="$v.form.roomGroup.$touch()"
                dense
                @change="setRoomGroup($event)"
                outlined
              ></v-combobox>
            </v-col>
            <v-col
              cols="12"
             >
              <v-text-field
                outlined
                dense
                label="Room Name*"
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
                label="Room Intercome*"
                v-model="form.intercom"
                :error-messages="intercomErrors"
                @input="$v.form.intercom.$touch()"
                @blur="$v.form.intercom.$touch()"
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
               @click="deleteRoom"
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
               @click="saveRoom"
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
           intercom: {required},
           roomGroup: {required },
           status: {required},
         }
     },
    data: () => ({
      orderid: 0,
      permission: 'room',
      overlay: false,
      roomGroup: [],
      itemStatus: [{'id':1, 'name':'Active'}, {'id':2, 'name':'Inactive'}],
      form: {
              name: null,
              roomGroup:null,
              roomGroupId:null,
              intercom: null,
              status:null,
              statusId:null,
              overlay: false,
              allError: {},

      }
    }),
    created(){
      axios.get(`roomgroup`)
            .then(resp=>{
              this.roomGroup = transformKeys.camelCase(resp.data.data);
            })
            .catch(err => Exception.handle(err, 'admin'));
      if (this.$route.params.orderid) {
        this.orderid = this.$route.params.orderid;
        this.overlay = true;
        axios.get(`room/${this.orderid}`)
             .then(resp => {
              let getRoomOrder            = transformKeys.camelCase(resp.data.data);
              this.form.name              = getRoomOrder.name;
              this.form.intercom          = getRoomOrder.intercom;
              this.form.roomGroup         = getRoomOrder.roomGroup;
              this.form.roomGroupId       = getRoomOrder.roomGroupId;
              this.form.status            = getRoomOrder.status;
              this.form.statusId          = getRoomOrder.statusId;
             })
             .catch(err => Exception.handle(err, 'admin'));
        this.overlay = false;
      }
      
    },
    computed: {
      roomGroupErrors () {
        const errors = [];
        if (!this.$v.form.roomGroup.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'roomGroupId') {
            errors.push(this.form.allError.roomGroupId[0]);
            break;
          } 

        } 
        !this.$v.form.roomGroup.required && errors.push('Room Group is required')
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
        !this.$v.form.status.required && errors.push('Room Status is required')
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
        !this.$v.form.name.required && errors.push('Room Name is required')
        return errors
      },
      intercomErrors () {
        const errors = []
        if (!this.$v.form.intercom.$dirty) return errors; 
        for (let items in this.form.allError) {
          if (items == 'intercom') {
            errors.push(this.form.allError.intercom[0]);
            break;
          } 

        } 
        !this.$v.form.intercom.required && errors.push('Room Price is required')
        return errors
      },
      
    },
    methods: {
          setRoomGroup(data){
            this.form.roomGroupId = data.id;
          },
          setStatus(data){
            this.form.statusId = data.id;
          },
          viewRoom(){
            this.$router.push({name:'view-room'});
          },
          deleteRoom()
          {
            
            swal({
                  title: "Notification!",
                  text: 'Are you sure you want to Delete this Room',
                  buttons: ['No', 'Yes']
                })
            .then((yes) => {
              if (yes) {
                this.overlay = true;
                axios.delete(`room/${this.orderid}`)
                     .then(resp => {
                      this.$router.push({name:'view-room', params: { message: `Room Deleted Successfully` }});
                     })
                     .catch(err => Exception.handle(err, 'admin'));
                this.overlay = false;
              }
            })
          },
          saveRoom(){
            this.$v.form.$touch();
            if (this.$v.form.$invalid) 
            {
              return;
            }
            this.overlay = true;
            if (this.orderid != 0) 
            {
              axios.patch(`room/${this.orderid}`, transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-room', params: { message: `Room ${resp.data.name} Updated Successfully` }});
                    })
                    .catch(err => {
                      this.overlay = false;
                      this.form.allError =  transformKeys.camelCase(err.response.data.errors);
                      console.log(this.form.allError);
                    });
            }
            else
            {
              axios.post('room', transformKeys.snakeCase(this.form))
                    .then(resp =>{
                      this.$router.push({name:'view-room', params: { message: `Room ${resp.data.name} Added Successfully` }});
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
