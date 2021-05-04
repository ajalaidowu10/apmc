<template>
  <v-app>
    <app-header></app-header>
    <toolbar></toolbar>
      <v-main>
        <v-container class="pt-10">
          <router-view></router-view>
        </v-container>
      </v-main>
      <app-footer></app-footer>
  </v-app>
</template>

<script>
  import toolbar from '../components/admin/layout/Toolbar';
  import AppHeader from '../components/admin/layout/AppHeader';
  import AppFooter from '../components/admin/layout/AppFooter';
    export default {
        components: {toolbar, AppHeader, AppFooter},
        created(){
          if (!Admin.loggedIn()) {
            this.$router.push({name: 'admin-login'}).catch(()=>{})
          }

        }
    }
</script>