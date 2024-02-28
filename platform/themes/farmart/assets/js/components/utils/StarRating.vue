<template>
    <div class="star-rating-wrapper" v-if="avg">
        <div class="star-rating" role="img" :aria-label="'Rated' + avg + 'out of 5'">
            <span class="max-rating rating-stars">
                <span class="svg-icon">
                    <svg>
                        <use href="#svg-icon-star" xlink:href="#svg-icon-star"></use>
                    </svg>
                </span>
                <span class="svg-icon">
                    <svg>
                        <use href="#svg-icon-star" xlink:href="#svg-icon-star"></use>
                    </svg>
                </span>
                <span class="svg-icon">
                    <svg>
                        <use href="#svg-icon-star" xlink:href="#svg-icon-star"></use>
                    </svg>
                </span>
                <span class="svg-icon">
                    <svg>
                        <use href="#svg-icon-star" xlink:href="#svg-icon-star"></use>
                    </svg>
                </span>
                <span class="svg-icon">
                    <svg>
                        <use href="#svg-icon-star" xlink:href="#svg-icon-star"></use>
                    </svg>
                </span>
            </span>
            <span class="user-rating rating-stars" :style="{width: avg * 20 + '%'}">
                <span class="svg-icon">
                    <svg>
                        <use href="#svg-icon-star" xlink:href="#svg-icon-star"></use>
                    </svg>
                </span>
                <span class="svg-icon">
                    <svg>
                        <use href="#svg-icon-star" xlink:href="#svg-icon-star"></use>
                    </svg>
                </span>
                <span class="svg-icon">
                    <svg>
                        <use href="#svg-icon-star" xlink:href="#svg-icon-star"></use>
                    </svg>
                </span>
                <span class="svg-icon">
                    <svg>
                        <use href="#svg-icon-star" xlink:href="#svg-icon-star"></use>
                    </svg>
                </span>
                <span class="svg-icon">
                    <svg>
                        <use href="#svg-icon-star" xlink:href="#svg-icon-star"></use>
                    </svg>
                </span>
            </span>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        avg: {
            type: Number,
            default: 0,
        },
    },
    methods: {}
}
</script>
