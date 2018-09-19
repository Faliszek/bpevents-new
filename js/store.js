import Vue from 'vue';
import Vuex from 'vuex';

import { stateCreator } from './state';
import { gettersCreator } from './getters';
import { actionsCreators } from './actions';
import { mutationsCreator } from './mutations';
Vue.use(Vuex);

const store = new Vuex.Store({
  state: stateCreator(),
  getters: gettersCreator(),
  mutations: mutationsCreator(),
  actions: actionsCreators(),
});

export default store;


