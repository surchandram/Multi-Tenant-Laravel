window.Choices = Choices

import Alpine from 'alpinejs';

import FiltersMap from '../filters-map';
import scrollTo from 'alpinejs-scroll-to';
import intersect from "@alpinejs/intersect";

import Prism from "prismjs";
import flatpickr from "flatpickr";

Alpine.plugin(intersect);
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
