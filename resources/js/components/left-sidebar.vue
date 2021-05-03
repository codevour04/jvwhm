<template>
  <v-navigation-drawer
      v-model="drawer"
      absolute
      temporary
    >
      <v-list
        nav
      >
        <v-list-item-group
          active-class="deep-purple--text text--accent-4"
        >
          <v-list-item @click="to('dashboard')">
            <v-list-item-title>Dashboard</v-list-item-title>
          </v-list-item>

          <v-list-item @click="to('people')">
            <v-list-item-title>People</v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-title>Reports</v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-title @click="logout">Logout</v-list-item-title>
          </v-list-item>

        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
</template>

<script>
  
export default {
  data: () => ({
    drawer: false,
  }),
  created () {
    this.$root.$on('drawerNavIcon', () => {
        this.drawer = !this.drawer
      });
  },
  methods : {
    to (route) {
      location = `/${route}`
    },
    logout () {
      axios.post('logout')
      .then(response => (location.reload()));
    }
  }
}

</script>