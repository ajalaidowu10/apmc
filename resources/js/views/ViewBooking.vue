<template>
  <v-app>
    <booking-bar></booking-bar>
    <v-main>
      <view-order></view-order>
    </v-main>
    <app-footer></app-footer>
  </v-app>
</template>

<script>
  import BookingBar from '../components/main/BookingBar';
  import ViewOrder from '../components/main/ViewOrder';
  import AppFooter from '../components/main/AppFooter';

    export default {
        components: {BookingBar, ViewOrder, AppFooter},
        mounted() {
            // console.log('Component mounted.')
        },
        created(){
          if (!User.loggedIn()) {
            this.$router.push({name: 'login'})
          }

        }

    }
</script>