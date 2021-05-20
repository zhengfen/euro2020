<template>
  <tr :class="finishedclass" :id="'game_' + game.id" v-if="game">
    <!-- date -->
    <td
      :class="gameclass + '--date'"
      class="text-center moment-date"
      :title="game.date"
    >
      {{ viewDate }}
    </td>
    <!-- team home -->
    <td :class="homeclass + ' ' + gameclass + '--hometeam'" class="text-right">
      <teamname :team="getTeamById(game.team_h)" :ha="'h'" />
      <!-- scores -->
      <label :class="gameclass + '--label'">
        <input
          :id="'game-' + game.id + '-result-home'"
          data-type="home"
          type="text"
          :class="gameclass + '--result'"
          :value="game.score_h"
          disabled
        />
      </label>
    </td>

    <!-- game -->
    <td
      :class="gameclass + '--spacer'"
      class="text-center"
      :title="getStadiumName(game.stadium_id)"
    >
      <small>Match {{ game.id }}</small>
    </td>

    <!-- team away -->
    <td :class="awayclass + ' ' + gameclass + '--awayteam'">
      <!-- prognostics -->
      <label :class="gameclass + '--label'">
        <input
          @blur="setResult"
          :id="'game-' + game.id + '-result-away'"
          data-type="away"
          type="text"
          :class="gameclass + '--result'"
          :value="game.score_a"
          disabled
        />
      </label>
      <teamname :team="getTeamById(game.team_a)" :ha="'a'" />
    </td>
  </tr>
</template>

<script>
/**
 * https://github.com/lsv/fifa-worldcup-2018-jsfrontend/blob/bf8616b1a3b58d06869bce0f386918ba9ce43ec6/src/Components/Match.vue
 */
import { mapGetters } from "vuex";

export default {
  props: {
    game: {
      type: Object,
      default: () => {},
    },
  },
  computed: {
    gameclass() {
      if (this.game.type === 0) {
        return "table-groups";
      }
      return "table-knockouts";
    },
    finished() {
      return this.game && this.game.score_h !== null && this.score_a !== null;
    },
    finishedclass() {
      return this.finished ? this.gameclass + "--finished" : "";
    },
    date() {
      return moment(this.game.date);
    },
    viewDate() {
      return this.date.fromNow();
    },
    homeclass() {
      if (this.finished) {
        if (this.game.score_h === this.game.score_a) {
          return this.gameclass + "--draw";
        }
        if (this.game.score_h > this.game.score_a) {
          return this.gameclass + "--winner";
        }
        if (this.game.score_h < this.game.score_a) {
          return this.gameclass + "--loser";
        }
      }
      return "";
    },
    awayclass() {
      if (this.finished) {
        if (this.game.score_h === this.game.score_a) {
          return this.gameclass + "--draw";
        }
        if (this.game.score_h < this.game.score_a) {
          return this.gameclass + "--winner";
        }
        if (this.game.score_h > this.game.score_a) {
          return this.gameclass + "--loser";
        }
      }
      return "";
    },
    ...mapGetters("games", ["getTeamById", "getStadiumName"]),
  },
  methods: {
    setResult(e) {
      let otherobject;
      let awayscore;
      let homescore;
      if (e.target.dataset.type === "home") {
        homescore = e.target.value.trim();
        otherobject = document.getElementById(
          "game-" + this.game.id + "-result-away"
        );
        awayscore = otherobject.value.trim();
      } else {
        awayscore = e.target.value.trim();
        otherobject = document.getElementById(
          "game-" + this.game.id + "-result-home"
        );
        homescore = otherobject.value.trim();
      }

      if ((awayscore && homescore) || (awayscore === "" && homescore === "")) {
        if (awayscore === "" && homescore === "") {
          awayscore = null;
          homescore = null;
        }
        // TODO server post request
        /*
        if (this.gametype === "groups") {
          this.SET_GROUP_MATCH_RESULT({
            gameid: this.game.id,
            groupid: this.id,
            homescore,
            awayscore,
          });
        } else {
          this.SET_KNOCKOUT_MATCH_RESULT({
            gameid: this.game.id,
            knockoutid: this.id,
            homescore,
            awayscore,
          });
        }
        */
      }
    },
  },
};
</script>

<style>
</style>
