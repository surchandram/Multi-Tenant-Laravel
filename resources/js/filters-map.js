export default (id, filterUrl, requestFilters = {}) => ({
    /*
     * The component's data.
     */
    filters: [],

    selected: requestFilters,

    get selectedFilters() {
        return _.keys(this.selected)
    },

    get hasSelectedFilters() {
        return _.size(this.selectedFilters)
    },

    processing: false,

    /**
     * Prepare the component.
     */
    init() {
        this.getFilters();
    },

    /**
     * Get filters from url.
     */
    getFilters() {
        axios.get(filterUrl)
                .then(response => {
                    this.filters = response.data.data;
                });
    },

    /**
     * Push filter to selected filters.
     */
    addFilter(key, value) {
        this.selected = Object.assign({}, this.selected, { [key]: value }) 
    },

    /**
     * Remove filter from selected filters.
     */
    removeFilter(key) {
        this.selected = _.omit(this.selected, key)
    },

    /**
     * Show the form for creating new clients.
     */
    showFiltersModal() {
        this.$dispatch('open-modal', id);
    },
})

