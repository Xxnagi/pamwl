// src/store.js
import { createStore } from "vuex";
import { fetchData } from "../services/api";

const store = createStore({
  state() {
    return {
      products: [],
      suppliers: [],
      categories: [],
      sales: [],
      purchases: [],
      transactions: [],
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
    setSales(state, sales) {
      state.sales = sales;
    },
    setTransactions(state, transactions) {
      state.transactions = transactions;
    },
    setPurchases(state, purchases) {
      state.purchases = purchases;
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
        const categories = await fetchData("/category/all");
        commit("setCategories", categories);
      } catch (error) {
        console.error("Error fetching categories:", error);
      }
    },
    async fetchSales({ commit }) {
      try {
        const sales = await fetchData("/sales/all");
        commit("setSales", sales);
      } catch (error) {
        console.error("Error fetching sales:", error);
      }
    },
    async fetchTransactions({ commit }) {
      try {
        const sales = await fetchData("/transaction/all");
        commit("setTransactions", sales);
      } catch (error) {
        console.error("Error fetching transactions:", error);
      }
    },
    async fetchPurchases({ commit }) {
      try {
        const purchases = await fetchData("/purchases/all");
        commit("setPurchases", purchases);
      } catch (error) {
        console.error("Error fetching purchases:", error);
      }
    },
    async initializeAppData({ dispatch }) {
      await Promise.all([
        dispatch("fetchProducts"),
        dispatch("fetchSuppliers"),
        dispatch("fetchCategories"),
        dispatch("fetchSales"),
        dispatch("fetchTransactions"),
        dispatch("fetchPurchases"),
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
    getSales(state) {
      return state.sales;
    },
    getTransactions(state) {
      return state.transactions;
    },
    getPurchases(state) {
      return state.purchases;
    },
  },
});

export default store;
