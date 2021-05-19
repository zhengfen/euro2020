<template>
  <div class="knockouts">
    <article
      class="mb-3 card card--knockouts"
      :class="knockoutclass(type)"
      v-for="type in [1, 2, 3, 4]"
      :key="type"
    >
      <div class="card-header" v-html="getTypeName(type)"></div>
      <table class="table table-vsm table-knockouts">
        <tbody>
          <pronostic
            v-for="(game, index) in getGamesByType(type)"
            :key="index"
            :game="game"
          />
        </tbody>
      </table>
    </article>
  </div>
</template>

<script>
/*
 https://github.com/lsv/fifa-worldcup-2018-jsfrontend/blob/bf8616b1a3b58d06869bce0f386918ba9ce43ec6/src/Components/Knockout.vue
*/
import { mapGetters } from "vuex";
export default {
  computed: {
    ...mapGetters("games", ["getTypeName", "getGamesByType"]),
  },
  methods: {
    getTypeClass(type) {
      switch (type) {
        case 1:
          return "round_16";
        case 2:
          return "round_8";
        case 3:
          return "round_4";
        case 4:
          return "round_2";
      }
    },
    knockoutclass(type) {
      return "card--" + this.getTypeClass(type);
    },
  },
};
</script>

<style>
</style>
