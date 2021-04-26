<template>
	<v-app>
	    <v-row align="center" justify="center" v-if="isFormOpen">
			<v-col cols="12" sm="8" md="8" lg="6" xl="6">
	            <v-card class="elevation-12">
	              <v-toolbar color="primary" dark flat>
	              	<v-toolbar-title>{{ title }}</v-toolbar-title>
	              </v-toolbar>
	              <v-card-text>
	              	
                <v-form
                ref="form"
                lazy-validation
                >
                <v-autocomplete 
                  v-model="newPerson.leader"
                  :items="people"
                  label="Leader"
                  item-text='firstname'
                  item-value="id"
                  ></v-autocomplete>
                  <v-text-field
                  v-model="newPerson.firstname"
                  label="Given name"
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
                      v-model="computedDateFormatted"
                      label="Birthdate"
                      readonly
                      clearable
                      v-bind="attrs"
                      v-on="on"
                      @click:clear="newPerson.birthdate = null"
                      ></v-text-field>
                    </template>
                    <v-row justify="center">
                      <v-date-picker dense
                      ref="picker"
                      v-model="newPerson.birthdate"
                      :max="new Date().toISOString().substr(0, 10)"
                      min="1950-01-01"
                      @change="menu = false"
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
                Submit
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
	</v-app>
</template>

<script>

	import moment from 'moment'

	export default {
		props: {
			title: String
		},
		data: () => ({
			newPerson: new Person(),
			menu: false,
			cities: [],
			isLoading: false,
			leaderRules: [v => !!v || 'Leader name is required'],
			firstnameRules: [v => !!v || 'Firstname is required'],
			lastnameRules: [v => !!v || 'Surname is required'],
			isFormOpen: true,
			eventName: 'register',
			people: []
		}),
		watch: {
			menu (val) {
				val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
			}
		},
		computed: {
			computedDateFormatted () {
		    	return this.newPerson.birthdate ? moment(this.newPerson.birthdate).format('ll') : ''
		    }
		},
		created () {
			this.$root.$on('updatePerson', (person) => {
      			this.newPerson = person;
      			this.eventName = 'update';
    		});
			
			this.cities = Philippines.city_mun.map(city => city.name);

			this.fetchPeople();
		},
		methods: {
			fetchPeople() {
				axios.get('person')
		        .then(response => {
		          this.people = response.data;
		        })
		        .catch(error => (console.log(error)));
			},
		    validate () {
		      let valid = this.$refs.form.validate();
		      if (valid) {
		      	if (this.eventName == 'update') {
		      		this.updatePerson()
		      	} else {
		      		this.addPerson()
		      	}
		      } 
		    },
	    	addPerson () {
		      var self = this;
		      this.isLoading = true;
		      axios.post('person', this.newPerson)
		      .then(response => {
		        this.isLoading = false
		        this.$refs.form.reset();
		        this.people.shift(response.data);
		      })
		      .catch(error => {
		        this.isLoading = false
		      });
		    },
		    updatePerson () {
				this.isLoading = true;
				axios.patch('person/'+this.newPerson.id, this.newPerson)
				.then(response => {
					this.$root.$emit('closeForm');
					this.people.filter((item, index) => {
						if(item.id === this.newPerson.id){
							this.people.splice(index, 1, this.newPerson);
							this.isLoading = false;
						} 
					})
				})
				.catch(error => {
					this.isLoading = false;
					console.log(error);
				});
			},
		    save (date) {
		    	this.$refs.menu.save(date)
		    },
		    closeForm () {
		    	this.$root.$emit('closeForm')
		    }
  		}
	}
</script>
