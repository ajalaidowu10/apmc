<template>
  <v-container v-if="hasAccess">
    <v-card
      v-if="bookingForm == 1"
      >
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
                 Add Booking
              </div>
              <div v-else>
                <v-icon
                  slot="icon"
                  color="warning"
                >
                  mdi-notebook-edit-outline
                </v-icon>
                Edit Booking
              </div>
              
              
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="viewBooking"
                >
                  <span class="d-none d-md-flex">View Booking</span>
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
              md="3"
              >
              <v-menu
                ref="menuFrom"
                v-model="menuFrom"
                :close-on-content-click="false"
                :return-value.sync="dateFrom"
                transition="scale-transition"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    outlined
                    dense
                    v-model="dateFrom"
                    label="Date"
                    append-icon="mdi-calendar"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="dateFrom"
                  :allowed-dates="dateFromDisablePastDates"
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
                    @click="$refs.menuFrom.save(dateFrom)"
                  >
                    OK
                  </v-btn>
                </v-date-picker>
              </v-menu>
            </v-col>
            <v-col
              cols="12"
              md="3"
              >
              <v-menu
                ref="menuTo"
                label="Check In"
                v-model="menuTo"
                :close-on-content-click="false"
                :return-value.sync="dateTo"
                transition="scale-transition"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    outlined
                    dense
                    v-model="dateTo"
                    label="Check Out"
                    append-icon="mdi-calendar"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-date-picker
                  v-model="dateTo"
                  :allowed-dates="dateToDisablePastDates"
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
                    @click="$refs.menuTo.save(dateTo)"
                  >
                    OK
                  </v-btn>
                </v-date-picker>
              </v-menu>
            </v-col>
            <v-col
              cols="12"
              md="2"
              >
              <v-select
                v-model="totalRoom"
                :items="rooms"
                :error-messages="totalRoomErrors"
                label="Rooms"
                outlined
                dense
                @input="selectRoom($event)"
              ></v-select>
            </v-col>
          </v-row>
          <v-row v-for="(roomInfo, index) in roomsInfo" :key="index">
            <v-col cols="12">
              <v-alert
                color="primary"
                outlined
                dense
              >
               Room {{ roomInfo.dummyRoomId }}
              </v-alert>
            </v-col>
            <v-col
              cols="12"
              md="4"
              >
              <v-select
                :items="[1, 2, 3]"
                label="Adult"
                outlined
                :value="roomInfo.adults"
                dense
                @input="selectAdult($event, index)"
              ></v-select>
              <p class="green--text text-caption" v-text="roomInfo.extraBed == 1 ? 'You will charge charge for Extra Bed' : ''"></p>
            </v-col>
            <v-col
              cols="12"
              md="2"
              >
              <v-select
                :items="[0, 1]"
                label="Children"
                outlined
                :value="roomInfo.children"
                dense
                @input="selectChildren($event, index)"
              ></v-select>
            </v-col>
            <v-col
              cols="12"
              md="2"
              >
              <v-select
                v-show="roomInfo.children == 1"
                :items="[1,2,3,4,5,6,7,8,9,10]"
                label="Child Age"
                :value="roomInfo.childAge"
                outlined
                dense
                @input="selectChildAge($event, index)"
              ></v-select>
            </v-col>
          </v-row>
          <v-row>
            <v-col
              cols="12"
              md="6"
              >
              <v-btn
               color="primary"
               class="pa-10"
               dark
               min-width="300"
               x-large
               @click="searchBooking"
               >
               Search
               <v-icon
                 right
                 dark
                >
                 mdi-magnify
               </v-icon>
             </v-btn>
            </v-col>

          </v-row>
        </v-container>
      </v-card>
    </v-card>

    <v-card
      v-if="bookingForm == 2"
      class="d-md-flex flex-row"
      >
      <v-card
        min-height="500"
        elevation="1"
        >
        <v-row>
          <v-col class="mt-n3">
            <v-banner
              single-line
              outlined

            >
              <v-icon
                slot="icon"
                color="warning"
              > 
                mdi-printer
              </v-icon>
              Booking Summary
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="bookingForm = 1"
                >
                  <span class="d-none d-md-flex">Edit Booking</span>
                  <v-icon >
                    mdi-notebook-edit-outline
                  </v-icon>
                </v-btn>
              </template>
            </v-banner>
            <br>
          </v-col>
        </v-row>
        <v-container>
          <table class="table table-bordered" cellspacing="0">
            <tbody>
              <tr>
                <td>
                  <strong>CHECKIN</strong>
                </td>
                <td>
                  <v-chip
                    class="ma-2"
                    color="deep-purple accent-4"
                    outlined
                  >
                    <v-icon left>
                      mdi-calendar
                    </v-icon>
                    {{ dateFrom }}
                  </v-chip>
                </td>
              </tr>
              <tr>
                <td>
                  <strong>CHECKOUT</strong>
                </td>
                <td>
                  <v-chip
                    class="ma-2"
                    color="deep-purple accent-4"
                    outlined
                  >
                    <v-icon left>
                      mdi-calendar
                    </v-icon>
                    {{ dateTo }}
                  </v-chip>
                </td>
              </tr>
              <tr>
                <td>
                  <strong>NUMBER OF NIGHT</strong>
                </td>
                <td>
                  <v-chip
                    class="ma-2"
                    color="deep-purple accent-4"
                    outlined
                  >
                    {{ numOfNight }}
                  </v-chip>
                </td>
              </tr>
              <tr>
                <td>
                  <strong>TOTAL ROOMS</strong>
                </td>
                <td>
                  <v-chip
                    class="ma-2"
                    color="deep-purple accent-4"
                    outlined
                  >
                    {{ totalRoom }}
                  </v-chip>
                  <span class="grey--text"> &#8377 {{ roomPrice }} / Per Night</span>
                </td>
              </tr>
              <tr v-if="totalExtraBed">
                <td>
                  <strong>TOTAL EXTRA BED</strong>
                </td>
                <td>
                  <v-chip
                    class="ma-2"
                    color="deep-purple accent-4"
                    outlined
                  >
                    {{ totalExtraBed }} 
                  </v-chip>
                  <span class="grey--text"> &#8377 {{ extraBedPrice }} / Per Night</span>
                </td>
              </tr>
              <tr>
                <td>
                  <strong>TOTAL ADULTS</strong>
                </td>
                <td>
                  <v-chip
                    class="ma-2"
                    color="deep-purple accent-4"
                    outlined
                  >
                    {{ totalAdults }}
                  </v-chip>
                </td>
              </tr>
              <tr>
                <td>
                  <strong>TOTAL CHILDREN</strong>
                </td>
                <td>
                  <v-chip
                    class="ma-2"
                    color="deep-purple accent-4"
                    outlined
                  >
                    {{ totalChildren }}
                  </v-chip>
                </td>
              </tr>
              <tr>
                <td>
                  <strong>TOTAL AMOUNT</strong>
                </td>
                <td>
                  <strong>&#8377 {{ totalAmount}}</strong>
                </td>
              </tr>
            </tbody>
          </table>
        </v-container>
      </v-card>
      <v-card
        min-height="500"
        elevation="0"
        class="flex-fill"
        >
        <v-row>
          <v-col class="mt-n3">
            <v-banner
              single-line
              outlined
            >
              <v-icon
                slot="icon"
                color="warning"
              >
                mdi-account-check
              </v-icon>
              Enter Customer Details
            </v-banner>
            <br>
          </v-col>
        </v-row>
        <v-container>
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
                  </v-col>
                  <v-col
                    cols="12"
                  >
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
                      class="pa-10"
                      color="primary"
                      @click="saveBooking"
                      >
                      Save
                      <v-icon 
                        class="ma-2"
                        right
                        dark
                        >
                        mdi-content-save-outline
                      </v-icon>
                    </v-btn>
                  </v-col>
                </v-row>
              </v-container>
            </form>
          </v-card>
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
         totalRoom:     {required },
         form:{
           firstName:  {required },
           lastName:   {required },
           phone:      {required, numeric},
           email:      {required, email },
         }
     },
    data: () => ({
      permission: 'booking',
      orderid: 0,
      bookingForm: 1,
      dateFrom: new Date().toISOString().substr(0, 10),
      dateTo: new Date().toISOString().substr(0, 10),
      roomGroupId: 1,
      roomPrice: 0,
      extraBedPrice: 0,
      totalRoom: null,
      menuFrom: false,
      menuTo: false,
      overlay: false,
      rooms: [
                '1', '2', '3', '4', '5', 
                '6', '7', '8', '9', '10',
                '11', '12', '13', '14', '15', '16'
              ],
      roomsInfo: [],
      arrayEvents: null,
      date1: new Date().toISOString().substr(0, 10),
      form: {
                firstName: null,
                lastName: null,
                phone: null,
                email: null,
                overlay: false,
                allError: {},

      }
    }),
    mounted () {
          this.arrayEvents = [...Array(15)].map(() => {
            const day = Math.floor(Math.random() * 30)
            const d = new Date()
            d.setDate(day)
            return d.toISOString().substr(0, 10)
          })
    },
    created(){
      if (this.$route.params.orderid) {
        this.orderid = this.$route.params.orderid;
        this.overlay = true;
        axios.get(`booking/${this.orderid}`)
             .then(resp => {
              let getBookingOrder = transformKeys.camelCase(resp.data.data);
              this.orderid = getBookingOrder.id;
              this.dateFrom = getBookingOrder.dateFrom;
              this.dateTo = getBookingOrder.dateTo;
              this.roomPrice = getBookingOrder.roomPrice;
              this.extraBedPrice = getBookingOrder.extraBedPrice;
              this.totalRoom = getBookingOrder.totalRoom;
              this.form.firstName = getBookingOrder.user.firstName;
              this.form.lastName= getBookingOrder.user.lastName;
              this.form.phone = getBookingOrder.user.phone;
              this.form.email = getBookingOrder.user.email;
             })
             .catch(err => Exception.handle(err, 'admin'));
        axios.get(`booking/roominfo/${this.orderid}`)
             .then(resp => {
              this.roomsInfo = transformKeys.camelCase(resp.data.data);
             })
             .catch(err => Exception.handle(err, 'admin'));
        this.overlay = false;
        
      }else{

        const d = new Date();
        d.setDate(new Date().getDate()+1);
        this.dateFrom = d.toISOString().substr(0, 10);

        const d1 = new Date();
        d1.setDate(new Date().getDate()+2);
        this.dateTo = d1.toISOString().substr(0, 10);
      }
      
    },
    computed: {
      totalRoomErrors () {
        const errors = [];
        if (!this.$v.totalRoom.$dirty) return errors; 
        
        !this.$v.totalRoom.required && errors.push('Rooms is required')
        return errors;
      },
      numOfNight(){
        let dt1 = new Date(this.dateFrom);
        let dt2 = new Date(this.dateTo);
        return Math.floor((Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) - Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate()) ) /(1000 * 60 * 60 * 24));
      },
      totalExtraBed(){
        return this.roomsInfo.reduce((prev, cur) => ({extraBed: prev.extraBed + cur.extraBed})).extraBed
      },
      totalAdults(){
        return this.roomsInfo.reduce((prev, cur) => ({adults: prev.adults + cur.adults})).adults
      },
      totalChildren(){
        return this.roomsInfo.reduce((prev, cur) => ({children: prev.children + cur.children})).children
      },
      totalRoomAmount(){
        return  this.numOfNight * this.totalRoom * this.roomPrice
      },
      totalBedAmount(){
        return  this.numOfNight * this.totalExtraBed * this.extraBedPrice
      },
      totalRoomCost(){
        return this.totalRoomAmount + this.totalBedAmount
      },
      totalAmount(){
        return this.totalRoomCost
      },

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
    methods: {
          dateFromDisablePastDates(val) {
            return val >= this.dateFrom
          },
          dateToDisablePastDates(val) {
            return val >= this.dateTo
          },
          viewBooking(){
            this.$router.push({name:'view-booking'});
          },
          functionEvents (date) {
            const [,, day] = date.split('-')
            if ([12, 17, 28].includes(parseInt(day, 10))) return true
            if ([1, 19, 22].includes(parseInt(day, 10))) return ['red', '#00f']
            return false
          },
          selectRoom(value){
            this.roomsInfo  = [];
            for (let i = 1; i <= value; i++) {

              let newdata = {dummyRoomId: i, adults: 1, extraBed: 0, children: 0, childAge: 0, statusId: 2};
              this.roomsInfo.push(newdata);
            } 
          }, 
          selectAdult(value, index){ 
            this.roomsInfo = this.roomsInfo.map((item, i) => {
               if (index == i) 
                { 
                  item.adults = value;
                  if (value == 3) { item.extraBed = 1; }else{ item.extraBed= 0; } 
                } 
              return item; 
            }); 
          }, 
          selectChildren(value, index){ 
            this.roomsInfo = this.roomsInfo.map((item, i) => { 
                if (index == i) 
                { 
                  item.children = value;
                  if (value == 1) { item.childAge = 1; }else{ item.childAge = 0; } 
                } 
              return item; 
            });
          },
          selectChildAge(value, index){ 
            this.roomsInfo = this.roomsInfo.map((item, i) => { 
                if (index == i) 
                { 
                  item.childAge = value;
                } 
              return item; 
            });
          },
          async createBooking(){
            this.$v.form.$touch();
            if (this.$v.form.$invalid) 
            {
              return;
            }

            let signup = await axios.post('auth/signup', transformKeys.snakeCase(this.form));
            let data = {};
            if (this.orderid != 0) {
              data['id']  = this.orderid;
            } 
            data['roomGroupId']       = this.roomGroupId;
            data['dateFrom']          = this.dateFrom;
            data['dateTo']            = this.dateTo;
            data['numOfNight']        = this.numOfNight;
            data['totalRoom']         = this.totalRoom;
            data['totalExtraBed']     = this.totalExtraBed;
            data['roomsInfo']         = this.roomsInfo;
            data['totalAdults']       = this.totalAdults;
            data['totalChildren']     = this.totalChildren;
            data['userId']            = signup.data.user_id;

            if (this.orderid != 0) 
            {
              let create = await axios.patch(`booking/${this.orderid}`, transformKeys.snakeCase(data));
              return create;
            }
            else
            {
              let create = await axios.post('booking/adminstore', transformKeys.snakeCase(data));
              return create;
            }

            

          },
          async searchBooking(){
            this.$v.totalRoom.$touch();
            if (this.$v.totalRoom.$invalid) 
            {
              return;
            }
            this.overlay = true;
            let searching = await axios
              .get(`booking/search/${this.roomGroupId}/${this.dateFrom}/ ${this.dateTo}/${this.totalRoom}/${this.orderid}`)
            .then(resp => {
              this.overlay = false;
              if (resp.data.is_avail) {
                this.roomPrice = resp.data.room_price;
                this.extraBedPrice = resp.data.extra_bed_price;
                swal({
                  title: "Notification!",
                  text: resp.data.message,
                  buttons: ['Back', 'Proceed to Booking']
                })
                .then((reply) => {
                    if (reply) {
                        this.bookingForm = 2;
                    }
                });
              }else{
                swal('Notification', resp.data.message);
              }
            })
            .catch(err => {
              this.overlay = false;
            });
          },
          saveBooking(){
            this.overlay = true;
            this.createBooking()
              .then(resp => {
                this.overlay = false;
                if (this.order != 0) 
                {
                  this.$router.push({name:'view-booking', params: { message: `Booking with ID ${resp.data.orderid} Updated Successfully` }});
                }
                else
                {
                  this.$router.push({name:'view-booking', params: { message: `Booking with ID ${resp.data.orderid} Added Successfully` }});
                }
                
              })
              .catch(err => {
                this.overlay = false;
                Exception.handle(err, 'admin');
              });
          }
      },
  }
</script>
