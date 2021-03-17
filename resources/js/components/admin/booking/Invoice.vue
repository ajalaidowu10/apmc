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
              View Invoice
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
              <tr>
                <td>
                  <strong>TOTAL ROOM AMOUNT</strong>
                </td>
                <td>
                  <strong> &#8377 {{ getBookingOrder.totalAmount}}</strong>
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
              Invoice Details
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="bookingForm = !bookingForm"
                >
                  <span class="d-none d-md-flex">View Invoice</span>
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
                  <strong>LODGE STATUS</strong>
                </th>
              </tr>
            </thead>
            <v-data-table
              :headers="itemHeaders"
              :items="bookingOrderItems"
               hide-default-footer
              >
              <template
                v-slot:body="{ items }"
              >
                <tbody>
                  <tr
                    v-for="item in items"
                    :key="item.name"
                  >
                    <td>
                        {{ item.room_group_name }} 
                        <v-icon color="deep-purple accent-4"> mdi-chevron-right </v-icon> 
                        {{ item.room_name }}
                    </td>
                    <td>{{ item.status_name }}</td>
                    <td>{{ item.day_stayed }}</td>
                    <td>{{ item.extra_bed }}</td>
                    <td>{{ item.time_in }}</td>
                    <td>{{ item.time_out }}</td>
                    <td>{{ item.cost }}</td>
                  </tr>
                  <tr>
                    <td colspan="6"><strong>TOTAL</strong></td>
                    <td><strong>{{ totalCost }}</strong></td>
                  </tr>
                  <tr>
                    <td colspan="6"><strong>GST (16%)</strong></td>
                    <td><strong>{{ gst }}</strong></td>
                  </tr>
                  <tr>
                    <td colspan="6"><strong>TOTAL AMOUNT</strong></td>
                    <td><strong>{{ totalAmount }}</strong></strong></td>
                  </tr>
                </tbody>
              </template>
            </v-data-table>
            <tr>
              <td>Account Name: {{getBookingOrder.user.accountName}} </td>
            </tr>
            <tr>
              <td>Account Balance: &#8377 {{ acctBal }}  </td>
            </tr>
          </table>
          <div class="text-center">
            <v-btn
              color="red"
              dark
              large
              @click="printInvoice"
             >
             PRINT INVOICE
               <v-icon right>
                  mdi-file-pdf-outline
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
      permission: 'invoice-report',
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
              ],
      itemHeaders: [
                {
                  text: 'Room',
                  align: 'start',
                  sortable: true,
                  value: 'room',
                },
                { text: 'Status', value: 'status_name' },
                { text: 'Day Stayed', value: 'day_stayed' },
                { text: 'Extra Bed', value: 'extra_bed' },
                { text: 'Time In', value: 'time_in' },
                { text: 'Time Out', value: 'time_out' },
                { text: 'Cost', value: 'cost' },
              ],
      getBookingOrder: {},
      acctBal: 0,
      bookingOrders: [],
      bookingOrderItems: [],
      bookingForm: true,
      overlay: false,
    }),
    computed: {
      totalCost(){
        if (this.bookingOrderItems.length > 0) {
          return this.bookingOrderItems.reduce((prev, cur) => ({cost: prev.cost + cur.cost})).cost
        }
        return 0;
      },
      gst(){
        return this.totalCost * 0.16;
      },
     
      totalAmount(){
        return this.totalCost + this.gst;
      },
    },
    created(){
       this.index();
    },
    methods: {
              addBooking(){
                this.$router.push({name:'add-booking'});
              },
              async showBooking(id){
                try {
                  let getBooking = await axios.get(`booking/${id}`);
                  this.getBookingOrder = transformKeys.camelCase(getBooking.data.data);
                  
                  let  roomInfo = await axios.get(`booking/roominfo/${id}`);
                  this.bookingOrderItems = roomInfo.data.data;
                  this.orderid = this.getBookingOrder.id;
                  this.bookingForm = false;
                  
                  let acctbal = await  axios.get(`acctbal/${this.getBookingOrder.user.accountId}`);
                   console.log(acctbal.data);
                    if (acctbal.data >= 0) {
                            this.acctBal = Number(acctbal.data) + ' CR';
                          } 
                          else{
                            this.acctBal = Number(acctbal.data) * -1 + ' DR';
                          }
                   
                } catch(err) {
                  Exception.handle(err, 'admin');
                }


                
              },
              index()
              {

                this.overlay = true;
                axios.get('booking/get/invoice')
                     .then(resp => {
                      this.overlay = false;
                      this.bookingOrders = resp.data.data;
                      if (this.$route.params.message) {
                        this.alert = true;
                      }
                    })
                     .catch(err => {
                      Exception.handle(err, 'admin');
                      this.overlay = false;
                    });

              },
              viewBookingOrder(id)
              {
                this.overlay = true;
                this.showBooking(id);
                this.overlay = false;
              },
              printInvoice()
              {
                  let routeData = this.$router.resolve({name: 'print-booking',  params:{id:this.orderid}});
                  window.open(routeData.href, '_blank');
              },
              
        }
  }
</script>
