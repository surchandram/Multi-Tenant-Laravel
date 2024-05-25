# Dev Guide

Notes for devs working on the project.

## UI Folder Structure

- resources
  - `css`: All css for the app.
  - `js`
    - `app`
      - `[domain]`: eg, account, admin, auth
        - `modals`: Holds all modal based route views.
        - `views`: Holds all normal route views.
    - `components`: Holds all non-domain restrictive components
      - `ui`: Holds `shadcn-vue` components
    - `composables`: Holds reusable VueJs functionality
    - `directives`: Holds custom VueJs directives
    - `helpers`: Holds helper functions for primarily non VueJs functionality
    - `lib`: Holds custom functionality for different libraries
      - `utils.js`: Holds `shadcn-vue` helper functions. Any helper functions can be added.
    - `pages`: Acts as a connector between backend and frontend; for reusable functionality
    - `tailadmin`: Holds functionality for tailadmin theme. **To be removed**
    - `vendor`: Library customization. **To be removed**
    - `app.js`: Front-end entry point.

## UI Libraries

- [Tailwind CSS](https://tailwindcss.com/), for CSS styling
- [shadcn-vue](https://www.shadcn-vue.com/), built on top of [Radix Vue](https://www.radix-vue.com/).
- [headless UI](https://headlessui.com/), for more custom components.
- [Lucide Icons](https://lucide.dev/), using `lucide-vue-next` through `LucideIcon.vue` components.
- [Momentum Modal](https://github.com/lepikhinb/momentum-modal) used to power Inertia modal driven routes.
