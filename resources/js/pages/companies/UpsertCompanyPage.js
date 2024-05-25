import { watch, computed, onMounted, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
// import Fuse from "fuse.js";

export default function upsertCompanyPage(model, editing = false) {
    // const fuse = new Fuse([]);

    const form = useForm({
        name: model.company?.name || '',
        domain: model.company?.domain || '',
        email: model.company?.email || '',
        measurement_unit: model.company?.measurement_unit || '',
        currency: model.company?.currency || '',
        default_tax: model.company?.default_tax || '',
        license_no: model.company?.license_no || '',
        tax_id: model.company?.tax_id || '',
        projects_prefix: model.company?.projects_prefix || '',
        logo: null,
        apps: [],
    });

    const cityQuery = ref('');

    const countryData = computed(() => {
        if (!form.country_id) {
            return;
        }

        return _.find(model.countries, { id: form.country_id });
    });

    const cities = ref([]);

    // store method

    onMounted(() => {
        watch(
            () => form.name,
            (value) => {
                if (editing) {
                    return;
                }

                form.domain = window.domainSlugger(value, {
                    replacement: '',
                });
            },
        );

        // generate cities
        watch(
            () => form.country_id,
            () => {
                cityQuery.value = '';
                form.city = '';
            },
        );

        // generate cities
        watch(cityQuery, (value) => {
            if (_.isEmpty(value)) {
                return;
            }
            form.city = value;

            const results = _.find(model.cities, {
                iso2: countryData.value.code,
            })?.cities;

            fuse.setCollection(results || []);

            cities.value = fuse.search(cityQuery.value, {
                limit: 5,
            });
        });
    });

    return {
        cityQuery,
        cities,
        form,
    };
}
