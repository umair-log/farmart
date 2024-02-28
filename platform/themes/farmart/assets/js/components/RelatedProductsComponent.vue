<template>
    <div class="product-deals-day__body arrows-top-right">
        <div
            v-if="!isLoading"
            v-slick
            v-lazyload
            class="product-deals-day-body slick-slides-carousel"
            :data-slick="slick_config" >
            <div
                v-for="item in data"
                :key="item.id"
                class="product-inner"
                v-html="item"
            ></div>
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
        limit: {
            type: String,
            default: () => 0,
        },
        slick_config: {
            type: String,
            default: () => null,
            required: true,
        },
    },
    mounted() {
        this.getProducts();
    },
    methods: {
        getProducts() {
            this.data = [];
            this.isLoading = true;
            let url = this.url;
            if (this.limit) {
                url += '?limit=' + this.limit;
            }

            axios
                .get(url)
                .then(res => {
                    this.data = res.data?.data || [];
                    this.isLoading = false;
                })
                .catch(() => {
                    this.isLoading = false;
                });
        },
    },
};
</script>
