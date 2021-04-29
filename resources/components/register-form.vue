  <template>
  <v-main>
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
              <v-form ref="form" lazy-validation>
                <div class="d-flex justify-center align-end pt-4">
                  <v-avatar size="100">
                    <img alt="user" :src="url">
                  </v-avatar>
                  <div>
                    <v-file-input v-model="image" @change="changeAvatar" :rules="uploadRules"
                    type="file"
                    accept="image/.jpg, image/.jpeg, image/.png"
                    prepend-icon="mdi-camera" hide-input>
                    </v-file-input>
                  </div>
                </div>
                <leader-dropdown></leader-dropdown>
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
                <list-of-city></list-of-city>
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
                  <v-btn
                  :loading="isLoading"
                  :disabled="isLoading"
                  color="success"
                  class="mr-4" @click="validate">Submit</v-btn>
                  <v-btn @click="closeForm"
                  :disabled="isLoading"
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
    person: new Person(),
    menu: false,
    date: null,
    cities: [],
    isLoading: false,
    firstnameRules: [v => !!v || 'Firstname is required'],
    lastnameRules: [v => !!v || 'Surname is required'],
    alertMessage: 'Add successfull',
    leader: null,
    image: null,
    url: "/images/profile-card/default.jpg",
    uploadRules: [v => !v || v.size < 2000000 || 'Avatar size should be less than 2 MB!'],
  }),
  watch: {
    menu (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    }
  },
  created () {
    this.cities = Philippines.city_mun.map(city => city.name)
    this.$root.$on('leader-dropdown', (data) => {
        this.leader = data
    })
    this.$root.$on('select-city', (data) => {
        this.person.city = data
    })
    this.$root.$on('change-avatar', (data) => {
      console.log(data)
        this.person.avatar = data
    })
  },
  methods: {
    validate () {
      let valid = this.$refs.form.validate()
      if (valid) this.addPerson()
    },
    addPerson () {
      this.isLoading = true;
      if (this.leader) Object.assign(this.person, {leader : this.person.id})

      var form = new FormData();

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
    reset () {
      this.$refs.form.reset()
    },
    save (date) {
      this.$refs.menu.save(this.person.date)
    },
    closeForm () {
      window.location = '/home'
    },
    changeAvatar (files) {
      console.log(files);
      
        if (!files) return false

        this.person.avatar = files

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

        this.url = URL.createObjectURL(files)
      }
  }
}
</script>