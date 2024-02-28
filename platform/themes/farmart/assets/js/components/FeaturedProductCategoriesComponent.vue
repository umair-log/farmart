<template>
    <div class="product-categories-body pb-4 arrows-top-right">
        <div
            v-if="!isLoading"
            :data-slick="slick_config"
            v-slick
            v-lazyload
            class="product-categories-box slick-slides-carousel">
            <div
                v-for="item in data"
                v-bind:key="item.id"
                class="product-category-item p-3">
                <div class="category-item-body p-3">
                    <a class="d-block py-3" :href="item.url">
                        <div class="category__thumb img-fluid-eq mb-3">
                            <div class="img-fluid-eq__dummy"></div>
                            <div class="img-fluid-eq__wrap">
                                <img
                                    class="lazyload mx-auto"
                                    :data-src="item.thumbnail"
                                    :alt="item.name" />
                            </div>
                        </div>
                        <div class="category__text text-center py-3">
                            <h6 class="category__name">{{ item.name }}</h6>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="arrows-wrapper"></div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            isLoading: true,
            data: [],
        };
    },
    props: {
        url: {
            type: String,
            default: () => null,
            required: true,
        },
        slick_config: {
            type: String,
            default: () => null,
            required: true,
        },
    },
    mounted() {
        this.getCategories();
    },
    methods: {
        getCategories() {
            this.data = [];
            this.isLoading = true;
            axios
                .get(this.url)
                .then(res => {
                    this.data = res.data.data ? res.data.data : [];
                    this.isLoading = false;
                })
                .catch(() => {
                    this.isLoading = false;
                });
        },
    },
};
</script>
