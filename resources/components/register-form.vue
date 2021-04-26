<template>
  <v-main v-if="isFormOpen">
    <snack-bar v-bind:message="alertMessage"></snack-bar>
    <v-container fluid>
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
            <v-card-text>
              <v-form
              ref="form"
              lazy-validation
              >
                <v-combobox
                v-model="newPerson.leader"
                :items="people"
                item-text="fullname"
                label="Leader"
                placeholder="John Doe">
                </v-combobox>
                <v-text-field
                v-model="newPerson.firstname"
                label="First name"
                required
                :rules="firstnameRules"
                placeholder="Mark"
                ></v-text-field>
                <v-text-field
                v-model="newPerson.lastname"
                label="Last name"
                required
                :rules="lastnameRules"
                placeholder="Doe"
                ></v-text-field>
                <v-text-field
                v-model="newPerson.middlename"
                label="Middle name"
                placeholder="Smith"
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
                    placeholder="December 25, 1995"
                    :max="new Date().toISOString().substr(0, 10)"
                    min="1950-01-01"
                    @change="save"
                    ></v-date-picker>
                  </v-row>
                </v-menu>
                <v-text-field
                v-model="newPerson.address"
                label="Address"
                placeholder="M.H. del Pilar st. Brgy. Masigla, Bright Subdivision"
                ></v-text-field>
                <v-autocomplete
                v-model="newPerson.city"
                :items="cities"
                label="City"
                placeholder="Quezon city"
                ></v-autocomplete>
                <v-text-field
                v-model="newPerson.contact_number"
                label="Contact number"
                placeholder="09456644920"
                ></v-text-field>
                <v-btn
                :loading="isLoading"
                :disabled="isLoading"
                color="success"
                class="mr-4"
                @click="validate">{{ buttonLabel }}</v-btn>
                <v-btn @click="closeForm"
                color="error"
                class="mr-4">Cancel</v-btn>
              </v-form>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
export default {
  props: {
    source: String
  },
  data: () => ({
    isFormOpen: false,
    people: [],
    newPerson: new Person(),
    menu: false,
    cities: [],
    isLoading: false,
    leaderRules: [v => !!v || 'Leader name is required'],
    firstnameRules: [v => !!v || 'Firstname is required'],
    lastnameRules: [v => !!v || 'Surname is required'],
    alertMessage: 'Add successfull',
    buttonLabel: 'ADD'
  }),
  watch: {
    menu (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    }
  },
  created () {
    this.fetchPeople()
    this.cities = Philippines.city_mun.map(city => city.name)
    this.$root.$on('openForm', (data) => {
      this.isFormOpen = !this.isFormOpen
      this.buttonLabel = data.button
      this.newPerson = data.person
    })
    this.$root.$on('loadPeople', (people) => {
      this.people = people
    })
  },
  methods: {
    validate () {
      let valid = this.$refs.form.validate()
      if (valid){
        if (this.buttonLabel === 'UPDATE') {
          this.updatePerson()
        }else{
          this.addPerson()
        }
      }
    },
    addPerson () {
      this.isLoading = true;
      axios.post('person', this.newPerson)
      .then(response => {
        let submitted = Object.assign({}, this.newPerson);
        this.$root.$emit('personAdded', submitted)
        this.isLoading = false
        this.$root.$emit('alert', 'Add successfull')
        this.reset()
      })
      .catch(error => {
        this.isLoading = false
      });
    },
    updatePerson () {
        this.isLoading = true;
        axios.patch('person/'+this.newPerson.id, this.newPerson)
        .then(response => {
          let submitted = Object.assign({}, this.newPerson)
          this.$root.$emit('personUpdated', submitted);
          this.isLoading = false
          this.alertMessage = "Update successfull"
          this.$root.$emit('alert')
        })
        .catch(error => {
          this.isLoading = false
        });
    },
    reset () {
      this.$refs.form.reset()
    },
    save (date) {
      this.$refs.menu.save(date)
    },
    closeForm () {
      this.$root.$emit('clickCancel')
      this.isFormOpen = !this.isFormOpen
    },
    fetchPeople () {
      axios.get('person')
      .then(response => {
        this.people = response.data
      })
      .catch(error => (console.log(error)));
    }
  }
}
</script>