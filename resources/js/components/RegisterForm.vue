<!-- <template>
      <v-app>
        <v-row
        align="center"
        justify="center"
        >
          <v-col
          cols="12"
          sm="8"
          md="8"
          lg="6"
          xl="6"
          >
            <v-card class="elevation-12">

              <v-toolbar
              color="primary"
              dark
              flat
              >
              </v-toolbar>
              <v-card-title title="Register"></v-card-title>
              <v-card-text>
                <v-form
                ref="form"
                lazy-validation
                >
                  <v-text-field
                  v-model="newPerson.leader"
                  label="Leader"
                  required
                  :rules="leaderRules"
                  ></v-text-field>
                  <v-text-field
                  v-model="newPerson.firstname"
                  label="Firstname"
                  required
                  :rules="firstnameRules"
                  ></v-text-field>
                  <v-text-field
                  v-model="newPerson.lastname"
                  label="Surname"
                  required
                  :rules="lastnameRules"
                  ></v-text-field>
                  <v-text-field
                  v-model="newPerson.middlename"
                  label="Middlename"
                  ></v-text-field>
                  <v-menu
                  ref="menu"
                  v-model="menu"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                      v-model="newPerson.birthdate"
                      label="Birthday date"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      ></v-text-field>
                    </template>
                    <v-row justify="center">
                      <v-date-picker dense
                      ref="picker"
                      v-model="newPerson.birthdate"
                      :max="new Date().toISOString().substr(0, 10)"
                      min="1950-01-01"
                      @change="save"
                      ></v-date-picker>
                    </v-row>
                  </v-menu>
                <v-text-field
                v-model="newPerson.address"
                label="Address"
                ></v-text-field>
                <v-autocomplete
                v-model="newPerson.city"
                :items="cities"
                label="City"
                ></v-autocomplete>
                <v-text-field
                v-model="newPerson.contact_number"
                label="Contact number"
                ></v-text-field>
                <v-btn
                :loading="isLoading"
                :disabled="isLoading"
                color="success"
                class="mr-4"
                @click="validate"
                >
                Add
                </v-btn>
                <v-btn
                color="error"
                class="mr-4"
                >
                Cancel
                </v-btn>
              </v-form>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-app>
</template> -->

<template>
  <v-app>
    <card title="Register"></card>
  </v-app>
</template>

<script>
export default {
  props: {
    source: String
  },
  data: () => ({ 
    drawer: null,
    newPerson: new Person(),
    menu: false,
    cities: [],
    isLoading: false,
    leaderRules: [v => !!v || 'Leader name is required'],
    firstnameRules: [v => !!v || 'Firstname is required'],
    lastnameRules: [v => !!v || 'Surname is required']
  }),
  watch: {
    menu (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    }
  },
  created () {
    this.cities = Philippines.city_mun.map(city => city.name);
  },
  methods: {
    validate () {
      let valid = this.$refs.form.validate();
      if (valid) this.addPerson()
    },
    addPerson () {
      var self = this;
      this.isLoading = true;
      axios.post('person', this.newPerson)
      .then(response => {
        this.isLoading = false
        this.$refs.form.reset();
      })
      .catch(error => {
        this.isLoading = false
      });
    },
    save (date) {
      this.$refs.menu.save(date)
    }
  }
}
</script>