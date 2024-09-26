<div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
    <!--begin::Thumbnail settings-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Thumbnail</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body text-center pt-0">
            <!--begin::Image input-->
            <!--begin::Image input placeholder-->
            <style>
            .image-input-placeholder {
                background-image: url('/good/assets/media/svg/files/blank-image.svg');
            }

            [data-bs-theme="dark"] .image-input-placeholder {
                background-image: url('/good/assets/media/svg/files/blank-image-dark.svg');
            }
            </style>
            <!--end::Image input placeholder-->

            <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                data-kt-image-input="true">
                <!--begin::Preview existing avatar-->
                <div class="image-input-wrapper w-150px h-150px"></div>
                <!--end::Preview existing avatar-->

                <!--begin::Label-->
                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar"
                    data-bs-original-title="Change avatar" data-kt-initialized="1">
                    <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span class="path2"></span></i>
                    <!--begin::Inputs-->
                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                    <input type="hidden" name="avatar_remove">
                    <!--end::Inputs-->
                </label>
                <!--end::Label-->

                <!--begin::Cancel-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar"
                    data-bs-original-title="Cancel avatar" data-kt-initialized="1">
                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                </span>
                <!--end::Cancel-->

                <!--begin::Remove-->
                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar"
                    data-bs-original-title="Remove avatar" data-kt-initialized="1">
                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                </span>
                <!--end::Remove-->
            </div>
            <!--end::Image input-->

            <!--begin::Description-->
            <div class="text-muted fs-7">Set the product thumbnail image. Only *.png, *.jpg and *.jpeg image files are
                accepted</div>
            <!--end::Description-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Thumbnail settings-->
    <!--begin::Status-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Status</h2>
            </div>
            <!--end::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <div class="rounded-circle bg-success w-15px h-15px" id="kt_ecommerce_add_product_status"></div>
            </div>
            <!--begin::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Select2-->
            <select class="form-select mb-2 select2-hidden-accessible" data-control="select2" data-hide-search="true"
                data-placeholder="Select an option" id="kt_ecommerce_add_product_status_select"
                data-select2-id="select2-data-kt_ecommerce_add_product_status_select" tabindex="-1" aria-hidden="true"
                data-kt-initialized="1">
                <option></option>
                <option value="published" selected="" data-select2-id="select2-data-11-e9sl">Published</option>
                <option value="draft">Draft</option>
                <option value="scheduled">Scheduled</option>
                <option value="inactive">Inactive</option>
            </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr"
                data-select2-id="select2-data-10-r20k" style="width: 100%;"><span class="selection"><span
                        class="select2-selection select2-selection--single form-select mb-2" role="combobox"
                        aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false"
                        aria-labelledby="select2-kt_ecommerce_add_product_status_select-container"
                        aria-controls="select2-kt_ecommerce_add_product_status_select-container"><span
                            class="select2-selection__rendered"
                            id="select2-kt_ecommerce_add_product_status_select-container" role="textbox"
                            aria-readonly="true" title="Published">Published</span><span
                            class="select2-selection__arrow" role="presentation"><b
                                role="presentation"></b></span></span></span><span class="dropdown-wrapper"
                    aria-hidden="true"></span></span>
            <!--end::Select2-->

            <!--begin::Description-->
            <div class="text-muted fs-7">Set the product status.</div>
            <!--end::Description-->

            <!--begin::Datepicker-->
            <div class="d-none mt-10">
                <label for="kt_ecommerce_add_product_status_datepicker" class="form-label">Select publishing date and
                    time</label>
                <input class="form-control flatpickr-input" id="kt_ecommerce_add_product_status_datepicker"
                    placeholder="Pick date &amp; time" type="text" readonly="readonly">
            </div>
            <!--end::Datepicker-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Status-->

    <!--begin::Category & tags-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Product Details</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Input group-->
            <!--begin::Label-->
            <label class="form-label">Categories</label>
            <!--end::Label-->

            <!--begin::Select2-->
            <select class="form-select mb-2 select2-hidden-accessible" data-control="select2"
                data-placeholder="Select an option" data-allow-clear="true" multiple=""
                data-select2-id="select2-data-12-3z48" tabindex="-1" aria-hidden="true" data-kt-initialized="1">
                <option></option>
                <option value="Computers">Computers</option>
                <option value="Watches">Watches</option>
                <option value="Headphones">Headphones</option>
                <option value="Footwear">Footwear</option>
                <option value="Cameras">Cameras</option>
                <option value="Shirts">Shirts</option>
                <option value="Household">Household</option>
                <option value="Handbags">Handbags</option>
                <option value="Wines">Wines</option>
                <option value="Sandals">Sandals</option>
            </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr"
                data-select2-id="select2-data-13-gj8j" style="width: 100%;"><span class="selection"><span
                        class="select2-selection select2-selection--multiple form-select mb-2" role="combobox"
                        aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false">
                        <ul class="select2-selection__rendered" id="select2-iedt-container"></ul><span
                            class="select2-search select2-search--inline"><textarea class="select2-search__field"
                                type="search" tabindex="0" autocorrect="off" autocapitalize="none" spellcheck="false"
                                role="searchbox" aria-autocomplete="list" autocomplete="off" aria-label="Search"
                                aria-describedby="select2-iedt-container" placeholder="Select an option"
                                style="width: 100%;"></textarea></span>
                    </span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
            <!--end::Select2-->

            <!--begin::Description-->
            <div class="text-muted fs-7 mb-7">Add product to a category.</div>
            <!--end::Description-->
            <!--end::Input group-->

            <!--begin::Button-->
            <a href="/good/apps/ecommerce/catalog/add-category.html" class="btn btn-light-primary btn-sm mb-10">
                <i class="ki-duotone ki-plus fs-2"></i> Create new category
            </a>
            <!--end::Button-->

            <!--begin::Input group-->
            <!--begin::Label-->
            <label class="form-label d-block">Tags</label>
            <!--end::Label-->

            <!--begin::Input-->
            <tags class="tagify form-control mb-2 tagify--noTags tagify--empty" tabindex="-1">
                <span contenteditable="" tabindex="0" data-placeholder="​" aria-placeholder="" class="tagify__input"
                    role="textbox" autocapitalize="false" autocorrect="off" spellcheck="false" aria-autocomplete="both"
                    aria-multiline="false"></span>
                ​
            </tags><input id="kt_ecommerce_add_product_tags" name="kt_ecommerce_add_product_tags"
                class="form-control mb-2" value="" tabindex="-1">
            <!--end::Input-->

            <!--begin::Description-->
            <div class="text-muted fs-7">Add tags to a product.</div>
            <!--end::Description-->
            <!--end::Input group-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Category & tags-->
    <!--begin::Weekly sales-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Weekly Sales</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            <span class="text-muted">No data available. Sales data will begin capturing once product has been
                published.</span>
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Weekly sales-->
    <!--begin::Template settings-->
    <div class="card card-flush py-4">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title">
                <h2>Product Template</h2>
            </div>
            <!--end::Card title-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Select store template-->
            <label for="kt_ecommerce_add_product_store_template" class="form-label">Select a product template</label>
            <!--end::Select store template-->

            <!--begin::Select2-->
            <select class="form-select mb-2 select2-hidden-accessible" data-control="select2" data-hide-search="true"
                data-placeholder="Select an option" id="kt_ecommerce_add_product_store_template"
                data-select2-id="select2-data-kt_ecommerce_add_product_store_template" tabindex="-1" aria-hidden="true"
                data-kt-initialized="1">
                <option></option>
                <option value="default" selected="" data-select2-id="select2-data-15-jrmg">Default template</option>
                <option value="electronics">Electronics</option>
                <option value="office">Office stationary</option>
                <option value="fashion">Fashion</option>
            </select><span class="select2 select2-container select2-container--bootstrap5" dir="ltr"
                data-select2-id="select2-data-14-5w7s" style="width: 100%;"><span class="selection"><span
                        class="select2-selection select2-selection--single form-select mb-2" role="combobox"
                        aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false"
                        aria-labelledby="select2-kt_ecommerce_add_product_store_template-container"
                        aria-controls="select2-kt_ecommerce_add_product_store_template-container"><span
                            class="select2-selection__rendered"
                            id="select2-kt_ecommerce_add_product_store_template-container" role="textbox"
                            aria-readonly="true" title="Default template">Default template</span><span
                            class="select2-selection__arrow" role="presentation"><b
                                role="presentation"></b></span></span></span><span class="dropdown-wrapper"
                    aria-hidden="true"></span></span>
            <!--end::Select2-->

            <!--begin::Description-->
            <div class="text-muted fs-7">Assign a template from your current theme to define how a single product is
                displayed.</div>
            <!--end::Description-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Template settings-->
</div>