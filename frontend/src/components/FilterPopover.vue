<template>
  <Popover ref="filterPopover">
    <div class="w-96 p-4">
      <div class="w-full flex justify-between items-center mb-4">
        <h4 class="font-semibold">Filter</h4>
        <Button
          severity="contrast"
          @click="$refs.filterPopover.hide()"
          icon="pi pi-times"
          variant="text"
          rounded
        />
      </div>
      <div class="space-y-3">
        <div>
          <div class="flex justify-between items-center">
            <label>Kategori</label>
            <Button
              label="Hapus"
              @click="resetCategoryFilter"
              variant="link"
              severity="primary"
            />
          </div>
          <MultiSelect
            v-model="localSelectedCategories"
            :options="categories"
            optionLabel="category_name"
            optionValue="category_id"
            placeholder="Pilih Kategori"
            class="w-full"
          />
        </div>
        <div>
          <label class="block mb-2">Status</label>
          <div class="flex gap-2">
            <Select
              v-model="localStatusFilter"
              :options="statusFilterOptions"
              optionLabel="label"
              optionValue="value"
              placeholder="Pilih Status"
              class="w-full"
            />
          </div>
        </div>
        <div class="flex justify-between pt-2">
          <Button
            label="Reset"
            severity="contrast"
            variant="outlined"
            class="w-1/3"
            @click="resetFilter"
          />
          <Button label="Terapkan" class="w-1/3" @click="applyFilters" />
        </div>
      </div>
    </div>
  </Popover>
</template>

<script>
import Popover from "primevue/popover";
import Button from "primevue/button";
import MultiSelect from "primevue/multiselect";
import Select from "primevue/select";

export default {
  components: {
    Popover,
    Button,
    MultiSelect,
    Select,
  },
  props: {
    categories: {
      type: Array,
      default: () => [],
    },
    currentSelectedCategories: {
      type: Array,
      default: () => [],
    },
    currentStatusFilter: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      localSelectedCategories: [...this.currentSelectedCategories],
      localStatusFilter: this.currentStatusFilter,
      statusFilterOptions: [
        { label: "Masih", value: "masih" },
        { label: "Hampir", value: "hampir" },
        { label: "Habis", value: "habis" },
      ],
    };
  },
  methods: {
    applyFilters() {
      this.$emit("apply-filters", {
        categories: this.localSelectedCategories,
        status: this.localStatusFilter,
      });
      this.$refs.filterPopover.hide();
    },
    resetFilter() {
      this.localSelectedCategories = [];
      this.localStatusFilter = null;
      this.$emit("apply-filters", {
        categories: [],
        status: null,
      });
    },
    resetCategoryFilter() {
      this.localSelectedCategories = [];
      this.$emit("apply-filters", {
        categories: [],
        status: this.localStatusFilter,
      });
    },
  },
};
</script>
