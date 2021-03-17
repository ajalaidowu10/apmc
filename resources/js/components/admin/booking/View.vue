<template>
  <v-container v-if="hasAccess">
    <v-alert
      v-model="alert"
      border="left"
      close-text="Close Alert"
      color="success"
      dark
      dismissible
      >
      {{ $route.params.message }}
    </v-alert>
    <v-card
      v-if="bookingForm"
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
              <v-icon
                slot="icon"
                color="warning"
              >
                mdi-book-search-outline
              </v-icon>
              View Booking
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="addBooking"
                >
                  <span class="d-none d-md-flex">Add Booking</span>
                  <v-icon >
                    mdi-notebook-plus-outline
                  </v-icon>
                </v-btn>
              </template>
            </v-banner>
          </v-col>
        </v-row>
        <v-container>
          <v-card>
            <v-card-title>
              <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
                >
              </v-text-field>
            </v-card-title>
            <v-data-table
              :headers="headers"
              :items="bookingOrders"
              :search="search"
              >
              <template v-slot:item.view="{ item }">
                <v-btn
                  color="primary"
                  text
                  small
                  @click="viewBookingOrder(item.id)"
                >
                  <v-icon>
                    mdi-eye
                  </v-icon>
                </v-btn>
              </template>
              <template v-slot:item.status="{ item }">
                <v-btn
                  v-if="item.status == 'Confirmed'"
                  color="success"
                  text
                  small
                >
                  {{ item.status }}
                </v-btn>
                <v-btn
                  v-else
                  color="primary"
                  text
                  small
                >
                  {{ item.status }}
                </v-btn>
              </template>
            </v-data-table>
          </v-card>
        </v-container>
      </v-card>
    </v-card>

    <v-card
      v-if="!bookingForm"
      class="d-md-flex"
      >
      <v-card
        min-height="500"
        min-width="300"
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
              Booking Details
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
                    {{ getBookingOrder.dateFrom }}
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
                    {{ getBookingOrder.dateTo }}
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
                    {{ getBookingOrder.numOfNight }}
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
                    {{ getBookingOrder.totalRoom }}
                  </v-chip>
                  <span class="grey--text"> &#8377 {{ getBookingOrder.roomPrice }} / Per Night</span>
                </td>
              </tr>
              <tr v-if="getBookingOrder.totalExtraBed">
                <td>
                  <strong>TOTAL EXTRA BED</strong>
                </td>
                <td>
                  <v-chip
                    class="ma-2"
                    color="deep-purple accent-4"
                    outlined
                  >
                    {{ getBookingOrder.totalExtraBed }} 
                  </v-chip>
                  <span class="grey--text"> &#8377 {{ getBookingOrder.extraBedPrice }} / Per Night</span>
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
                    {{ getBookingOrder.totalAdults }}
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
                    {{ getBookingOrder.totalChildren }}
                  </v-chip>
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
                mdi-credit-card-check-outline
              </v-icon>
              Payment Details
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="bookingForm = !bookingForm"
                >
                  <span class="d-none d-md-flex">View Bookings</span>
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
          <table class="table table-bordered" cellspacing="0">
            <thead>
              <tr>
                <th  colspan="2" class="text-left">
                  <strong>YOUR ORDER</strong>
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="getBookingOrder.totalRoom">
                <td>
                  {{ getBookingOrder.totalRoom }} Rooms
                </td>
                <td>
                  <strong>
                   &#8377 {{ getBookingOrder.totalRoomAmount }}
                  </strong>
                </td>
              </tr>
              <tr v-if="getBookingOrder.totalExtraBed">
                <td>
                  {{ getBookingOrder.totalExtraBed }} Extra Beds
                </td>
                <td>
                 <strong>
                  &#8377 {{ getBookingOrder.totalExtraBedAmount}}
                 </strong>
                </td>
              </tr>
              <tr v-if="getBookingOrder.totalRoomCost">
                <td>
                 Total Room Cost
                </td>
                <td>
                 <strong>
                  &#8377 {{ getBookingOrder.totalRoomCost}}
                 </strong>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                 Kindly note 16% GST charges is applicable on the final billing.
                </td>
              </tr>
              <tr>
                <td>
                  <strong>TOTAL</strong>
                </td>
                <td>
                  <strong>&#8377 {{ getBookingOrder.totalAmount}}</strong>
                </td>
              </tr>
              <tr v-if="getBookingOrder.message">
                <td colspan="2">
                  <strong>Message</strong>
                </td>
              </tr>
              <tr v-if="getBookingOrder.message">
                <td colspan="2">
                  {{ getBookingOrder.message }}
                </td>
              </tr>
            </tbody>
          </table>
          <div class="text-center">
            <v-btn
              v-if="getBookingOrder.status == 'Confirmed'"
              color="success"
              dark
              large
             >
              {{ getBookingOrder.status }}
              <v-icon right>
                mdi-book-check-outline
              </v-icon>
            </v-btn>
            <v-btn
              v-else
              color="red"
              dark
              large
              @click="confirmBooking"
             >
              Not Confirmed
              <v-icon right>
                mdi-book-cancel-outline
              </v-icon>
            </v-btn>
            <v-btn
              color="orange"
              dark
              large
              @click="editBooking"
             >
             Edit
               <v-icon right>
                 mdi-book-edit-outline
               </v-icon>
            </v-btn>
            <v-btn
              color="primary"
              dark
              large
              @click="deleteBooking"
             >
             Delete
               <v-icon right>
                 mdi-book-remove-outline
               </v-icon>
            </v-btn>
          </div>
        </v-container>
      </v-card>
    </v-card>
    <v-overlay 
      :value="overlay"
      z-index="300"
      >
      <v-progress-circular
        indeterminate
        size="64"
      ></v-progress-circular>
    </v-overlay>
  </v-container>
