const state = {
    now: Date.now(),
};

const getters = {};

const actions = {
    setDate({ commit }) {
        commit('SET_DATE', Date.now());
        // setInterval(() => {
        //     commit('SET_DATE', Date.now());
        // }, 1000);
    },
};

const mutations = {
    ['SET_DATE'](state, payload) {
        state.now = payload;
    },
};

export default {
    state,
    getters,
    actions,
    mutations,
};
