require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('OrderManager', require('./components/OrderManager.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

let app = document.querySelector('#app');

if(app)
{
    const app = new Vue({
        el: '#app',
    });
}

const links = document.querySelectorAll(".scroll-link");
const overlayMenu = document.getElementsByClassName('nav-overlay')[0];

for (const link of links) {
    
    link.addEventListener('click', function(e){
        e.preventDefault();
        
        document.getElementById(this.getAttribute('scroll-to')).scrollIntoView({behavior: "smooth"});

        if(window.getComputedStyle(overlayMenu).getPropertyValue("visibility") == 'visible')
            overlayMenu.style.visibility = 'hidden';
    })
}

document.getElementById('burger').addEventListener('click', function(e){
    e.preventDefault();

    if(window.getComputedStyle(overlayMenu).getPropertyValue("visibility") == 'visible')
        overlayMenu.style.visibility = 'hidden';
    else
        overlayMenu.style.visibility = 'visible';
})