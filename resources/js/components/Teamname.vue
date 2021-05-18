<template>
  <span
    @mouseout="unhover"
    @mouseover="hover"
    :data-id="'team-' + team.id"
    class="team--name"
    v-if="team"
  >
    <i v-if="ha != 'h'" class="flag-icon" :class="'flag-icon-' + team.iso"></i>
    {{ team.name }}
    <i v-if="ha == 'h'" class="flag-icon" :class="'flag-icon-' + team.iso"></i>
  </span>
</template>

<script>
export default {
  props: {
    team: Object,
    ha: String, // home or away
  },
  methods: {
    hover(e) {
      const elements = document.querySelectorAll(
        '[data-id="' + e.target.dataset.id + '"]'
      );
      elements.forEach((element) => {
        element.classList.add("team--name--hover");
      });
    },
    unhover(e) {
      const elements = document.querySelectorAll(
        '[data-id="' + e.target.dataset.id + '"]'
      );
      elements.forEach((element) => {
        element.classList.remove("team--name--hover");
      });
    },
  },
};
</script>

<style>
</style>
