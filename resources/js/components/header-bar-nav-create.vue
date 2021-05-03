<template>
  <v-app id="inspire">
    <left-sidebar></left-sidebar>
      <v-app-bar app color="deep-purple accent-4" dark>
          <v-app-bar-nav-icon @click="drawer"></v-app-bar-nav-icon>
        
        <v-col>
          <snack-bar></snack-bar>
        </v-col>
      </v-app-bar>

    <v-main class="overflow-y-auto">
      <!--  -->
      <slot></slot>
    </v-main>

  </v-app>
</template>

<script>
  export default {
    data: () => ({
      isDrawerOpen: false,
      person: '',
      isListOpen: true,
      isSearching: false,
      search: '',
      people: [],
      isThisHomePage: true
    }),
    created () {
      this.$root.$on('drawerNavIcon', () => {
        this.isDrawerOpen = !this.isDrawerOpen
      });
    },
    methods: {
      home () {
        location = "/main"
      },
      showForm () {
        location = 'person/create'
      },
      drawer () {
        this.$root.$emit('drawerNavIcon')
      },
      searchPerson () {
        let data = {
          search: this.search
        }
        this.isSearching = true
        axios.post('/people/search', data)
        .then(response => {
          this.isSearching = false
          this.$root.$emit('search', response.data.data) 
        })
        .catch(error => {
          this.isSearching = false
        });
      },
      checkInput () {
        if (this.search.length === 0) {
          this.searchPerson()
        }
      }
    }

  }
</script>

