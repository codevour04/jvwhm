<template>
    <v-main>
      <v-container fluid>
        <v-row>
          <v-col>
            <v-card>
              <v-img
              height="250"
              src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
              ></v-img>
              <v-card-title>{{ leader }}</v-card-title>
            </v-card>
          </v-col>        
        </v-row>
        <v-row>
          <v-col v-for="(person, index) in disciples" :key="index" :xs="12" :sm="4"
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
                      <div class="person-name-card">{{ person.fullname }}</div>
                    </v-card-text>
                  </v-img>
                  <v-card-text class="text--primary grey--text">
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
          </v-col>
        </v-row>
    </v-container>
  </v-main>
</template>

<script>
  export default {
    props: ['leader', 'people'],
    data: () => ({
      disciples: []
    }),
    created () {
      this.disciples = JSON.parse(this.people);
      this.$root.$emit('profilePage');
    },
    methods : {
      showInformation (id) {
        window.location = `/person/${id}`
      },
      edit (id) {
        window.location = `${id}/edit`
      },
    }
  }
</script>