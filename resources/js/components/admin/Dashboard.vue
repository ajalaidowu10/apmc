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
    <v-row>
      <v-col cols="3">
        <v-card color="lime lighten-5" class="pa-5">
          <div class="d-flex flex-no-wrap justify-space-between">
             <v-icon size="50" color="lime">mdi-dots-grid</v-icon>
             <div>
                <v-card-title
                  class="headline"
                >{{ countUnconfirmedBooking }}</v-card-title>

                <v-card-subtitle>Cash &amp; Bank Balance</v-card-subtitle>

                <v-card-actions>
                  <v-btn
                    outlined
                    rounded
                    small
                    @click="viewUnconfirmedBooking"
                  >
                    View Details
                  </v-btn>
                </v-card-actions>
              </div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="3">
        <v-card color="amber lighten-5" class="pa-5">
          <div class="d-flex flex-no-wrap justify-space-between">
             <v-icon size="50" color="amber">mdi-bank-check</v-icon>
             <div>
                <v-card-title
                  class="headline"
                >{{countCheckin}}</v-card-title>

                <v-card-subtitle>Payables</v-card-subtitle>

                <v-card-actions>
                  <v-btn
                    outlined
                    rounded
                    small
                    @click="viewCheckin"
                  >
                    View Details
                  </v-btn>
                </v-card-actions>
             </div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="3">
        <v-card color="blue-grey lighten-5" class="pa-5">
          <div class="d-flex flex-no-wrap justify-space-between">
             <v-icon size="50" color="blue-grey">mdi-ship-wheel</v-icon>
             <div>
                <v-card-title
                  class="headline"
                >{{ countDebitCustomer }}</v-card-title>

                <v-card-subtitle>Receivable</v-card-subtitle>

                <v-card-actions>
                  <v-btn
                    outlined
                    rounded
                    small
                    @click="viewDebitCustomer"
                  >
                    View Details
                  </v-btn>
                </v-card-actions>
             </div>
          </div>
        </v-card>
      </v-col>
      <v-col cols="3">
        <v-card color="pink lighten-5" class="pa-5">
          <div class="d-flex flex-no-wrap justify-space-between">
             <v-icon size="50" color="pink">mdi-home-variant-outline</v-icon>
             <div>
                <v-card-title
                  class="headline"
                >{{ countFreeRoom }}</v-card-title>

                <v-card-subtitle>Stock</v-card-subtitle>

                <v-card-actions>
                  <v-btn
                    outlined
                    rounded
                    small
                    @click="viewRoom"
                  >
                    View Details
                  </v-btn>
                </v-card-actions>
             </div>
          </div>
        </v-card>
      </v-col>
    </v-row>
    <v-row v-if="cashbankBalance">
      <v-col cols="12">
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
            :headers="cashbankBalanceHeaders"
            :items="getUnconfirmedBooking"
            :search="search"
            >
            <template v-slot:item.view="{ item }">
              <v-btn
                color="primary"
                text
                small
                @click="seeUnconfirmedBooking(item.id)"
              >
                <v-icon>
                  mdi-eye
                </v-icon>
              </v-btn>
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
    <v-row v-if="checkin">
      <v-col cols="12">
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
            :headers="checkinHeaders"
            :items="checkinOrders"
            :search="search"
            >
            <template v-slot:item.room="{ item }">
              <strong>{{ item.room_name }}</strong>
              <v-chip v-if="item.extraBed != 0"
                class="ma-2"
                color="deep-purple accent-4"
                outlined
              >
                <v-icon left>
                  mdi-bed
                </v-icon>
                {{ item.extra_bed }}
              </v-chip>
            </template>
            <template v-slot:item.checkoutRoom="{ item }">
              <v-btn v-if="item.status_id == 5"
                color="success"
                dark
                large
                @click="checkout(item.id, item.room_id)"
               >

                <v-icon>
                   mdi-check-outline
                 </v-icon>
              </v-btn>
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
    <v-row v-if="debitCustomer">
      <v-col cols="12">
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
            :headers="debitCustomerHeaders"
            :items="getDebitCustomer"
            :search="search"
            >
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
    <v-row v-if="rooms">
      <v-col cols="12">
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
            :headers="roomHeaders"
            :items="roomOrders"
            :search="search"
            >
            <template v-slot:item.status="{ item }">
              <v-btn
                v-if="item.status == 'Active'"
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
                Free
              </v-btn>
            </template>
          </v-data-table>
        </v-card>
      </v-col>
    </v-row>
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
  import transformKeys from '../../utils/transformKeys';
  export default {
    data: () => ({
      alert: false,
      permission: 'dashboard',
      cashbankBalance: true,
      checkin: false,
      debitCustomer: false,
      rooms: false,
      orderid: null,
      alert: false,
      search: '',
      roomHeaders: [
                { text: 'Room Group Type', value: 'room_group' },
                { text: 'Room Name', value: 'name' },
                { text: 'Room Intercom', value: 'intercom' },
                { text: 'Status', value: 'status' },
              ],
      cashbankBalanceHeaders: [
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
              ],
      checkinHeaders: [
                {
                  text: 'Booking ID',
                  align: 'start',
                  sortable: true,
                  value: 'booking_order.id',
                },
                { text: 'First Name', value: 'booking_order.user.first_name' },
                { text: 'Last Name', value: 'booking_order.user.last_name' },
                { text: 'Email', value: 'booking_order.user.email' },
                { text: 'Room', value: 'room' },
                { text: 'Checkout Date', value: 'booking_order.date_to' },
                { text: 'Checkout Room', value: 'checkoutRoom' },
              ],
      debitCustomerHeaders: [
                {
                  text: 'Customer Name',
                  align: 'start',
                  sortable: true,
                  value: 'acct_name',
                },
                { text: 'Phone Number', value: 'phone' },
                { text: 'Email', value: 'email' },
                { text: 'Amount', value: 'balance' },
              ],
      bookingOrders: [],
      checkinOrders: [],
      roomOrders: [],
      debitCustomerOrders: [],
      overlay: false,
    }),
    computed: {
      getUnconfirmedBooking(){
        return this.bookingOrders.filter(item => item.status == "Not Confirmed");
      },
      getFreeRoom(){
        return this.roomOrders.filter(item => item.status == "Inactive");
      },
      getDebitCustomer(){
          return this.debitCustomerOrders.filter(item => item.balance > 0);
      },
      countUnconfirmedBooking(){
        return this.getUnconfirmedBooking.length; 
      },
      countCheckin(){
        return this.checkinOrders.length; 
      },
      countDebitCustomer(){
          return this.getDebitCustomer.length; 
      },
      countFreeRoom(){
          return this.getFreeRoom.length; 
      },
    },
    created(){
       // this.getLedgerAcct();
       // this.getBooking();
       // this.getCheckin();
       // this.getRoom();

    },
    methods: {
              getRoom()
              {
                this.overlay = true;
                axios.get('room')
                     .then(resp => {
                      this.overlay = false;
                      this.roomOrders = resp.data.data;
                    })
                     .catch(err => {
                      Exception.handle(err, 'admin');
                      this.overlay = false;
                    });
                this.overlay = false;
              },
              getBooking()
              {
                this.overlay = true;
                axios.get('booking')
                     .then(resp => {
                      this.bookingOrders = resp.data.data;
                    })
                     .catch(err => {
                      Exception.handle(err, 'admin');
                    });
                this.overlay = false;
              },
              getCheckin()
              {
                this.overlay = true;
                axios.get('booking/get/checkout')
                     .then(resp => {
                      this.checkinOrders = resp.data.data;
                      if (this.$route.params.message) {
                        this.alert = true;
                      }
                    })
                     .catch(err => {
                      Exception.handle(err, 'admin');
                    });
               this.overlay = false;
              },
              getLedgerAcct()
              {
                this.overlay = true;
                axios.get(`ledger/get/acct/2/1`)
                     .then(resp => {
                      this.debitCustomerOrders = resp.data;
                      if (this.$route.params.message) {
                        this.alert = true;
                      }
                    })
                     .catch(err => {
                      Exception.handle(err, 'admin');
                    });
               this.overlay = false;
              },
              disableAll(){
                this.cashbankBalance = false;
                this.checkin = false;
                this.rooms = false;
                this.debitCustomer = false;
                this.$route.params.message = null;
              },
              viewUnconfirmedBooking(){
                this.disableAll();
                this.cashbankBalance = true;
                this.getBooking();
              },
              viewDebitCustomer(){
                this.disableAll();
                this.debitCustomer = true;
                this.getLedgerAcct();
              },
              viewCheckin(){
                this.disableAll();
                this.checkin = true;
                this.getCheckin();
              },
              viewRoom(){
                this.disableAll();
                this.rooms = true;
                this.getRoom();
              },
              seeUnconfirmedBooking(id)
              {
                this.$router.push({name:'view-booking', params:{orderid:id}});
              },
              checkout(id, room_id){ 
                let data = {};
                data.id = id;
                data.room_id =  room_id;
                swal({
                      title: "Notification!",
                      text: 'Are you sure you want to CHECKOUT this room',
                      buttons: ['No', 'Yes']
                    })
                .then((yes) => {
                  if (yes) {
                    this.overlay = true;
                    axios.post('booking/store/checkout', data)
                         .then(resp => {
                          this.$route.params.message = resp.data.message;
                          this.getCheckin();
                         })
                         .catch(err => Exception.handle(err, 'admin'));
                    this.overlay = false;
                  }
                });

              },
        }
  }
</script>


