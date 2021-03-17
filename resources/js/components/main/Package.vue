<template>
  <section
    id="packages"
    v-if="packages"
    >
    <div class="py-12"></div>

    <v-container class="text-center">
      <h2 class="display-2 font-weight-bold mb-3">PACKAGES</h2>
      <p class="text-center text--disabled">Check out our packages</p>

      <v-responsive
        class="mx-auto mb-12"
        width="56"
      >
        <v-divider class="mb-1"></v-divider>

        <v-divider></v-divider>
      </v-responsive>

        <v-row>
          <v-col
            v-for="(pack, i) in packages"
            :key="i"
            cols="12"
            md="4"
          >
          <v-card
            class="mx-auto"
            >
            <v-img
              :src="pack.image"
              height="200px"
              gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
            ></v-img>

            <v-card-title>
              {{ pack.title }}
            </v-card-title>

            <v-card-subtitle class="text-justify">
              {{ pack.description }}
            </v-card-subtitle>
            <v-chip
                    class="ma-2"
                    color="green darken-4"
                    large
                    outlined
                  >
                    &#8377 {{ pack.price }} / Night
                  </v-chip>
              
            <v-card-actions>
              <v-btn
                color="orange lighten-2"
                text
              >
                Explore
              </v-btn>

              <v-spacer></v-spacer>

              <v-btn
                icon
                @click="toggleExplore(pack)"
              >
                <v-icon>{{ pack.explore ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>
              </v-btn>
            </v-card-actions>
            <v-expand-transition>
              <div v-if="pack.explore">
                <v-divider></v-divider>
                <v-card-text>
                  I'm a thing. But, like most politicians, he promised more than he could deliver. You won't have time for sleeping, soldier, not with all the bed making you'll be doing. Then we'll go with that data file! Hey, you add a one and two zeros to that or we walk! You're going to do his laundry? I've got to find a way to escape.
                </v-card-text>
              </div>
            </v-expand-transition>
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
            return{
                    packages: false,
                    packages1: [
                                {
                                  image: 'images/packages/hotel-single-room.jpg',
                                  title: 'Single Room',
                                  price: 125,
                                  description: 'Well-furnished and designed rooms feature air-conditioning, ergonomic work area, and LED HD TV. It comes with fine curtains, safety deposit box and tea and coffee amenities along with a mini-fridge.',
                                  explore: false,
                                },
                                {
                                  image: 'images/packages/double-room-free-img.jpg',
                                  title: 'Double Room',
                                  price: 255,
                                  description: 'Well-furnished and designed rooms feature air-conditioning, ergonomic work area, and LED HD TV. It comes with fine curtains, safety deposit box and tea and coffee amenities along with a mini-fridge.',
                                  explore: false,

                                },
                                {
                                  image: 'images/packages/duplex-suite-free-img.jpg',
                                  title: 'Duplex Suite',
                                  price: 425,
                                  description: 'Well-furnished and designed rooms feature air-conditioning, ergonomic work area, and LED HD TV. It comes with fine curtains, safety deposit box and tea and coffee amenities along with a mini-fridge.',
                                  explore: false,
                                },
                              ],
            }
    },
    methods:{
      toggleExplore(pack){
          this.packages.forEach(pack => {
            pack.explore = false;
        });
        pack.explore = true;
      }
    }
  }
</script>