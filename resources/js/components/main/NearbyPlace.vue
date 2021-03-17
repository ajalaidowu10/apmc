<template>
  <section
    id="nearby"
    class="grey lighten-3"
    >
    <div class="py-12"></div>
    <v-container class="text-center">
      <h2 class="display-2 font-weight-bold mb-3">NEARBY ATTRACTIONS</h2>
      <p class="text-center text--disabled">We welcome you to experience the Redstone Resort At Post borgaon Budruk Near Dhom Damp</p>

      <v-responsive
        class="mx-auto mb-12"
        width="56"
      >
        <v-divider class="mb-1"></v-divider>

        <v-divider></v-divider>
      </v-responsive>
    </v-container >
      <v-container>
        <v-carousel 
          shaped
          cycle
          >
            <v-carousel-item
              v-for="({ image, title, info}, i) in nearbys"
              :key="i"
            >
              <v-row
                no-gutters
                >
                <v-col
                 md="6"
                >
                 <v-img
                   :src="image"
                   width="100%"
                   height="100vh"
                 > 
                 </v-img>
                </v-col>
                <v-col
                 md="6"
                >
                  <div
                    class="pa-15 white black--text"
                    style="height: 100vh;"
                  >
                    <h2 class="text-center mb-2">{{ title }}</h2>
                    <div class="text-justify">{{ info }}</div>
                  </div> 
                </v-col>
              </v-row>
            </v-carousel-item>
        </v-carousel>
      </v-container>
    
    <div class="py-12"></div>
  </section>
</template>
<script>
  export default{
    data(){
      return {
                nearbys: [
                            {
                              image: 'images/nearby/pratpgarh-fort.jpg',
                              title: "Pratapgad Fort",
                              info: "Pratapgad is 21 kms from Mahabaleshwar on Mahad Road. It is very important fort as the major fight with Afzal Khan took place here on 10’th November 1659. In 1656 Ch. Shivaji Maharaj built this fort. The height of this fort is 3543 feet above sea level. Also temple of Tulja Bhavani has been built here by Ch. Shivaji Maharaj. You can have vast look out of Hundreds of kilometer area right from Konkan.",
                            },
                            {
                              image: 'images/nearby/venna-lake.jpg',
                              title: "Venna Lake",
                              info: "Venna Lake is a scenic manmade lake in Mahabaleshwar. The lake offers rowboats, and paddleboats ride to the visitors and hence is usually very crowded. There is horse riding and rides for children such as merry go round and the toy train. There are a number of eateries around the lake famous for street food like corn, bhelpuri and fresh fruits like mulberries, strawberries and carrots.",

                            },
                            {
                              image: 'images/nearby/wilson-point.jpg',
                              title: "Wilson Point",
                              info: "Wilson Point is the highest point in Mahabaleshwar, situated at an altitude of 1439m. Also famous as the Sunrise Point, it is a famous tourist attraction for viewing stunning sunrise. Wilson Point is a vast plateau comprising of three watchtowers at different spots which offers stunning panoramic view of Mahabaleshwar. Originally known as Sindola Hill, Wilson Point is named after Sir Leslie Wilson, the Governor of Bombay province from 1923 to 1926.",
                            },
                            {
                              image: 'images/nearby/elephant.jpg',
                              title: "Elephant's Head point",
                              info: "Elephant's Head Point is one of the most picturesque viewpoints in Mahabaleshwar which is famous for the stunning view of the Sahyadri ranges. Also known as Needle's Point, this famous tourist spot is best visited during sunrise and sunset. The Elephant's Point got its name as it resembles the head and trunk of an elephant. The gap between the elephant's head and the trunk looks like a needlepoint when viewed from far, thus giving it the name Needle Point.",
                            },
                            {
                              image: 'images/nearby/arthur.jpg',
                              title: "Arthur's Seat",
                              info: "Arthur's Seat is one of the most popular viewpoints in Mahabaleshwar, located around 13km away. Also known as the Suicide Point, it is popular as the Queen of all points as it offers the most mesmerizing and fascinating view of the dense valleys of Brahma-Arayana and the Savitri river. Arthur's Seat Point is made up of 6 viewpoints - Arthur's Seat Point, Tiger Sprint Point, Hunter Point, Echo Point, Window Point and Malcolm Point.",
                            }
                          ],
                
      }
    }
  }
</script>