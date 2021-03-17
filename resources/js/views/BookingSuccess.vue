<template>
  <v-app>
    <v-container>
      <v-card 
        max-width="600"
        elevation="1"
        height="100%"
        class="mx-auto mt-15 pa-10 text-center"
        >
          <div class="my-auto">
            <span class="headline font-weight-bolder">BOOKING SUCCESSFUL</span>
            <v-alert type="success">
              Thanks for your order, your Booking ID is {{ $route.params.bookingid }}
            </v-alert>
            <v-btn
              text
              color="primary"
              to="/"
            >
             Back Home Page 
            </v-btn>
          </div>
      </v-card>
    </v-container>
  </v-app>
</template>
<script>
  export default {
    data: () => ({
      
    }),
    
  }
</script>
