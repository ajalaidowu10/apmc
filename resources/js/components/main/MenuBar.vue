<template>
  <div id="menu">
    <v-app-bar
      app
      color="white"
      height="100"
      elevation="5"
      >
      <v-container>
        <v-layout row>
            <v-avatar
              size="100"  
              tile
            >
              <v-img
                contain
                max-height="100%"
                src="images/logo.png"
                @click="$vuetify.goTo('#menu')"
              ></v-img>
            </v-avatar>
            <v-toolbar-title id="nav-title"  class="display-1 font-weight-bold black--text mt-8 ml-5 d-none d-md-flex">
              <div @click="$vuetify.goTo('#menu')">REDSTONE RESORT</div>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <div id="nav-tab" class="black--text my-6 d-none d-md-flex">
              <v-tabs 
                right
                align-with-title
                background-color="white"
                color="black--text"
                slider-color="white"

                >
                <v-tab @click="$vuetify.goTo('#about-me')">About Us</v-tab>
                <v-tab @click="$vuetify.goTo('#nearby')">Attractions</v-tab>
                <v-tab @click="$vuetify.goTo('#gallery')">Gallery</v-tab>
                <v-tab @click="$vuetify.goTo('#room')">Rooms</v-tab>
                <v-tab @click="$router.push('/booking')">Book Now</v-tab>
              </v-tabs>
            </div>
            <div class="d-flex d-md-none my-5">
              <v-menu
                bottom
                left
               >
                <template v-slot:activator="{ on, attrs }">
                  <v-btn
                    icon
                    v-bind="attrs"
                    v-on="on"
                  >
                    <v-icon>mdi-dots-vertical</v-icon>
                  </v-btn>
                </template>

                <v-list>
                  <v-list-item @click="$vuetify.goTo('#about-me')">About Us</v-list-item>
                  <v-list-item @click="$vuetify.goTo('#nearby')">Attractions</v-list-item>
                  <v-list-item @click="$vuetify.goTo('#gallery')">Gallery</v-list-item>
                  <v-list-item @click="$vuetify.goTo('#room')">Rooms</v-list-item>
                  <v-list-item @click="$router.push('/booking')">Book Now</v-list-item>
                </v-list>
              </v-menu>
            </div>
        </v-layout>
      </v-container>
    </v-app-bar>
  </div>
</template>