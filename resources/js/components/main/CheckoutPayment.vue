<template>
  <form :action="actionUrl" method="POST">
    <div ref="myScript"></div>
  </form>
</template>
<script>
  export default {
    props: ['amount', 'orderid', 'username', 'email', 'contact'],
    data: () => ({
      actionUrl: 'https://redstoneresort.in/payment/success',//https://redstoneresort.in/payment/success or http://localhost:8000/payment/success
      razorSrc: 'https://checkout.razorpay.com/v1/checkout.js',
      razorKey: 'rzp_test_JyM6bIkC4AS5ts',
      appName: 'Redstoneresort.in',
      appDescription: 'Redstoneresort.in Experience unlimited Joy',
      appLogo: 'https://redstoneresort.in/images/favicon.png',
      currency: 'INR',
      btnText: 'Pay with Razorpay',
      razorTheme: '#B71C1C',
    }),
    mounted () {
        // Create a script element so we can inject the NetEnt gameinclusion script
          let myScript = document.createElement('script');

          myScript.setAttribute('src', this.razorSrc);
          myScript.setAttribute('data-key', this.razorKey);
          myScript.setAttribute('data-currency', this.currency);
          myScript.setAttribute('data-name', this.appName);
          myScript.setAttribute('data-description', this.appDescription);
          myScript.setAttribute('data-image', this.appLogo);
          myScript.setAttribute('data-buttontext', this.btnText);
          myScript.setAttribute('data-order_id', this.orderid);
          myScript.setAttribute('data-amount', this.amount);
          myScript.setAttribute('data-prefill.name', this.username);
          myScript.setAttribute('data-prefill.email', this.email);
          myScript.setAttribute('data-prefill.contact', this.contact);
          myScript.setAttribute('data-theme.color', this.razorTheme);

          // Append script
          this.$refs.myScript.insertAdjacentElement('afterend', myScript);
      }
    
  }
</script>
