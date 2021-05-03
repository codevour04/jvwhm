 <template>
  <v-app>
      <v-row>
        <v-col v-for="(person, index) in people" :key="index" :xs="12" :sm="4"
          :md="3"
          :lg="3"
          :xl="3"
          :cols="12"
        >
          <v-hover>
            <template v-slot:default="{ hover }">
              <v-card>
                <v-img aspect-ratio
                   :src="'../../images/people/default/default-image.jpg'"
                  class="white--text align-end"
                  gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                >
                  <v-card-text class="text--primary">
                    <div class="person-name-card">{{ person.firstname }} {{ person.lastname }}</div>
                  </v-card-text>
                </v-img>
                <v-card-text class="text--primary grey--text">
                  <span class="v-card-text-span-label">Leader:</span>
                  <span v-text='person.leader'></span>
                </br>
                  <span class="v-card-text-span-label">Status:</span>
                  <span>Regular</span>
                </v-card-text>
                <v-fade-transition>
                    <v-overlay
                      v-if="hover"
                      absolute
                      color="#036358"
                    >
                      <v-btn icon @click.stop="edit(person.id)">
                        <v-icon>mdi-account-edit</v-icon>
                      </v-btn>
                      <v-btn icon @click.stop="showInformation(person.id)"><v-icon>mdi-information-variant</v-icon></v-btn>
                      <v-btn icon @click.stop="dialogDelete(person.id)">
                        <v-icon>mdi-trash-can</v-icon>
                      </v-btn>
                    </v-overlay>
                </v-fade-transition>
              </v-card>
            </template>
          </v-hover>
          <v-dialog v-model="isDialogOpen" persistent width="unset">
            <v-card>
              <v-card-title>Are you sure you want to remove this user?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="green darken-1"
                  text
                  @click="isDialogOpen = false"
                >
                  No
                </v-btn>
                <v-btn
                  color="green darken-1"
                  text
                  @click="deactivate()"
                >
                  Yes
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-col>
      </v-row>
  </v-app>
</template>



<script>
  export default {
    props: ['personid'],
    data: () => ({
      selected: [],
      people: [],
      person: [],
      menu: false,
      cities: [],
      leaderRules: [v => !!v || 'Leader name is required'],
      firstnameRules: [v => !!v || 'Firstname is required'],
      lastnameRules: [v => !!v || 'Surname is required'],
      isLoading: false,
      isDialogOpen: false,
      peopleToDelete: [],
      drawer: false
    }),
    watch: {
    menu (val) {
        val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
      }
    },
    mounted () {
      this.fetchPeople();
      this.getPeople();
    },
    methods: {
      getPeople () {
        console.log(this.personid);

        let data = {
          id: Number(this.personid)
        }; 
        console.log(data);
         axios.post('/person/people', data)
        .then(response => {
          console.log(response);
          this.people = response.data;
        })
        .catch(error => (console.log(error)));
      },
      fetchPeople () {
        // axios.get('person')
        // .then(response => {
        //   this.people = response.data;
        // })
        // .catch(error => (console.log(error)));
      },
      edit (id) {
        this.$root.$emit('openUpdateForm');
        this.people.filter((item) => {
          if(item.id === id) this.person = item
        })
        this.$nextTick(() => {
          this.$root.$emit('updatePerson', this.person);
        })
        
      },
      dialogDelete (id) {
        this.peopleToDelete.push(id);
        this.isDialogOpen = true;
      },
      deactivate () {
        axios.delete('person/'+this.peopleToDelete)
        .then(response => {  
          this.people.filter((item, index) => {
            this.peopleToDelete.filter((id) => {
              if(item.id === id){
                this.people.splice(index, 1);
                this.isDialogOpen = false;
              } 
            })
          })
        });
      }
    }
  }
</script>