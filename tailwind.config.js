const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    darkModel : "class" , 
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Vazir', ...defaultTheme.fontFamily.sans],
            },
            colors : {
                'template' : '#f3f4f6' ,
                'alert-text' : 'rgb(180, 83, 9)' ,
                
            },
            
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
