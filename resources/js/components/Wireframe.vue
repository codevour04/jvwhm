<template>
  <v-app id="inspire">
    <v-navigation-drawer
    app
    v-model="drawer"
    temporary
    mobile-breakpoint="md"
    >
      <v-list dense>
        <v-list-item link>
          <v-list-item-action>
            <v-icon>mdi-account-group</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>People</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app color="deep-purple">
      <v-app-bar-nav-icon @click.stop="drawer = !drawer">
      </v-app-bar-nav-icon>
      <v-spacer></v-spacer>
      <v-btn @click="showForm('Register')" v-if="!isFormOpen">
        <v-icon>mdi-plus</v-icon>Add
      </v-btn>
    </v-app-bar>

    <v-main>
      <v-container fluid>
        <!-- <register-form v-if="isFormOpen"></register-form> -->
        <input-form :title="formTitle" v-if="isFormOpen"></input-form>
        <list-of-people v-else></list-of-people>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>

  export default {
  props: {
    source: String
  },
  data: () => ({ 
    drawer: null,
    isFormOpen: false,
    formTitle: ''
  }),
  mounted () {
    this.$root.$on('openUpdateForm', () => {
      this.showForm('Update information');
    });

    this.$root.$on('closeForm', () => {
      this.isFormOpen = false;
    });
  },
  methods : {   
    showForm (title) {
      this.isFormOpen = true;
      this.formTitle = title;

    }
  }
}
</script>
