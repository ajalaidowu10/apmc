<template>
  <v-container>
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
                mdi-history
              </v-icon>
              Booking History
            </v-banner>
            <br>
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
                  dark
                  small
                  @click="viewBookingOrder(item.id)"
                >
                  <v-icon dark>
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
              <template v-slot:actions>
                <v-btn
                  class="mx-2 float-right"
                  color="orange"
                  @click="bookingForm = !bookingForm"
                >
                  <span class="d-none d-md-flex">View Bookings</span>
                  <v-icon >
                    mdi-history
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
              text
              color="orange"
              block
              small
              to="/terms-and-conditions"
              target="_blank"
              >
              view terms and conditions
            </v-btn>
            <v-btn
              v-if="getBookingOrder.status == 'Confirmed'"
              color="red"
              dark
              large
              @click="bookingMessageForm = true"

             >
              Edit or Cancel Booking
            </v-btn>
            <v-btn
              v-else
              color="primary"
              dark
              large
             >
              {{ getBookingOrder.status }}
            </v-btn>
          </div>
        </v-container>
      </v-card>
    </v-card>
    <v-dialog
      v-model="bookingMessageForm"
      persistent
      max-width="600px"
     >
      <v-card>
        <v-card-title>
          <span class="headline font-weight-bolder">Send us a message</span>
        </v-card-title>
        <v-form>
          <v-card-text>
            <v-container class="mb-n5">
              <v-row>
                <v-col
                  cols="12"
                >
                  <v-textarea
                    outlined
                    dense
                    placeholder="Kindly give the reason and details for editing/canceling this  reservation"
                    label="Message*"
                    rows="8"
                    v-model="form.message"
                    :error-messages="messageErrors"
                    @input="$v.form.message.$touch()"
                    @blur="$v.form.message.$touch()"
                    required
                  ></v-textarea>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-container class="mt-n5">
              <v-row>
                <v-col cols="6">
                  <v-btn
                    color="blue darken-1"
                    text
                    @click="bookingMessageForm = false"
                  >
                    Close
                  </v-btn>
                </v-col>
                <v-col cols="6">
                  <v-btn
                    class="ma-2 float-right"
                    color="blue darken-1"
                    @click="sendMessage"
                  >
                    Submit
                        <v-icon light >mdi-telegram</v-icon>
                  </v-btn>
                </v-col>
              </v-row>
            </v-container>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
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
  import { validationMixin } from 'vuelidate'
  import { required} from 'vuelidate/lib/validators'
  export default {
    mixins: [validationMixin],
    validations: {
      form:{
        message:   {required },
      }
    },
    computed: {
      messageErrors () {
        const errors = [];
        if (!this.$v.form.message.$dirty) return errors
        
        !this.$v.form.message.required && errors.push('Message is required')
        return errors;
      },
    },
    data: () => ({
      form: {
                id: null,
                message: null,
      },
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
      bookingMessageForm: false,
      overlay: false,
    }),
    created(){
       this.index();
    },
    methods: {
              index()
              {
                axios.get('booking/index')
                     .then(resp => this.bookingOrders = resp.data.data)
                     .catch(err => Exception.handle(err));
              },

              viewBookingOrder(id)
              {
                this.overlay = true;
                axios.get(`booking/show/${id}`)
                     .then(resp => {
                      this.getBookingOrder = transformKeys.camelCase(resp.data.data);
                      this.form.id = this.getBookingOrder.id;
                      this.bookingForm = false;
                     })
                     .catch(err => Exception.handle(err));
                this.overlay = false;
              },
              clear(){
                this.$v.$reset()
                this.form.message = null;
              },
              sendMessage()
              {
                this.$v.form.$touch();
                if (this.$v.form.$invalid) 
                {
                  return;
                }
                this.overlay = true;
                axios.post('booking/message', this.form)
                .then(resp => {
                  this.clear();
                  this.bookingMessageForm = false;
                  this.bookingForm = true;
                  this.index();
                  this.overlay = false;
                  swal('Notification', resp.data.message);
                })
                .catch(err => {
                  this.overlay = false;
                  Exception.handle(err);
                })
              },
              
        }
  }
</script>
