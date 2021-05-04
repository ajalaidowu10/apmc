<template>
    <v-navigation-drawer 
      app
      v-model="drawer"
      :mini-variant.sync="mini"
      permanent
    >
      <v-list-item class="px-2">
        <v-list-item-avatar>
          <v-icon color="orange">mdi-account</v-icon>
        </v-list-item-avatar>

        <v-list-item-title>{{ username }}</v-list-item-title>

        <v-btn
          icon
          @click.stop="mini = !mini"
        >
          <v-icon>mdi-chevron-left</v-icon>
        </v-btn>
      </v-list-item>

      <v-divider></v-divider>

      <v-list dense>
        <v-list-item-group
            color="orange"
          >
          <v-list-item to="/web-admin/dashboard">
            <v-list-item-icon>
              <v-icon>mdi-view-dashboard</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title>Dashboard</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
        
        <v-list-group
          v-for="menu in menus"
          :key="menu.name"
          v-model="menu.active"
          color="orange"
          :prepend-icon="menu.icon"
          no-action
        >
        <template v-slot:activator>
             <v-list-item-title>{{ menu.name }}</v-list-item-title>
        </template>
        <v-list-item
            v-for="subMenu in menu.items"
            :key="subMenu.name"
            :to="subMenu.link"
          >
          <v-list-item-content>
              <v-list-item-title>
                  {{subMenu.name}}
              </v-list-item-title>
          </v-list-item-content>
          
          <v-list-item-icon>
            <v-icon>{{ subMenu.icon }}</v-icon>
          </v-list-item-icon>
        </v-list-item>
        </v-list-group>
      </v-list>
    </v-navigation-drawer>
</template>

<script>
  export default {
    data () {
      return {
        drawer: true,
        menus:[],
        mini: true,
        username: null,
      }
    },
    created(){
        this.username = Admin.name();
        axios.get('admin-auth/menu')
             .then(resp => {
                this.menus = resp.data;
            })
             .catch(err => Exception.handle(err, 'admin'));
    },
  }
</script>