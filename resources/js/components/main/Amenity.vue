<template>
  <section
    id="amenities"
    class="grey lighten-3"
    >
    <div class="py-12"></div>
    <v-container class="text-center">
      <h2 class="display-2 font-weight-bold mb-3">AMENITIES</h2>
      <p class="text-center text--disabled">Providing Hospitality the Correct Way</p>

      <v-responsive
        class="mx-auto mb-12"
        width="56"
      >
        <v-divider class="mb-1"></v-divider>

        <v-divider></v-divider>
      </v-responsive>

      <v-row class="mb-2">
          <v-col
            v-for="({image, title}, i) in amenities" 
            :key="i"
          >
            <v-avatar
                color="white"
                size="100"
                tile

                class="rounded mb-1"
            >
                <v-img
                  contain
                  :src="image"
                  max-height="50%"

                >
                    
                </v-img>
            </v-avatar>
            <p class="text--dark font-weight-bold">{{ title }}</p>
          </v-col>
      </v-row>  

      <v-row>
        <v-col
          v-for="({ image, title}, i) in features"
          :key="i"
          cols="12"
          md="3"
        >
          <v-card>
            <v-img
              :src="image"
              class="white--text align-end"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
              aspect-ratio="1"

            >
              <v-card-title v-text="title"></v-card-title>
            </v-img>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <div class="py-12"></div>
  </section>
</template>
<script>
  export default{
    data(){
      return {
                features: [
                            {
                              image: 'images/features/hotel-linens.jpg',
                              title: 'Linens',
                            },
                            {
                              image: 'images/features/toileteries-free-img.jpg',
                              title: 'Toiletries',
                            },
                            {
                              image: 'images/features/breakfast-free-img.jpg',
                              title: 'Breakfast',
                            },
                            {
                              image: 'images/features/swimming-pool-free-img.jpg',
                              title: 'Swimming Pool',
                            }
                          ],
                amenities: [
                              {
                                image: 'images/amenities/banquet.png',
                                title: 'Banquet',
                              },
                              {
                                image: 'images/amenities/home-cafe.png',
                                title: 'Coffee Bar',
                              },
                              {
                                image: 'images/amenities/restaurant.png',
                                title: 'Restaurant',
                              },
                              {
                                image: 'images/amenities/room-service.png',
                                title: 'Room Service',
                              },
                              {
                                image: 'images/amenities/reception.png',
                                title: '24x7 Reception',
                              },
                              {
                                image: 'images/amenities/swim.png',
                                title: 'Swimming Pool',
                              },
                              {
                                image: 'images/amenities/hair-dryer.png',
                                title: 'Hair Dryer',
                              },
                              {
                                image: 'images/amenities/wifi.png',
                                title: 'Secure Wi-Fi',
                              },
                          ],
      }
    }
  }
</script>