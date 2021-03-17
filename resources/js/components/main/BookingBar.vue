<template>
  <div id="menu">
    <v-app-bar
      app
      color="white"
      height="100"
      elevation="5"
      >
      <v-container>
        <v-layout row>
            <v-avatar
              size="100"  
              tile
            >
              <v-img
                contain
                max-height="100%"
                src="images/logo.png"
                @click="$router.push('/')"
              ></v-img>
            </v-avatar>
            <v-toolbar-title id="nav-title"  class="display-1 font-weight-bold black--text mt-8 ml-5 d-none d-md-flex">
              <div @click="$router.push('/')">REDSTONE RESORT</div>
            </v-toolbar-title>
            <v-spacer></v-spacer>
        </v-layout>
      </v-container>
    </v-app-bar>
  </div>
</template>
<script>
  export default {
    data(){
      return {
                userName: User.name(),
      }
    },
    methods: {
      logout() {
        User.logout();
      }
    }
    
  }
</script>