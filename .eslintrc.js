module.exports = {
    env: {
        node: true,
    },
    extends: [
        'eslint:recommended',
        'plugin:tailwindcss/recommended',
        'plugin:@typescript-eslint/eslint-recommended',
        'plugin:vue/vue3-recommended',
        'prettier',
    ],
    ignorePatterns: ['*.d.ts'],
    parser: 'vue-eslint-parser',
    parserOptions: {
        parser: '@typescript-eslint/parser',
    },
    rules: {
        // override/add rules settings here, such as:
        'vue/multi-word-component-names': 'off',
        'vue/component-api-style': ['error', ['script-setup', 'composition']],
        'vue/component-name-in-template-casing': 'error',
        'vue/no-v-html': 'off',
        'no-undef': 'off',
        // 'vue/no-unused-vars': 'error'
    },
};
