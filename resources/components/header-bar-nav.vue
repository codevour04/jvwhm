<template>
  <v-app-bar app light color="indigo darken-2">
    <v-app-bar-nav-icon @click.stop="drawer"></v-app-bar-nav-icon>
    <v-spacer></v-spacer>
    <v-col cols="6">
    <!-- <v-combobox v-if="isListOpen" v-model="person" :items="people" item-text="fullname" :disabled="isSearching" @keyup.enter="searchPerson"
    @keyup="displaySuggestions"
    dense
    solo
    hide-details
    prepend-inner-icon="mdi-magnify" xs="2" id="combo-input">
    </v-combobox> -->
    <v-text-field
            filled
            label="Prepend inner"
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
      search: ''
    }),
    created () {
      this.$root.$on('clickCancel', () => {
        this.isListOpen = !this.isListOpen
      })
    },
    methods: {
      showForm (formTitle) {
        this.isListOpen = !this.isListOpen
        let data = {
          button: 'ADD',
          person: new Person()
        }
        this.$root.$emit('openForm', data)
      },
      drawer () {
        this.$root.$emit('drawerNavIcon')
      },
      searchPerson () {
        if (this.person.id) {
          console.log(this.person.id)
        }
        
      },
      displaySuggestions () {
        console.log($("#combo-input").text())

        // axios.get('search', this.person)
      }
    }

  }
</script>

