<template>
  <div>
    <section class="groups">
      <group-game
        v-for="(group, index) in groups"
        :group="group"
        :key="index"
      />
    </section>
    <section>
      <knockout-games />
    </section>
  </div>
</template>

<script>
// https://github.com/lsv/fifa-worldcup-2018-jsfrontend/blob/bf8616b1a3b58d06869bce0f386918ba9ce43ec6/src/views/Matches.vue
// https://github.com/lsv/fifa-worldcup-2018-jsfrontend/blob/bf8616b1a3b58d06869bce0f386918ba9ce43ec6/src/views/Phase.vue
import { mapGetters } from "vuex";
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
  },
  created() {
    this.$store.commit("games/groupsMutation", this.groups);
    this.$store.commit("games/teamsMutation", this.teams);
    this.$store.commit("games/gamesMutation", this.games);
    this.$store.commit("games/stadiumsMutation", this.stadiums);
  },
  computed: {},
  methods: {},
};
</script>

<style>
</style>
