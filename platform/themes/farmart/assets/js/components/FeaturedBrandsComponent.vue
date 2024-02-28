<template>
    <div class="featured-brands__body arrows-top-right">
        <div
            v-if="!isLoading"
            v-slick
            v-lazyload
            class="featured-brands-body slick-slides-carousel"
            :data-slick="slick_config"
        >
            <div v-for="item in data" v-bind:key="item.id" class="featured-brand-item">
                <div class="brand-item-body mx-2 py-4 px-2">
                    <a class="py-3" :href="item.url">
                        <div class="brand__thumb mb-3 img-fluid-eq">
                            <div class="img-fluid-eq__dummy"></div>
                            <div class="img-fluid-eq__wrap">
                                <img
                                    class="lazyload mx-auto"
                                    :src="siteConfig.img_placeholder ? siteConfig.img_placeholder : item.logo"
                                    :data-src="item.logo"
                                    alt="brand"
                                />
                            </div>
                        </div>
                        <div class="brand__text py-3">
                            <h4 class="h6 fw-bold text-secondary text-uppercase brand__name">
                                {{ item.name }}
                            </h4>
                            <div class="h5 fw-bold brand__desc">
                                <div v-html="item.description"></div>
                            </div>
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
        this.getFeaturedBrands();
    },
    methods: {
        getFeaturedBrands() {
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
