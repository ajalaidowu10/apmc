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
      axios.get(`acctbal/print/report/${this.$route.params.acctId}/${this.$route.params.dateTo}`)
           .then(resp => {
            this.page = resp.data;
          })
           .catch(err => {
            console.log(err);
          });
      this.overlay = false;
    },
    data: () => ({
      permission: 'account-bal',
      overlay: false,
      page: null,
    }),
    
  }
</script>
