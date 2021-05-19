<template>
  <tr
    :class="finishedclass"
    :id="'game_' + game.id"
  >
    <!-- date -->
    <td
      :class="gameclass + '--date'"
      class="text-center moment-date"
      :title="game.date"
    >
      {{ viewDate }}
    </td>
    <!-- team home -->
    <td
      :class="homeclass + ' ' + gameclass + '--hometeam'"
      class="text-right"
    >
      <teamname
        :team="getTeamById(team_h)"
        ha="h"
      ></teamname>
      <!-- pronostic -->
      <label :class="gameclass + '--label'">
        <input
          :id="'game-' + game.id + '-result-home'"
          data-type="home"
          type="text"
          :class="gameclass + '--result'"
          :value="score_h"
          :disabled="disabled"
          @change="setResult('score_h', $event.target.value)"
        />
      </label>
    </td>

    <!-- game -->
    <td
      :class="gameclass + '--spacer'"
      class="text-center"
      :title="getStadiumName(game.stadium_id)"
    >
      <small v-text="'Match ' + game.id"></small>
      <small
        v-if="disabled"
        v-html="statistics"
      />
    </td>
    <td :class="awayclass + ' ' + gameclass + '--awayteam'">
      <label :class="gameclass + '--label'">
        <input
          type="text"
          :id="'game-' + game.id + '-result-away'"
          data-type="away"
          :class="gameclass + '--result'"
          :value="score_a"
          :disabled="disabled"
          @change="setResult('score_a', parseInt($event.target.value))"
        />
      </label>
      <teamname :team="getTeamById(team_a)"></teamname>
    </td>
  </tr>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: {
    game: {
      type: Object,
      required: true,
    },
  },
  computed: {
    disabled() {
      // return  (  moment().add(24, 'hours').isBefore(this.game.getDate()) ) ? false : true;
      return this.$store.state.games.disabled;
    },
    pronostic() {
      let id = this.game.id;
      return this.$store.state.games.pronostics.find(
        (elem) => elem.game_id === id
      );
    },
    team_h() {
      if (this.game.type === 0) return this.game.team_h;
      return this.pronostic && this.pronostic.team_h;
    },
    team_a() {
      if (this.game.type === 0) return this.game.team_a;
      return this.pronostic && this.pronostic.team_a;
    },
    score_h(){
      return  this.pronostic && this.pronostic.score_h; 
    },
    score_a(){
      return  this.pronostic && this.pronostic.score_a; 
    },
    statistics() {
      let id = this.game.id;
      if (id < 49) {
        let statistics = this.$store.state.games.statistics_group[id];
        if (statistics) {
          return (
            "<br>" + statistics.percent_h + "% " + statistics.percent_a + "%"
          );
        }
      }
    },
    gameclass() {
      if (this.game.type == 0) {
        return "table-groups";
      }
      return "table-knockouts";
    },
    finished() {
      return (
        this.pronostic &&
        this.pronostic.score_h !== null &&
        this.pronostic.score_a !== null
      );
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
        if (this.pronostic.score_h === this.pronostic.score_a) {
          return this.gameclass + "--draw";
        }
        if (this.pronostic.score_h > this.pronostic.score_a) {
          return this.gameclass + "--winner";
        }
        if (this.pronostic.score_h < this.pronostic.score_a) {
          return this.gameclass + "--loser";
        }
      }
      return "";
    },
    awayclass() {
      if (this.finished) {
        if (this.pronostic.score_h === this.pronostic.score_a) {
          return this.gameclass + "--draw";
        }
        if (this.pronostic.score_h < this.pronostic.score_a) {
          return this.gameclass + "--winner";
        }
        if (this.pronostic.score_h > this.pronostic.score_a) {
          return this.gameclass + "--loser";
        }
      }
      return "";
    },
    ...mapGetters("games", ["getTeamById", "getStadiumName", "isCompletedGroup", "getGroupById", "getGameByQualification", "getTeamByQualification", "isCompletedGroups", "getThirdTeams"]),
  },
  methods: {
    async setResult(field, value) {
      const gameId = this.game.id;
      await this.$store.dispatch('games/updatePronosticAction', {
        [field]: value,
        game_id: gameId
      });

      if (this.game.type == 0 && this.isCompletedGroup(gameId)) {
        // update teams for the games of type 1 'round of 16'
        const group_id = this.game.group_id;
        const group = this.getGroupById(group_id);
        for (const position of [1, 2]) {
          const qualification = `${position}_${group.name}`; // '2_A', '3_DEF', 'W42'
          // the game to be updated
          let game = this.getGameByQualification(qualification);
          console.log('game', game);
          if (game) {
            // the team qualified for the game 
            const team = this.getTeamByQualification(qualification);
            console.log('team', team);
            const field = game.qualification_h === qualification ? 'team_h' : 'team_a';
            if (team) {
              await this.$store.dispatch('games/updatePronosticAction', {
                [field]: team.id,
                game_id: game.id
              })
            }
          }
        }

        if (this.isCompletedGroups) {

           console.log('getThirdTeams', this.getThirdTeams); 
          // Third-placed teams qualify from groups

        }

      }

    },
  },
};
</script>
