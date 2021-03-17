<template>
  <v-app>
    <booking-bar></booking-bar>
    <v-main>
      <view-terms></view-terms>
    </v-main>
    <app-footer></app-footer>
  </v-app>
</template>

<script>
  import BookingBar from '../components/main/BookingBar';
  import AppFooter from '../components/main/AppFooter';
  import ViewTerms from '../components/main/ViewTerms';

    export default {
        components: {BookingBar, ViewTerms, AppFooter},
        mounted() {
            // console.log('Home mounted.')
        }
    }
</script>