<template>
  <section id="sub_banner">
    <v-img
      :height="$vuetify.breakpoint.smAndDown ? 700 : 500"
      src="images/enquiry.jpg"
      gradient="to top right, rgba(11,33,43,.6), rgba(29,57,75,.9)"
    >
    
      <v-container fill-height>
        <v-row class="mx-auto">
          <v-col
            cols="12"
            md="8"
          >
            <div id="enquiry-title" class="display-1 font-weight-bold  mb-5  text-uppercase white--text">
              Escape To The Luxury 
            </div>
            <div class="white--text" >
              Revive your mind and body at The Redstone Resorts with amazing comfort and luxury yet pocket-friendly. Multi Cuisine Restaurant, 24 Hours Room Service, Swimming Pool, Banquets for Conferences, Wedding Functions, Corporate Events etc Enjoy the charm of Nature And lakeside and nearness to Wai..
            </div>
          </v-col>
          <v-col
            cols="12"
            md="4"
          >
            <div class="text-center mt-8">
              <v-btn 
                  color="orange" 
                  large class="rounded black--text font-weight-bold"
                  @click="$refs.enquiry1.openModal()"
                >
                 MAKE AN ENQUIRY
                 <v-icon dark>
                     mdi-chevron-right
                 </v-icon>
              </v-btn>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </v-img>
    <enquiry-modal ref="enquiry1"></enquiry-modal>
  </section>
</template>
<script type="text/javascript">
  import EnquiryModal from './EnquiryModal';
  export default {
    components:{EnquiryModal},
  }

</script>