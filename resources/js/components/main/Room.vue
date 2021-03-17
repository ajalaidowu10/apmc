<template>
  <section
    id="room"
    class="grey lighten-3"
    >
    <div class="py-12"></div>
    <v-container class="text-center">
      <h2 class="display-2 font-weight-bold mb-3">ROOMS</h2>
      <p class="text-center text--disabled">Choice Of Rooms</p>

      <v-responsive
        class="mx-auto mb-12"
        width="56"
      >
        <v-divider class="mb-1"></v-divider>

        <v-divider></v-divider>
      </v-responsive>
    </v-container>
      <v-container fluid>
        <v-row
          no-gutters
          >
          <v-col
            md="5"
          >
            <v-carousel 
              hide-delimiter-background
              hide-delimiters
              cycle
              next-icon=""
              prev-icon=""
              >
                <v-carousel-item
                  v-for="image in roomGroupImages"
                  :key="image"
                  transition="fade"
                >
                  <v-card
                    class="d-flex flex-md-row"
                    >
                      <v-img
                        :src="image"
                        height="500"
                      >
                      </v-img>
                  </v-card>
                </v-carousel-item>
            </v-carousel>
          </v-col>
          <v-col
          md="7"
          >
            <v-card
              class="pa-10 white black--text"
              height="100%"
            >
            <h2 class="text-center mb-2">{{ roomGroup.name }}</h2>
            <div class="text-justify mb-2">{{ roomGroup.descp }}</div>
              <v-card
                class="d-flex flex-wrap"
                flat
                tile
                >
                <v-alert
                  v-for="asset in assets"
                  :key="asset"
                  class="pa-2 flex-fill"
                  type="success"
                  elevation="2"
                  outlined
                 >
                  {{ asset }}
                </v-alert>
              </v-card>
              <div class="d-md-flex">
                <v-chip
                  class="ma-2 mr-auto"
                  color="green darken-4"
                  large
                  outlined
                >
                  &#8377 {{ roomGroup.roomPrice }} / Per Night
                </v-chip>
                <v-btn 
                  class="mt-5 ml-auto"
                  color="pink"
                  large
                  dark
                  to="/booking"
                  >
                  Book Now
                </v-btn>
                <div class="d-md-none py-5"></div>
              </div>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    <div class="py-12"></div>
  </section>
</template>
<script>
import transformKeys from '../../utils/transformKeys';
  export default{
    data(){
      return {
                roomGroupImages: [
                          'images/rooms/room-one.jpg',
                          'images/rooms/room-two.jpg',
                          'images/rooms/room-three.jpg',
                        ],
                roomGroup: {},
                          assets: [
                                 'Sanitizers Lounge'
                                ,'Restaurant'
                                ,'Swimming Pool'
                                ,'Lawn Sitting Area'
                                ,'Furnitured Rooms'
                                ,'Reception'
                                ,'Parking'
                                ,'CCTV'
                                ,'Hygine'
                                ,'Gyser'
                                ,'Bathroom Kits'
                                ,'Towels'
                                ,'kettels and tea supply'
                                ,'Flat TV'
                              ]
                
      }
    },
    created(){
      axios.get(`roomgroup/1`)
            .then(resp=>{
              this.roomGroup = transformKeys.camelCase(resp.data.data);
            })
            .catch(err => console.log(err));
    }

  }
</script>