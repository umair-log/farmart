@php
    $categories->loadMissing(['slugable', 'activeChildren:id,name,parent_id', 'activeChildren.slugable']);

    if (!empty($categoriesRequest)) {
        $categories = $categories->whereIn('id', $categoriesRequest);
    }
@endphp

<ul>
    @if (!empty($categoriesRequest))
        <li class="category-filter">
            <a class="nav-list__item-link" href="{{ route('public.products') }}" data-id="">
                <span class="cat-menu-close svg-icon">
                    <svg>
                        <use href="#svg-icon-chevron-left" xlink:href="#svg-icon-close"></use>
                    </svg>
                </span>
                <span>{{ __('All categories') }}</span>
            </a>
        </li>
    @endif

    @foreach($categories as $category)
        @php
            $isActive = $urlCurrent == $category->url ||
                (!empty($categoriesRequest && in_array($category->id, $categoriesRequest))) ||
                ($loop->first && $categoriesRequest && $categories->count() == 1 && $category->activeChildren->count());
        @endphp
        <li class="category-filter @if ($isActive) opened @endif">
            <div class="widget-layered-nav-list__item">
                <div class="nav-list__item-title">
                    <a class="nav-list__item-link @if ($isActive) active @endif"
                        href="{{ $category->url }}" data-id="{{ $category->id }}">
                        @if (!$category->parent_id)
                            @if ($category->getMetaData('icon_image', true))
                                <img src="{{ RvMedia::getImageUrl($category->getMetaData('icon_image', true)) }}" alt="{{ $category->name }}" width="18" height="18">
                            @elseif ($category->getMetaData('icon', true))
                                <i class="{{ $category->getMetaData('icon', true) }}"></i>
                            @endif
                            <span class="ms-1">{!! BaseHelper::clean($category->name) !!}</span>
                        @else
                            <span>{!! BaseHelper::clean($category->name) !!}</span>
                        @endif
                    </a>
                </div>
                @if ($category->activeChildren->count())
                    <span class="cat-menu-close svg-icon">
                        <svg>
                            <use href="#svg-icon-close" xlink:href="#svg-icon-close"></use>
                        </svg>
                    </span>
                @endif
            </div>
            @if ($category->activeChildren->count())
                @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.categories', compact('urlCurrent') + [
                    'categories' => $category->activeChildren,
                    'categoriesRequest' => [],
                ])
            @endif
        </li>
    @endforeach
</ul>
