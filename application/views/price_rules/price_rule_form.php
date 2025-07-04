<?php $this->load->view("partial/header"); ?>

<?php echo form_open('price_rules/save/' . $this->uri->segment('3'), array('id' => 'create_price_rule_form', 'class' => 'form-horizontal'));     ?>
<div class="card">
    <div class="card-header rounded rounded-3 ">
        <div class="card-title">
            <?php echo lang("price_rules_basic_info"); ?> (<small><?php echo lang('fields_required_message'); ?></small>)
        </div>
    </div>

    <div class="card-body">
        <div class="row">

            <label class="col-sm-3 col-md-3 col-lg-2 form-check-label" for="flexCheckDefault"><?php echo form_label(lang('price_rules_type')) ?></label>
            <div class="col-sm-9 col-md-9 col-lg-10 mb-2">
                <?php

                if (isset($rule_info['type'])) {
                    $rule = $rule_info['type'];
                } else {
                    $rule = NULL;
                }
                $rule_types[''] = lang('price_rules_select_type');
                $rule_types['simple_discount'] = lang('simple_discount');
                $rule_types['advanced_discount'] = lang('advanced_discount');
                $rule_types['buy_x_get_y_free'] = lang('buy_x_get_y_free');
                $rule_types['buy_x_get_discount'] = lang('buy_x_get_discount');
                $rule_types['spend_x_get_discount'] = lang('spend_x_get_discount');


                echo form_dropdown('type', $rule_types, $rule, 'class="form-select form-select-solid form-inps" id="type"'); ?>
            </div>

            <label class="form-check-label col-sm-3 col-md-3 col-lg-2" for="flexCheckChecked"><?php echo form_label(lang('price_rules_name')) ?></label>
            <div class="col-sm-9 col-md-9 col-lg-10 mb-2">
                <?php echo form_input(
                    array(
                        'name' => 'name',
                        'id' => 'name',
                        'required' => 'required',
                        'class' => 'form-control form-control-solid form-inps',
                        'value' => isset($rule_info['name']) ? $rule_info['name'] : ''
                    )
                ); ?>
            </div>

            <label class="form-check-label col-sm-3 col-md-3 col-lg-2" for="flexCheckDefault"><?php echo form_label(lang('description')) ?></label>
            <div class="col-sm-9 col-md-9 col-lg-10 mb-2">
                <?php echo form_textarea(array(
                    'name' => 'description',
                    'id' => 'description',
                    'class' => 'form-control form-control-solid text-area',
                    'rows' => '4',
                    'cols' => '30',
                    'value' => isset($rule_info['description']) ? $rule_info['description'] : ''
                )); ?>

            </div>
        </div>

        <div class="row">

            <label class="form-check-label col-sm-3 col-md-3 col-lg-2" for="flexCheckDefault"><?php echo form_label(lang('price_rules_start_date')) ?></label>
            <div class="col-sm-9 col-md-9 col-lg-10 mb-2">
                <div class="input-group date" data-date="<?php echo isset($rule_info['start_date']) && $rule_info['start_date'] ? date(get_date_format(), strtotime($rule_info['start_date'])) : ''; ?>">
                    <span class="input-group-text bg"><i class="ion ion-ios-calendar-outline pt-1"></i></span>
                    <?php echo form_input(array(
                        'name' => 'start_date',
                        'id' => 'start_date',
                        'class' => 'form-control form-control-solid datepicker',
                        'value' => isset($rule_info['start_date']) && $rule_info['start_date'] ? date(get_date_format(), strtotime($rule_info['start_date'])) : ''
                    )); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <label class="form-check-label  col-sm-3 col-md-3 col-lg-2" for="flexCheckDefault"><?php echo form_label(lang('price_rules_end_date')) ?></label>
            <div class="col-sm-9 col-md-9 col-lg-10  mb-2">
                <div class="input-group date " data-date="<?php echo isset($rule_info['end_date']) && $rule_info['end_date'] ? date(get_date_format(), strtotime($rule_info['end_date'])) : ''; ?>">
                    <span class="input-group-text bg"><i class="ion ion-ios-calendar-outline pt-1"></i></span>
                    <?php echo form_input(
                        array(
                            'name' => 'end_date',
                            'id' => 'end_date',
                            'class' => 'form-control form-control-solid form-inps datepicker',
                            'value' => isset($rule_info['end_date']) && $rule_info['end_date'] ? date(get_date_format(), strtotime($rule_info['end_date'])) : ''
                        )
                    ); ?>
                </div>
            </div>
        </div>
        <div class="row">


            <label class="form-check-label col-sm-3 col-md-3 col-lg-2" for="flexCheckDefault"><?php echo form_label(lang('locations')) ?></label>
            <div class="col-sm-9 col-md-9 col-lg-10">
                <?php

                foreach ($authenticated_locations as $location_id => $location_name) {
                    $locations[$location_id] = $location_name;
                }
                ?>

                <?php
                echo form_dropdown('locations[]', $locations, $price_rule_locations, 'class="" id="location_listd" multiple');
                ?>

            </div>
        </div>



        <div class="row">


            <?php
            if ($this->Tier->count_all() > 0) {
            ?>
                <label class="form-check-label  col-sm-3 col-md-3 col-lg-2" for="flexCheckDefault"><?php echo form_label(lang('price_rules_exclude_from_tiers')) ?></label>
                <div class="col-sm-9 col-md-9 col-lg-10">
                    <?php
                    foreach ($this->Tier->get_all()->result() as $tier) {
                        $tier_id = $tier->id;
                        $tier_name = $tier->name;
                        $checkbox_options = array(
                            'id' => 'reports_selected_tier_ids' . $tier_id,
                            'class' => 'selected_tier_ids_checkboxes form-check-input',
                            'name' => 'excluded_tiers[]',
                            'value' => $tier_id,
                            'checked' => in_array($tier_id, $price_rule_excluded_tiers),
                        );

                        echo '<li>' . form_checkbox($checkbox_options) . '<label for="reports_selected_tier_ids' . $tier_id . '">' . $tier_name . '</label></li>';
                    }
                    ?>

                </div>
            <?php } ?>



        </div>


        <div class="row">

            <?php echo form_label(lang('price_rules_applies_on_days') . ':', 'days_of_week', array('class' => 'col-sm-3 col-md-3 col-lg-2 form-check-label')); ?>
            <div class="col-sm-9 col-md-9 col-lg-10">
                <ul class="list-inline mx-7">
                    <?php
                    echo '<li class="form-check form-check-sm form-check-custom form-check-solid mx-5">' . form_checkbox(array('class' => ' form-check-input', 'id' => 'days_of_week_all', 'name' => 'days_of_week_all', 'value' => '1', 'checked' => ($rule_info && $rule_info['days_of_week'] === NULL) || !$rule_info  ? TRUE : FALSE)) . '<label for="days_of_week_all" class="form-check-label mx-0">' . lang('all') . '</label></li>';
                    echo '<li class="form-check form-check-sm form-check-custom form-check-solid mx-5">' . form_checkbox(array('class' => 'dow form-check-input', 'id' => 'mon', 'name' => 'days_of_week[]', 'value' => '1', 'checked' => $rule_info && strpos($rule_info['days_of_week'], '1') !== false ? TRUE : FALSE)) . '<label for="mon" class="form-check-label mx-0">Mon</label></li>';
                    echo '<li class="form-check form-check-sm form-check-custom form-check-solid mx-5">' . form_checkbox(array('class' => 'dow form-check-input', 'id' => 'tue', 'name' => 'days_of_week[]', 'value' => '2', 'checked' => $rule_info && strpos($rule_info['days_of_week'], '2') !== false ? TRUE : FALSE)) . '<label for="tue" class="form-check-label mx-0">Tue</label></li>';
                    echo '<li class="form-check form-check-sm form-check-custom form-check-solid mx-5">' . form_checkbox(array('class' => 'dow form-check-input', 'id' => 'wed', 'name' => 'days_of_week[]', 'value' => '3', 'checked' => $rule_info && strpos($rule_info['days_of_week'], '3') !== false ? TRUE : FALSE)) . '<label for="wed" class="form-check-label mx-0">Wed</label></li>';
                    echo '<li class="form-check form-check-sm form-check-custom form-check-solid mx-5">' . form_checkbox(array('class' => 'dow form-check-input', 'id' => 'thu', 'name' => 'days_of_week[]', 'value' => '4', 'checked' => $rule_info && strpos($rule_info['days_of_week'], '4') !== false ? TRUE : FALSE)) . '<label for="thu" class="form-check-label mx-0">Thu</label></li>';
                    echo '<li class="form-check form-check-sm form-check-custom form-check-solid mx-5">' . form_checkbox(array('class' => 'dow form-check-input', 'id' => 'fri', 'name' => 'days_of_week[]', 'value' => '5', 'checked' => $rule_info && strpos($rule_info['days_of_week'], '5') !== false ? TRUE : FALSE)) . '<label for="fri" class="form-check-label mx-0">Fri</label></li>';
                    echo '<li class="form-check form-check-sm form-check-custom form-check-solid mx-5">' . form_checkbox(array('class' => 'dow form-check-input', 'id' => 'sat', 'name' => 'days_of_week[]', 'value' => '6', 'checked' => $rule_info && strpos($rule_info['days_of_week'], '6') !== false ? TRUE : FALSE)) . '<label for="sat" class="form-check-label mx-0">Sat</label></li>';
                    echo '<li class="form-check form-check-sm form-check-custom form-check-solid mx-5">' . form_checkbox(array('class' => 'dow form-check-input', 'id' => 'sun', 'name' => 'days_of_week[]', 'value' => '0', 'checked' => $rule_info && strpos($rule_info['days_of_week'], '0') !== false ? TRUE : FALSE)) . '<label for="sun" class="form-check-label mx-0">Sun</label></li>';
                    ?>
                </ul>
            </div>
            <script>
                $(".dow").click(function() {
                    $("#days_of_week_all").prop('checked', false);
                });

                $("#days_of_week_all").click(function() {
                    $(".dow").prop('checked', false);
                });
            </script>

        </div>
        <div class="row mb-6">
            <!--begin::Label-->
            <label class="col-sm-3 col-md-3 col-lg-2 col-form-label text-center  fw-semibold fs-6"></label>
            <!--end::Label-->

            <!--begin::Col-->
            <div class="col-sm-9 col-md-9 col-lg-10 fv-row fv-plugins-icon-container">
                <!--begin::Options-->
                <div class="d-flex align-items-center mt-3">
                    <!--begin::Option-->
                    <label class="form-check form-check-custom form-check-inline form-check-solid me-5">
                        <?php echo form_checkbox(
                            array(
                                'name' => 'requires_coupon',
                                'id' => 'requires_coupon',
                                'value' => '1',
                                'class' => 'form-check-input mt-0-i ',
                                'checked' => !empty($rule_info['coupon_code']) ?  true : false
                            )
                        ); ?>
                        <span class="fw-semibold ps-2 fs-6">
                            <?php echo lang('price_rules_requires_coupon') ?>
                        </span>
                    </label>
                    <!--end::Option-->

                </div>
                <!--end::Options-->
                <!--end::Col-->
            </div>
        </div>




        <div class="row" id="coupon_code_field">

            <label class="form-check-label col-sm-3 col-md-3 col-lg-2" for="flexCheckDefault"><?php echo form_label(lang('coupon_code')) ?></label>
            <div class="col-sm-9 col-md-9 col-lg-10">
                <?php echo form_input(
                    array(
                        'name' => 'coupon_code',
                        'id' => 'coupon_code',
                        'class' => 'form-control form-control-solid form-inps ',
                        'value' => (isset($rule_info['coupon_code'])) ? $rule_info['coupon_code'] : ''
                    ),
                ); ?>
            </div>








        </div>
        <div class="row" id="coupon_code_field_checkbox">
            <!--begin::Label-->
            <label class="col-sm-3 col-md-3 col-lg-2 col-form-label text-center  fw-semibold fs-6"></label>
            <!--end::Label-->

            <!--begin::Col-->
            <div class="col-sm-9 col-md-9 col-lg-10 fv-row fv-plugins-icon-container">
                <!--begin::Options-->
                <div class="d-flex align-items-center mt-3">
                    <!--begin::Option-->
                    <label class="form-check form-check-custom form-check-inline form-check-solid me-5">
                        <?php echo form_checkbox(
                            array(
                                'name' => 'show_on_receipt',
                                'id' => 'show_on_receipt',
                                'class' => 'form-check-input mt-0-i',
                                'value' => '1',
                                'checked' => !empty($rule_info['show_on_receipt']) ?  true : false
                            )
                        ); ?>
                        <span class="fw-semibold ps-2 fs-6">
                            <?php echo form_label(lang('price_rules_show_coupon_on_receipt')) ?>
                        </span>
                    </label>
                    <!--end::Option-->
                </div>
                <!--end::Options-->
                <!--end::Col-->
            </div>
        </div>

        <div class="row " id="coupon_code_field">
            <!--begin::Label-->
            <label class="col-sm-3 col-md-3 col-lg-2 col-form-label text-center  fw-semibold fs-6"></label>
            <!--end::Label-->

            <!--begin::Col-->
            <div class="col-sm-9 col-md-9 col-lg-10 fv-row fv-plugins-icon-container">
                <!--begin::Options-->
                <div class="d-flex align-items-center mt-3">
                    <!--begin::Option-->
                    <label class="form-check form-check-custom form-check-inline form-check-solid me-5">
                        <?php echo form_checkbox(
                            array(
                                'name' => 'active',
                                'id' => 'active',
                                'class' => 'form-check-input mt-0-i',
                                'value' => '1',
                                'checked' => empty($rule_info['active']) || $rule_info['active'] === NULL ?  true : $rule_info['active']
                            )
                        ); ?>
                        <span class="fw-semibold ps-2 fs-6">
                            <?php echo form_label(lang('price_rules_active')) ?>
                        </span>
                    </label>
                    <!--end::Option-->
                </div>
                <!--end::Options-->
                <!--end::Col-->
            </div>
        </div>

        <?php
        if ($this->config->item('enable_customer_loyalty_system')) {

            $enable_customer_loyalty_system = false;
            if (isset($rule_info['disable_loyalty_for_rule'])) {
                if ($rule_info['disable_loyalty_for_rule'] !== NULL) {
                    $enable_customer_loyalty_system =   $rule_info['disable_loyalty_for_rule'];
                }
            }
        ?>


            <div class="row mb-2">
                <!--begin::Label-->
                <label class="col-sm-3 col-md-3 col-lg-2 col-form-label text-center  fw-semibold fs-6"></label>
                <!--end::Label-->

                <!--begin::Col-->
                <div class="col-sm-9 col-md-9 col-lg-10 fv-row fv-plugins-icon-container">
                    <!--begin::Options-->
                    <div class="d-flex align-items-center mt-3">
                        <!--begin::Option-->
                        <label class="form-check form-check-custom form-check-inline form-check-solid me-5">
                            <?php echo form_checkbox(
                                array(
                                    'name' => 'disable_loyalty_for_rule',
                                    'id' => 'disable_loyalty_for_rule',
                                    'value' => '1',
                                    'checked' => $enable_customer_loyalty_system,
                                    'class' => 'form-check-input mt-0-i'
                                ),
                            ); ?>
                            <span class="fw-semibold ps-2 fs-6">
                                <?= lang('disable_loyalty'); ?>
                            </span>
                        </label>
                        <!--end::Option-->
                    </div>
                    <!--end::Options-->
                    <!--end::Col-->
                </div>
            </div>

        <?php } ?>










        <div id="coupon_spend_amount" class="form-group hidden">
            <?php echo form_label(lang('price_rules_spend_amount_to_activate') . ':', 'coupon_spend_amount', array('class' => 'col-sm-3 col-md-3 col-lg-2 form-check-label')); ?>
            <div class="col-sm-9 col-md-9 col-lg-10">

                <?php
                echo form_input(
                    array(
                        'name' => 'coupon_spend_amount',
                        'id' => 'coupon_spend_amount',
                        'class' => 'form-control form-control-solid form-inps',
                        'value' => (isset($rule_info['coupon_spend_amount'])) ? to_currency_no_money($rule_info['coupon_spend_amount']) : ''
                    )
                ); ?>
            </div>
        </div>



        <span id="select_fields" class="hidden">

            <div class="row my-2">


                <label class="form-check-label col-sm-3 col-md-3 col-lg-2" for="flexCheckDefault"><?php echo form_label(lang('price_rules_select_items')) ?></label>
                <div class="input-group col-sm-9 col-md-9 col-lg-10">
                    <span class="input-group-text bg icon ti-harddrive">
                    </span>
                    <input type="text" name="items[]" w="itemsName" value="<?php echo set_value('items[],$rule_items'); ?>" class="form-control form-control-solid form-inps items">
                </div>
            </div>
            <div class="row  mb-2">
                <label class="form-check-label col-sm-3 col-md-3 col-lg-2" for="flexCheckDefault"><?php echo form_label(lang('price_rules_select_item_kits')) ?></label>
                <div class="input-group col-sm-9 col-md-9 col-lg-10">
                    <span class="input-group-text bg icon ti-harddrives">
                    </span>
                    <input type="text" name="itemkits[]" w="itemsKitName" value="<?php echo set_value('itemkits[],$rule_item_kits'); ?>" class="form-control form-inps ikits">
                </div>

            </div>

            <div class="row  my-2">

                <label class="form-check-label col-sm-3 col-md-3 col-lg-2" for="flexCheckDefault"><?php echo form_label(lang('price_rules_select_categories')) ?></label>
                <div class="input-group col-sm-9 col-md-9 col-lg-10">
                    <span class="input-group-text bg icon ti-layout-list-thumb">

                    </span>
                    <input type="text" name="categories[]" w="itemsCategory" value="<?php echo set_value('categories[],$rule_cats'); ?>" class="form-control form-inps cats">
                </div>
            </div>

            <div class="row  my-2">
                <label class="form-check-label col-sm-3 col-md-3 col-lg-2" for="flexCheckDefault"><?php echo form_label(lang('price_rules_select_tags')) ?></label>
                <div class="input-group col-sm-9 col-md-9 col-lg-10">
                    <span class="input-group-text bg icon ti-tag">

                    </span>
                    <input type="text" name="tags[]" w="itemsTag" value="<?php echo set_value('tags[],$rule_tags'); ?>" class="form-control form-inps tags">
                </div>


            </div>

            <div class="row  my-2">
                <label class="form-check-label col-sm-3 col-md-3 col-lg-2" for="flexCheckDefault"><?php echo form_label(lang('price_rules_select_manufacturers')) ?></label>
                <div class="input-group col-sm-9 col-md-9 col-lg-10">
                    <span class="input-group-text bg icon ti-truck">

                    </span>
                    <input type="text" name="manufacturers[]" id="itemsManufacturers" value="<?php echo set_value('manufacturers[],$rule_manus'); ?>" class="form-control form-inps manus">
                </div>
            </div>

        </span>



        <div id="items_to_buy_field" class="row hidden  my-2">

            <label class="form-check-label col-sm-3 col-md-3 col-lg-2" for="flexCheckDefault"><?php echo form_label(lang('price_rules_items_to_buy')) ?></label>
            <div class="input-group col-sm-9 col-md-9 col-lg-10">
                <span class="input-group-text bg icon ti-tag">

                </span>
                <input type="text" name="items_to_buy" id="items_to_buy" value="<?php echo isset($rule_info['items_to_buy']) ? to_quantity($rule_info['items_to_buy'], false) : ''; ?>" class="form-control  form-inps items_to_buy">
            </div>
        </div>

        <?php
        $items_to_get = 0;

        if (isset($rule_info['items_to_get'])) {
            $items_to_get = $rule_info['items_to_get'];
        }
        ?>


        <div id="items_to_get_field" class="row hidden  my-2">

            <label class="form-check-label col-sm-3 col-md-3 col-lg-2" for="flexCheckDefault"><?php echo form_label(lang('price_rules_items_to_get')) ?></label>
            <div class="input-group col-sm-9 col-md-9 col-lg-10">
                <span class="input-group-text bg icon ti-tag">

                </span>
                <input type="text" name="items_to_get" id="items_to_get" value="<?php echo (int) $items_to_get == 0 ? '' : to_quantity($items_to_get, false); ?>" class="form-control form-inps items_to_get">
            </div>
        </div>


        <div id="spend_amount_field" class="row hidden my-2">

            <label class="form-check-label col-sm-3 col-md-3 col-lg-2" for="flexCheckDefault"><?php echo form_label(lang('price_rules_spend_amount')) ?></label>
            <div class="input-group col-sm-9 col-md-9 col-lg-10">
                <span class="input-group-text bg icon ti-money">

                </span>
                <input type="text" name="spend_amount" id="spend_amount" value="<?php echo isset($rule_info['spend_amount']) ? to_currency_no_money($rule_info['spend_amount']) : ''; ?>" class="form-control form-inps  ">
            </div>
        </div>

      

        <span id="discount_fields" class="hidden">

            <div class="row">


                <label class="form-check-label col-sm-3 col-md-3 col-lg-2" for="flexCheckDefault"><?php echo form_label(lang('price_rules_percent_off')) ?></label>

                <div class="input-group col-sm-9 col-md-9 col-lg-10">
                    <?php echo form_input(
                        array(
                            'name' => 'percent_off',
                            'id' => 'percent_off',
                            'class' => 'form-control form-control-solid form-inps',
                            'type' => 'text',
                            'step' => 'any',
                            'value' => isset($rule_info['percent_off']) && $rule_info['percent_off'] !== NULL ? to_quantity($rule_info['percent_off'], false) : '',
                        )
                    ); ?>
                </div>
            </div>

            <div class="form-group">
                <h4 class="text-center"><?php echo lang('or') ?></h4>
            </div>
            <div class="row">
                <label class="form-check-label col-sm-3 col-md-3 col-lg-2" for="flexCheckDefault"><?php echo form_label(lang('price_rules_fixed_off')) ?></label>
                <div class="input-group col-sm-9 col-md-9 col-lg-10">
                    <?php echo form_input(
                        array(
                            'name' => 'fixed_off',
                            'id' => 'fixed_off',
                            'class' => 'form-control form-control-solid form-inps',
                            'type' => 'text',
                            'step' => 'any',
                            'value' => isset($rule_info['fixed_off']) && $rule_info['fixed_off'] !== NULL  ? to_currency_no_money($rule_info['fixed_off']) : '',
                        )
                    ); ?>


                </div>

            </div>



        </span>

        <div id="times_to_apply" class="my-2 row hidden">

            <?php echo form_label(lang('price_rules_num_times_to_apply') . ':', 'num_times_to_apply', array('class' => 'col-sm-3 col-md-3 col-lg-2 form-check-label required')); ?>
            <div class="col-sm-9 col-md-9 col-lg-10">
                <?php echo form_input(
                    array(
                        'name' => 'num_times_to_apply',
                        'type' => 'number',
                        'id' => 'num_times_to_apply',
                        'class' => 'form-control form-control-solid form-inps items_to_buy',
                        'value' => isset($rule_info['num_times_to_apply']) ? to_quantity($rule_info['num_times_to_apply'], false) : ''
                    )
                ); ?>
            </div>
        </div>

        <div id="mix_and_match_container" class="row hidden">
            <label class="col-sm-3 col-md-3 col-lg-2 col-form-label text-center  fw-semibold fs-6"></label>

            <!--begin::Col-->
            <div class="col-sm-9 col-md-9 col-lg-10 fv-row fv-plugins-icon-container">
                <!--begin::Options-->
                <div class="d-flex align-items-center mt-3">
                    <!--begin::Option-->
                    <label class="form-check form-check-custom form-check-inline form-check-solid me-5">
                        <?php
                        echo form_checkbox(array(
                            'name' => 'mix_and_match',
                            'id' => 'mix_and_match',
                            'class' => 'form-check-input mt-0-i',

                            'value' => '1',
                            'checked' => isset($rule_info['mix_and_match']) && $rule_info['mix_and_match'] ?  true : false
                        ));
                        ?>
                        <span class="fw-semibold ps-2 fs-6">
                            <?php echo form_label(lang('price_rules_mix_and_match')) ?>
                        </span>
                    </label>
                    <!--end::Option-->
                </div>
                <!--end::Options-->
                <!--end::Col-->
            </div>
        </div>


        <div id="unlimited_field" class="form-group hidden">
            <div class="row">

                <label class="col-sm-3 col-md-3 col-lg-2 col-form-label text-center  fw-semibold fs-6"></label>


                <!--begin::Col-->
                <div class="col-sm-9 col-md-9 col-lg-10 fv-row fv-plugins-icon-container">
                    <!--begin::Options-->
                    <div class="d-flex align-items-center mt-3">
                        <!--begin::Option-->
                        <label class="form-check form-check-custom form-check-inline form-check-solid me-5">
                            <?php
                            echo form_checkbox(array(
                                'name' => 'unlimited',
                                'id' => 'unlimited',
                                'class' => 'form-check-input mt-0-i',
                                'value' => '1',
                                'checked' => !isset($rule_info['num_times_to_apply']) || $rule_info['num_times_to_apply'] === 0 ?  true : false
                            ));
                            ?>
                            <span class="fw-semibold ps-2 fs-6">
                                <?php echo lang('price_rules_unlimited') ?>
                            </span>
                        </label>
                        <!--end::Option-->
                    </div>
                    <!--end::Options-->
                    <!--end::Col-->
                </div>


            </div>

        </div>

        
        <div class="row">
            <div class="col-sm-9 col-md-9 col-lg-12">

                <div class="py-5 mb-5">
                    <div class="p-10">
                        <table class="table table-bordered text-center" id="price_break_rule_tbl">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><?php echo lang('price_rules_qty_to_buy'); ?></th>
                                    <th><?php echo lang('price_rules_flat_discount_per_unit'); ?></th>
                                    <th><?php echo lang('price_rules_percent_discount_per_unit'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($rule_price_breaks) && count($rule_price_breaks) > 0) {
                                    $i = 1;
                                    foreach ($rule_price_breaks as $break) {
                                ?>
                                        <tr id='<?php echo $i; ?>'>
                                            <td><a onclick="deleteRow(<?php echo $i; ?>)"><i class="ion-close-circled text-danger" title="<?php echo lang('delete'); ?>"></i></a></td>
                                            <td><input type="text" name="qty_to_buy[]" value="<?php echo to_quantity($break['item_qty_to_buy']); ?>" class="qty_to_buy form-control form-control-solid" /></td>
                                            <td><input type="text" name="flat_unit_discount[]" value="<?php echo make_currency_no_money($break['discount_per_unit_fixed'], 10); ?>" class="unit_discount form-control form-control-solid" /></td>
                                            <td><input type="text" name="percent_unit_discount[]" value="<?php echo to_quantity($break['discount_per_unit_percent'], false); ?>" class="unit_discount form-control form-control-solid" /></td>
                                            </td>
                                        </tr>
                                    <?php $i++;
                                    } //endforeach 
                                    ?>

                                <?php } else { ?>

                                    <tr id='1'>
                                        <td><a onclick="deleteRow(1)"><i class="ion-close-circled text-danger" title="<?php echo lang('delete'); ?>"></i></a></td>
                                        <!-- onchange="returnItemInfo(this.value)" -->
                                        <td> <input type="text" name="qty_to_buy[]" class="qty_to_buy form-control form-control-solid" /> </td>
                                        <td> <input type="text" name="flat_unit_discount[]" class="unit_discount form-control form-control-solid" />
                                        </td>
                                        <td> <input type="text" name="percent_unit_discount[]" class="unit_discount form-control form-control-solid" />
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <a class="btn btn-primary" id="add_row"><span class="glyphicon glyphicon-plus"></span>
                            <?php echo lang('price_rules_add_price_break_rule') ?></a>

                    </div>
                </div>
            </div>
        </div>


    </div>

    <div id="price_breaks_table" class="form-group hidden">
        <div class="col-sm-9 col-md-9 col-lg-12">

            <div class="py-5 mb-5">
                <div class="p-10">
                    <?php echo form_label(lang('price_rules_price_breaks')) ?>
                </div>
            </div>
        </div>

    </div>



</div>

<div class="form-controls">
    <ul class="list-inline pull-right">
        <li>
            <?php
            echo form_submit(
                array(
                    'name' => 'submitf',
                    'id' => 'submitf',
                    'value' => lang('save'),
                    'class' => ' btn btn-primary py-3'
                )
            );
            ?>
        </li>
    </ul>
</div>

</div> <!-- close pannel body -->
<?php $this->load->view("partial/footer"); ?>
</div> <!-- close panel -->

<?php echo form_close(); ?>

<script type="text/javascript">
    if ($('#requires_coupon').is(':checked')) {
        $('#coupon_code_field').removeClass('hidden');
        $('#coupon_code_field_checkbox').removeClass('hidden');
    }

    if ($("#show_on_receipt").is(':checked')) {
        $('#coupon_spend_amount').removeClass('hidden');
    }


    jQuery(document).on("click", "#add_row", function() {
        var last_row_id = $('#price_break_rule_tbl tbody tr:last').attr('id');
        new_row_id = parseInt(last_row_id) + 1;
        var new_row = '<tr id="' + new_row_id + '">';
        new_row += '<td><a onclick="deleteRow(' + new_row_id +
            ')"><i class="ion-close-circled text-danger" title="<?php echo lang('delete'); ?>"></i></a></td>';
        new_row +=
            '<td><input type="text" name="qty_to_buy[]" class="qty_to_buy form-control form-control-solid" /></td>';
        new_row +=
            '<td><input type="text" name="flat_unit_discount[]" class="unit_discount form-control form-control-solid" /></td>';
        new_row +=
            '<td><input type="text" name="percent_unit_discount[]" class="unit_discount form-control form-control-solid" /></td>';
        new_row += '</tr>';

        $("#price_break_rule_tbl tbody").append(new_row);
    });

    function deleteRow(id) {
        var elem = document.getElementById(id); // getElementById requires the ID
        elem.parentNode.removeChild(elem);
        return false;
    }


    //validation and submit handling
    var ruleID = '<?php echo $this->uri->segment('3'); ?>';
    var type = $('#type').val();

    $(document).ready(function() {
        $("#location_listd").select2({
            dropdownAutoWidth: true
        });
        $('.card-body .items').tokenInput('<?php echo site_url('price_rules/search_term'); ?>?act=autocomplete', {
            theme: "facebook",
            queryParam: "term",
            extraParam: "w",
            hintText: "<?php echo lang('price_rules_search_term'); ?>",
            noResultsText: "<?php echo lang('price_rules_no_results'); ?>",
            searchingText: "<?php echo lang('price_rules_searching'); ?>",
            preventDuplicates: true,
            prePopulate: <?php echo json_encode(H($rule_items)); ?>
        });

        $('.card-body .ikits').tokenInput('<?php echo site_url('price_rules/search_term'); ?>?act=autocomplete', {
            theme: "facebook",
            queryParam: "term",
            extraParam: "w",
            hintText: "<?php echo lang('price_rules_search_term'); ?>",
            noResultsText: "<?php echo lang('price_rules_no_results'); ?>",
            searchingText: "<?php echo lang('price_rules_searching'); ?>",
            preventDuplicates: true,
            prePopulate: <?php echo json_encode(H($rule_item_kits)); ?>
        });

        $('.card-body .cats').tokenInput('<?php echo site_url('price_rules/search_term'); ?>?act=autocomplete', {
            theme: "facebook",
            queryParam: "term",
            extraParam: "w",
            hintText: "<?php echo lang('price_rules_search_term'); ?>",
            noResultsText: "<?php echo lang('price_rules_no_results'); ?>",
            searchingText: "<?php echo lang('price_rules_searching'); ?>",
            preventDuplicates: true,
            prePopulate: <?php echo json_encode(H($rule_cats)); ?>
        });

        $('.card-body .tags').tokenInput('<?php echo site_url('price_rules/search_term'); ?>?act=autocomplete', {
            theme: "facebook",
            queryParam: "term",
            extraParam: "w",
            hintText: "<?php echo lang('price_rules_search_term'); ?>",
            noResultsText: "<?php echo lang('price_rules_no_results'); ?>",
            searchingText: "<?php echo lang('price_rules_searching'); ?>",
            preventDuplicates: true,
            prePopulate: <?php echo json_encode(H($rule_tags)); ?>
        });

        $('.card-body .manus').tokenInput('<?php echo site_url('price_rules/search_term'); ?>?act=autocomplete', {
            theme: "facebook",
            queryParam: "term",
            extraParam: "w",
            hintText: "<?php echo lang('price_rules_search_term'); ?>",
            noResultsText: "<?php echo lang('price_rules_no_results'); ?>",
            searchingText: "<?php echo lang('price_rules_searching'); ?>",
            preventDuplicates: true,
            prePopulate: <?php echo json_encode(H($rule_manus)); ?>
        });



        date_time_picker_field($('.datepicker'), JS_DATE_FORMAT);

        display_rule_type_options(type);

    });

    function display_rule_type_options(type) {
        switch (type) {
            case "simple_discount":
                //show
                $('#select_fields, #discount_fields, #unlimited_field').toggleClass('hidden', false);
                //hide
                $('#items_to_buy_field, #items_to_get_field, #spend_amount_field, #price_breaks_table,#mix_and_match_container')
                    .toggleClass('hidden', true);
                break;
            case "buy_x_get_y_free":
                //show
                $('#select_fields, #items_to_buy_field, #items_to_get_field, #unlimited_field, #mix_and_match_container')
                    .toggleClass('hidden', false);
                //hide
                $('#discount_fields, #spend_amount_field, #price_breaks_table').toggleClass('hidden', true);
                break;
            case "buy_x_get_discount":
                //show
                $('#select_fields, #items_to_buy_field, #items_to_get_field,#unlimited_field, #discount_fields, #mix_and_match_container')
                    .toggleClass('hidden', false);
                //hide
                $('#spend_amount_field, #price_breaks_table').toggleClass('hidden', true);
                break;
            case "spend_x_get_discount":
                //show
                $('#spend_amount_field, #discount_fields, #unlimited_field').toggleClass('hidden', false);
                //hide
                $('#select_fields, #items_to_buy_field, #items_to_get_field, #price_breaks_table,#mix_and_match_container')
                    .toggleClass('hidden', true);
                break;
            case "advanced_discount":

                if (!$('#unlimited').is(':checked')) {
                    $('#unlimited').trigger('click');
                }
                //show
                $('#select_fields, #price_breaks_table,#mix_and_match_container').toggleClass('hidden', false);
                //hide
                $('#items_to_buy_field, #items_to_get_field, #spend_amount_field, #discount_fields, #unlimited_field')
                    .toggleClass('hidden', true);
                break;
            default:
                //hide
                $('#select_fields, #items_to_buy_field, #items_to_get_field, #spend_amount_field, #discount_fields, #unlimited_field, #price_breaks_table,#mix_and_match_container')
                    .toggleClass('hidden', true);
                break;
        }
    }

    if ($('#num_times_to_apply').val() == 0) {
        $('#unlimited').prop('checked', true);
    }

    if (!$('#unlimited').is(":checked")) {
        if ($('#num_times_to_apply').val() === undefined) {
            $('#num_times_to_apply').val(1);
        }

        $('#times_to_apply').toggleClass('hidden', false);
    }

    $('#requires_coupon').on('change', function() {
        if ($(this).is(":checked")) {
            $('#coupon_code_field').removeClass('hidden');
            $('#coupon_code_field_checkbox').removeClass('hidden');

        } else {
            $('#coupon_code_field').addClass('hidden');
            $('#coupon_code_field_checkbox').addClass('hidden');
            $('#coupon_code').val('');
        }

    });

    $('#show_on_receipt').on('change', function() {

        if ($(this).is(":checked")) {
            $("#coupon_spend_amount").removeClass('hidden');
        } else {
            $("#coupon_spend_amount").addClass('hidden');
        }
    });


    $("#unlimited").on('change', function() {
        if ($(this).is(":checked")) {
            $('#times_to_apply').toggleClass('hidden', true);
            $('#num_times_to_apply').val(0);
        } else {
            if ($('#num_times_to_apply').val() == 0 || $('#num_times_to_apply').val() === undefined) {
                $('#num_times_to_apply').val(1);
            }

            $('#times_to_apply').toggleClass('hidden', false);
        }
    });

    $('#type').on('change', function(event) {
        event.preventDefault();
        //clear all data
        $(".card-body .items").tokenInput("clear");
        $(".card-body .ikits").tokenInput("clear");
        $(".card-body .cats").tokenInput("clear");
        $(".card-body .manus").tokenInput("clear");
        $(".card-body .tags").tokenInput("clear");

        $(this).closest('form').find("input[type=text]").each(function() {
            if ($(this).attr("id") !== 'name' && $(this).attr("id") !== 'start_date' && $(this).attr(
                    "id") !== 'end_date') {
                $(this).val("");
            }
        });

        //uncheck mix and match
        $("#mix_and_match").prop('checked', false);

        var type = $('#type').val();
        display_rule_type_options(type);
    });

    $("#percent_off, #fixed_off").on("keyup", function(e) {
        var id = $(this).attr("id");
        var val = $(this).val();
        if (e.which == 9) {
            return;
        }

        if (val < 0 || (isNaN(val) && val != '.')) {
            $(this).val('');
        } else {
            if (id == 'fixed_off') {
                $('#percent_off').val('');
            }
            if (id == 'percent_off') {
                $('#fixed_off').val('');
            }
        }
    });

    $("#price_break_rule_tbl tbody").on("keyup", ".unit_discount", function(e) {
        var row = $(this).closest('tr');
        var n = $(this).attr("name");
        var val = $(this).val();

        if (e.which == 9) {
            return;
        }

        if (val < 0 || (isNaN(val) && val != '.')) {
            $(this).val('');
        } else {
            if (n == 'flat_unit_discount[]') {
                var other = row.find("input[name='percent_unit_discount[]']");
            }
            if (n == 'percent_unit_discount[]') {
                var other = row.find("input[name='flat_unit_discount[]']");
            }

            other.val('');
        }

    });

    $("#select_all").click(function() {
        $(".selected_location_ids_checkboxes").prop('checked', false);
        check_boxes();
    });
    $('.selected_location_ids_checkboxes').click(function() {
        check_boxes();
    });
    check_boxes();

    function check_boxes() {
        var checked_boxes = 0;
        $(".selected_location_ids_checkboxes").each(function(index) {
            if ($(this).prop('checked')) {
                checked_boxes++;
            }
        });

        if (checked_boxes) {
            $("#select_all").prop('checked', false);
        }
    }
</script>