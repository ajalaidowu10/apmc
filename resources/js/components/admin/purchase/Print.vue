<template>
  <v-app>
    <v-container v-if="hasAccess">
      <div v-html="page"></div>
    </v-container>
    <v-overlay 
      :value="overlay"
      z-index="300"
      >
      <v-progress-circular
        indeterminate
        size="64"
      ></v-progress-circular>
    </v-overlay>
  </v-app>
</template>
<script>
  export default {
    created(){
      this.overlay = true;
      axios.get(`sales/print/invoice/${this.$route.params.id}/`)
           .then(resp => {
            this.page = resp.data;
          })
           .catch(err => {
            console.log(err);
          });
      this.overlay = false;
    },
    data: () => ({
      permission: 'restuarant-sales',
      overlay: false,
      page: null,
    }),
    
  }
</script>
