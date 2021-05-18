
const module = {
    namespaced: true,
    state: {
        groups: [],
        teams: [],
        matches: [],
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
        matchesMutation(state, payload) {
            console.log('matchesMutation', payload);
            state.matches = payload;
        },
        stadiumsMutation(state, payload) {
            state.stadiums = payload;
        },
        pronosticsMutation(state, payload) {
            state.pronostics = payload;
        }
    },
    actions: {
    },
    getters: {
        getTeam: (state) => (id) => {
            return state.teams.find(elem => elem.id === id);
        },
        getStadiumName: (state) => (id) => {
            const item = state.stadiums.find(elem => elem.id === id);
            if (item) return item.name;
        },
        getMatchesByGroup: (state) => (group_id) => {
            const teams_id = state.teams
                .filter((elem) => elem.group_id == group_id)
                .map((elem) => elem.id);
            return state.matches.filter((elem) => elem.type === 0 && teams_id.includes(elem.team_h));
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
            const matches = getters.getMatchesByGroup(group_id);
            for (const match of matches) {
                if (match.score_h != null && match.score_a != null) {
                    let standing_h = standings.find(elem => elem.team.id === match.team_h);
                    let standing_a = standings.find(elem => elem.team.id === match.team_a);

                    standing_h.played++;
                    standing_a.played++;

                    standing_h.goalsFor += match.score_h;
                    standing_a.goalsFor += match.score_a;

                    standing_h.goalsAgainst += match.score_a;
                    standing_a.goalsAgainst += match.score_h;

                    if (match.score_h > match.score_a) {
                        standing_h.wins++;
                        standing_a.losses++;
                    }
                    if (match.score_h < match.score_a) {
                        standing_a.wins++;
                        standing_h.losses++;
                    }
                    if (match.score_h == match.score_a) {
                        standing_a.draws++;
                        standing_h.draws++;
                    }

                }
            }
            return standings.sort(sortStanding);
        },

        getPronosticStandingsByGroup: (state, getters) => (group_id) => {
            let standings = getters.getInitialStandingsByGroup(group_id);
            return standings;
            // Todo update standings
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

        getMatchesByType: (state) => (type) => {
            return state.matches.filter(elem => elem.type === type);
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
    let match = matches.find((m: MatchModel) => {
        const ateam = a.getTeam();
        const bteam = b.getTeam();
        const hometeam = m.getHomeTeam();
        const awayteam = m.getAwayTeam();
        if (typeof hometeam !== 'string' && typeof awayteam !== 'string' && typeof ateam !== 'string' && typeof bteam !== 'string') {
            return hometeam.getId() === ateam.getId() && awayteam.getId() === bteam.getId();
        }
    });
    if (match) {
        if (match.getHomeResult() > match.getAwayResult()) {
            return -1;
        }

        if (match.getAwayResult() > match.getHomeResult()) {
            return 1;
        }
    }
    match = matches.find((m: MatchModel) => {
        const ateam = a.getTeam();
        const bteam = b.getTeam();
        const hometeam = m.getHomeTeam();
        const awayteam = m.getAwayTeam();
        if (typeof hometeam !== 'string' && typeof awayteam !== 'string' && typeof ateam !== 'string' && typeof bteam !== 'string') {
            return hometeam.getId() === bteam.getId() && awayteam.getId() === ateam.getId();
        }
    });
    if (match) {
        if (match.getHomeResult() > match.getAwayResult()) {
            return 1;
        }

        if (match.getAwayResult() > match.getHomeResult()) {
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
