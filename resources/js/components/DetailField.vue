<template>
  <panel-item :field="field">
    <template slot="value" v-if="field.inlineDetail">
      <div class="flex w-full">
        <!-- Search Input -->
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
          class="flex-1 form-control form-select"
          :class="errorClasses"
          :options="field.options"
          :selected="value"
          :disabled="isReadonly"
          @change="attemptUpdate"
        >
          <option value="" disabled>
            {{ __("Choose an option") }}
          </option>
        </select-control>

        <button
          class="btn btn-default btn-primary flex items-center justify-center px-3 ml-2"
          :title="__('Update')"
          v-if="showUpdateButton"
          @click="submit"
        >
          <icon type="play" class="text-white" style="margin-left: 7px" />
        </button>
      </div>
    </template>

    <template slot="value" v-else>
      {{ displayValue }}
    </template>
  </panel-item>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';
import InlineInit from './mixins/init';
import InlineMixin from './mixins/inline';

export default {
  mixins: [FormField, HandlesValidationErrors, InlineInit, InlineMixin],
  methods: {
    attemptUpdate() {
      if (this.field.detailTwoStepDisabled) {
        return this.submit();
      }

      this.showUpdateButton = true;
    }
  }
}
</script>