</template>
<script>
  import transformKeys from '../../../utils/transformKeys';
  export default {
    data: () => ({
      permission: 'booking',
      orderid: null,
      alert: false,
      search: '',
      headers: [
                {
                  text: 'Booking ID',
                  align: 'start',
                  sortable: true,
                  value: 'id',
                },
                { text: 'Room Type', value: 'room_group' },
                { text: 'Checkin', value: 'date_from' },
                { text: 'Checkout', value: 'date_to' },
                { text: 'No. of Night', value: 'num_of_night' },
                { text: 'Total Amount', value: 'total_amount' },
                { text: 'View', value: 'view' },
                { text: 'Status', value: 'status' },
              ],
      getBookingOrder: {},
      bookingOrders: [],
      bookingForm: true,
      overlay: false,
    }),
    created(){
       this.index();
    },
    methods: {
              addBooking(){
                this.$router.push({name:'add-booking'});
              },
              index()
              {

                this.overlay = true;
                console.log(this.$route.params.orderid);
                 if (this.$route.params.orderid) 
                 {
                   axios.get(`booking/${this.$route.params.orderid}`)
                        .then(resp => {
                         this.getBookingOrder = transformKeys.camelCase(resp.data.data);
                         this.orderid = this.getBookingOrder.id;
                         this.bookingForm = false;
                        })
                  .catch(err => Exception.handle(err, 'admin'));
                  }
                  else
                  {
                    axios.get('booking')
                         .then(resp => {
                          this.bookingOrders = resp.data.data;
                          if (this.$route.params.message) {
                            this.alert = true;
                          }
                        })
                         .catch(err => {
                          Exception.handle(err, 'admin');
                        });
                  }
                this.overlay = false;

              },
              viewBookingOrder(id)
              {
                this.overlay = true;
                axios.get(`booking/${id}`)
                     .then(resp => {
                      this.getBookingOrder = transformKeys.camelCase(resp.data.data);
                      this.orderid = this.getBookingOrder.id;
                      this.bookingForm = false;
                     })
                     .catch(err => Exception.handle(err, 'admin'));
                this.overlay = false;
              },
              confirmBooking()
              {
                
                swal({
                      title: "Notification!",
                      text: 'Are you sure you want to confirm this booking',
                      buttons: ['No', 'Yes']
                    })
                .then((yes) => {
                  if (yes) {
                    this.overlay = true;
                    axios.get(`booking/confirm/${this.orderid}`)
                         .then(resp => {
                          this.orderid = resp.data.orderid;
                          this.$route.params.message = `Booking with ID ${this.orderid} Confirmed Successfully`;
                          this.index();
                          this.bookingForm = true;
                         
                         })
                         .catch(err => Exception.handle(err, 'admin'));
                    this.overlay = false;
                  }
                })
              },
              editBooking(){
                this.$router.push({name:'add-booking', params:{orderid:this.orderid}});
              },
              deleteBooking()
              {
                
                swal({
                      title: "Notification!",
                      text: 'Are you sure you want to Delete this booking',
                      buttons: ['No', 'Yes']
                    })
                .then((yes) => {
                  if (yes) {
                    this.overlay = true;
                    axios.delete(`booking/${this.orderid}`)
                         .then(resp => {
                          this.orderid = resp.data.orderid;
                          this.$route.params.message = `Booking with ID ${this.orderid} Deleted Successfully`;
                          this.index();
                          this.bookingForm = true;
                         
                         })
                         .catch(err => Exception.handle(err, 'admin'));
                    this.overlay = false;
                  }
                })
              },
              
        }
  }
</script>
