<template>
  <v-app>
    <!-- <v-container fluid>
      <v-row
        align="center"
        justify="center"
        >
        <v-col
          cols="12"
          sm="12"
          md="12"
          lg="12"
          xl="12"
          > -->
          <v-card class="elevation-12 mx-auto" width="500">
            <v-card-text>
              <v-form ref="form" lazy-validation>
                <div class="d-flex justify-center align-end pt-4">
                  <v-avatar size="200">
                    <img alt="user" :src="imageSource">
                  </v-avatar>
                  <div>
                    <v-file-input v-model="image" @change="changeAvatar" :rules="uploadRules"
                    type="file"
                    accept="image/.jpg, image/.jpeg, image/.png"
                    prepend-icon="mdi-camera" hide-input>
                    </v-file-input>
                  </div>
                </div>
                <!-- <leader-dropdown></leader-dropdown> -->
                <v-combobox
                  v-model="person.leader"
                    :items="people"
                    item-text="fullname"
                    label="Leader"
                    placeholder="John Doe">
                </v-combobox>
                <v-text-field
                v-model="person.firstname"
                :rules="firstnameRules"
                label="First name"
                required
                placeholder="Mark"
                ></v-text-field>
                <v-text-field
                v-model="person.lastname"
                :rules="lastnameRules"
                label="Last name"
                required
                placeholder="Doe"
                ></v-text-field>
                <v-text-field
                v-model="person.middlename"
                label="Middle name"
                placeholder="Smith"
                ></v-text-field>
                <v-text-field
                v-model="person.address"
                label="Address"
                placeholder="M.H. del Pilar st. Brgy. Masigla, Bright Subdivision"
                ></v-text-field>
                <!-- <list-of-city></list-of-city> -->
                <v-autocomplete
                v-model="person.city"
                :items="cities"
                label="City"
                ></v-autocomplete>
                <template>
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
                          v-model="person.birthdate"
                          label="Birthday date"
                          readonly
                          v-bind="attrs"
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        ref="picker"
                        v-model="person.birthdate"
                        :max="new Date().toISOString().substr(0, 10)"
                        min="1950-01-01"
                        @change="save"
                      ></v-date-picker>
                    </v-menu>
                  </template>
                  <v-text-field
                  v-model="person.contact_number"
                  label="Contact number"
                  placeholder="09456644920"
                  ></v-text-field>
                  <v-btn v-if="isCreating"
                  :loading="isLoading"
                  :disabled="isLoading"
                  color="success"
                  class="mr-4" @click="validate">Submit</v-btn>
                  <v-btn v-if="isUpdating"
                  :loading="isLoading"
                  :disabled="isLoading"
                  color="success"
                  class="mr-4" @click="validate">Update</v-btn>
                  <v-btn @click="to('people')"
                  :disabled="isLoading"
                  color="error"
                  class="mr-4">Cancel</v-btn>
              </v-form> 
            </v-card-text>
          </v-card>
        <!-- </v-col>
      </v-row>
    </v-container> -->
</v-app>
</template>

<script>
export default {
  props: ['source', 'user', 'buttonStatus'],
  data: () => ({
    isFormOpen: false,
    people: [],
    person: new Person(),
    menu: false,
    date: null,
    cities: [],
    isLoading: false,
    firstnameRules: [v => !!v || 'Firstname is required'],
    lastnameRules: [v => !!v || 'Surname is required'],
    leader: null,
    image: null,
    uploadRules: [v => !v || v.size < 2000000 || 'Avatar size should be less than 2 MB!'],
    isUpdating: false,
    isCreating: true,
    imageSource: "/uploads/avatars/default.jpg",
    files: null,
  }),
  watch: {
    menu (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    }
  },
  created () {
    if (this.user) {
      this.person = JSON.parse(this.user)
      this.isUpdating = true
      this.isCreating = false
      this.imageSource = '/uploads/avatars/'+this.person.avatar
    }

    this.fetchPeople()
    
    this.cities = Philippines.city_mun.map(city => city.name)
    this.$root.$on('leader-dropdown', (data) => {
        this.leader = data
    })
    this.$root.$on('select-city', (data) => {
        this.person.city = data
    })
    this.$root.$on('change-avatar', (data) => {
      this.person.avatar = data
    })
    this.$root.$on('add-record', () => {
      alert()
    })
    this.$root.$on('update-record', () => (this.isUpdating = true ))
  },
  methods: {
    validate () {
      let valid = this.$refs.form.validate()
      if (valid) {
        if (this.isCreating) {
          this.addPerson()
          return true
        }
        this.updatePerson()
      }  
    },
    fetchPeople () {
      axios.get('/person')
      .then(response => {
      this.people = response.data.data
      })
      .catch(error => (console.log(error)));
    },
    addPerson () {
      this.isLoading = true;
      if (this.person.leader) Object.assign(this.person, {leader : this.person.leader.id})

      let form = new FormData();

      for (let key in this.person) {
        form.append(`${key}`, this.person[key]);
      }

      axios.post('/person', form)
      .then(response => {
        let data = {
          type: "success",
          message: "Add record successful"
        }
        this.$root.$emit('alert', data)
        this.isLoading = false
        this.reset()
      })
      .catch(error => {
        this.isLoading = false
      });
    },
    updatePerson () {
      this.isLoading = true;

      const form = new FormData();

      if (this.person.leader) Object.assign(this.person, {leader : this.person.leader.id})

      for (let key in this.person) {
        form.append(`${key}`, this.person[key]);
      }

      form.append('_method', 'PUT')
      axios.post('/person/'+this.person.id, form)
      .then(response => {
        let data = {
          type: "success",
          message: "Update record successful"
        }
        window.location = "/people"
      })
      .catch(error => {
        this.isLoading = false
      });
    },
    reset () {
      this.$refs.form.reset()
    },
    save (date) {
      this.$refs.menu.save(this.person.date)
    },
    to (route) {
      window.location = `/${route}`
    },
    changeAvatar (files) {
      
        if (!files) return false

        this.person.avatar = files
        this.files = files

        if (files.type !== "image/png" && files.type !== "image/jpeg") {
          let data = {
            type: "error",
            message: "Only jpeg and png images are allowed"
          }
          this.$root.$emit("alert", data)
          return false

        } else if (files.size > 2000000) {
          let data = {
            type: "error",
            message: "File size should be less than 2 MB!"
          }
          this.$root.$emit("alert", data)
          return false

        } 

        this.imageSource = URL.createObjectURL(files)

      }
  }
}
</script>