<template>
  <v-footer
    class="py-4"
    color="white"
    height="auto"
    elevation="5"
    >
    <v-container class="mx-auto">
      <v-row>
        <v-col 
          cols="12" 
          sm="12"
          md="7"
          >

          <v-alert
            color="white"
            icon="mdi-email-outline"
          >
            info@redstoneresort.in
          </v-alert>
          <v-alert
            color="white"
            icon="mdi-map-marker"
          >
            At Post Borgoan Budruk Dhoom Balkavadi Dam Road Tal.Wai Dist Satara
          </v-alert>
          <v-alert
            color="white"
            icon="mdi-phone"
          >
            +91 8623066564
          </v-alert>
          <v-alert
            color="white"
            icon="mdi-whatsapp"
          >
            +91 93260 21551
          </v-alert>
        </v-col>
        <v-col 
          cols="12" 
          sm="12"
          md="5"
          >
          <v-btn
            v-for="(item, i) in items"
            :key="i"
            :href="item.href"
            class="ml-0 mr-3"
            rounded
            color="primary"
            outlined
            target="_blank"
          >
            <v-icon v-text="item.icon" />
          </v-btn>
          <div class="mt-md-15">
            <v-btn
              text
              small
              to="/terms-and-conditions"
              target="_blank"
              >
              Terms and conditions
            </v-btn>
          </div>
        </v-col>
      </v-row>
      <v-divider></v-divider>
      <v-row>
        <v-col
          class="text-center"
          cols="12"
        >
        Copyright &copy; {{ new Date().getFullYear() }} <strong>Softwey</strong>
        </v-col>
      </v-row>
    </v-container>
  </v-footer>
</template>

<script>
  export default {
    data: () => ({
      items: [
        {
          href: 'https://www.instagram.com/redstoneresort1/',
          icon: 'mdi-instagram',
        },
        {
          href: 'https://www.facebook.com/theredstoneresort/',
          icon: 'mdi-facebook',
        },
        {
          href: 'https://wa.me/919326021551',
          icon: 'mdi-whatsapp',
        },
        {
          href: 'https://www.linkedin.com/in/redstone-resort-496886202/',
          icon: 'mdi-linkedin',
        },
      ],
    }),
  }
</script>
