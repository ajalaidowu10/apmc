<template>
  <v-sheet
    id="contact"
    color="black"
    dark
    tag="section"
    tile
    >
    <div class="py-12"></div>

    <v-container>
      <h2 class="display-2 font-weight-bold mb-3 text-uppercase text-center">Contact Us</h2>

      <v-responsive
        class="mx-auto mb-12"
        width="56"
      >
        <v-divider class="mb-1"></v-divider>

        <v-divider></v-divider>
      </v-responsive>

      <v-theme-provider light>
        <v-row>
          <v-col
            md="4"
          >
            <v-avatar
              size="300"  
              tile
              >
              <v-img
                contain
                max-height="100%"
                src="images/favicon.png"
                @click="$vuetify.goTo('#menu')"
              ></v-img>
            </v-avatar>
            <h3>Red Stone Restort</h3>
            <p>The Redstone Resort At Post borgaon Budruk Near Dhom Damp. Sprawling premises set in the heart of the Wai And Mahabaleshwar, just 20min peaceful drive from Wai. It is perfectly located in between Mountains of Mahabaleshwar &amp; wai.</p>
            </v-col>
            <v-col
              md="4"
              >
              <h3>Send Us Message</h3>
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    flat
                    label="Name*"
                    solo
                  ></v-text-field>
                </v-col>

                <v-col cols="12">
                  <v-text-field
                    flat
                    label="Email*"
                    solo
                  ></v-text-field>
                </v-col>

                <v-col cols="12">
                  <v-text-field
                    flat
                    label="Subject*"
                    solo
                  ></v-text-field>
                </v-col>

                <v-col cols="12">
                  <v-textarea
                    flat
                    label="Message*"
                    solo
                  ></v-textarea>
                </v-col>

                <v-col
                  class="mx-auto"
                  cols="auto"
                >
                  <v-btn
                    color="accent"
                    x-large
                  >
                    Submit
                  </v-btn>
                </v-col>
              </v-row>
            </v-col>
            <v-col
              md="4"
            >
              <h3>Address</h3>
              <v-list class="text-white">
                <v-list-item>
                  <v-list-item-avatar
                    color="primary"
                  >
                    <v-icon
                      class="elevation-4"
                      dark
                    >
                      mdi-email-outline
                    </v-icon>
                  </v-list-item-avatar>

                  <v-list-item-title>info@theredstoneresort</v-list-item-title>
                </v-list-item>

                <v-list-item>
                  <v-list-item-avatar color="primary">
                    <v-icon
                      class="elevation-4"
                      dark
                    >
                      mdi-map-marker
                    </v-icon>
                  </v-list-item-avatar>

                  <v-list-item-subtitle>
                    At Post Borgoan Budruk Dhoom Balkavadi Dam Road Tal.Wai Dist Satara
                  </v-list-item-subtitle>
                </v-list-item>

                <v-list-item>
                  <v-list-item-avatar color="primary">
                    <v-icon
                      class="elevation-4"
                      dark
                    >
                      mdi-phone
                    </v-icon>
                  </v-list-item-avatar>

                  <v-list-item-title>8530566555</v-list-item-title>
                </v-list-item>
              </v-list>
            </v-col>
        </v-row>
      </v-theme-provider>
    </v-container>

    <div class="py-12"></div>
  </v-sheet>
</template>
