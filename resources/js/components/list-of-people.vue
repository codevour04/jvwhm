 <template>
  <div>
      <v-container fluid>
        <v-row>
          <v-col v-for="(person, index) in people" :key="index" :xs="12" :sm="2"
            :md="2"
            :lg="2"
            :xl="2"
            :cols="12"
          >
            <v-hover>
              <template v-slot:default="{ hover }">
                <v-card>
                  <v-img height="150"
                    :src="'/uploads/avatars/'+person.avatar"
                    class="white--text align-end"
                    gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                  >
                    <v-card-text class="text--primary">
                      <div class="person-name-card" v-text="person.fullname"></div>
                    </v-card-text>
                    <template v-slot:placeholder>
                      <v-row
                        class="fill-height ma-0"
                        align="center"
                        justify="center"
                      >
                        <v-progress-circular
                          indeterminate
                          color="grey lighten-5"
                        ></v-progress-circular>
                      </v-row>
                    </template>
                  </v-img>
                  <v-card-text class="text--primary grey--text text-truncate">
                    <span class="v-card-text-span-label">Leader:</span><br>
                    <span v-text="person.leadername"></span>
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
          </v-col>
        </v-row>
        <v-row v-intersect="infiniteScrolling">      
        </v-row>
    </v-container>
    <v-dialog
      v-model="isDialogOpen"
      width="400"
      persistent
    >
      <v-card>
        <v-card-title class="error">
          Warning!
        </v-card-title>
        <v-card-text class="text--primary pt-5 px-8">
          <div>Are you sure you want to deactivate this user?</div>
        </v-card-text>
        <v-card-actions>
          <v-btn
            :disabled="isLoading"
            color="primary"
            text
            @click="isDialogOpen = false"
          >
            No
          </v-btn>
          <v-btn
            :loading="isLoading"
            :disabled="isLoading"
            color="error"
            text
            @click="deactivate"
          >
            Yes
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
</div>
</template>

<script>
  export default {
    props: {
      message: String
    },
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
      isListOpen: true,
      alertMessage: 'Delete successful',
      page: 1,
      last_page: 0
    }),
    computed: {
      url () {
        return "person?page="+this.page
      }
    },
    watch: {
    menu (val) {
        val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
      }
    },
    created () {
      this.$root.$on('openForm', () => (this.isListOpen = !this.isListOpen))
      this.$root.$on('clickCancel', () => {
        this.isListOpen = !this.isListOpen
      })
      this.$root.$on('personUpdated', (person) => {
        this.people.filter((item, index) => {
            if(item.id === person.id){
              this.people.splice(index, 1, person);
            } 
          })
      })
      this.$root.$on('search', (people) => {
        this.people = []
        this.people = people
      })
    },
    methods: {
      edit (id) {
        this.$root.$emit('update-record')
        location = `person/${id}/edit`
      },
      dialogDelete (id) {
        this.peopleToDelete.push(id)
        this.isDialogOpen = true
      },
      deactivate () {
        this.isLoading = true
        axios.delete('person/'+this.peopleToDelete)
        .catch(error => (console.log(error)));
        this.isDialogOpen = false
        this.$root.$emit('alert')
        this.isLoading = false
        this.people.filter((item, index) => {
            this.peopleToDelete.filter((id) => {
              if(item.id === id){
                this.people.splice(index, 1)            
              } 
            })
          })
      },
      showInformation (id) {
        window.location = `/person/${id}`;
      },
      infiniteScrolling(entries, observer, isIntersecting) { 
          axios.get(this.url)
            .then(response => {
                this.current_page = response.data.current_page
                this.last_page = response.data.last_page

                response.data.data.forEach(item => this.people.push(item));
                this.$root.$emit('loadPeople', this.people)
                this.page++
            })
            .catch(err => {
              console.log(err);
            });
      }
    }
  }
</script>