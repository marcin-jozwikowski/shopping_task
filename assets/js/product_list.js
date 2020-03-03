import Vue from "vue";
import Products from "./productList";

new Vue({
    components: {Products},
    template: "<Products/>",
}).$mount("#application");