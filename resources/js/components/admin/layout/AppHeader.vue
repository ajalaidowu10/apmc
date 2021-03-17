<template>
  <div>
    <v-app-bar app
      color="primary"
      dense
      dark
    >
      <v-toolbar-title class="pl-10">Apmc Manager</v-toolbar-title>

      <v-spacer></v-spacer>

      
      <v-btn 
        icon
        to="/logout"
        >
        <v-icon>mdi-logout</v-icon>
      </v-btn>
    </v-app-bar>
  </div>
</template>
<script>
  export default {
      created() {
        EventBus.$on("logout", () => {
          Admin.logout();
        });
      }
  }
</script>