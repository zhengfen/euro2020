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

    <!-- game info -->
    <td
      :class="gameclass + '--spacer'"
      class="text-center"
      :title="getStadiumName(game.stadium_id)"
    >
      <small :title="game.qualification_h + '_' + game.qualification_a">Match {{ game.id }}</small>
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
import { thirdMatchArray } from "../util";
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
    score_h() {
      return this.pronostic && this.pronostic.score_h;
    },
    score_a() {
      return this.pronostic && this.pronostic.score_a;
    },
    winner_team() {
      if (!this.finished) return;
      return this.score_h > this.score_a ? this.team_h : this.team_a;
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
    setResult(field, value) {
      // update score 
      this.update_pronotic(this.game.id, field, value);
      if (!this.finished) return;

      const gameId = this.game.id;
      const gameType = this.game.type;

      if (gameType == 0) {
        const groupId = this.game.group_id;
        if (this.isCompletedGroup(groupId)) {
          // update teams for the games of type 1 'round of 16'
          const group = this.getGroupById(groupId);
          for (const position of [1, 2]) {
            const qualification = `${position}_${group.name}`; // '2_A'
            // the game to be updated
            let gameNext = this.getGameByQualification(qualification);
            if (gameNext) {
              // the team qualified for the game 
              const field = gameNext.qualification_h === qualification ? 'team_h' : 'team_a';
              const team = this.getTeamByQualification(qualification);
              if (team) {
                this.update_pronotic(gameNext.id, field, team.id);
                this.update_knockout_teams(gameNext);
              }
            }
          }
        }
        if (this.isCompletedGroups) {
          const third_teams = this.getThirdTeams;
          const third_groups = third_teams.map(elem => elem.group_id).sort().join('');
          const matchingThirdGroups = thirdMatchArray[third_groups]; // [1, 5, 2, 3]
          const matchingWinnerGroups = ['B', 'C', 'E', 'F'];
          for (let i = 0; i < 4; i++) {
            const qualification = `1_${matchingWinnerGroups[i]}`;
            let gameNext = this.getGameByQualification(qualification);
            if (gameNext) {
              const field = gameNext.qualification_h === qualification ? 'team_a' : 'team_h';  // opposite team
              const team = third_teams.find(elem => elem.group_id === matchingThirdGroups[i]);
              if (team) {
                this.update_pronotic(gameNext.id, field, team.id);
                this.update_knockout_teams(gameNext);
              }
            }
          }
        }
      }

      if (gameType > 0 && gameType <= 4) {
        const qualification = `W${gameId}`;   // 'W41'        
        let gameNext = this.getGameByQualification(qualification);
        if (gameNext) {
          const field = gameNext.qualification_h === qualification ? 'team_h' : 'team_a';
          const team_id = this.winner_team;
          if (team_id) {
            this.update_pronotic(gameNext.id, field, team_id);
            this.update_knockout_teams(gameNext);
          }
        }
      }
    },
    /**
    * commit mutation directly, to avoid delay of serveur response.
    */
    update_pronotic(game_id, field, value) {
      let data = {
        [field]: value,
        game_id: game_id
      };
      this.$store.commit('games/pronosticMutation', data);
      this.$store.dispatch('games/updatePronosticAction', data);
    },

    /**
     * update knockout games from the game on
     * input game is the knockout game that has team changed
     */

    update_knockout_teams(game) {
      let gameCurrent = game;
      while (gameCurrent && gameCurrent.type < 4) {        
        const qualification = `W${gameCurrent.id}`;
        // get next game should be updated
        const gameNext = this.getGameByQualification(qualification);
        // get pronostic for the current game
        const pronostic = this.$store.state.games.pronostics.find(
          (elem) => elem.game_id === gameCurrent.id
        );
        // if current game is finished
        if (pronostic && pronostic.score_h !== null && pronostic.score_a !== null) {
          const field = gameNext.qualification_h === qualification ? 'team_h' : 'team_a';
          const team_id = pronostic.score_h > pronostic.score_a ? pronostic.team_h : pronostic.team_a;
          if (team_id) this.update_pronotic(gameNext.id, field, team_id);
        }
        gameCurrent = gameNext;
      }
    }
  },
};
</script>
