<template>
  <div v-if="loaded">
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
  created() {
    this.$store.dispatch("games/fetchGamesDataAction").then(()=> this.loaded=true); 
  },
  data(){
    return {
      loaded: false
    }
  }, 
  computed:{
    groups(){
      return this.$store.state.games.groups; 
    }
  }
};
</script>

<style>
</style>
