export default function useDocumentPreview(body, replacements = {}) {
    let formatted = body;

    Object.keys(replacements).forEach((replacement) => {
        formatted = formatted.replaceAll(
            `%${replacement}`,
            replacements[ replacement ]
        );
    });

    return formatted;
}
