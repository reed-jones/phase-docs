const freshState = () => ({
  latest: null
});

const getters = {
  //
};

const mutations = {
  RESET_MODULE(state) {
    Object.assign(state, freshState());
  }
};

const actions = {
  async reset({ commit }) {
    commit('RESET_MODULE');
  },
};

export default {
  namespaced: true,
  state: freshState(),
  getters,
  mutations,
  actions
};
