export function getAvailableLayouts (files) {
    let layouts = Object.keys(files).map(function(key) {
        const name = key
            .split("layouts/")
            .pop()
            .replace(/(\.\/|\.vue)/g, "");
        return { exportName: name + "-layout", name: name, path: key };
    });

    layouts.map(async function(layout) {
        let module = files[layout.path];

        layout.component = module;

        return layout;
    });

    return layouts;
};

export function resolvePageLayout (layoutName, layouts) {
    const layout = layouts.find((l) => l.name === layoutName);

    return typeof layout !== "undefined"
        ? layout.component
        : layouts.find((l) => l.name === "default").component;
};
