module.exports = {
    root: true,
    env: {
        browser: true,
        es2021: true,
    },
    extends: [
        "plugin:vue/essential",
        "plugin:prettier/recommended",
        "prettier",
    ],
    plugins: ["prettier"],
    rules: {
        "no-irregular-whitespace": "off",
        "vue/no-unused-vars": "error",
        "vue/html-self-closing": [
            "error",
            {
                html: {
                    void: "always",
                    normal: "never",
                    component: "always",
                },
                svg: "always",
                math: "always",
            },
        ],
    },
};
