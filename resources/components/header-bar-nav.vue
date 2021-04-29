<template>
  <v-app-bar app light color="indigo darken-2">
    <drawer-button></drawer-button>
    <v-spacer></v-spacer>
    <v-col cols="6" 
    v-if="isThisHomePage">
    <!-- <v-combobox v-if="isListOpen" v-model="person" :items="people" item-text="fullname" :disabled="isSearching" @keyup.enter="searchPerson"
    @keyup="displaySuggestions"
    dense
    solo
    hide-details
    prepend-inner-icon="mdi-magnify" xs="2" id="combo-input">
    </v-combobox> -->
    <v-text-field v-model="search" @keyup.enter="searchPerson" @keyup="checkInput"
    :loading="isSearching"
    :disabled="isSearching"
    color="success"
    dense
    hide-details
    solo
    prepend-inner-icon="mdi-magnify"
    ></v-text-field>
  </v-col>
    <v-spacer></v-spacer>
    <v-btn @click="showForm('Register')" v-if="isListOpen">
      <v-icon>mdi-plus</v-icon>Add
    </v-btn>
  </v-app-bar>
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
    methods: {
      showForm (formTitle) {
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

