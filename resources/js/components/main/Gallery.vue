<template>
  <section id="gallery">
    <div class="py-12"></div>

    <v-container>
      <h2 class="display-2 font-weight-bold mb-3 text-uppercase text-center">GALLERY</h2>
      <p class="text-disabled text-center">Peek Into Our World</p>

      <v-responsive
        class="mx-auto mb-12"
        width="56"
      >
        <v-divider class="mb-1"></v-divider>

        <v-divider></v-divider>   
      </v-responsive>

      <v-carousel 
        v-model="model"
        shaped
        vertical-delimiters
        cycle
        >
          <v-carousel-item
            v-for="(gallery, i) in galleries"
            :key="i"
            :src="gallery.image"
            reverse-transition="fade-transition"
            transition="fade-transition"

          >
            
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
              model: 0,
              galleries: [
                            {
                              image: 'images/galleries/1.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/2.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/3.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/4.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/5.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/6.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/7.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/8.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/9.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/10.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/11.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/12.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/13.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/14.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/15.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/16.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/17.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/18.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/19.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/20.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/21.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/22.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/23.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/24.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/25.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/26.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/27.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/28.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/29.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/30.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/31.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/32.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/33.jpg',
                              title: 'Red Stone Resort',
                            },
                            {
                              image: 'images/galleries/34.jpg',
                              title: 'Red Stone Resort',
                            },
                          ],
      
      }
    }
  }
</script> 