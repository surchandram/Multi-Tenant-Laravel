import { router } from '@inertiajs/vue3';

export default function (el, binding) {
    const $eventBus = window.$eventBus;
    const rawValue = binding.value;

    // check if 'hide' argument present
    const hide = typeof binding.arg !== 'undefined' && binding.arg == 'hide';

    // check if current route matches passed value
    var onRoute = route().current(rawValue);

    // handles 'el' display on route change
    const handleRouteChange = () => {
        if (onRoute) {
            if (!hide) {
                el.style.display = 'block';
            } else {
                el.style.display = 'none';
            }
        } else if (!onRoute && hide) {
            el.style.display = 'block';
        } else {
            el.style.display = 'none';
        }
    };

    // listen for route changes
    router.on('navigate', () => {
        onRoute = route().current(rawValue);
    });

    $eventBus.on('route::changed', (val) => {
        onRoute = route().current(rawValue);

        handleRouteChange();
    });

	// call on el 'init'
    handleRouteChange();
}
