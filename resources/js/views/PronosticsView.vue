<template>
  <div>
    <section class="groups">
      <group-pronostic
        v-for="(group, index) in groups"
        :group="group"
        :key="index"
      />
    </section>

    <section>
      <knockout-pronostics />
    </section>

    {{ getThirdTeamsStandings }}
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  props: {
    groups: {
      type: Array,
      default: () => [],
    },
    teams: {
      type: Array,
      default: () => [],
    },
    games: {
      type: Array,
      default: () => [],
    },
    stadiums: {
      type: Array,
      default: () => [],
    },
    pronostics: {
      type: Array,
      default: () => [],
    },
  },
  created() {
    this.$store.commit("games/groupsMutation", this.groups);
    this.$store.commit("games/teamsMutation", this.teams);
    this.$store.commit("games/gamesMutation", this.games);
    this.$store.commit("games/stadiumsMutation", this.stadiums);
    this.$store.commit("games/pronosticsMutation", this.pronostics);
  },
  computed: {
    ...mapGetters("games", ["getThirdTeamsStandings"])
  }
};
</script>
