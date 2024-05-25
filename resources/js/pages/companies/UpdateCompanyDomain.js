import { watch, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';

export default function upsertCompanyPage(model, action, success, error) {
    const form = useForm({
        domain: model.company?.domain || '',
    });

    const store = () => {
        form.clearErrors();

        if (typeof action !== 'string') {
            return;
        }

        form.post(action, {
            onSuccess: success,
            onError: error,
        });
    };

    onMounted(() => {
        watch(
            () => form.domain,
            (value) => {
                form.domain = window.domainSlugger(value, {
                    replacement: '',
                });
            },
        );
    });

    return {
        form,
        store,
    };
}
