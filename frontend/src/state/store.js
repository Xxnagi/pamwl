// src/store.js
import { createStore } from "vuex";
import { fetchData } from "../services/api";

const store = createStore({
  state() {
    return {
      products: [],
      suppliers: [],
      categories: [],
      expenses: [],
      initialized: false,
    };
  },
  mutations: {
    setProducts(state, products) {
      state.products = products;
    },
    setSuppliers(state, suppliers) {
      state.suppliers = suppliers;
    },
    setCategories(state, categories) {
      state.categories = categories;
    },
    setExpenses(state, expenses) {
      state.expenses = expenses;
    },

    setInitialized(state, value) {
      state.initialized = value;
    },
  },
  actions: {
    async fetchProducts({ commit }) {
      try {
        const products = await fetchData("/products/all");
        commit("setProducts", products);
      } catch (error) {
        console.error("Error fetching products:", error);
      }
    },
    async fetchSuppliers({ commit }) {
      try {
        const suppliers = await fetchData("/suppliers/all");
        commit("setSuppliers", suppliers);
      } catch (error) {
        console.error("Error fetching suppliers:", error);
      }
    },
    async fetchCategories({ commit }) {
      try {
        const categories = await fetchData("/categories");
        commit("setCategories", categories);
      } catch (error) {
        console.error("Error fetching categories:", error);
      }
    },
    async fetchExpenses({ commit }) {
      try {
        const expenses = await fetchData("/purchases/total");
        commit("setExpenses", expenses);
      } catch (error) {
        console.error("Error fetching expenses:", error);
      }
    },
    async initializeAppData({ dispatch }) {
      await Promise.all([
        dispatch("fetchProducts"),
        dispatch("fetchSuppliers"),
        dispatch("fetchCategories"),
        dispatch("fetchExpenses"),
      ]);
    },
  },
  getters: {
    getProducts(state) {
      return state.products;
    },
    getSuppliers(state) {
      return state.suppliers;
    },
    getCategories(state) {
      return state.categories;
    },
    getExpenses(state) {
      return state.expenses;
    },
  },
});

export default store;
