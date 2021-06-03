<template>
  <div>
    <section class="groups">
      <group-prediction
        v-for="(group, index) in groups"
        :group="group"
        :key="index"
      />
    </section>

    <section>
      <knockout-predictions />
    </section>

  </div>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  props: {
    predictions: {
      type: Array,
      default: () => [],
    },
  },
  created() {
    this.$store.dispatch("games/fetchGamesDataAction").then(() => this.loaded = true);
    this.$store.commit("games/predictionsMutation", this.predictions);
  },
  data() {
    return {
      loaded: false
    }
  },
  computed: {
    groups() {
      return this.$store.state.games.groups;
    },
    ...mapGetters("games", ["getThirdTeamsStandings"])
  }
};
</script>
