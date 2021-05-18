<template>
  <tr :class="finishedclass" :id="'match_' + match.id">
    <!-- date -->
    <td
      :class="matchclass + '--date'"
      class="text-center moment-date"
      :title="match.date"
    >
      {{ viewDate }}
    </td>
    <!-- team home -->
    <td :class="homeclass + ' ' + matchclass + '--hometeam'" class="text-right">
      <teamname :team="getTeam(match.team_h)" :ha="'h'" />
      <!-- scores -->
      <label :class="matchclass + '--label'">
        <input
          :id="'match-' + match.id + '-result-home'"
          data-type="home"
          type="text"
          :class="matchclass + '--result'"
          :value="match.score_h"
          disabled
        />
      </label>
    </td>

    <!-- match -->
    <td
      :class="matchclass + '--spacer'"
      class="text-center"
      :title="getStadiumName(match.stadium_id)"
    >
      <small>Match {{ match.id }}</small>
    </td>

    <!-- team away -->
    <td :class="awayclass + ' ' + matchclass + '--awayteam'">
      <!-- prognostics -->
      <label :class="matchclass + '--label'">
        <input
          @blur="setResult"
          :id="'match-' + match.id + '-result-away'"
          data-type="away"
          type="text"
          :class="matchclass + '--result'"
          :value="match.score_a"
          disabled
        />
      </label>
      <teamname :team="getTeam(match.team_a)" :ha="'a'" />
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
    match: {
      type: Object,
      default: () => {},
    },
    gametype: {
      type: String,
      required: true,
      default: "groups",
    },
  },
  computed: {
    matchclass() {
      if (this.match.type === 0) {
        return "table-groups";
      }
      return "table-knockouts";
    },
    finished() {
      return this.match.score_h !== null && this.score_a !== null;
    },
    finishedclass() {
      return this.finished ? this.matchclass + "--finished" : "";
    },
    date() {
      return moment(this.match.date);
    },
    viewDate() {
      return this.date.fromNow();
    },
    homeclass() {
      if (this.finished) {
        if (this.match.score_h === this.match.score_a) {
          return this.matchclass + "--draw";
        }
        if (this.match.score_h > this.match.score_a) {
          return this.matchclass + "--winner";
        }
        if (this.match.score_h < this.match.score_a) {
          return this.matchclass + "--loser";
        }
      }
      return "";
    },
    awayclass() {
      if (this.finished) {
        if (this.match.score_h === this.match.score_a) {
          return this.matchclass + "--draw";
        }
        if (this.match.score_h < this.match.score_a) {
          return this.matchclass + "--winner";
        }
        if (this.match.score_h > this.match.score_a) {
          return this.matchclass + "--loser";
        }
      }
      return "";
    },
    ...mapGetters("matches", ["getTeam", "getStadiumName"]),
  },
  methods: {
    setResult(e) {
      let otherobject;
      let awayscore;
      let homescore;
      if (e.target.dataset.type === "home") {
        homescore = e.target.value.trim();
        otherobject = document.getElementById(
          "match-" + this.match.id + "-result-away"
        );
        awayscore = otherobject.value.trim();
      } else {
        awayscore = e.target.value.trim();
        otherobject = document.getElementById(
          "match-" + this.match.id + "-result-home"
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
            matchid: this.match.id,
            groupid: this.id,
            homescore,
            awayscore,
          });
        } else {
          this.SET_KNOCKOUT_MATCH_RESULT({
            matchid: this.match.id,
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
