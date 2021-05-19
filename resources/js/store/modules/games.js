
const module = {
  namespaced: true,
  state: {
    groups: [],
    teams: [],
    games: [],
    stadiums: [],
    pronostics: [],
    disabled: false,
    statistics_group: []
  },
  mutations: {
    groupsMutation(state, payload) {
      state.groups = payload;
    },
    teamsMutation(state, payload) {
      state.teams = payload;
    },
    gamesMutation(state, payload) {
      console.log('gamesMutation', payload);
      state.games = payload;
    },
    stadiumsMutation(state, payload) {
      state.stadiums = payload;
    },
    pronosticsMutation(state, payload) {
      state.pronostics = payload;
    },
    // mutate for a single game
    pronosticMutation(state, payload) {
      const game = state.games.find(elem => elem.id === payload.game_id);
      // modify or add pronostic
      let pronostic = state.pronostics.find(elem => elem.game_id === payload.game_id);
      if (pronostic) {
        if ('score_h' in payload) pronostic.score_h = payload.score_h;
        if ('score_a' in payload) pronostic.score_a = payload.score_a;
        if ('team_h' in payload) pronostic.team_h = payload.team_h;
        if ('team_a' in payload) pronostic.team_a = payload.team_a;
      }
      else {
        state.pronostics.push(payload);
      }      
    }
  },
  actions: {
    async updatePronosticAction({ state, commit }, payload) {
      // commit('pronosticMutation', payload);
      return new Promise((resolve, reject) => {
        // update input scores in database table pronostic
        axios.post("/pronostics/update", payload)
          .then(({ data }) => {
            console.log(data); 
            if (data.pronostic) commit('pronosticMutation', data.pronostic);
            resolve(data); 
          })
          .catch(error => reject(error));
      })
    }
  },
  getters: {
    getTeamById: (state) => (id) => {
      return state.teams.find(elem => elem.id === id);
    },
    getGroupById: (state) => (id) => {
      return state.groups.find(elem => elem.id === id);
    },
    getStadiumName: (state) => (id) => {
      const item = state.stadiums.find(elem => elem.id === id);
      if (item) return item.name;
    },
    getGamesByGroup: (state) => (group_id) => {
      const teams_id = state.teams
        .filter((elem) => elem.group_id == group_id)
        .map((elem) => elem.id);
      return state.games.filter((elem) => elem.type === 0 && teams_id.includes(elem.team_h));
    },
    getInitialStandingsByGroup: (state) => (group_id) => {
      let standings = [];
      const teams = state.teams.filter((elem) => elem.group_id == group_id);
      teams.forEach((team) => {
        standings.push({
          team: team,
          played: 0,
          wins: 0,
          draws: 0,
          losses: 0,
          goalsFor: 0,
          goalsAgainst: 0,
        });
      });
      return standings;
    },
    // https://github.com/lsv/fifa-worldcup-2018-jsfrontend/blob/master/src/Parser/group.ts
    // private static parseStandingMatc
    getStandingsByGroup: (state, getters) => (group_id) => {
      let standings = getters.getInitialStandingsByGroup(group_id);
      // update standing
      const games = getters.getGamesByGroup(group_id);
      for (const game of games) {
        if (game.score_h != null && game.score_a != null) {
          let standing_h = standings.find(elem => elem.team.id === game.team_h);
          let standing_a = standings.find(elem => elem.team.id === game.team_a);

          standing_h.played++;
          standing_a.played++;

          standing_h.goalsFor += Number(game.score_h);
          standing_a.goalsFor += Number(game.score_a);

          standing_h.goalsAgainst += Number(game.score_a);
          standing_a.goalsAgainst += Number(game.score_h);

          if (game.score_h > game.score_a) {
            standing_h.wins++;
            standing_a.losses++;
          }
          if (game.score_h < game.score_a) {
            standing_a.wins++;
            standing_h.losses++;
          }
          if (game.score_h == game.score_a) {
            standing_a.draws++;
            standing_h.draws++;
          }

        }
      }
      return standings.sort(sortStanding);
    },

    /**
     * 
     * @param {*} state 
     * @param {*} getters 
     * @returns [{ team, played, goalsFor, goalsAgainst, wins, losses, draws }]
     */
    getPronosticStandingsByGroup: (state, getters) => (group_id) => {
      let standings = getters.getInitialStandingsByGroup(group_id);
      const games = getters.getGamesByGroup(group_id);
      for (const game of games) {
        const pronostic = state.pronostics.find(elem => elem.game_id === game.id);
        if (pronostic) {
          if (pronostic.score_h != null && pronostic.score_a != null) {
            let standing_h = standings.find(elem => elem.team.id === game.team_h);
            let standing_a = standings.find(elem => elem.team.id === game.team_a);

            standing_h.played++;
            standing_a.played++;

            standing_h.goalsFor += Number(pronostic.score_h);
            standing_a.goalsFor += Number(pronostic.score_a);

            standing_h.goalsAgainst += Number(pronostic.score_a);
            standing_a.goalsAgainst += Number(pronostic.score_h);

            if (pronostic.score_h > pronostic.score_a) {
              standing_h.wins++;
              standing_a.losses++;
            }
            if (pronostic.score_h < pronostic.score_a) {
              standing_a.wins++;
              standing_h.losses++;
            }
            if (pronostic.score_h == pronostic.score_a) {
              standing_a.draws++;
              standing_h.draws++;
            }
          }
        }
      }

      return standings.sort(sortStanding);
      // Todo update standings
    },

    // if the pronostics for the group is completed
    isCompletedGroup: (state, getters) => (group_id) => {
      const games = getters.getGamesByGroup(group_id);
      for (const game of games) {
        const pronostic = state.pronostics.find(elem => elem.game_id === game.id);
        if (! pronostic) return false; 
        if (pronostic.score_h == null || pronostic.score_a == null) return false;
      }
      return true; 
    },

    /*
    Types: [1, 2, 3, 4]
    Round of 16,  type ==1
    Quarter finals, 2
    Semi-finals, 3
    Third place play-off  (there is no third play anymore)
    Final 4
    */
    getTypeName: (state) => (type) => {
      switch (type) {
        case 1: return 'Round of 16';
        case 2: return 'Quarter finals';
        case 3: return 'Semi-finals';
        case 4: return 'Final';
      }
    },

    getGamesByType: (state) => (type) => {
      return state.games.filter(elem => elem.type === type);
    }, 
    // get related game of the next stage
    getGameByQualification: (state) => (qualification) => {
      return state.games.find(elem => elem.qualification_h === qualification || elem.qualification_a === qualification);   
    }, 
    // '2_A', '3_DEF', 'W42'
    getTeamByQualification: (state, getters) => (qualification) => {
      const quals = qualification.split('_'); 
      // from group games
      if (quals.length == 2){
        const position = quals[0]; 
        if (position <=2){
          const group_name = quals[1]; 
          const group_id = getters.getGroupIdByName(group_name); 
          const standings = getters.getPronosticStandingsByGroup(group_id); 
          return standings[position-1].team; 
        }
      }
    }, 

    getGroupIdByName: (state) => (name) => {
      const item = state.groups.find(elem => elem.name === name); 
      if (item) return item.id; 
    }, 

    isCompletedGroups: (state) => {
      const games = state.games.filter( elem => elem.type ===0 ); 
      for (const game of games) {
        const pronostic = state.pronostics.find(elem => elem.game_id === game.id);
        if (! pronostic) return false; 
        if (pronostic.score_h == null || pronostic.score_a == null) return false;
      }
      return true; 
    }, 
    // get Third-placed teams qualify from groups, according to pronostic
    getThirdTeamsStandings: (state, getters) => {
      let standings = []; 
      for (let i = 1; i <= 6; i++){
        standings.push(getters.getPronosticStandingsByGroup(i)[2]);
      }
      return standings.sort(sortStanding);
    },
    getThirdTeams: (state, getters) => {
      return getters.getThirdTeamsStandings.map(elem => elem.team).filter( (el, index) => index < 4); 
    }

  }
}

