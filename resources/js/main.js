import './bootstrap';

import Slugify from 'slugify';
import Currency from 'currency.js';
import Choices from 'choices.js';

var currencyFormatter = function (value, options = {}) {
    return Currency(value, options)
}

var domainSlugger = function(word) {
    return Slugify(word, {
        lower: true,
        remove: new RegExp(/[*+~.()'"!:@#^\\//]/g)
    })
}

var domainNamer = function(word) {
    return word.replace(new RegExp(/[*+~.()'"!:@#^%,\\//]/g), '')
}

window.Choices = Choices
window.slugify = Slugify
window.domainNamer = domainNamer
window.domainSlugger = domainSlugger
window.currencyFormatter = currencyFormatter

import Alpine from 'alpinejs';
import FiltersMap from './filters-map';
import scrollTo from 'alpinejs-scroll-to';

window.Alpine = Alpine;

Alpine.plugin(scrollTo);
Alpine.data('FiltersMap', FiltersMap);
Alpine.directive('choicesjs', (el, {}, { cleanup }) => {
	const choice = new window.Choices(el, {
	    removeItemButton: true
    });

    let handler = function (event) {
    	if (typeof el._x_model !== 'undefined') {
	    	el._x_model.set(choice.getValue(true));
    	}
    };

    window.addEventListener('change', handler)

    cleanup(() => {
        window.removeEventListener('click', handler)
    })

});
Alpine.start();
