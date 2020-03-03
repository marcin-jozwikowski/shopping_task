<template>
    <div class="container">
        <h1>Products:</h1>
        <div class="product-list">
            <div class="row">
                <div class="col-3"><p>Product name</p></div>
                <div class="col-6"><p>Description</p></div>
                <div class="col-3"><p>Price</p></div>
            </div>
            <div class="row" v-for="product in products">
                <div class="col-3"><p v-text="product.name"></p></div>
                <div class="col-6" v-html="product.description"></div>
                <div class="col-3"><p><span v-text="product.price / 100"></span> <span v-text="product.symbol"></span></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <ul class="pagination">
                    <li :class="{'page-item': true, 'disabled': page === 1}"><a class="page-link" href="#"
                                                                                @click="firstPage"><< </a></li>
                    <li :class="{'page-item': true, 'disabled': page === 1}"><a class="page-link" href="#"
                                                                                @click="prevPage"> < </a></li>
                    <li class="page-item disabled"><a class="page-link" href="#">
                        Page <span v-text="page"></span> of <span v-text="total_pages"></span>
                    </a></li>
                    <li :class="{'page-item': true, 'disabled': page === total_pages}"><a class="page-link" href="#"
                                                                                          @click="nextPage"> > </a></li>
                    <li :class="{'page-item': true, 'disabled': page === total_pages}"><a class="page-link" href="#"
                                                                                          @click="lastPage"> >> </a>
                    </li>
                </ul>
            </div>
            <div class="col-6">
                <div class="form-group row">
                    <label for="perPage" class="col-4 col-form-label">Per Page </label>
                    <div class="col-8">
                        <select id="perPage" class="form-control" v-model="per_page" @change="changePerPage($event)">
                            <option>5</option>
                            <option>10</option>
                            <option>15</option>
                            <option>20</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    const routes = require('../../public/js/fos_js_routes.json');
    import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.js';

    Routing.setRoutingData(routes);
    export default {
        name: "Products",
        data: function () {
            return {
                products: [],
                page: 0,
                per_page: 0,
                total_pages: 0,
            }
        },
        mounted: function () {
            this.loadProducts(1, 10);
        },
        methods: {
            getProductsUrl: function (page, perPage) {
                return Routing.generate('products', {page: page, per_page: perPage});
            },

            firstPage: function () {
                this.loadProducts(1, this.per_page);
            },
            prevPage: function () {
                this.loadProducts(this.page - 1, this.per_page);
            },
            nextPage: function () {
                this.loadProducts(this.page + 1, this.per_page);
            },
            lastPage: function () {
                this.loadProducts(this.total_pages, this.per_page);
            },
            changePerPage: function (event) {
                this.loadProducts(1, event.target.value);
            },

            loadProducts: function (page, perPage) {
                let request = new XMLHttpRequest(),
                    vueSelf = this;
                request.open('GET', vueSelf.getProductsUrl(page, perPage), true);
                request.onload = function () {
                    let response;
                    try {
                        response = JSON.parse(request.responseText);
                    } catch (e) {
                        console.error(e);
                        return;
                    }
                    if (request.status === 200 && response.hasOwnProperty('products')) {
                        vueSelf.products = response.products;
                        vueSelf.total_pages = response.total_pages;
                        vueSelf.page = response.page;
                        vueSelf.per_page = response.per_page;
                    }
                };
                // request.onerror = vueSelf.onNetworkError;
                // request.ontimeout = vueSelf.onNetworkError;
                // vueSelf.status = vueSelf.statuses.loading;
                request.send();

            }
        }

    };
</script>