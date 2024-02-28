<template>
    <div>
        <div class="product-deals-day__body arrows-top-right"
            v-infinite-scroll="getProducts"
            infinite-scroll-disabled="loaded"
            infinite-scroll-distance="0">
            <div
                v-if="!isLoading"
                v-slick
                v-lazyload
                class="product-deals-day-body slick-slides-carousel"
                :data-slick="slick_config">
                <div v-for="item in data" :key="item.id" class="product-inner" v-html="item"></div>
            </div>
            <div class="arrows-wrapper"></div>
        </div>
        <spinner-component v-if="isLoading"></spinner-component>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            isLoading: true,
            data: [],
            loaded: false,
        };
    },
    props: {
        url: {
            type: String,
            default: () => null,
            required: true,
        },
        id: {
            type: String,
            default: () => null,
        },
        slick_config: {
            type: String,
            default: () => null,
            required: true,
        },
    },
    mounted() {
        // this.getProducts();
    },
    methods: {
        getProducts() {
            this.data = [];
            this.isLoading = true;
            this.loaded = true;
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
