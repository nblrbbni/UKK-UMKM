<div class="filter__item">
    <div class="row">
        <div class="col-lg-4 col-md-5">
            <div class="filter__sort">
                <span>Sort By</span>
                {!! html()->select('sorting', $sortingOptions, $sortingQuery)->attribute(
                        'onchange',
                        'this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);',
                    ) !!}
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="filter__found">
                &nbsp;
            </div>
        </div>
        <div class="col-lg-4 col-md-3">
            <div class="filter__option">
                <span class="icon_grid-2x2"></span>
                <span class="icon_ul"></span>
            </div>
        </div>
    </div>
</div>
