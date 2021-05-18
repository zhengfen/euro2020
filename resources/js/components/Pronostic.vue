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
      <teamname :team="getTeam(match.team_h)" ha="h"></teamname>
      <!-- pronostic -->
      <label :class="matchclass + '--label'">
        <input
          :id="'match-' + match.id + '-result-home'"
          data-type="home"
          type="text"
          :class="matchclass + '--result'"
          :value="scores.score_h"
          :disabled="disabled"
          @change="setResult('score_h', $event.target.value)"
        />
      </label>
    </td>

    <!-- match -->
    <td
      :class="matchclass + '--spacer'"
      class="text-center"
      :title="getStadiumName(match.stadium_id)"
    >
      <small v-text="'Match ' + match.id"></small>
      <small v-if="disabled" v-html="statistics" />
    </td>
    <td :class="awayclass + ' ' + matchclass + '--awayteam'">
      <label :class="matchclass + '--label'">
        <input
          type="text"
          :id="'match-' + match.id + '-result-away'"
          data-type="away"
          :class="matchclass + '--result'"
          :value="scores.score_a"
          :disabled="disabled"
          @change="setResult('score_a', $event.target.value)"
        />
      </label>
      <teamname :team="getTeam(match.team_a)"></teamname>
    </td>
  </tr>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: {
    match: {
      type: Object,
      required: true,
    },
    gametype: {
      type: String,
      required: true,
      default: "groups",
    },
  },
  computed: {
    disabled() {
      // return  (  moment().add(24, 'hours').isBefore(this.match.getDate()) ) ? false : true;
      return this.$store.state.matches.disabled;
    },
    pronostic() {
      let id = this.match.id;
      return this.$store.state.matches.pronostics.find(
        (elem) => elem.match_id === id
      );
    },
    scores() {
      if (this.pronostic) {
        return {
          score_h: this.pronostic.score_h,
          score_a: this.pronostic.score_a,
        };
      } else return { score_h: null, score_a: null };
    },
    statistics() {
      let id = this.match.id;
      if (id < 49) {
        let statistics = this.$store.state.matches.statistics_group[id];
        if (statistics) {
          return (
            "<br>" + statistics.percent_h + "% " + statistics.percent_a + "%"
          );
        }
      }
    },
    matchclass() {
      if (this.gametype !== "groups") {
        return "table-knockouts";
      }
      return "table-" + this.gametype;
    },
    finished() {
      return (
        this.pronostic &&
        this.pronostic.score_h !== null &&
        this.pronostic.score_a !== null
      );
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
        if (this.pronostic.score_h === this.pronostic.score_a) {
          return this.matchclass + "--draw";
        }
        if (this.pronostic.score_h > this.pronostic.score_a) {
          return this.matchclass + "--winner";
        }
        if (this.pronostic.score_h < this.pronostic.score_a) {
          return this.matchclass + "--loser";
        }
      }
      return "";
    },
    awayclass() {
      if (this.finished) {
        if (this.pronostic.score_h === this.pronostic.score_a) {
          return this.matchclass + "--draw";
        }
        if (this.pronostic.score_h < this.pronostic.score_a) {
          return this.matchclass + "--winner";
        }
        if (this.pronostic.score_h > this.pronostic.score_a) {
          return this.matchclass + "--loser";
        }
      }
      return "";
    },
    ...mapGetters("matches", ["getTeam", "getStadiumName"]),
  },
  methods: {
    setResult(field, value) {
      console.log(field, value);
      // update input scores in database table pronostic
      axios.post("/pronostics/update_scores", {
        [field]: value,
        match_id: this.match.id,
      });
    },
  },
};
</script>
