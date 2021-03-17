<template>
  <v-app>
    <booking-bar></booking-bar>
    <v-main>
      <booking-banner></booking-banner>
      <booking-form></booking-form>
    </v-main>
    <app-footer></app-footer>
  </v-app>
</template>

<script>
  import BookingBar from '../components/main/BookingBar';
  import BookingBanner from '../components/main/BookingBanner';
  import BookingForm from '../components/main/BookingForm';
  import AppFooter from '../components/main/AppFooter';

    export default {
        components: {BookingBar, BookingBanner, BookingForm, AppFooter},
        mounted() {
            // console.log('Component mounted.')
        },

    }
</script>