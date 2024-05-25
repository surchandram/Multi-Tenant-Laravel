import { computed, ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";


export function useFilters(filtersMap, routeName, routeParams = {}) {
    const selectedFilters = ref({});

    const withFilter = (key, value) => {
        if (typeof key === 'object' && _.size(key) >= 1) {
            selectedFilters.value = Object.assign({}, selectedFilters.value, key);
        } else {
            selectedFilters.value = Object.assign({}, selectedFilters.value, {
                [key]: value });
        }

        applyFilters();
    };

    const withoutFilter = (key) => {
        selectedFilters.value = _.omit(selectedFilters.value, key);

        applyFilters();
    };

    const withoutAllFilters = (key) => {
        selectedFilters.value = _.omit(selectedFilters.value, filtersMap.keys);

        return selectedFilters.value;
    };

    const applyFilters = (filters = {}) => {
        if (_.size(filters)) {
            withFilter(filters);
            return;
        }

        var params = routeParams;

        params = Object.assign({}, routeParams, selectedFilters.value);

        router.get(window.route(routeName, params));
    };

    const hasFilter = (key) => {
        return _.has(selectedFilters.value, key);
    };

    const hasSelectedFilters = computed(() => {
        return _.size(_.pick(selectedFilters.value, Object.keys(filtersMap)));
    });

    const selectedLabels = computed(() => {
        return _.map(
            _.pickBy(
                filtersMap, (value, key) => _.includes(Object.keys(selectedFilters.value), key)
            ), 'heading'
        );
    });

    /**
     * Handle filters on component mount.
     */
    onMounted(() => {
        // set initial filters
        selectedFilters.value = _.omit(window.route().params, ['page']);
    });

    return {
        selectedFilters,
        withFilter,
        withoutFilter,
        withoutAllFilters,
        applyFilters,
        hasFilter,
        hasSelectedFilters,
        selectedLabels,
    }
}
