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
      axios.get(`report/print/purchasebill/${this.$route.params.acctId}/${this.$route.params.date}`)
           .then(resp => {
            this.page = resp.data;
          })
           .catch(err => {
            console.log(err);
          });
      this.overlay = false;
    },
    data: () => ({
      permission: 'purchase-printing',
      overlay: false,
      page: null,
    }),
    
  }
</script>
