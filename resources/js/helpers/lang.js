import { usePage } from "@inertiajs/vue3";
import { get } from "lodash";

export default function __(key, replacements = {}) {
    const translations = usePage().props.translations;

    let translation = get(translations, key, key);

    Object.keys(replacements).forEach(replacement => {
        translation = translation.replace(`:${replacement}`, replacements[replacement]);
    });

    return translation;
}
