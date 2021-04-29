<template>
    <v-navigation-drawer
    v-model="isDrawerOpen"
    app
    >
      <v-list>
        <v-list-item link @click="home">
          <v-list-item-action>
            <v-icon>mdi-account-group</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Home</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
</template>
<script>
  export default {
    data: () => ({
      isDrawerOpen: false
    }),
    created () {
      this.$root.$on('drawerNavIcon', () => {
        this.isDrawerOpen = !this.isDrawerOpen
      });
    },
    methods: {
      home () {
        window.location = "/home";
      }
    }
  }
</script>