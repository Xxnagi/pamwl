<template>
  <Popover ref="sortPopover">
    <div class="p-4 w-96">
      <div class="flex justify-between items-center mb-4">
        <h4 class="font-semibold">Sort</h4>
        <Button
          severity="contrast"
          @click="$refs.sortPopover.hide()"
          icon="pi pi-times"
          variant="text"
          rounded
        />
      </div>
      <div class="space-y-2">
        <div
          v-for="option in sortOptions"
          :key="option.value"
          class="flex items-center"
        >
          <RadioButton
            v-model="localSortOption"
            :value="option.value"
            :inputId="option.value"
          />
          <label :for="option.value" class="ml-2 cursor-pointer">
            {{ option.label }}
          </label>
        </div>
      </div>
      <div class="flex justify-between mt-4">
        <Button label="Reset" severity="secondary" @click="resetSorting" />
        <Button label="Terapkan" @click="applySorting" />
      </div>
    </div>
  </Popover>
</template>

<script>
import Popover from "primevue/popover";
import Button from "primevue/button";
import RadioButton from "primevue/radiobutton";

export default {
  components: {
    Popover,
    Button,
    RadioButton,
  },
  props: {
    currentSortOption: {
      type: String,
      default: "name_asc",
    },
  },
  data() {
    return {
      localSortOption: this.currentSortOption,
      sortOptions: [
        { label: "Nama (A-Z)", value: "name_asc" },
        { label: "Nama (Z-A)", value: "name_desc" },
        { label: "Kategori (A-Z)", value: "category_asc" },
        { label: "Kategori (Z-A)", value: "category_desc" },
        { label: "Stok Terendah", value: "stock_asc" },
        { label: "Stok Tertinggi", value: "stock_desc" },
      ],
    };
  },
  methods: {
    applySorting() {
      this.$emit("apply-sorting", this.localSortOption);
      this.$refs.sortPopover.hide();
    },
    resetSorting() {
      this.localSortOption = "name_asc";
      this.$emit("apply-sorting", "name_asc");
    },
  },
};
</script>
