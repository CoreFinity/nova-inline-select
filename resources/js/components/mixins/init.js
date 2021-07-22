export default {
    data: () => ({
        selectedOption: null,
        search: '',
    }),

    created() {
        if (this.field.value && this.isSearchable) {
            this.selectedOption = _(this.field.options).find(
                v => v.value == this.field.value
            )
        }
    },
    computed: {
        /**
         * Determine if the related resources is searchable
         */
        isSearchable() {
            return this.field.searchable
        },

        /**
         * Return the field options filtered by the search string.
         */
        filteredOptions() {
            return this.field.options.filter(option => {
                return (
                    option.label.toLowerCase().indexOf(this.search.toLowerCase()) > -1
                )
            })
        },

        /**
         * Return the placeholder text for the field.
         */
        placeholder() {
            return this.field.placeholder || this.__('Choose an option')
        },
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || ''
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || '')
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = value
        },

        /**
         * Set the search string to be used to filter the select field.
         */
        performSearch(event) {
            this.search = event
        },

        /**
         * Clear the current selection for the field.
         */
        clearSelection() {
            this.selectedOption = ''
            this.value = ''
        },

        /**
         * Select the given option.
         */
        selectOption(option) {
            this.selectedOption = option
            this.value = option.value

            if (this.field.inlineDetail)
                this.attemptUpdate()
        },
    }
}
