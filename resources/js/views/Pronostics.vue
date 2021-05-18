<template>
  <div>
    <section class="groups">
      <group-pronostic
        v-for="(group, index) in groups"
        :group="group"
        :key="index"
      />
    </section>
  </div>
</template>

<script>
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
    matches: {
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
    this.$store.commit("matches/groupsMutation", this.groups);
    this.$store.commit("matches/teamsMutation", this.teams);
    this.$store.commit("matches/matchesMutation", this.matches);
    this.$store.commit("matches/stadiumsMutation", this.stadiums);
    this.$store.commit("matches/pronosticsMutation", this.pronostics);
  },
};
</script>
