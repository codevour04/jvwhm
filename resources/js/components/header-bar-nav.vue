<template>
  <v-app id="inspire">
    <left-sidebar></left-sidebar>
      <v-app-bar app color="deep-purple accent-4" dark>
        
          <v-app-bar-nav-icon @click="drawer"></v-app-bar-nav-icon>
        <v-spacer></v-spacer>
        <v-col cols="8" 
          v-if="isThisHomePage">
          <v-text-field v-model="search" @keyup.enter="searchPerson" @keyup="checkInput"
          :loading="isSearching"
          :disabled="isSearching"
          dense
          hide-details
          solo
          light
          prepend-inner-icon="mdi-magnify"
          ></v-text-field>
        </v-col>
        <v-spacer></v-spacer>
          <v-btn @click="to('person/create')" v-if="isListOpen" color="success">
            <v-icon>mdi-plus</v-icon>Add
          </v-btn>
        <v-col>
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
        window.location = "/main";
      },
      to (route) {
        location = `${route}`
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
          console.log(error)
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

