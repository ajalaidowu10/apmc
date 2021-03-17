<template>
  <section id="banner">
    <v-row no-gutters>
      <v-img
        :height="'calc(60vh - ' + $vuetify.application.top + 'px)'"
        src="images/booking.jpg"
        gradient="to top right, rgba(11,33,43,.6), rgba(29,57,75,.9)"
      >
        <v-theme-provider dark>
          <v-container fill-height>
            <v-row
              align="center"
              class="white--text mx-auto"
              justify="center"
            >
              <v-col
                class="white--text text-center"
                cols="12"
                tag="h1"
              >
                <span
                :class="[$vuetify.breakpoint.smAndDown ? 'display-1' : 'display-2']"
                  class="font-weight-light"
                >
                  WELCOME TO BOOKING
                </span>

                <br>

                <span
                  :class="[$vuetify.breakpoint.smAndDown ? 'display-3': 'display-4']"
                  class="font-weight-black" id="nav-title1"
                >
                  @ REDSTONE RESORT
                </span>

              </v-col>
              <v-col
                cols="12"
                class="text-center mt-5"
              >
                <v-btn 
                  color="orange" 
                  large class="rounded black--text font-weight-bold"
                  @click="$refs.enquiry.openModal()"
                  >
                   MAKE AN ENQUIRY
                   <v-icon dark>
                       mdi-chevron-right
                   </v-icon>
                </v-btn> 
              </v-col>
            </v-row>
          </v-container>
        </v-theme-provider>
      </v-img>
    </v-row>
    <enquiry-modal ref="enquiry"></enquiry-modal>
  </section>
</template>
<script type="text/javascript">
  import EnquiryModal from './EnquiryModal';
  export default {
    components:{EnquiryModal},
  }

</script>