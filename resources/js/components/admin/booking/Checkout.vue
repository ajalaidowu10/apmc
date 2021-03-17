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
                mdi-home-export-outline
              </v-icon>
              View Checkout
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
      permission: 'check-out',
      orderid: null,
      alert: false,
      search: '',
      rooms: [],
      headers: [
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
      getBookingOrder: {},
      bookingOrders: [],
      bookingForm: true,
      overlay: false,
    }),
    created(){
       this.index();
    },
    methods: {
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
                          this.index();
                         })
                         .catch(err => Exception.handle(err, 'admin'));
                    this.overlay = false;
                  }
                });

              },
              index()
              {

                this.overlay = true;
                axios.get('booking/get/checkout')
                     .then(resp => {
                      this.overlay = false;
                      this.bookingOrders = resp.data.data;
                      this.fetchAvalRoom()
                      .then(resp => {
                        this.rooms = resp.data.data;
                      })
                      if (this.$route.params.message) {
                        this.alert = true;
                      }
                    })
                     .catch(err => {
                      Exception.handle(err, 'admin');
                      this.overlay = false;
                    });

              },
              async fetchAvalRoom(){
                let avalRoom = await axios.get('booking/get/avalroom');
                return avalRoom;
              },
        }
  }
</script>
