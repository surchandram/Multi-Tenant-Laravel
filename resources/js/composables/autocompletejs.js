import autoComplete from "@tarekraafat/autocomplete.js";

export function useAutoComplete(selector, src, config = {}) {
    const autoCompleteJS = new autoComplete({
        selector: selector,
        placeHolder: config?.placeHolder || "",
        data: {
            src: src,
            cache: true,
            keys: config.srcKey,
        },
        resultItem: {
            highlight: config.highlight || true,
        },
        threshold: config.threshold || 0,
        resultsList: {
            maxResults: undefined,
        },
        noResults: config.noResults || false,
        events: {
            input: {
                keyup: () => {
                    const value = autoCompleteJS.input.value;

                    if (typeof config.onKeyup === 'function') {
                        const callable = config.onKeyup;
                        callable(value);
                    }
                },
                selection: (event) => {
                    const selection = event.detail.selection.value;

                    autoCompleteJS.input.value = selection.name;

                    if (typeof config.onSelection === 'function') {
                        const callable = config.onSelection;
                        callable(selection);
                    }
                },
            },
        },
    });

    return {
        autoCompleteJS
    };
};
