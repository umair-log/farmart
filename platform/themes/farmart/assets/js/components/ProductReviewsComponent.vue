<template>
    <div class="product-comments-list">
        <div class="comment-container row pb-2 mb-3 border-bottom" v-for="item in data" :key="item.id">
            <div class="col-auto">
                <img class="rounded-circle" :src="item.user_avatar" :alt="item.user_name" width="60">
            </div>
            <div class="col">
                <div class="meta">
                    <strong class="review__author">{{ item.user_name }}</strong>
                    <span class="review__dash">–</span>
                    <time class="review__published-date" :datetime="item.created_at_tz">{{ item.created_at }}</time>
                    <span v-if="item.ordered_at" class="ml-2">{{ item.ordered_at }}</span>
                </div>
                <star-rating :avg="item.star" />
                <div class="description mt-2">
                    <p>{{ item.comment }}</p>
                </div>

                <div class="review-images" v-if="item.images && item.images.length">
                    <a :href="image.full_url" v-for="(image, index) in item.images" v-bind:key="index">
                        <img :src="image.thumbnail" :alt="image.thumbnail" class="img-fluid rounded h-100">
                    </a>
                </div>
            </div>
        </div>

        <div v-if="!isLoading && !data.length" class="text-center">
            <p>{{ __('No reviews!') }}</p>
        </div>

        <div v-if="isLoading" class="review__loading">
            <div class="half-circle-spinner">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
            </div>
        </div>

        <div class="pagination">
            <pagination :data="meta" @on-click-paging="onClickPaginate" />
        </div>
    </div>
</template>

<script>
    import Pagination from './utils/Pagination.vue';
    import StarRating from './utils/StarRating.vue';

    export default {
        data: function() {
            return {
                isLoading: true,
                data: [],
                meta: {},
                star: 0,
            };
        },
        props: {
            url: {
                type: String,
                default: () => null,
                required: true
            },
        },
        mounted() {
            this.getData(this.url, false);
        },
        methods: {
            getData(link, animation = true) {
                this.isLoading = true;
                if (animation) {
                    $('html, body').animate({
                        scrollTop: $('.product-reviews-container').offset().top + 'px',
                    }, 1500);
                }
                axios.get(link)
                    .then(res => {
                        this.data = res.data.data || [];
                        this.meta = res.data.meta;
                        this.isLoading = false;

                        $('.product-reviews-container .product-reviews-header').html(res.data.message);
                    })
                    .catch(() => {
                        this.isLoading = false;
                    });
            },
            onClickPaginate({element}) {
                if (!element.active) {
                    this.getData(element.url);
                }
            }
        },
        updated: function () {
            let $galleries = $('.product-reviews-container .review-images');
            if ($galleries.length) {
                $galleries.map((index, value) => {
                    if (!$(value).data('lightGallery')) {
                        $(value).lightGallery({
                            selector: 'a',
                            thumbnail: true,
                            share: false,
                            fullScreen: false,
                            autoplay: false,
                            autoplayControls: false,
                            actualSize: false,
                        });
                    }
                });
            }
        },

        components: {
            Pagination,
            StarRating
        }
    }
</script>
