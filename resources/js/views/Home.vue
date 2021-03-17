<template>
  <v-app>
    <menu-bar></menu-bar>
    <v-main>
      <main-banner></main-banner>
      <about></about>
      <amenity></amenity>
      <sub-banner></sub-banner>
      <nearby-place></nearby-place>
      <gallery></gallery>
      <room></room>
      <package></package>
    </v-main>
    <app-footer></app-footer>
  </v-app>
</template>

<script>
  import MenuBar from '../components/main/MenuBar';
  import MainBanner from '../components/main/MainBanner';
  import About from '../components/main/About';
  import Amenity from '../components/main/Amenity';
  import SubBanner from '../components/main/SubBanner';
  import NearbyPlace from '../components/main/NearbyPlace';
  import Gallery from '../components/main/Gallery';
  import Package from '../components/main/Package';
  import Room from '../components/main/Room';
  import AppFooter from '../components/main/AppFooter';

    export default {
        components: {MenuBar, MainBanner, About, Amenity, SubBanner, NearbyPlace, Gallery, Package, Room, AppFooter},
        mounted() {
            // console.log('Home mounted.')
        }
    }
</script>