import "./assets/index.css";

import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./state/store";
import PrimeVue from "primevue/config";
import Aura from "@primevue/themes/aura";

createApp(App)
  .use(router)
  .use(store)
  .use(PrimeVue, {
    // Default theme configuration
    theme: {
      preset: Aura,
      options: {
        prefix: "p",
        darkModeSelector: false,
        cssLayer: false,
      },
    },
  })
  .mount("#app");