// https://github.com/lsv/fifa-worldcup-2018-jsfrontend/blob/bf8616b1a3b58d06869bce0f386918ba9ce43ec6/src/Parser/group.ts#L67
function sortStanding(a, b) {
  if (a.wins * 3 + a.draws !== b.wins * 3 + b.draws) {
    return (a.wins * 3 + a.draws) < (b.wins * 3 + b.draws) ? 1 : -1;
  }

  if (a.goalsFor - a.goalsAgainst !== b.goalsFor - b.goalsAgainst) {
    return (a.goalsFor - a.goalsAgainst) < (b.goalsFor - b.goalsAgainst) ? 1 : -1;
  }

  if (a.goalsFor !== b.goalsFor) {
    return a.goalsFor < b.goalsFor ? -1 : 1;
  }
  /*
  let game = games.find((m: MatchModel) => {
      const ateam = a.getTeam();
      const bteam = b.getTeam();
      const hometeam = m.getHomeTeam();
      const awayteam = m.getAwayTeam();
      if (typeof hometeam !== 'string' && typeof awayteam !== 'string' && typeof ateam !== 'string' && typeof bteam !== 'string') {
          return hometeam.getId() === ateam.getId() && awayteam.getId() === bteam.getId();
      }
  });
  if (game) {
      if (game.getHomeResult() > game.getAwayResult()) {
          return -1;
      }

      if (game.getAwayResult() > game.getHomeResult()) {
          return 1;
      }
  }
  game = games.find((m: MatchModel) => {
      const ateam = a.getTeam();
      const bteam = b.getTeam();
      const hometeam = m.getHomeTeam();
      const awayteam = m.getAwayTeam();
      if (typeof hometeam !== 'string' && typeof awayteam !== 'string' && typeof ateam !== 'string' && typeof bteam !== 'string') {
          return hometeam.getId() === bteam.getId() && awayteam.getId() === ateam.getId();
      }
  });
  if (game) {
      if (game.getHomeResult() > game.getAwayResult()) {
          return 1;
      }

      if (game.getAwayResult() > game.getHomeResult()) {
          return -1;
      }
  }

  const aTeam = a.getTeam();
  const bTeam = b.getTeam();

  if (typeof aTeam !== 'string' && typeof bTeam !== 'string') {
      return aTeam.getWeight() < bTeam.getWeight() ? 1 : -1;
  }
  */
  return 0;
}

export default module;
