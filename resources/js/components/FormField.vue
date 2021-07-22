<template>
  <default-field :field="field" :errors="errors">
    <template slot="field">
      <search-input
        v-if="!isReadonly && isSearchable"
        @input="performSearch"
        @clear="clearSelection"
        @change="attemptUpdate"
        @selected="selectOption"
        :error="hasError"
        :value="selectedOption"
        :data="filteredOptions"
        :clearable="field.nullable"
        trackBy="value"
        class="w-full"
      >
        <!-- The Selected Option Slot -->
        <div slot="default" v-if="selectedOption" class="flex items-center">
          {{ selectedOption.label }}
        </div>

        <!-- Options List Slot -->
        <div
          slot="option"
          slot-scope="{ option, selected }"
          class="flex items-center text-sm font-semibold leading-5 text-90"
          :class="{ 'text-white': selected }"
        >
          {{ option.label }}
        </div>
      </search-input>

      <select-control
        v-else
        :id="field.attribute"
        v-model="value"
        class="w-full form-control form-select"
        :class="errorClasses"
        :options="field.options"
        :selected="value"
        :disabled="isReadonly"
      >
        <option value="" disabled>
          {{ __("Choose an option") }}
        </option>
      </select-control>
    </template>
  </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';
import InlineInit from './mixins/init';

export default {
  mixins: [FormField, HandlesValidationErrors, InlineInit],

  props: ['resourceName', 'resourceId', 'field']
}
</script>
