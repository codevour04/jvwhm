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
            <image-input></image-input>
			<v-card-text>
                <v-form
                ref="form"
                lazy-validation
                >
                <leader-dropdown></leader-dropdown>
                  <v-text-field
                  v-model="leader.firstname"
                  label="Given name"
                  required
                  :rules="firstnameRules"
                  ></v-text-field>
                  <v-text-field
                  v-model="leader.lastname"
                  label="Surname"
                  required
                  :rules="lastnameRules"
                  ></v-text-field>
                  <v-text-field
                  v-model="leader.middlename"
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
                      v-model="computedDateFormatted"
                      label="Birthdate"
                      readonly
                      clearable
                      v-bind="attrs"
                      v-on="on"
                      ></v-text-field>
                    </template>
                    <v-row justify="center">
                      <v-date-picker dense
                      ref="picker"
                      v-model="leader.birthdate"
                      :max="new Date().toISOString().substr(0, 10)"
                      min="1950-01-01"
                      @change=""
                      ></v-date-picker>
                    </v-row>
                  </v-menu>
                <v-text-field
                v-model="leader.address"
                label="Address"
                ></v-text-field>
                <list-of-city></list-of-city>
                <v-text-field
                v-model="leader.contact_number"
                label="Contact number"
                ></v-text-field>
                <v-btn
                :loading="isLoading"
                :disabled="isLoading"
                color="success"
                class="mr-4"
                @click="validate"
                >
                Update
                </v-btn>
                <v-btn @click="closeForm"
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
</v-container>
</v-main>
</template>

<script>	
	import moment from 'moment'

	export default {
		props: ['person'],
		data: () => ({
			menu: false,
			isLoading: false,
			leaderRules: [v => !!v || 'Leader name is required'],
			firstnameRules: [v => !!v || 'Firstname is required'],
			lastnameRules: [v => !!v || 'Surname is required'],
			people: [],
			leader: []
		}),
		watch: {
			menu (val) {
				val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
			}
		},
		created () {
	    	this.leader = JSON.parse(this.person);
	    	this.$root.$on('select-city', (data) => {
		        this.person.city = data
		    })
        this.$root.$on('update-alert', (data) => {
            this.color = data
        })
        this.$root.$on('change-avatar', (data) => {
            console.log(data)
        })
	    },
		computed: {
			computedDateFormatted () {
		    	return this.person.birthdate ? moment(this.person.birthdate).format('ll') : ''
		    }
		},
		methods: {
      test () {
        console.log(this.foo)
      },
			fetchPeople () {
				axios.get('person')
		        .then(response => {
		          this.people = response.data;
		        })
		        .catch(error => (console.log(error)));
			},
		  validate () {
		      let valid = this.$refs.form.validate();
		      if (valid) this.updatePerson()
		  },
		  updatePerson () {
				this.isLoading = true;
				axios.patch("/person/"+this.leader.id, this.leader)
				.then(response => {
          this.$root.$emit('alert')
          this.isLoading = false
        })
				.catch(error => (this.isLoading = false));
			},
		    save (date) {
		    	this.$refs.menu.save(date)
		    },
		    closeForm () {
		      window.location = '/home'
		    }
  		}
	}
</script>
